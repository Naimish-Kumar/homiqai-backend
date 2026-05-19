@extends('admin.layout')

@section('title', 'Community')

@section('content')
<!-- Community Intelligence Metrics -->
<section class="grid gap-8 sm:grid-cols-2 xl:grid-cols-4">
    @foreach([
        ['label' => 'Total Members', 'value' => $summary['total_users'], 'sub' => 'Ecosystem total', 'bg' => 'bg-[#f1f3f0]', 'color' => 'text-[#7a8a6b]'],
        ['label' => 'System Admins', 'value' => $summary['admins'], 'sub' => 'Platform control', 'bg' => 'bg-[#f7f2ed]', 'color' => 'text-[#a89078]'],
        ['label' => 'Pro Members', 'value' => $summary['premium'], 'sub' => 'Premium tier', 'bg' => 'bg-[#f9f7f4]', 'color' => 'text-[#8b745d]'],
        ['label' => 'Restricted', 'value' => $summary['blocked'], 'sub' => 'Account blocks', 'bg' => 'bg-[#f7e9e9]', 'color' => 'text-[#8c4343]']
    ] as $stat)
    <article class="group rounded-[36px] border border-black/[0.03] bg-white p-8 shadow-sm transition-all hover:-translate-y-1 hover:shadow-2xl hover:shadow-black/[0.04]">
        <p class="text-[10px] font-bold uppercase tracking-[0.3em] {{ $stat['color'] }}">{{ $stat['sub'] }}</p>
        <p class="mt-6 text-4xl font-bold tracking-tighter text-black">{{ number_format($stat['value']) }}</p>
        <p class="mt-3 text-[11px] font-bold text-[#5f5750]/60">{{ $stat['label'] }}</p>
    </article>
    @endforeach
</section>

<!-- Member Directory Surface -->
<section class="mt-8 rounded-[48px] border border-black/[0.03] bg-white p-10 shadow-xl shadow-black/[0.02]">
    <div class="flex flex-col gap-8 border-b border-black/[0.03] pb-10 xl:flex-row xl:items-center xl:justify-between">
        <div>
            <h2 class="font-[Playfair Display] text-4xl font-bold text-black italic">Member Directory</h2>
            <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Audit & moderate user ecosystem</p>
        </div>
        
        <form action="{{ route('admin.users') }}" method="GET" class="relative group w-full max-w-xl">
            <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-[#a89078] text-sm group-focus-within:rotate-12 transition-transform"></i>
            </div>
            <input type="search" name="search" value="{{ $search }}" placeholder="Search members by identity or ID..." class="w-full rounded-[28px] border border-black/[0.04] bg-[#faf9f6] py-5 pl-14 pr-32 text-[14px] font-bold text-black outline-none ring-[#7a8a6b]/20 transition-all focus:bg-white focus:ring-8">
            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-2xl bg-black px-6 py-2.5 text-[11px] font-bold uppercase tracking-widest text-white shadow-lg transition hover:scale-105 active:scale-95">Find</button>
        </form>
    </div>

    <div class="mt-10 space-y-8">
        @forelse($users as $user)
            @php
                $latestSubscription = $user->subscriptions->first();
                $hasActiveSubscription = $latestSubscription && $latestSubscription->status === 'active' && $latestSubscription->end_date?->isFuture();
            @endphp
            <article class="group relative overflow-hidden rounded-[40px] border border-black/[0.04] bg-[#fbfaf8] p-8 transition-all hover:bg-white hover:shadow-2xl hover:shadow-black/[0.04]">
                <div class="flex flex-col gap-10 xl:flex-row xl:items-center">
                    <!-- Identity Block -->
                    <div class="flex flex-1 items-center gap-6">
                        <div class="relative">
                            <div class="flex h-20 w-20 items-center justify-center rounded-[32px] bg-white text-2xl font-bold text-black shadow-lg ring-1 ring-black/[0.05]">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            @if($hasActiveSubscription || $user->is_premium)
                                <div class="absolute -right-2 -top-2 flex h-8 w-8 items-center justify-center rounded-full bg-black text-[12px] text-white shadow-xl ring-4 ring-[#fbfaf8] group-hover:ring-white transition-all">
                                    <i class="fa-solid fa-crown"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-4">
                                <h3 class="text-2xl font-bold text-black tracking-tight">{{ $user->name }}</h3>
                                @if($user->is_admin)
                                    <span class="rounded-full bg-[#7a8a6b] px-3 py-1 text-[9px] font-bold uppercase tracking-widest text-white">Admin</span>
                                @endif
                                @if($user->is_blocked)
                                    <span class="rounded-full bg-[#8c4343] px-3 py-1 text-[9px] font-bold uppercase tracking-widest text-white">Restricted</span>
                                @endif
                            </div>
                            <p class="mt-1 text-[13px] font-medium text-[#7a8a6b]">{{ $user->email ?: 'Identity Protected' }}</p>
                            <div class="mt-5 flex gap-6 text-[11px] font-bold uppercase tracking-widest text-[#a89078]/80">
                                <span class="flex items-center gap-2"><i class="fa-solid fa-wand-magic-sparkles text-[10px]"></i> {{ number_format($user->room_designs_count) }} Generations</span>
                                <span class="flex items-center gap-2"><i class="fa-solid fa-bolt-lightning text-[10px]"></i> {{ $user->free_designs_left ?? 0 }} Available</span>
                                <span class="flex items-center gap-2"><i class="fa-solid fa-calendar text-[10px]"></i> Joined {{ $user->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Command Center -->
                    <div class="grid gap-6 sm:grid-cols-3 xl:w-[700px]">
                        <!-- Credit Control -->
                        <form action="{{ route('admin.users.credits', $user) }}" method="POST" class="rounded-[28px] bg-white p-5 border border-black/[0.03] shadow-sm group/form">
                            @csrf @method('PATCH')
                            <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-[#a89078]">Allocate Credits</p>
                            <div class="mt-4 flex items-center gap-2">
                                <input type="number" name="free_designs_left" value="{{ $user->free_designs_left ?? 0 }}" class="w-full rounded-xl border border-black/[0.04] bg-[#faf9f6] px-4 py-3 text-[13px] font-bold text-black outline-none focus:bg-white focus:ring-1 focus:ring-[#7a8a6b]">
                                <button type="submit" class="shrink-0 rounded-xl bg-black px-4 py-3 text-white transition hover:scale-105 active:scale-95">
                                    <i class="fa-solid fa-check text-[10px]"></i>
                                </button>
                            </div>
                        </form>

                        <!-- Tier Management -->
                        <form action="{{ route('admin.users.subscription', $user) }}" method="POST" class="rounded-[28px] bg-white p-5 border border-black/[0.03] shadow-sm group/form">
                            @csrf @method('PATCH')
                            <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-[#7a8a6b]">Member Grade</p>
                            <div class="mt-4 flex items-center gap-2">
                                <select name="is_premium" class="w-full rounded-xl border border-black/[0.04] bg-[#faf9f6] px-4 py-3 text-[13px] font-bold text-black outline-none appearance-none focus:bg-white focus:ring-1 focus:ring-[#7a8a6b]">
                                    <option value="0" @selected(! $user->is_premium)>Standard</option>
                                    <option value="1" @selected($user->is_premium)>Premium Pro</option>
                                </select>
                                <button type="submit" class="shrink-0 rounded-xl bg-black px-4 py-3 text-white transition hover:scale-105 active:scale-95">
                                    <i class="fa-solid fa-check text-[10px]"></i>
                                </button>
                            </div>
                        </form>

                        <!-- Security Control -->
                        <div class="rounded-[28px] bg-white p-5 border border-black/[0.03] shadow-sm">
                            <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-[#8c4343]">Security Protocol</p>
                            <div class="mt-4">
                                <form action="{{ route('admin.users.block', $user) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="w-full rounded-xl py-3 text-[11px] font-bold uppercase tracking-widest transition-all {{ $user->is_blocked ? 'bg-[#eef3ea] text-[#405038] hover:bg-[#7a8a6b] hover:text-white' : 'bg-[#f7e9e9] text-[#8c4343] hover:bg-[#8c4343] hover:text-white' }}">
                                        {{ $user->is_blocked ? 'Reinstate Access' : 'Suspend Account' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="py-32 text-center">
                <div class="inline-flex h-20 w-20 items-center justify-center rounded-[32px] bg-[#fbfaf8] text-[#a89078] shadow-inner">
                    <i class="fa-solid fa-user-slash text-2xl"></i>
                </div>
                <h3 class="mt-8 font-[Playfair Display] text-2xl font-bold text-black">No matching identities found.</h3>
                <p class="mt-2 text-sm font-medium text-[#7a8a6b]">The specified criteria did not return any records from the member database.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Footer -->
    <div class="mt-12 flex flex-col gap-8 border-t border-black/[0.03] pt-10 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex items-center gap-4">
            <span class="text-[11px] font-bold uppercase tracking-widest text-[#a89078]">Audit Range</span>
            <p class="text-[13px] font-bold text-black">
                Showing {{ $users->firstItem() ?? 0 }}—{{ $users->lastItem() ?? 0 }} of {{ number_format($users->total()) }} members
            </p>
        </div>
        <div class="admin-pagination">
            {{ $users->links() }}
        </div>
    </div>
</section>
@endsection


