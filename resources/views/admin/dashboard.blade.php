@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<section class="grid gap-6 xl:grid-cols-[minmax(0,1.15fr)_minmax(320px,0.85fr)]">
    <div class="rounded-[36px] bg-[#171717] px-6 py-7 text-white shadow-[0_30px_90px_rgba(0,0,0,0.18)] sm:px-8">
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#d8cab4]">Command Center</p>
        <h2 class="mt-4 max-w-3xl font-[Playfair Display] text-4xl leading-tight text-white sm:text-5xl">Run Homiq from a dashboard that feels crisp, intentional, and easy to read.</h2>
        <p class="mt-5 max-w-2xl text-sm leading-8 text-white/78">See design activity, growth, and customer momentum at a glance without the washed-out cards and low-contrast text.</p>

        <div class="mt-8 grid gap-4 sm:grid-cols-3">
            <div class="rounded-[24px] border border-white/10 bg-white/8 p-5">
                <p class="text-xs uppercase tracking-[0.2em] text-[#d8cab4]">Monthly designs</p>
                <p class="mt-3 text-3xl font-semibold text-white">{{ number_format($stats['monthly_designs']) }}</p>
                <p class="mt-2 text-sm text-white/70">{{ number_format($stats['today_designs']) }} created today</p>
            </div>
            <div class="rounded-[24px] border border-white/10 bg-white/8 p-5">
                <p class="text-xs uppercase tracking-[0.2em] text-[#d8cab4]">Active users</p>
                <p class="mt-3 text-3xl font-semibold text-white">{{ number_format($stats['active_users']) }}</p>
                <p class="mt-2 text-sm text-white/70">Last 30 days</p>
            </div>
            <div class="rounded-[24px] border border-white/10 bg-white/8 p-5">
                <p class="text-xs uppercase tracking-[0.2em] text-[#d8cab4]">Premium mix</p>
                <p class="mt-3 text-3xl font-semibold text-white">{{ $stats['conversion_rate'] }}%</p>
                <p class="mt-2 text-sm text-white/70">{{ number_format($stats['premium_users']) }} premium accounts</p>
            </div>
        </div>
    </div>

    <div class="rounded-[36px] border border-black/6 bg-white p-6 shadow-[0_22px_60px_rgba(31,31,31,0.08)]">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logo.png') }}" alt="Homiq logo" class="h-14 w-14 rounded-2xl border border-black/6 bg-[#faf7f2] object-cover">
            <div>
                <p class="font-[Playfair Display] text-3xl leading-none text-[#171717]">Homiq</p>
                <p class="mt-1 text-xs font-semibold uppercase tracking-[0.24em] text-[#7a8a6b]">Brand Pulse</p>
            </div>
        </div>

        <div class="mt-7 space-y-4">
            <div class="rounded-[24px] bg-[#f7f2ea] p-5">
                <p class="text-sm font-medium text-[#5e564e]">Total users</p>
                <p class="mt-2 text-3xl font-semibold text-[#171717]">{{ number_format($stats['total_users']) }}</p>
                <p class="mt-2 text-sm text-[#7a8a6b]">{{ number_format($stats['monthly_users']) }} joined this month</p>
            </div>
            <div class="rounded-[24px] bg-[#eef3ea] p-5">
                <p class="text-sm font-medium text-[#4f5a48]">Designs generated</p>
                <p class="mt-2 text-3xl font-semibold text-[#171717]">{{ number_format($stats['total_designs']) }}</p>
                <p class="mt-2 text-sm text-[#7a8a6b]">Across all rooms and styles</p>
            </div>
        </div>
    </div>
</section>

<section class="mt-6 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
    <article class="rounded-[30px] border border-black/6 bg-white p-6 shadow-[0_18px_50px_rgba(31,31,31,0.06)]">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f7f2ea] text-[#171717]">
            <i class="fa-solid fa-users"></i>
        </div>
        <p class="mt-5 text-sm font-medium text-[#5e564e]">Total users</p>
        <p class="mt-2 text-3xl font-semibold text-[#171717]">{{ number_format($stats['total_users']) }}</p>
        <p class="mt-2 text-sm text-[#6a625a]">{{ number_format($stats['monthly_users']) }} joined this month</p>
    </article>

    <article class="rounded-[30px] border border-black/6 bg-white p-6 shadow-[0_18px_50px_rgba(31,31,31,0.06)]">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#eef3ea] text-[#536149]">
            <i class="fa-solid fa-wand-magic-sparkles"></i>
        </div>
        <p class="mt-5 text-sm font-medium text-[#5e564e]">Designs generated</p>
        <p class="mt-2 text-3xl font-semibold text-[#171717]">{{ number_format($stats['total_designs']) }}</p>
        <p class="mt-2 text-sm text-[#6a625a]">{{ number_format($stats['today_designs']) }} created today</p>
    </article>

    <article class="rounded-[30px] border border-black/6 bg-white p-6 shadow-[0_18px_50px_rgba(31,31,31,0.06)]">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f3ece4] text-[#8b745d]">
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <p class="mt-5 text-sm font-medium text-[#5e564e]">Active users</p>
        <p class="mt-2 text-3xl font-semibold text-[#171717]">{{ number_format($stats['active_users']) }}</p>
        <p class="mt-2 text-sm text-[#6a625a]">Last 30 days</p>
    </article>

    <article class="rounded-[30px] border border-black/6 bg-white p-6 shadow-[0_18px_50px_rgba(31,31,31,0.06)]">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f7f2ea] text-[#8b745d]">
            <i class="fa-solid fa-crown"></i>
        </div>
        <p class="mt-5 text-sm font-medium text-[#5e564e]">Premium users</p>
        <p class="mt-2 text-3xl font-semibold text-[#171717]">{{ $stats['conversion_rate'] }}%</p>
        <p class="mt-2 text-sm text-[#6a625a]">{{ number_format($stats['premium_users']) }} premium accounts</p>
    </article>
</section>

<section class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1.2fr)_minmax(0,0.8fr)]">
    <div class="rounded-[34px] border border-black/6 bg-white p-6 shadow-[0_22px_60px_rgba(31,31,31,0.07)]">
        <div class="flex flex-col gap-4 border-b border-black/6 pb-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.26em] text-[#7a8a6b]">Latest activity</p>
                <h2 class="mt-3 font-[Playfair Display] text-3xl leading-tight text-[#171717]">Recent room transformations</h2>
            </div>
            <a href="{{ route('admin.users') }}" class="inline-flex items-center justify-center rounded-full border border-black/8 bg-[#faf7f2] px-5 py-3 text-sm font-semibold text-[#171717] transition hover:bg-[#f0e8dc]">Manage users</a>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full text-left">
                <thead>
                    <tr class="text-xs font-semibold uppercase tracking-[0.22em] text-[#766d63]">
                        <th class="pb-4 pr-4">User</th>
                        <th class="pb-4 pr-4">Style</th>
                        <th class="pb-4 pr-4">Status</th>
                        <th class="pb-4">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/6">
                    @forelse($stats['recent_activity'] as $activity)
                        <tr>
                            <td class="py-4 pr-4">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-[#f7f2ea] font-semibold text-[#171717]">
                                        {{ strtoupper(substr($activity->user->name ?? 'G', 0, 1)) }}
                                    </span>
                                    <div>
                                        <p class="font-semibold text-[#171717]">{{ $activity->user->name ?? 'Guest User' }}</p>
                                        <p class="text-sm text-[#6a625a]">{{ $activity->user->email ?? 'No email attached' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 pr-4 text-sm text-[#4d463f]">{{ $activity->style->name ?? 'Unassigned' }}</td>
                            <td class="py-4 pr-4">
                                @php
                                    $statusClasses = match($activity->status) {
                                        'completed' => 'bg-[#eef3ea] text-[#405038]',
                                        'processing' => 'bg-[#f7f2ea] text-[#7e6852]',
                                        'failed' => 'bg-[#f7e9e9] text-[#8c4343]',
                                        default => 'bg-[#f1ece6] text-[#433d36]',
                                    };
                                @endphp
                                <span class="inline-flex rounded-full px-3 py-2 text-xs font-semibold uppercase tracking-[0.14em] {{ $statusClasses }}">
                                    {{ ucfirst($activity->status) }}
                                </span>
                            </td>
                            <td class="py-4 text-sm text-[#6a625a]">{{ $activity->created_at?->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-sm text-[#6a625a]">No room designs have been generated yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="space-y-6">
        <div class="rounded-[34px] border border-black/6 bg-white p-6 shadow-[0_22px_60px_rgba(31,31,31,0.07)]">
            <p class="text-xs font-semibold uppercase tracking-[0.26em] text-[#7a8a6b]">Pipeline</p>
            <h2 class="mt-3 font-[Playfair Display] text-3xl leading-tight text-[#171717]">Design status</h2>
            <div class="mt-6 space-y-4">
                <div class="flex items-center justify-between rounded-[22px] bg-[#eef3ea] px-4 py-4">
                    <span class="text-sm font-medium text-[#405038]">Completed</span>
                    <strong class="text-xl text-[#171717]">{{ number_format($stats['completed_designs']) }}</strong>
                </div>
                <div class="flex items-center justify-between rounded-[22px] bg-[#f7f2ea] px-4 py-4">
                    <span class="text-sm font-medium text-[#7e6852]">Processing</span>
                    <strong class="text-xl text-[#171717]">{{ number_format($stats['processing_designs']) }}</strong>
                </div>
                <div class="flex items-center justify-between rounded-[22px] bg-[#f3ece4] px-4 py-4">
                    <span class="text-sm font-medium text-[#735f4b]">Pending</span>
                    <strong class="text-xl text-[#171717]">{{ number_format($stats['pending_designs']) }}</strong>
                </div>
                <div class="flex items-center justify-between rounded-[22px] bg-[#f7e9e9] px-4 py-4">
                    <span class="text-sm font-medium text-[#8c4343]">Failed</span>
                    <strong class="text-xl text-[#171717]">{{ number_format($stats['failed_designs']) }}</strong>
                </div>
            </div>
        </div>

        <div class="rounded-[34px] border border-black/6 bg-white p-6 shadow-[0_22px_60px_rgba(31,31,31,0.07)]">
            <p class="text-xs font-semibold uppercase tracking-[0.26em] text-[#7a8a6b]">Style demand</p>
            <h2 class="mt-3 font-[Playfair Display] text-3xl leading-tight text-[#171717]">Top styles</h2>
            <div class="mt-6 space-y-4">
                @forelse($stats['top_styles'] as $style)
                    <div class="flex items-center justify-between rounded-[22px] bg-[#faf7f2] px-4 py-4">
                        <span class="text-sm font-medium text-[#3f3933]">{{ $style->name }}</span>
                        <strong class="text-lg text-[#171717]">{{ number_format($style->room_designs_count) }}</strong>
                    </div>
                @empty
                    <p class="text-sm text-[#6a625a]">No styles are available yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

<section class="mt-6 rounded-[34px] border border-black/6 bg-white p-6 shadow-[0_22px_60px_rgba(31,31,31,0.07)]">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.26em] text-[#7a8a6b]">Seven days</p>
            <h2 class="mt-3 font-[Playfair Display] text-3xl leading-tight text-[#171717]">Growth snapshot</h2>
        </div>
        <div class="flex gap-5 text-sm">
            <span class="flex items-center gap-2 text-[#4d463f]"><i class="h-3 w-3 rounded-full bg-[#7a8a6b]"></i>Users</span>
            <span class="flex items-center gap-2 text-[#4d463f]"><i class="h-3 w-3 rounded-full bg-[#a89078]"></i>Designs</span>
        </div>
    </div>

    @php
        $maxValue = max(1, $stats['growth']->max(fn ($day) => max($day['users'], $day['designs'])));
    @endphp

    <div class="mt-8 grid grid-cols-7 gap-3 md:gap-5">
        @foreach($stats['growth'] as $day)
            <div class="flex min-h-[15rem] flex-col items-center justify-end gap-3 rounded-[24px] bg-[#faf7f2] px-3 py-4">
                <div class="flex h-36 items-end gap-2">
                    <span class="w-4 rounded-full bg-[#7a8a6b]" style="height: {{ max(12, ($day['users'] / $maxValue) * 120) }}px"></span>
                    <span class="w-4 rounded-full bg-[#a89078]" style="height: {{ max(12, ($day['designs'] / $maxValue) * 120) }}px"></span>
                </div>
                <div class="text-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#766d63]">{{ $day['label'] }}</p>
                    <p class="mt-2 text-xs text-[#6a625a]">{{ $day['users'] }} / {{ $day['designs'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
