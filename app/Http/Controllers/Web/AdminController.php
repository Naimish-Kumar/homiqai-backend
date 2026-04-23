<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\RoomDesign;
use App\Models\Setting;
use App\Models\Style;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        $request->session()->regenerate();

        if (! $request->user()->is_admin) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'This account does not have admin access.',
            ]);
        }

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function index()
    {
        $today = now()->startOfDay();
        $monthStart = now()->startOfMonth();

        $statusCounts = RoomDesign::select('status', DB::raw('count(*) as aggregate'))
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $userGrowth = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as aggregate'))
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $designGrowth = RoomDesign::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as aggregate'))
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $growth = collect(range(6, 0))->map(function (int $daysAgo) use ($userGrowth, $designGrowth) {
            $date = now()->subDays($daysAgo)->toDateString();

            return [
                'label' => Carbon::parse($date)->format('D'),
                'users' => (int) ($userGrowth->get($date)->aggregate ?? 0),
                'designs' => (int) ($designGrowth->get($date)->aggregate ?? 0),
            ];
        });

        $totalUsers = User::count();
        $premiumUsers = User::where('is_premium', true)->count();

        $stats = [
            'total_users' => $totalUsers,
            'admin_users' => User::where('is_admin', true)->count(),
            'premium_users' => $premiumUsers,
            'total_designs' => RoomDesign::count(),
            'total_styles' => Style::count(),
            'today_designs' => RoomDesign::where('created_at', '>=', $today)->count(),
            'monthly_users' => User::where('created_at', '>=', $monthStart)->count(),
            'monthly_designs' => RoomDesign::where('created_at', '>=', $monthStart)->count(),
            'active_users' => User::whereHas('roomDesigns', fn ($query) => $query->where('created_at', '>=', now()->subDays(30)))->count(),
            'conversion_rate' => $totalUsers > 0 ? round(($premiumUsers / $totalUsers) * 100, 1) : 0,
            'completed_designs' => (int) ($statusCounts->get('completed') ?? 0),
            'processing_designs' => (int) ($statusCounts->get('processing') ?? 0),
            'failed_designs' => (int) ($statusCounts->get('failed') ?? 0),
            'pending_designs' => (int) ($statusCounts->get('pending') ?? 0),
            'recent_activity' => RoomDesign::with(['user', 'style'])->latest()->take(8)->get(),
            'top_styles' => Style::withCount('roomDesigns')->orderByDesc('room_designs_count')->take(5)->get(),
            'growth' => $growth,
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users(Request $request)
    {
        $search = $request->string('search')->toString();

        $users = User::query()
            ->withCount('roomDesigns')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $summary = [
            'total_users' => User::count(),
            'admins' => User::where('is_admin', true)->count(),
            'premium' => User::where('is_premium', true)->count(),
        ];

        return view('admin.users', compact('users', 'search', 'summary'));
    }

    public function subscriptions()
    {
        $recentSubscriptions = UserSubscription::with('user')
            ->latest()
            ->take(15)
            ->get();

        $activeSubscriptions = UserSubscription::where('status', 'active')
            ->where('end_date', '>', now())
            ->count();

        $summary = [
            'active_subscriptions' => $activeSubscriptions,
            'total_revenue' => UserSubscription::where('status', 'active')->sum('amount'),
            'ios_users' => UserSubscription::where('platform', 'ios')->where('status', 'active')->count(),
            'android_users' => UserSubscription::where('platform', 'android')->where('status', 'active')->count(),
            'estimated_mrr' => UserSubscription::where('status', 'active')->where('end_date', '>', now())->sum('amount'),
        ];

        return view('admin.subscriptions', compact('recentSubscriptions', 'summary'));
    }

    public function settings()
    {
        $settings = Setting::all()->keyBy('key');

        $config = [
            'ai_provider' => $settings->get('ai_provider')->value ?? config('services.ai.provider'),
            'stability_ai_key' => $settings->get('stability_ai_key')->value ?? config('services.stability_ai.key'),
            'openai_key' => $settings->get('openai_key')->value ?? config('services.openai.key'),
            'amazon_affiliate_tag' => $settings->get('amazon_affiliate_tag')->value ?? config('services.affiliate.amazon_tag'),
            'apple_shared_secret' => $settings->get('apple_shared_secret')->value ?? config('services.apple.shared_secret'),
            'google_package_name' => $settings->get('google_package_name')->value ?? config('services.google_play.package_name'),
            'maintenance_mode' => $settings->get('maintenance_mode')->value ?? '0',
            'app_version' => $settings->get('app_version')->value ?? '1.0.0',
        ];

        $system = [
            'environment' => app()->environment(),
            'debug' => config('app.debug') ? 'Enabled' : 'Disabled',
            'storage_disk' => config('filesystems.default'),
            'db_connection' => config('database.default'),
            'last_sync' => now()->diffForHumans(),
        ];

        return view('admin.settings', compact('config', 'system'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'ai_provider' => ['required', 'string', 'in:stability,openai'],
            'stability_ai_key' => ['nullable', 'string'],
            'openai_key' => ['nullable', 'string'],
            'amazon_affiliate_tag' => ['nullable', 'string'],
            'apple_shared_secret' => ['nullable', 'string'],
            'google_package_name' => ['nullable', 'string'],
            'maintenance_mode' => ['required', 'string', 'in:0,1'],
            'app_version' => ['required', 'string'],
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value, $this->getGroupForKey($key));
        }

        // Also update JSON for redundancy/fallback if DB is down during boot
        file_put_contents(storage_path('app/settings.json'), json_encode($validated, JSON_PRETTY_PRINT));

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Database settings synchronized successfully! System is now using live values.');
    }

    protected function getGroupForKey(string $key): string
    {
        if (str_contains($key, 'ai') || str_contains($key, 'openai')) return 'ai';
        if (str_contains($key, 'amazon') || str_contains($key, 'affiliate')) return 'affiliate';
        if (str_contains($key, 'apple') || str_contains($key, 'google')) return 'payment';
        if (str_contains($key, 'maintenance') || str_contains($key, 'version')) return 'system';
        return 'general';
    }

    public function designs(Request $request)
    {
        $status = $request->string('status')->toString();

        $designs = RoomDesign::with(['user', 'style'])
            ->when($status !== '', fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $summary = [
            'total' => RoomDesign::count(),
            'completed' => RoomDesign::where('status', 'completed')->count(),
            'processing' => RoomDesign::where('status', 'processing')->count(),
            'failed' => RoomDesign::where('status', 'failed')->count(),
        ];

        return view('admin.designs', compact('designs', 'summary', 'status'));
    }

    public function deleteDesign(RoomDesign $design)
    {
        // Delete images from storage
        if ($design->original_image_path) {
            \Storage::disk('public')->delete($design->original_image_path);
        }
        if ($design->generated_image_path) {
            \Storage::disk('public')->delete($design->generated_image_path);
        }

        $design->delete();

        return redirect()->route('admin.designs')->with('status', 'Design deleted successfully.');
    }

    public function styles()
    {
        $styles = Style::withCount('roomDesigns')->orderBy('name')->get();
        return view('admin.styles', compact('styles'));
    }

    public function storeStyle(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:styles,name',
            'thumbnail_url' => 'nullable|url|max:500',
            'prompt_prefix' => 'nullable|string|max:1000',
        ]);

        Style::create($request->only(['name', 'thumbnail_url', 'prompt_prefix']));

        return redirect()->route('admin.styles')->with('status', "Style '{$request->name}' created successfully.");
    }

    public function deleteStyle(Style $style)
    {
        $name = $style->name;
        $style->delete();

        return redirect()->route('admin.styles')->with('status', "Style '{$name}' deleted.");
    }
}
