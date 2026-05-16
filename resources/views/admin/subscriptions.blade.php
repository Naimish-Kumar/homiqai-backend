@section('content')
<div class="space-y-10">
    <!-- Revenue Intelligence -->
    <section class="grid gap-10 md:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Monthly Recurring</p>
            <div class="mt-4">
                <span class="font-[Playfair Display] text-4xl font-bold text-black italic">₹{{ number_format($summary['estimated_mrr']) }}</span>
                <p class="mt-2 text-[10px] font-bold text-[#a89078] uppercase tracking-widest opacity-60">Estimated Yield</p>
            </div>
        </article>

        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Lifetime Ledger</p>
            <div class="mt-4">
                <span class="font-[Playfair Display] text-4xl font-bold text-black italic">₹{{ number_format($summary['total_revenue']) }}</span>
                <p class="mt-2 text-[10px] font-bold text-[#a89078] uppercase tracking-widest opacity-60">Cumulative Revenue</p>
            </div>
        </article>

        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Platform Split</p>
            <div class="mt-4 grid grid-cols-2 gap-4">
                <div class="rounded-[24px] bg-[#faf9f6] p-4 border border-black/[0.02]">
                    <p class="text-[9px] font-bold uppercase tracking-widest text-[#a89078]">iOS</p>
                    <p class="mt-1 text-[18px] font-bold text-black tabular-nums">{{ $summary['ios_users'] }}</p>
                </div>
                <div class="rounded-[24px] bg-[#faf9f6] p-4 border border-black/[0.02]">
                    <p class="text-[9px] font-bold uppercase tracking-widest text-[#a89078]">Droid</p>
                    <p class="mt-1 text-[18px] font-bold text-black tabular-nums">{{ $summary['android_users'] }}</p>
                </div>
            </div>
        </article>

        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Active Retainers</p>
            <div class="mt-4">
                <span class="font-[Playfair Display] text-4xl font-bold text-black italic">{{ number_format($summary['active_subscriptions']) }}</span>
                <p class="mt-2 text-[10px] font-bold text-[#a89078] uppercase tracking-widest opacity-60">Valid Contracts</p>
            </div>
        </article>
    </section>

    <!-- Ledger Manifest -->
    <section class="rounded-[56px] border border-black/[0.03] bg-white overflow-hidden shadow-2xl shadow-black/[0.03]">
        <header class="px-12 py-10 bg-[#faf9f6] border-b border-black/[0.03]">
            <h2 class="font-[Playfair Display] text-3xl font-bold text-black italic">Financial Ledger</h2>
            <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Real-time transactional audit stream</p>
        </header>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-bold uppercase tracking-[0.25em] text-[#a89078] bg-white border-b border-black/[0.02]">
                        <th class="pl-12 pr-6 py-8">Identity</th>
                        <th class="px-6 py-8">Contract</th>
                        <th class="px-6 py-8">Vector</th>
                        <th class="px-6 py-8">Manifest ID</th>
                        <th class="px-6 py-8">Status</th>
                        <th class="pl-6 pr-12 py-8 text-right">Maturity</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/[0.02]">
                    @forelse($recentSubscriptions as $sub)
                        <tr class="hover:bg-[#faf9f6]/50 transition-colors group">
                            <td class="pl-12 pr-6 py-7">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-black text-white font-bold text-[13px] shadow-lg shadow-black/5">
                                        {{ strtoupper(substr($sub->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-[14px] font-bold text-black">{{ $sub->user->name ?? 'Unknown Client' }}</p>
                                        <p class="text-[11px] font-medium text-[#a89078] uppercase tracking-widest mt-0.5 opacity-60">{{ $sub->user->email ?? 'no-email@identity.com' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-7">
                                <div>
                                    <p class="text-[14px] font-bold text-black">{{ $sub->package_name }}</p>
                                    <p class="text-[12px] font-bold text-[#7a8a6b] tabular-nums mt-0.5">₹{{ number_format($sub->amount) }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-7">
                                <span class="inline-flex items-center gap-2 rounded-full px-5 py-1.5 text-[10px] font-bold uppercase tracking-widest {{ $sub->platform === 'android' ? 'bg-[#7a8a6b]/10 text-[#7a8a6b]' : 'bg-black/5 text-black' }}">
                                    <i class="fa-brands fa-{{ $sub->platform === 'android' ? 'android' : 'apple' }} text-[12px]"></i>
                                    {{ $sub->platform }}
                                </span>
                            </td>
                            <td class="px-6 py-7">
                                <code class="rounded-[14px] bg-[#faf9f6] px-4 py-2 text-[11px] font-mono font-medium text-black border border-black/[0.03]">{{ Str::limit($sub->transaction_id, 12) }}</code>
                            </td>
                            <td class="px-6 py-7">
                                <span class="inline-flex items-center gap-3">
                                    <span class="h-2.5 w-2.5 rounded-full {{ $sub->status === 'active' ? 'bg-[#7a8a6b]' : 'bg-[#8c4343]' }} animate-pulse"></span>
                                    <span class="text-[11px] font-bold uppercase tracking-[0.2em] {{ $sub->status === 'active' ? 'text-black' : 'text-[#8c4343]' }}">{{ $sub->status }}</span>
                                </span>
                            </td>
                            <td class="pl-6 pr-12 py-7 text-right">
                                <p class="text-[13px] font-bold text-black tabular-nums">{{ $sub->end_date->format('d M, Y') }}</p>
                                <p class="mt-1 text-[10px] font-bold uppercase tracking-widest {{ $sub->end_date->isPast() ? 'text-[#8c4343]' : 'text-[#7a8a6b]' }} opacity-60">
                                    {{ $sub->end_date->diffForHumans() }}
                                </p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-32 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fa-solid fa-file-invoice-dollar text-4xl text-black/5 mb-6"></i>
                                    <p class="text-[13px] font-bold text-black uppercase tracking-[0.2em] opacity-30">Ledger clear. No transactions documented.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection

