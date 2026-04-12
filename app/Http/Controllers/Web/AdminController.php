<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\RoomDesign;
use App\Models\Style;
use App\Models\User;
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
        $verifiedUsers = User::whereNotNull('email_verified_at')->count();

        $stats = [
            'total_users' => $totalUsers,
            'admin_users' => User::where('is_admin', true)->count(),
            'verified_users' => $verifiedUsers,
            'total_designs' => RoomDesign::count(),
            'total_styles' => Style::count(),
            'today_designs' => RoomDesign::where('created_at', '>=', $today)->count(),
            'monthly_users' => User::where('created_at', '>=', $monthStart)->count(),
            'monthly_designs' => RoomDesign::where('created_at', '>=', $monthStart)->count(),
            'active_users' => User::whereHas('roomDesigns', fn ($query) => $query->where('created_at', '>=', now()->subDays(30)))->count(),
            'conversion_rate' => $totalUsers > 0 ? round(($verifiedUsers / $totalUsers) * 100, 1) : 0,
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
            'verified' => User::whereNotNull('email_verified_at')->count(),
        ];

        return view('admin.users', compact('users', 'search', 'summary'));
    }

    public function subscriptions()
    {
        $premiumUsers = User::whereNotNull('email_verified_at')->latest()->take(8)->get();
        $summary = [
            'premium_users' => User::whereNotNull('email_verified_at')->count(),
            'free_users' => User::whereNull('email_verified_at')->count(),
            'estimated_mrr' => User::whereNotNull('email_verified_at')->count() * 199,
            'monthly_signups' => User::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        return view('admin.subscriptions', compact('premiumUsers', 'summary'));
    }

    public function settings()
    {
        $credentials = [
            'app_url' => config('app.url'),
            'ai_provider' => config('services.ai.provider', 'Not configured'),
            'openai' => filled(config('services.openai.key')) ? 'Configured' : 'Missing',
            'stability_ai' => filled(config('services.stability_ai.key')) ? 'Configured' : 'Missing',
            'mail_driver' => config('mail.default'),
        ];

        $styles = Style::withCount('roomDesigns')->orderBy('name')->get();
        $system = [
            'environment' => app()->environment(),
            'debug' => config('app.debug') ? 'Enabled' : 'Disabled',
            'queue' => config('queue.default'),
            'cache' => config('cache.default'),
        ];

        return view('admin.settings', compact('credentials', 'styles', 'system'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'stability_ai' => ['nullable', 'string', 'max:255'],
            'openai' => ['nullable', 'string', 'max:255'],
            'firebase_project_id' => ['nullable', 'string', 'max:255'],
        ]);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Settings received. Update production secrets from the server environment, then run php artisan config:clear.');
    }
}
