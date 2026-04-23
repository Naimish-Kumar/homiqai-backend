@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<section class="grid gap-6 xl:grid-cols-[minmax(0,1.1fr)_22rem]">
    <div class="rounded-[34px] border border-white/60 bg-[linear-gradient(135deg,rgba(47,47,47,0.96),rgba(63,63,63,0.92),rgba(122,138,107,0.84))] p-7 text-white shadow-[0_28px_80px_rgba(47,47,47,0.18)]">
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[rgba(247,246,242,0.7)]">Command Center</p>
        <h2 class="mt-4 max-w-2xl font-[var(--font-display)] text-4xl leading-tight sm:text-5xl">A calmer, premium workspace for every design signal.</h2>
        <p class="mt-5 max-w-2xl text-sm leading-8 text-[rgba(247,246,242,0.8)]">Track growth, transformations, and subscriber momentum in a dashboard that matches the Homiq brand instead of feeling disconnected from it.</p>

        <div class="mt-8 grid gap-4 sm:grid-cols-3">
            <div class="rounded-[24px] border border-white/10 bg-white/10 p-5 backdrop-blur-md">
                <p class="text-xs uppercase tracking-[0.22em] text-[rgba(247,246,242,0.64)]">Monthly designs</p>
                <p class="mt-3 text-3xl font-semibold text-white">{{ number_format($stats['monthly_designs']) }}</p>
                <p class="mt-2 text-sm text-[rgba(247,246,242,0.72)]">{{ number_format($stats['today_designs']) }} created today</p>
            </div>
            <div class="rounded-[24px] border border-white/10 bg-white/10 p-5 backdrop-blur-md">
                <p class="text-xs uppercase tracking-[0.22em] text-[rgba(247,246,242,0.64)]">Active users</p>
                <p class="mt-3 text-3xl font-semibold text-white">{{ number_format($stats['active_users']) }}</p>
                <p class="mt-2 text-sm text-[rgba(247,246,242,0.72)]">Last 30 days</p>
            </div>
            <div class="rounded-[24px] border border-white/10 bg-white/10 p-5 backdrop-blur-md">
                <p class="text-xs uppercase tracking-[0.22em] text-[rgba(247,246,242,0.64)]">Premium mix</p>
                <p class="mt-3 text-3xl font-semibold text-white">{{ $stats['conversion_rate'] }}%</p>
                <p class="mt-2 text-sm text-[rgba(247,246,242,0.72)]">{{ number_format($stats['premium_users']) }} premium accounts</p>
            </div>
        </div>
    </div>

    <div class="rounded-[34px] border border-white/60 bg-white/68 p-6 shadow-[0_22px_58px_rgba(47,47,47,0.07)] backdrop-blur-xl">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Homiq logo" class="h-14 w-14 rounded-2xl border border-white/60 bg-white/85 object-cover shadow-[0_14px_34px_rgba(47,47,47,0.08)]">
            <div>
                <p class="font-[var(--font-display)] text-2xl leading-none">Homiq</p>
                <p class="mt-1 text-xs font-semibold uppercase tracking-[0.24em] text-[var(--color-olive)]">Brand Pulse</p>
            </div>
        </div>

        <div class="mt-8 space-y-4">
            <div class="rounded-[24px] bg-[rgba(203,187,160,0.20)] p-5">
                <p class="text-sm text-[color:rgba(47,47,47,0.62)]">Total users</p>
                <p class="mt-2 text-3xl font-semibold text-[var(--color-charcoal)]">{{ number_format($stats['total_users']) }}</p>
                <p class="mt-2 text-xs uppercase tracking-[0.18em] text-[var(--color-olive)]">{{ number_format($stats['monthly_users']) }} joined this month</p>
            </div>
            <div class="rounded-[24px] bg-[rgba(122,138,107,0.14)] p-5">
                <p class="text-sm text-[color:rgba(47,47,47,0.62)]">Designs generated</p>
                <p class="mt-2 text-3xl font-semibold text-[var(--color-charcoal)]">{{ number_format($stats['total_designs']) }}</p>
                <p class="mt-2 text-xs uppercase tracking-[0.18em] text-[var(--color-olive)]">Across all rooms and styles</p>
            </div>
        </div>
    </div>
</section>

<section class="mt-6 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
    <article class="rounded-[28px] border border-white/60 bg-white/72 p-6 shadow-[0_18px_50px_rgba(47,47,47,0.06)] backdrop-blur-xl">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[rgba(203,187,160,0.25)] text-[var(--color-charcoal)]">
            <i class="fa-solid fa-users"></i>
        </div>
        <p class="mt-5 text-sm text-[color:rgba(47,47,47,0.62)]">Total users</p>
        <p class="mt-2 text-3xl font-semibold text-[var(--color-charcoal)]">{{ number_format($stats['total_users']) }}</p>
        <p class="mt-2 text-sm text-[color:rgba(47,47,47,0.58)]">{{ number_format($stats['monthly_users']) }} joined this month</p>
    </article>

    <article class="rounded-[28px] border border-white/60 bg-white/72 p-6 shadow-[0_18px_50px_rgba(47,47,47,0.06)] backdrop-blur-xl">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[rgba(122,138,107,0.18)] text-[var(--color-olive)]">
            <i class="fa-solid fa-wand-magic-sparkles"></i>
        </div>
        <p class="mt-5 text-sm text-[color:rgba(47,47,47,0.62)]">Designs generated</p>
        <p class="mt-2 text-3xl font-semibold text-[var(--color-charcoal)]">{{ number_format($stats['total_designs']) }}</p>
        <p class="mt-2 text-sm text-[color:rgba(47,47,47,0.58)]">{{ number_format($stats['today_designs']) }} created today</p>
    </article>

    <article class="rounded-[28px] border border-white/60 bg-white/72 p-6 shadow-[0_18px_50px_rgba(47,47,47,0.06)] backdrop-blur-xl">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[rgba(168,144,120,0.18)] text-[var(--color-taupe)]">
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <p class="mt-5 text-sm text-[color:rgba(47,47,47,0.62)]">Active users</p>
        <p class="mt-2 text-3xl font-semibold text-[var(--color-charcoal)]">{{ number_format($stats['active_users']) }}</p>
        <p class="mt-2 text-sm text-[color:rgba(47,47,47,0.58)]">Last 30 days</p>
    </article>

    <article class="rounded-[28px] border border-white/60 bg-white/72 p-6 shadow-[0_18px_50px_rgba(47,47,47,0.06)] backdrop-blur-xl">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[rgba(203,187,160,0.22)] text-[var(--color-taupe)]">
            <i class="fa-solid fa-crown"></i>
        </div>
        <p class="mt-5 text-sm text-[color:rgba(47,47,47,0.62)]">Premium users</p>
        <p class="mt-2 text-3xl font-semibold text-[var(--color-charcoal)]">{{ $stats['conversion_rate'] }}%</p>
        <p class="mt-2 text-sm text-[color:rgba(47,47,47,0.58)]">{{ number_format($stats['premium_users']) }} premium accounts</p>
    </article>
</section>

<section class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1.2fr)_minmax(0,0.8fr)]">
    <div class="rounded-[32px] border border-white/60 bg-white/72 p-6 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
        <div class="flex flex-col gap-4 border-b border-[rgba(47,47,47,0.08)] pb-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.26em] text-[var(--color-olive)]">Latest activity</p>
                <h2 class="mt-3 font-[var(--font-display)] text-3xl leading-tight">Recent room transformations</h2>
            </div>
            <a href="{{ route('admin.users') }}" class="inline-flex items-center justify-center rounded-full border border-[rgba(47,47,47,0.10)] bg-white/78 px-5 py-3 text-sm font-semibold text-[var(--color-charcoal)] transition hover:scale-[1.01]">Manage users</a>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full text-left">
                <thead>
                    <tr class="text-xs font-semibold uppercase tracking-[0.24em] text-[color:rgba(47,47,47,0.46)]">
                        <th class="pb-4 pr-4">User</th>
                        <th class="pb-4 pr-4">Style</th>
                        <th class="pb-4 pr-4">Status</th>
                        <th class="pb-4">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[rgba(47,47,47,0.08)]">
                    @forelse($stats['recent_activity'] as $activity)
                        <tr class="align-middle">
                            <td class="py-4 pr-4">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-[rgba(203,187,160,0.25)] font-semibold text-[var(--color-charcoal)]">
                                        {{ strtoupper(substr($activity->user->name ?? 'G', 0, 1)) }}
                                    </span>
                                    <div>
                                        <p class="font-semibold text-[var(--color-charcoal)]">{{ $activity->user->name ?? 'Guest User' }}</p>
                                        <p class="text-sm text-[color:rgba(47,47,47,0.56)]">{{ $activity->user->email ?? 'No email attached' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 pr-4 text-sm text-[color:rgba(47,47,47,0.72)]">{{ $activity->style->name ?? 'Unassigned' }}</td>
                            <td class="py-4 pr-4">
                                @php
                                    $statusClasses = match($activity->status) {
                                        'completed' => 'bg-[rgba(122,138,107,0.14)] text-[var(--color-olive)]',
                                        'processing' => 'bg-[rgba(203,187,160,0.22)] text-[var(--color-taupe)]',
                                        'failed' => 'bg-[rgba(170,80,80,0.12)] text-[#8c4343]',
                                        default => 'bg-[rgba(47,47,47,0.08)] text-[var(--color-charcoal)]',
                                    };
                                @endphp
                                <span class="inline-flex rounded-full px-3 py-2 text-xs font-semibold uppercase tracking-[0.14em] {{ $statusClasses }}">
                                    {{ ucfirst($activity->status) }}
                                </span>
                            </td>
                            <td class="py-4 text-sm text-[color:rgba(47,47,47,0.58)]">{{ $activity->created_at?->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-sm text-[color:rgba(47,47,47,0.56)]">No room designs have been generated yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="space-y-6">
        <div class="rounded-[32px] border border-white/60 bg-white/72 p-6 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
            <p class="text-xs font-semibold uppercase tracking-[0.26em] text-[var(--color-olive)]">Pipeline</p>
            <h2 class="mt-3 font-[var(--font-display)] text-3xl leading-tight">Design status</h2>

            <div class="mt-6 space-y-4">
                <div class="flex items-center justify-between rounded-[22px] bg-[rgba(122,138,107,0.12)] px-4 py-4">
                    <span class="text-sm font-medium text-[color:rgba(47,47,47,0.72)]">Completed</span>
                    <strong class="text-xl text-[var(--color-charcoal)]">{{ number_format($stats['completed_designs']) }}</strong>
                </div>
                <div class="flex items-center justify-between rounded-[22px] bg-[rgba(203,187,160,0.18)] px-4 py-4">
                    <span class="text-sm font-medium text-[color:rgba(47,47,47,0.72)]">Processing</span>
                    <strong class="text-xl text-[var(--color-charcoal)]">{{ number_format($stats['processing_designs']) }}</strong>
                </div>
                <div class="flex items-center justify-between rounded-[22px] bg-[rgba(168,144,120,0.14)] px-4 py-4">
                    <span class="text-sm font-medium text-[color:rgba(47,47,47,0.72)]">Pending</span>
                    <strong class="text-xl text-[var(--color-charcoal)]">{{ number_format($stats['pending_designs']) }}</strong>
                </div>
                <div class="flex items-center justify-between rounded-[22px] bg-[rgba(170,80,80,0.10)] px-4 py-4">
                    <span class="text-sm font-medium text-[color:rgba(47,47,47,0.72)]">Failed</span>
                    <strong class="text-xl text-[var(--color-charcoal)]">{{ number_format($stats['failed_designs']) }}</strong>
                </div>
            </div>
        </div>

        <div class="rounded-[32px] border border-white/60 bg-white/72 p-6 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
            <p class="text-xs font-semibold uppercase tracking-[0.26em] text-[var(--color-olive)]">Style demand</p>
            <h2 class="mt-3 font-[var(--font-display)] text-3xl leading-tight">Top styles</h2>

            <div class="mt-6 space-y-4">
                @forelse($stats['top_styles'] as $style)
                    <div class="flex items-center justify-between rounded-[22px] border border-[rgba(47,47,47,0.06)] bg-[rgba(247,246,242,0.84)] px-4 py-4">
                        <span class="text-sm font-medium text-[color:rgba(47,47,47,0.72)]">{{ $style->name }}</span>
                        <strong class="text-lg text-[var(--color-charcoal)]">{{ number_format($style->room_designs_count) }}</strong>
                    </div>
                @empty
                    <p class="text-sm text-[color:rgba(47,47,47,0.56)]">No styles are available yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

<section class="mt-6 rounded-[32px] border border-white/60 bg-white/72 p-6 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.26em] text-[var(--color-olive)]">Seven days</p>
            <h2 class="mt-3 font-[var(--font-display)] text-3xl leading-tight">Growth snapshot</h2>
        </div>
        <div class="flex gap-5 text-sm">
            <span class="flex items-center gap-2 text-[color:rgba(47,47,47,0.68)]"><i class="h-3 w-3 rounded-full bg-[var(--color-olive)]"></i>Users</span>
            <span class="flex items-center gap-2 text-[color:rgba(47,47,47,0.68)]"><i class="h-3 w-3 rounded-full bg-[var(--color-taupe)]"></i>Designs</span>
        </div>
    </div>

    @php
        $maxValue = max(1, $stats['growth']->max(fn ($day) => max($day['users'], $day['designs'])));
    @endphp

    <div class="mt-8 grid grid-cols-7 gap-3 md:gap-5">
        @foreach($stats['growth'] as $day)
            <div class="flex min-h-[15rem] flex-col items-center justify-end gap-3 rounded-[24px] bg-[rgba(247,246,242,0.82)] px-3 py-4">
                <div class="flex h-36 items-end gap-2">
                    <span class="w-4 rounded-full bg-[var(--color-olive)]" style="height: {{ max(12, ($day['users'] / $maxValue) * 120) }}px"></span>
                    <span class="w-4 rounded-full bg-[var(--color-taupe)]" style="height: {{ max(12, ($day['designs'] / $maxValue) * 120) }}px"></span>
                </div>
                <div class="text-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[color:rgba(47,47,47,0.44)]">{{ $day['label'] }}</p>
                    <p class="mt-2 text-xs text-[color:rgba(47,47,47,0.56)]">{{ $day['users'] }} / {{ $day['designs'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
