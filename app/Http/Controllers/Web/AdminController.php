<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\RoomDesign;
use App\Models\Layout;
use App\Models\Setting;
use App\Models\Style;
use App\Models\FurnitureProduct;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\Feedback;
use App\Models\Notification;
use App\Models\ApiLog;
use App\Services\AIService;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
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
        $totalRevenue = UserSubscription::where('status', 'active')->sum('amount');
        $processedImages = RoomDesign::query()
            ->selectRaw('COUNT(original_image_path) + COUNT(generated_image_path) as aggregate')
            ->value('aggregate');
        $topStyles = Style::withCount('roomDesigns')->orderByDesc('room_designs_count')->take(5)->get();

        $stats = [
            'total_users' => $totalUsers,
            'admin_users' => User::where('is_admin', true)->count(),
            'blocked_users' => User::where('is_blocked', true)->count(),
            'premium_users' => $premiumUsers,
            'total_designs' => RoomDesign::count(),
            'total_styles' => Style::count(),
            'today_designs' => RoomDesign::where('created_at', '>=', $today)->count(),
            'daily_active_users' => User::whereHas('roomDesigns', fn ($query) => $query->where('created_at', '>=', $today))->count(),
            'monthly_users' => User::where('created_at', '>=', $monthStart)->count(),
            'monthly_designs' => RoomDesign::where('created_at', '>=', $monthStart)->count(),
            'active_users' => User::whereHas('roomDesigns', fn ($query) => $query->where('created_at', '>=', now()->subDays(30)))->count(),
            'conversion_rate' => $totalUsers > 0 ? round(($premiumUsers / $totalUsers) * 100, 1) : 0,
            'images_processed' => (int) $processedImages,
            'revenue' => (float) $totalRevenue,
            'completed_designs' => (int) ($statusCounts->get('completed') ?? 0),
            'processing_designs' => (int) ($statusCounts->get('processing') ?? 0),
            'failed_designs' => (int) ($statusCounts->get('failed') ?? 0),
            'pending_designs' => (int) ($statusCounts->get('pending') ?? 0),
            'total_layouts' => Layout::count(),
            'completed_layouts' => Layout::where('status', 'completed')->count(),
            'processing_layouts' => Layout::where('status', 'processing')->count(),
            'failed_layouts' => Layout::where('status', 'failed')->count(),
            'recent_activity' => RoomDesign::with(['user', 'style'])->latest()->take(8)->get(),
            'top_styles' => $topStyles,
            'top_style_names' => $topStyles->pluck('name')->implode(', '),
            'growth' => $growth,
            'feature_modules' => [
                ['title' => 'Credits & Subscriptions', 'description' => 'Manage free credits, premium state, payments, and expiry from the user and subscription screens.', 'status' => 'Live'],
                ['title' => 'AI Request Management', 'description' => 'Inspect original/generated images, cost signals, request status, and retry failed generations.', 'status' => 'Live'],
                ['title' => 'Prompt & Style Control', 'description' => 'Create and update design styles with prompt prefixes that directly affect output quality.', 'status' => 'Live'],
                ['title' => 'Furniture Recommendations', 'description' => 'Current recommendations are generated from style and budget logic. Dedicated product CMS is the next admin step.', 'status' => 'Next'],
                ['title' => 'Notifications, Feedback, Logs', 'description' => 'The API has notification support, but a full admin console for campaigns, feedback, and logs still needs dedicated tables/UI.', 'status' => 'Planned'],
            ],
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users(Request $request)
    {
        $search = $request->string('search')->toString();

        $users = User::query()
            ->withCount('roomDesigns')
            ->with(['subscriptions' => fn ($query) => $query->latest('end_date')])
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
            'blocked' => User::where('is_blocked', true)->count(),
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
        $settings = Setting::safeKeyedValues();

        $config = [
            'ai_provider' => $settings->get('ai_provider')->value ?? config('services.ai.provider'),
            'stability_ai_key' => $settings->get('stability_ai_key')->value ?? config('services.stability_ai.key'),
            'openai_key' => $settings->get('openai_key')->value ?? config('services.openai.key'),
            'gemini_key' => $settings->get('gemini_key')->value ?? config('services.gemini.key') ?? env('GEMINI_API_KEY'),
            'amazon_affiliate_tag' => $settings->get('amazon_affiliate_tag')->value ?? config('services.affiliate.amazon_tag'),
            'apple_shared_secret' => $settings->get('apple_shared_secret')->value ?? config('services.apple.shared_secret'),
            'google_package_name' => $settings->get('google_package_name')->value ?? config('services.google_play.package_name'),
            'maintenance_mode' => $settings->get('maintenance_mode')->value ?? '0',
            'app_version' => $settings->get('app_version')->value ?? '1.0.0',
            'global_prompt_prefix' => $settings->get('global_prompt_prefix')->value ?? '',
            'global_prompt_suffix' => $settings->get('global_prompt_suffix')->value ?? '',
            'budget_low_label' => $settings->get('budget_low_label')->value ?? 'Low Budget',
            'budget_medium_label' => $settings->get('budget_medium_label')->value ?? 'Medium Budget',
            'budget_high_label' => $settings->get('budget_high_label')->value ?? 'High Budget',
            'budget_low_min' => $settings->get('budget_low_min')->value ?? '0',
            'budget_low_max' => $settings->get('budget_low_max')->value ?? '10000',
            'budget_medium_min' => $settings->get('budget_medium_min')->value ?? '10001',
            'budget_medium_max' => $settings->get('budget_medium_max')->value ?? '50000',
            'budget_high_min' => $settings->get('budget_high_min')->value ?? '50001',
            'budget_high_max' => $settings->get('budget_high_max')->value ?? '200000',
            'budget_low_prompt' => $settings->get('budget_low_prompt')->value ?? 'Use affordable, budget-friendly materials like laminate, MDF, and cotton textiles.',
            'budget_medium_prompt' => $settings->get('budget_medium_prompt')->value ?? 'Use mid-range materials like engineered wood, quality fabrics, and ceramic tiles.',
            'budget_high_prompt' => $settings->get('budget_high_prompt')->value ?? 'Use premium materials like solid hardwood, marble, brass fixtures, and designer furniture.',
            'max_upload_size' => $settings->get('max_upload_size')->value ?? '10',
            'ai_timeout' => $settings->get('ai_timeout')->value ?? '60',
            'firebase_config' => $settings->get('firebase_config')->value ?? '{}',
            'smtp_config' => $settings->get('smtp_config')->value ?? '{}',
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
            'gemini_key' => ['nullable', 'string'],
            'amazon_affiliate_tag' => ['nullable', 'string'],
            'apple_shared_secret' => ['nullable', 'string'],
            'google_package_name' => ['nullable', 'string'],
            'maintenance_mode' => ['required', 'string', 'in:0,1'],
            'app_version' => ['required', 'string'],
            'global_prompt_prefix' => ['nullable', 'string', 'max:2000'],
            'global_prompt_suffix' => ['nullable', 'string', 'max:2000'],
            'budget_low_label' => ['required', 'string', 'max:100'],
            'budget_medium_label' => ['required', 'string', 'max:100'],
            'budget_high_label' => ['required', 'string', 'max:100'],
            'budget_low_min' => ['required', 'integer', 'min:0'],
            'budget_low_max' => ['required', 'integer', 'min:0'],
            'budget_medium_min' => ['required', 'integer', 'min:0'],
            'budget_medium_max' => ['required', 'integer', 'min:0'],
            'budget_high_min' => ['required', 'integer', 'min:0'],
            'budget_high_max' => ['required', 'integer', 'min:0'],
            'budget_low_prompt' => ['required', 'string', 'max:1000'],
            'budget_medium_prompt' => ['required', 'string', 'max:1000'],
            'budget_high_prompt' => ['required', 'string', 'max:1000'],
            'max_upload_size' => ['required', 'integer', 'min:1', 'max:100'],
            'ai_timeout' => ['required', 'integer', 'min:1', 'max:300'],
            'firebase_config' => ['nullable', 'string'],
            'smtp_config' => ['nullable', 'string'],
        ]);

        if (! Setting::tableIsAvailable()) {
            file_put_contents(storage_path('app/settings.json'), json_encode($validated, JSON_PRETTY_PRINT));

            return redirect()
                ->route('admin.settings')
                ->with('status', 'Settings table is unavailable, so values were saved to the JSON fallback only.');
        }

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
        if (str_contains($key, 'ai') || str_contains($key, 'openai') || str_contains($key, 'gemini')) return 'ai';
        if (str_contains($key, 'amazon') || str_contains($key, 'affiliate')) return 'affiliate';
        if (str_contains($key, 'apple') || str_contains($key, 'google')) return 'payment';
        if (str_contains($key, 'budget') || str_contains($key, 'prompt')) return 'design';
        if (str_contains($key, 'maintenance') || str_contains($key, 'version') || str_contains($key, 'size') || str_contains($key, 'config')) return 'system';
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
            'estimated_cost' => RoomDesign::where('status', 'completed')->count() * 0.12,
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

    public function layouts(Request $request)
    {
        $status = $request->string('status')->toString();

        $layouts = Layout::with(['user'])
            ->when($status !== '', fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $summary = [
            'total' => Layout::count(),
            'completed' => Layout::where('status', 'completed')->count(),
            'processing' => Layout::where('status', 'processing')->count(),
            'failed' => Layout::where('status', 'failed')->count(),
        ];

        return view('admin.layouts', compact('layouts', 'summary', 'status'));
    }

    public function deleteLayout(Layout $layout)
    {
        if ($layout->floor_plan_url) {
            $path = str_replace(Storage::disk('public')->url(''), '', $layout->floor_plan_url);
            Storage::disk('public')->delete(trim($path, '/'));
        }

        $layout->delete();

        return redirect()->route('admin.layouts')->with('status', 'Layout deleted successfully.');
    }

    public function retryDesign(RoomDesign $design, AIService $aiService)
    {
        if ($design->generated_image_path) {
            Storage::disk('public')->delete($design->generated_image_path);
        }

        $design->furnitureRecommendations()->delete();
        $design->update([
            'generated_image_path' => null,
            'status' => 'pending',
        ]);

        $aiService->generateDesign($design->fresh(['style']));

        return redirect()->route('admin.designs')->with('status', 'AI generation retried successfully.');
    }

    public function styles()
    {
        $styles = Style::withCount('roomDesigns')->orderBy('name')->get();
        return view('admin.styles', compact('styles'));
    }

    public function storeStyle(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:styles,name',
            'thumbnail_url' => 'nullable|url|max:500',
            'prompt_prefix' => 'nullable|string|max:1000',
            'prompt_low' => 'nullable|string|max:1000',
            'prompt_medium' => 'nullable|string|max:1000',
            'prompt_high' => 'nullable|string|max:1000',
        ]);

        Style::create($validated);

        return redirect()->route('admin.styles')->with('status', "Style '{$request->name}' created successfully.");
    }

    public function updateStyle(Request $request, Style $style)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:styles,name,' . $style->id,
            'thumbnail_url' => 'nullable|url|max:500',
            'prompt_prefix' => 'nullable|string|max:1000',
            'prompt_low' => 'nullable|string|max:1000',
            'prompt_medium' => 'nullable|string|max:1000',
            'prompt_high' => 'nullable|string|max:1000',
        ]);

        $style->update($validated);

        return redirect()->route('admin.styles')->with('status', "Style '{$style->name}' updated successfully.");
    }

    public function deleteStyle(Style $style)
    {
        $name = $style->name;
        $style->delete();

        return redirect()->route('admin.styles')->with('status', "Style '{$name}' deleted.");
    }

    public function furniture()
    {
        $products = FurnitureProduct::with('styles')->latest()->get();
        $styles = Style::orderBy('name')->get();

        $summary = [
            'total_products' => FurnitureProduct::count(),
            'active_products' => FurnitureProduct::where('is_active', true)->count(),
            'categories' => FurnitureProduct::query()->distinct('category')->count('category'),
        ];

        return view('admin.furniture', compact('products', 'styles', 'summary'));
    }

    public function storeFurniture(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:100'],
            'image_url' => ['nullable', 'url', 'max:1000'],
            'affiliate_link' => ['nullable', 'url', 'max:1000'],
            'low_price' => ['nullable', 'numeric', 'min:0'],
            'medium_price' => ['nullable', 'numeric', 'min:0'],
            'high_price' => ['nullable', 'numeric', 'min:0'],
            'style_ids' => ['nullable', 'array'],
            'style_ids.*' => ['exists:styles,id'],
        ]);

        $product = FurnitureProduct::create([
            ...collect($validated)->except('style_ids')->toArray(),
            'is_active' => true,
        ]);

        $product->styles()->sync($validated['style_ids'] ?? []);

        return redirect()->route('admin.furniture')->with('status', 'Furniture product created successfully.');
    }

    public function updateFurniture(Request $request, FurnitureProduct $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:100'],
            'image_url' => ['nullable', 'url', 'max:1000'],
            'affiliate_link' => ['nullable', 'url', 'max:1000'],
            'low_price' => ['nullable', 'numeric', 'min:0'],
            'medium_price' => ['nullable', 'numeric', 'min:0'],
            'high_price' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'style_ids' => ['nullable', 'array'],
            'style_ids.*' => ['exists:styles,id'],
        ]);

        $product->update([
            ...collect($validated)->except('style_ids')->toArray(),
            'is_active' => $request->boolean('is_active'),
        ]);

        $product->styles()->sync($validated['style_ids'] ?? []);

        return redirect()->route('admin.furniture')->with('status', 'Furniture product updated successfully.');
    }

    public function deleteFurniture(FurnitureProduct $product)
    {
        $product->delete();

        return redirect()->route('admin.furniture')->with('status', 'Furniture product deleted successfully.');
    }

    public function storage()
    {
        $disk = Storage::disk('public');
        $files = $disk->allFiles('designs');
        $totalSize = 0;
        foreach ($files as $file) {
            $totalSize += $disk->size($file);
        }

        $summary = [
            'total_files' => count($files),
            'total_size' => round($totalSize / (1024 * 1024), 2), // MB
            'designs_count' => RoomDesign::count(),
            'storage_limit' => 5000, // 5GB mock limit
        ];

        $recentFiles = RoomDesign::whereNotNull('original_image_path')
            ->orWhereNotNull('generated_image_path')
            ->latest()
            ->take(20)
            ->get();

        return view('admin.storage', compact('summary', 'recentFiles'));
    }

    public function clearStorage(Request $request)
    {
        $days = $request->integer('days', 30);
        $oldDesigns = RoomDesign::where('created_at', '<', now()->subDays($days))->get();
        $count = 0;

        foreach ($oldDesigns as $design) {
            if ($design->original_image_path) {
                Storage::disk('public')->delete($design->original_image_path);
            }
            if ($design->generated_image_path) {
                Storage::disk('public')->delete($design->generated_image_path);
            }
            $design->delete();
            $count++;
        }

        return redirect()->route('admin.storage')->with('status', "Cleaned up {$count} old designs.");
    }

    public function feedback(Request $request)
    {
        $feedbacks = Feedback::with(['user', 'roomDesign'])
            ->latest()
            ->paginate(15);

        $summary = [
            'total' => Feedback::count(),
            'average_rating' => round(Feedback::avg('rating') ?? 0, 1),
            'pending' => Feedback::where('status', 'pending')->count(),
        ];

        return view('admin.feedback', compact('feedbacks', 'summary'));
    }

    public function updateFeedback(Request $request, Feedback $feedback)
    {
        $feedback->update(['status' => $request->string('status', 'reviewed')]);
        return redirect()->route('admin.feedback')->with('status', 'Feedback status updated.');
    }

    public function notifications()
    {
        $notifications = Notification::with('user')->latest()->paginate(15);
        $users = User::select('id', 'name', 'email')->get();

        $summary = [
            'total_sent' => Notification::count(),
            'read_rate' => Notification::where('is_read', true)->count() > 0 
                ? round((Notification::where('is_read', true)->count() / Notification::count()) * 100, 1) 
                : 0,
        ];

        return view('admin.notifications', compact('notifications', 'users', 'summary'));
    }

    public function sendNotification(Request $request, FirebaseService $firebase)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
            'type' => 'required|string|in:info,update,promotion,alert',
        ]);

        $notification = Notification::create([
            ...$validated,
            'sent_at' => now(),
        ]);

        // Send actual push notification via Firebase
        $firebase->sendPush(
            $validated['title'],
            $validated['message'],
            $validated['user_id'],
            [
                'type' => (string) $validated['type'], 
                'notification_id' => (string) $notification->id
            ]
        );

        return redirect()->route('admin.notifications')->with('status', 'Notification sent successfully.');
    }

    public function deleteNotification(Notification $notification)
    {
        $notification->delete();
        return redirect()->route('admin.notifications')->with('status', 'Campaign history deleted.');
    }

    public function logs(Request $request)
    {
        $logs = ApiLog::with('user')
            ->when($request->filled('status'), fn($q) => $q->where('status_code', $request->status))
            ->latest()
            ->paginate(25);

        $summary = [
            'total_requests' => ApiLog::count(),
            'failed_requests' => ApiLog::where('status_code', '>=', 400)->count(),
            'avg_duration' => round(ApiLog::avg('duration_ms') ?? 0, 0),
        ];

        return view('admin.logs', compact('logs', 'summary'));
    }

    public function updateUserCredits(Request $request, User $user)
    {
        $validated = $request->validate([
            'free_designs_left' => ['required', 'integer', 'min:0', 'max:10000'],
        ]);

        $user->update(['free_designs_left' => $validated['free_designs_left']]);

        return redirect()->route('admin.users')->with('status', "Credits updated for {$user->name}.");
    }

    public function toggleUserBlock(User $user)
    {
        $user->update(['is_blocked' => ! $user->is_blocked]);

        return redirect()->route('admin.users')->with('status', $user->is_blocked
            ? "{$user->name} has been blocked."
            : "{$user->name} has been unblocked.");
    }

    public function updateUserSubscription(Request $request, User $user)
    {
        $validated = $request->validate([
            'is_premium' => ['required', 'boolean'],
        ]);

        $user->update(['is_premium' => (bool) $validated['is_premium']]);

        return redirect()->route('admin.users')->with('status', "Subscription status updated for {$user->name}.");
    }

    public function profile()
    {
        $admin = auth()->user();
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = auth()->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $admin->update($data);

        return redirect()->route('admin.profile')->with('status', 'Profile updated successfully.');
    }
}
