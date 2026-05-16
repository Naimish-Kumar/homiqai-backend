@extends('admin.layout')

@section('title', 'Insights')

@section('content')
<section class="grid gap-6 xl:grid-cols-[minmax(0,1.15fr)_minmax(320px,0.85fr)]">
    <div class="rounded-[40px] border border-black/5 bg-white px-7 py-8 shadow-[0_30px_90px_rgba(31,31,31,0.06)] sm:px-10">
        <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Intelligence Dashboard</p>
        <h2 class="mt-5 max-w-2xl font-[Playfair Display] text-4xl leading-tight text-[#171717] sm:text-5xl">Monitor Homiq activity with precision and clarity.</h2>
        <p class="mt-6 max-w-xl text-sm leading-8 text-[#5e564e]">Analyze design trends, user growth, and operational health at a glance. Every metric is intentional, every view is optimized for decision-making.</p>

        <div class="mt-10 grid gap-5 sm:grid-cols-3">
            <div class="rounded-[28px] bg-[#faf7f2] p-6 transition hover:shadow-lg">
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#a89078]">Monthly designs</p>
                <p class="mt-3 text-4xl font-bold text-[#171717]">{{ number_format($stats['monthly_designs']) }}</p>
                <p class="mt-2 text-xs font-medium text-[#7a8a6b]">+{{ number_format($stats['today_designs']) }} today</p>
            </div>
            <div class="rounded-[28px] bg-[#eef3ea] p-6 transition hover:shadow-lg">
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#7a8a6b]">Active users</p>
                <p class="mt-3 text-4xl font-bold text-[#171717]">{{ number_format($stats['active_users']) }}</p>
                <p class="mt-2 text-xs font-medium text-[#5e564e]">Last 30 days</p>
            </div>
            <div class="rounded-[28px] bg-[#f3ece4] p-6 transition hover:shadow-lg">
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#8b745d]">Conversion</p>
                <p class="mt-3 text-4xl font-bold text-[#171717]">{{ $stats['conversion_rate'] }}%</p>
                <p class="mt-2 text-xs font-medium text-[#5e564e]">{{ number_format($stats['premium_users']) }} premium</p>
            </div>
        </div>
    </div>

    <div class="rounded-[40px] border border-black/5 bg-white p-7 shadow-[0_22px_60px_rgba(31,31,31,0.06)]">
        <div class="flex items-center gap-4">
            <div class="relative">
                <img src="{{ asset('images/logo.png') }}" alt="Homiq logo" class="h-14 w-14 rounded-2xl border border-black/5 bg-[#faf7f2] object-cover shadow-sm">
                <span class="absolute -right-1 -top-1 flex h-4 w-4 animate-pulse rounded-full bg-[#7a8a6b] ring-2 ring-white"></span>
            </div>
            <div>
                <p class="font-[Playfair Display] text-3xl font-bold leading-none text-[#171717]">Ecosystem</p>
                <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.24em] text-[#7a8a6b]">Live Pulse</p>
            </div>
        </div>

        <div class="mt-8 space-y-5">
            <div class="rounded-[28px] bg-[#fbfaf8] p-6 border border-black/5">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-bold text-[#5e564e]">Total users</p>
                    <i class="fa-solid fa-users text-[#a89078]"></i>
                </div>
                <p class="mt-3 text-4xl font-bold text-[#171717]">{{ number_format($stats['total_users']) }}</p>
                <p class="mt-2 text-xs font-semibold text-[#7a8a6b]">{{ number_format($stats['monthly_users']) }} this month</p>
            </div>
            <div class="rounded-[28px] bg-[#171717] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.15)]">
                <div class="flex items-center justify-between text-white/70">
                    <p class="text-sm font-bold">Projected Revenue</p>
                    <i class="fa-solid fa-chart-line text-[#d8cab4]"></i>
                </div>
                <p class="mt-3 text-4xl font-bold text-white">₹{{ number_format($stats['revenue']) }}</p>
                <p class="mt-2 text-xs font-semibold text-[#d8cab4]">Subscriptions & credits</p>
            </div>
        </div>
    </div>
</section>

<section class="mt-6 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
    <article class="group rounded-[32px] border border-black/5 bg-white p-7 shadow-[0_18px_50px_rgba(31,31,31,0.04)] transition hover:scale-[1.02]">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#faf7f2] text-[#a89078] transition group-hover:bg-[#a89078] group-hover:text-white">
            <i class="fa-solid fa-users"></i>
        </div>
        <p class="mt-6 text-sm font-bold text-[#5e564e]">Community</p>
        <p class="mt-2 text-3xl font-bold text-[#171717]">{{ number_format($stats['total_users']) }}</p>
        <div class="mt-3 h-1 w-full overflow-hidden rounded-full bg-[#f7f2ea]">
            <div class="h-full bg-[#a89078]" style="width: 70%"></div>
        </div>
    </article>

    <article class="group rounded-[32px] border border-black/5 bg-white p-7 shadow-[0_18px_50px_rgba(31,31,31,0.04)] transition hover:scale-[1.02]">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#eef3ea] text-[#7a8a6b] transition group-hover:bg-[#7a8a6b] group-hover:text-white">
            <i class="fa-solid fa-wand-magic-sparkles"></i>
        </div>
        <p class="mt-6 text-sm font-bold text-[#5e564e]">AI Throughput</p>
        <p class="mt-2 text-3xl font-bold text-[#171717]">{{ number_format($stats['today_designs']) }}</p>
        <p class="mt-2 text-xs font-semibold text-[#7a8a6b]">{{ number_format($stats['total_designs']) }} total requests</p>
    </article>

    <article class="group rounded-[32px] border border-black/5 bg-white p-7 shadow-[0_18px_50px_rgba(31,31,31,0.04)] transition hover:scale-[1.02]">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f3ece4] text-[#8b745d] transition group-hover:bg-[#8b745d] group-hover:text-white">
            <i class="fa-solid fa-bolt"></i>
        </div>
        <p class="mt-6 text-sm font-bold text-[#5e564e]">Active Presence</p>
        <p class="mt-2 text-3xl font-bold text-[#171717]">{{ number_format($stats['daily_active_users']) }}</p>
        <p class="mt-2 text-xs font-semibold text-[#8b745d]">Daily active core</p>
    </article>

    <article class="group rounded-[32px] border border-black/5 bg-white p-7 shadow-[0_18px_50px_rgba(31,31,31,0.04)] transition hover:scale-[1.02]">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f7e9e9] text-[#8c4343] transition group-hover:bg-[#8c4343] group-hover:text-white">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <p class="mt-6 text-sm font-bold text-[#5e564e]">Incident Rate</p>
        <p class="mt-2 text-3xl font-bold text-[#171717]">{{ number_format($stats['failed_designs']) }}</p>
        <p class="mt-2 text-xs font-semibold text-[#8c4343]">Requires attention</p>
    </article>
</section>

<section class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1.2fr)_minmax(0,0.8fr)]">
    <div class="rounded-[36px] border border-black/5 bg-white p-8 shadow-[0_22px_60px_rgba(31,31,31,0.06)]">
        <div class="flex flex-col gap-4 border-b border-black/5 pb-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Real-time stream</p>
                <h2 class="mt-3 font-[Playfair Display] text-3xl font-bold text-[#171717]">Recent activity</h2>
            </div>
            <a href="{{ route('admin.users') }}" class="inline-flex items-center justify-center rounded-2xl bg-[#faf7f2] px-6 py-3 text-sm font-bold text-[#171717] transition hover:bg-[#171717] hover:text-white">View all</a>
        </div>

        <div class="mt-8 overflow-x-auto">
            <table class="min-w-full text-left">
                <thead>
                    <tr class="text-[10px] font-bold uppercase tracking-[0.24em] text-[#a89078]">
                        <th class="pb-5">Member</th>
                        <th class="pb-5">Aesthetic</th>
                        <th class="pb-5 text-center">Status</th>
                        <th class="pb-5 text-right">Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse($stats['recent_activity'] as $activity)
                        <tr class="group transition hover:bg-[#faf7f2]/50">
                            <td class="py-5 pr-4">
                                <div class="flex items-center gap-4">
                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#f7f2ea] font-bold text-[#171717] shadow-sm">
                                        {{ strtoupper(substr($activity->user->name ?? 'G', 0, 1)) }}
                                    </span>
                                    <div class="min-w-0">
                                        <p class="truncate font-bold text-[#171717]">{{ $activity->user->name ?? 'Guest User' }}</p>
                                        <p class="truncate text-xs font-medium text-[#7a8a6b]">{{ $activity->user->email ?? 'no email' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 pr-4">
                                <span class="rounded-lg bg-[#faf7f2] px-3 py-1.5 text-xs font-bold text-[#5e564e]">
                                    {{ $activity->style->name ?? 'Modern' }}
                                </span>
                            </td>
                            <td class="py-5 pr-4 text-center">
                                @php
                                    $statusClasses = match($activity->status) {
                                        'completed' => 'bg-[#eef3ea] text-[#405038]',
                                        'processing' => 'bg-[#f7f2ea] text-[#7e6852]',
                                        'failed' => 'bg-[#f7e9e9] text-[#8c4343]',
                                        default => 'bg-[#f1ece6] text-[#433d36]',
                                    };
                                @endphp
                                <span class="inline-flex rounded-full px-4 py-1.5 text-[10px] font-bold uppercase tracking-widest {{ $statusClasses }}">
                                    {{ $activity->status }}
                                </span>
                            </td>
                            <td class="py-5 text-right text-xs font-semibold text-[#a89078]">
                                {{ $activity->created_at?->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-sm font-medium text-[#7a8a6b]">No recent activity found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="space-y-6">
        <div class="rounded-[36px] border border-black/5 bg-white p-8 shadow-[0_22px_60px_rgba(31,31,31,0.06)]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Queue status</p>
            <h2 class="mt-3 font-[Playfair Display] text-3xl font-bold text-[#171717]">Design health</h2>
            <div class="mt-8 space-y-3">
                <div class="flex items-center justify-between rounded-2xl bg-[#eef3ea] px-5 py-4">
                    <span class="text-sm font-bold text-[#405038]">Success</span>
                    <strong class="text-xl font-bold text-[#171717]">{{ number_format($stats['completed_designs']) }}</strong>
                </div>
                <div class="flex items-center justify-between rounded-2xl bg-[#faf7f2] px-5 py-4">
                    <span class="text-sm font-bold text-[#7e6852]">Processing</span>
                    <strong class="text-xl font-bold text-[#171717]">{{ number_format($stats['processing_designs']) }}</strong>
                </div>
                <div class="flex items-center justify-between rounded-2xl bg-[#f7e9e9] px-5 py-4">
                    <span class="text-sm font-bold text-[#8c4343]">Failures</span>
                    <strong class="text-xl font-bold text-[#171717]">{{ number_format($stats['failed_designs']) }}</strong>
                </div>
            </div>
        </div>

        <div class="rounded-[36px] border border-black/5 bg-white p-8 shadow-[0_22px_60px_rgba(31,31,31,0.06)]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#a89078]">Style metrics</p>
            <h2 class="mt-3 font-[Playfair Display] text-3xl font-bold text-[#171717]">Popularity</h2>
            <div class="mt-8 space-y-4">
                @forelse($stats['top_styles'] as $style)
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-sm font-bold text-[#171717]">
                            <span>{{ $style->name }}</span>
                            <span>{{ number_format($style->room_designs_count) }}</span>
                        </div>
                        <div class="h-2 w-full overflow-hidden rounded-full bg-[#faf7f2]">
                            @php
                                $percentage = ($style->room_designs_count / max(1, $stats['total_designs'])) * 100;
                            @endphp
                            <div class="h-full bg-[#a89078] rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm font-medium text-[#7a8a6b]">No styles tracked yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

<section class="mt-6 rounded-[40px] border border-black/5 bg-white p-8 shadow-[0_22px_60px_rgba(31,31,31,0.06)]">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Trend analysis</p>
            <h2 class="mt-3 font-[Playfair Display] text-3xl font-bold text-[#171717]">Growth Snapshot</h2>
        </div>
        <div class="flex gap-6 text-xs font-bold">
            <span class="flex items-center gap-2 text-[#5e564e]"><i class="h-2 w-2 rounded-full bg-[#7a8a6b]"></i>Users</span>
            <span class="flex items-center gap-2 text-[#5e564e]"><i class="h-2 w-2 rounded-full bg-[#a89078]"></i>Designs</span>
        </div>
    </div>

    @php
        $maxValue = max(1, $stats['growth']->max(fn ($day) => max($day['users'], $day['designs'])));
    @endphp

    <div class="mt-12 grid grid-cols-7 gap-4 md:gap-6">
        @foreach($stats['growth'] as $day)
            <div class="group flex flex-col items-center gap-4 rounded-3xl bg-[#fbfaf8] py-6 transition hover:bg-[#faf7f2]">
                <div class="flex h-40 items-end gap-2.5">
                    <div class="relative w-4.5 rounded-full bg-[#7a8a6b] transition-all group-hover:scale-x-110" style="height: {{ max(10, ($day['users'] / $maxValue) * 140) }}px">
                        <div class="absolute -top-8 left-1/2 -translate-x-1/2 rounded-lg bg-[#171717] px-2 py-1 text-[9px] text-white opacity-0 transition group-hover:opacity-100">{{ $day['users'] }}</div>
                    </div>
                    <div class="relative w-4.5 rounded-full bg-[#a89078] transition-all group-hover:scale-x-110" style="height: {{ max(10, ($day['designs'] / $maxValue) * 140) }}px">
                        <div class="absolute -top-8 left-1/2 -translate-x-1/2 rounded-lg bg-[#171717] px-2 py-1 text-[9px] text-white opacity-0 transition group-hover:opacity-100">{{ $day['designs'] }}</div>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[#a89078]">{{ $day['label'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section class="mt-6 mb-12 rounded-[40px] border border-black/5 bg-white p-8 shadow-[0_22px_60px_rgba(31,31,31,0.06)]">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">System modules</p>
            <h2 class="mt-3 font-[Playfair Display] text-3xl font-bold text-[#171717]">Operational surface</h2>
        </div>
        <p class="text-sm font-medium text-[#7a8a6b]">Architecture roadmap and current live systems.</p>
    </div>

    <div class="mt-10 grid gap-5 xl:grid-cols-2">
        @foreach ($stats['feature_modules'] as $module)
            <article class="rounded-[32px] bg-[#fbfaf8] p-7 transition hover:bg-[#faf7f2] border border-black/5">
                <div class="flex items-center justify-between gap-4">
                    <h3 class="text-lg font-bold text-[#171717]">{{ $module['title'] }}</h3>
                    @php
                        $modStatusClasses = match($module['status']) {
                            'Live' => 'bg-[#eef3ea] text-[#405038]',
                            'Next' => 'bg-[#faf7f2] text-[#a89078]',
                            default => 'bg-[#f1ece6] text-[#433d36]',
                        };
                    @endphp
                    <span class="inline-flex rounded-full px-4 py-1.5 text-[9px] font-bold uppercase tracking-widest {{ $modStatusClasses }}">
                        {{ $module['status'] }}
                    </span>
                </div>
                <p class="mt-4 text-sm leading-7 font-medium text-[#5e564e]">{{ $module['description'] }}</p>
            </article>
        @endforeach
    </div>
</section>
@endsection

