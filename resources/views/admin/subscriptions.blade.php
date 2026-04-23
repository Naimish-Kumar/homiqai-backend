@extends('admin.layout')

@section('title', 'Revenue & Subscriptions')

@section('content')
<section class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
    <article class="rounded-[28px] border border-white/60 bg-white/72 p-6 shadow-[0_18px_50px_rgba(47,47,47,0.06)] backdrop-blur-xl">
        <p class="text-sm text-[color:rgba(47,47,47,0.62)]">Estimated MRR</p>
        <p class="mt-3 text-3xl font-semibold text-[var(--color-charcoal)]">₹{{ number_format($summary['estimated_mrr']) }}</p>
        <p class="mt-2 text-sm text-[color:rgba(47,47,47,0.58)]">Active monthly recurring revenue</p>
    </article>
    <article class="rounded-[28px] border border-white/60 bg-white/72 p-6 shadow-[0_18px_50px_rgba(47,47,47,0.06)] backdrop-blur-xl">
        <p class="text-sm text-[color:rgba(47,47,47,0.62)]">Total Revenue</p>
        <p class="mt-3 text-3xl font-semibold text-[var(--color-charcoal)]">₹{{ number_format($summary['total_revenue']) }}</p>
        <p class="mt-2 text-sm text-[color:rgba(47,47,47,0.58)]">Lifetime processed</p>
    </article>
    <article class="rounded-[28px] border border-white/60 bg-white/72 p-6 shadow-[0_18px_50px_rgba(47,47,47,0.06)] backdrop-blur-xl">
        <p class="text-sm text-[color:rgba(47,47,47,0.62)]">Platform Split</p>
        <div class="mt-4 grid grid-cols-2 gap-3">
            <div class="rounded-[20px] bg-[rgba(247,246,242,0.82)] p-4 text-center">
                <p class="text-xs uppercase tracking-[0.18em] text-[color:rgba(47,47,47,0.46)]">iOS</p>
                <p class="mt-2 text-2xl font-semibold text-[var(--color-charcoal)]">{{ $summary['ios_users'] }}</p>
            </div>
            <div class="rounded-[20px] bg-[rgba(247,246,242,0.82)] p-4 text-center">
                <p class="text-xs uppercase tracking-[0.18em] text-[color:rgba(47,47,47,0.46)]">Android</p>
                <p class="mt-2 text-2xl font-semibold text-[var(--color-charcoal)]">{{ $summary['android_users'] }}</p>
            </div>
        </div>
    </article>
    <article class="rounded-[28px] border border-white/60 bg-white/72 p-6 shadow-[0_18px_50px_rgba(47,47,47,0.06)] backdrop-blur-xl">
        <p class="text-sm text-[color:rgba(47,47,47,0.62)]">Active Subs</p>
        <p class="mt-3 text-3xl font-semibold text-[var(--color-charcoal)]">{{ number_format($summary['active_subscriptions']) }}</p>
        <p class="mt-2 text-sm text-[color:rgba(47,47,47,0.58)]">Currently valid</p>
    </article>
</section>

<section class="mt-6 rounded-[32px] border border-white/60 bg-white/72 p-6 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
    <div class="border-b border-[rgba(47,47,47,0.08)] pb-5">
        <p class="text-xs font-semibold uppercase tracking-[0.26em] text-[var(--color-olive)]">Transactions</p>
        <h2 class="mt-3 font-[var(--font-display)] text-3xl leading-tight">Recent store purchases</h2>
    </div>

    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full text-left">
            <thead>
                <tr class="text-xs font-semibold uppercase tracking-[0.24em] text-[color:rgba(47,47,47,0.46)]">
                    <th class="pb-4 pr-4">User</th>
                    <th class="pb-4 pr-4">Plan</th>
                    <th class="pb-4 pr-4">Platform</th>
                    <th class="pb-4 pr-4">Transaction ID</th>
                    <th class="pb-4 pr-4">Status</th>
                    <th class="pb-4">Expiry</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[rgba(47,47,47,0.08)]">
                @forelse($recentSubscriptions as $sub)
                    <tr>
                        <td class="py-4 pr-4">
                            <div class="flex items-center gap-3">
                                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-[rgba(203,187,160,0.25)] font-semibold text-[var(--color-charcoal)]">
                                    {{ strtoupper(substr($sub->user->name ?? 'U', 0, 1)) }}
                                </span>
                                <div>
                                    <p class="font-semibold text-[var(--color-charcoal)]">{{ $sub->user->name ?? 'Unknown' }}</p>
                                    <p class="text-sm text-[color:rgba(47,47,47,0.56)]">{{ $sub->user->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 pr-4">
                            <div>
                                <p class="font-semibold text-[var(--color-charcoal)]">{{ $sub->package_name }}</p>
                                <p class="text-sm text-[color:rgba(47,47,47,0.56)]">₹{{ number_format($sub->amount) }}</p>
                            </div>
                        </td>
                        <td class="py-4 pr-4">
                            <span class="inline-flex rounded-full px-3 py-2 text-xs font-semibold uppercase tracking-[0.14em] {{ $sub->platform === 'android' ? 'bg-[rgba(122,138,107,0.14)] text-[var(--color-olive)]' : 'bg-[rgba(47,47,47,0.08)] text-[var(--color-charcoal)]' }}">
                                {{ strtoupper($sub->platform) }}
                            </span>
                        </td>
                        <td class="py-4 pr-4">
                            <code class="rounded-xl bg-[rgba(247,246,242,0.92)] px-3 py-2 text-xs text-[var(--color-charcoal)]">{{ Str::limit($sub->transaction_id, 16) }}</code>
                        </td>
                        <td class="py-4 pr-4">
                            <span class="inline-flex items-center gap-2 text-sm text-[color:rgba(47,47,47,0.72)]">
                                <i class="h-2.5 w-2.5 rounded-full {{ $sub->status === 'active' ? 'bg-[var(--color-olive)]' : 'bg-[#9f5656]' }}"></i>
                                {{ ucfirst($sub->status) }}
                            </span>
                        </td>
                        <td class="py-4 text-sm text-[color:rgba(47,47,47,0.68)]">
                            {{ $sub->end_date->format('d M, Y') }}
                            <p class="mt-1 {{ $sub->end_date->isPast() ? 'text-[#9f5656]' : 'text-[var(--color-olive)]' }}">
                                {{ $sub->end_date->diffForHumans() }}
                            </p>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-sm text-[color:rgba(47,47,47,0.56)]">No transactions recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
