@extends('admin.layout')

@section('title', 'Community')

@section('content')
<section class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
    <article class="rounded-[32px] border border-black/5 bg-white p-7 shadow-[0_18px_50px_rgba(31,31,31,0.04)]">
        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#a89078]">Ecosystem total</p>
        <p class="mt-4 text-3xl font-bold text-[#171717]">{{ number_format($summary['total_users']) }}</p>
        <p class="mt-2 text-xs font-semibold text-[#7a8a6b]">Registered members</p>
    </article>
    <article class="rounded-[32px] border border-black/5 bg-white p-7 shadow-[0_18px_50px_rgba(31,31,31,0.04)]">
        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#7a8a6b]">Administration</p>
        <p class="mt-4 text-3xl font-bold text-[#171717]">{{ number_format($summary['admins']) }}</p>
        <p class="mt-2 text-xs font-semibold text-[#7a8a6b]">Full system access</p>
    </article>
    <article class="rounded-[32px] border border-black/5 bg-white p-7 shadow-[0_18px_50px_rgba(31,31,31,0.04)]">
        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#a89078]">Premium Tier</p>
        <p class="mt-4 text-3xl font-bold text-[#171717]">{{ number_format($summary['premium']) }}</p>
        <p class="mt-2 text-xs font-semibold text-[#7a8a6b]">Paid subscriptions</p>
    </article>
    <article class="rounded-[32px] border border-black/5 bg-white p-7 shadow-[0_18px_50px_rgba(31,31,31,0.04)]">
        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#8c4343]">Restrictions</p>
        <p class="mt-4 text-3xl font-bold text-[#171717]">{{ number_format($summary['blocked']) }}</p>
        <p class="mt-2 text-xs font-semibold text-[#8c4343]">Blocked accounts</p>
    </article>
</section>

<section class="mt-6 rounded-[40px] border border-black/5 bg-white p-8 shadow-[0_22px_60px_rgba(31,31,31,0.06)]">
    <div class="flex flex-col gap-5 border-b border-black/5 pb-8 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Member Database</p>
            <h2 class="mt-3 font-[Playfair Display] text-3xl font-bold text-[#171717]">User Directory</h2>
        </div>
        <form action="{{ route('admin.users') }}" method="GET" class="flex w-full max-w-lg items-center gap-4 rounded-3xl border border-black/5 bg-[#fbfaf8] px-5 py-3 focus-within:ring-2 focus-within:ring-[#7a8a6b]/20 transition-all">
            <i class="fa-solid fa-magnifying-glass text-[#a89078]"></i>
            <input type="search" name="search" value="{{ $search }}" placeholder="Search name, email, or ID" class="w-full bg-transparent text-sm font-medium text-[#171717] outline-none placeholder:text-[#8b8175]">
            <button type="submit" class="rounded-2xl bg-[#171717] px-6 py-2.5 text-xs font-bold text-white transition hover:bg-black">Find</button>
        </form>
    </div>

    <div class="mt-8 space-y-6">
        @forelse($users as $user)
            @php
                $latestSubscription = $user->subscriptions->first();
                $hasActiveSubscription = $latestSubscription && $latestSubscription->status === 'active' && $latestSubscription->end_date?->isFuture();
            @endphp
            <article class="group relative overflow-hidden rounded-[36px] border border-black/5 bg-[#fbfaf8] p-6 transition hover:bg-[#faf7f2] hover:shadow-md">
                <div class="flex flex-col gap-6 xl:flex-row xl:items-center xl:justify-between">
                    <div class="flex items-center gap-5">
                        <div class="relative">
                            <span class="flex h-16 w-16 items-center justify-center rounded-[22px] bg-white text-xl font-bold text-[#171717] shadow-sm ring-1 ring-black/5">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                            @if($hasActiveSubscription || $user->is_premium)
                                <span class="absolute -right-2 -top-2 flex h-6 w-6 items-center justify-center rounded-full bg-[#171717] text-[10px] text-white shadow-lg ring-2 ring-white">
                                    <i class="fa-solid fa-crown"></i>
                                </span>
                            @endif
                        </div>
                        <div>
                            <div class="flex flex-wrap items-center gap-3">
                                <p class="text-xl font-bold text-[#171717]">{{ $user->name }}</p>
                                @if($user->is_admin)
                                    <span class="rounded-full bg-[#eef3ea] px-3 py-1 text-[9px] font-bold uppercase tracking-widest text-[#405038]">Admin</span>
                                @endif
                                @if($user->is_blocked)
                                    <span class="rounded-full bg-[#f7e9e9] px-3 py-1 text-[9px] font-bold uppercase tracking-widest text-[#8c4343]">Restricted</span>
                                @endif
                            </div>
                            <p class="mt-1 text-sm font-medium text-[#7a8a6b]">{{ $user->email ?: 'private@no-email' }}</p>
                            <div class="mt-4 flex flex-wrap gap-6 text-[11px] font-bold uppercase tracking-wider text-[#a89078]">
                                <span class="flex items-center gap-2"><i class="fa-solid fa-wand-magic-sparkles"></i> {{ number_format($user->room_designs_count) }} Designs</span>
                                <span class="flex items-center gap-2"><i class="fa-solid fa-bolt"></i> {{ $user->free_designs_left ?? 0 }} Credits</span>
                                <span class="flex items-center gap-2"><i class="fa-solid fa-calendar"></i> {{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-3 xl:min-w-[42rem]">
                        <form action="{{ route('admin.users.credits', $user) }}" method="POST" class="rounded-[28px] border border-black/5 bg-white p-5 shadow-sm">
                            @csrf
                            @method('PATCH')
                            <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-[#a89078]">Credit Balance</p>
                            <div class="mt-3 flex items-center gap-3">
                                <input type="number" min="0" name="free_designs_left" value="{{ $user->free_designs_left ?? 0 }}" class="w-full rounded-xl border border-black/5 bg-[#fbfaf8] px-4 py-2.5 text-sm font-bold text-[#171717] outline-none focus:ring-1 focus:ring-[#7a8a6b]">
                                <button type="submit" class="shrink-0 rounded-xl bg-[#171717] p-2.5 text-white transition hover:bg-black">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </div>
                        </form>

                        <form action="{{ route('admin.users.subscription', $user) }}" method="POST" class="rounded-[28px] border border-black/5 bg-white p-5 shadow-sm">
                            @csrf
                            @method('PATCH')
                            <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-[#7a8a6b]">Membership Status</p>
                            <div class="mt-3 flex items-center gap-3">
                                <select name="is_premium" class="w-full rounded-xl border border-black/5 bg-[#fbfaf8] px-4 py-2.5 text-sm font-bold text-[#171717] outline-none appearance-none focus:ring-1 focus:ring-[#7a8a6b]">
                                    <option value="0" @selected(! $user->is_premium)>Standard</option>
                                    <option value="1" @selected($user->is_premium)>Premium</option>
                                </select>
                                <button type="submit" class="shrink-0 rounded-xl bg-[#171717] p-2.5 text-white transition hover:bg-black">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </div>
                        </form>

                        <div class="rounded-[28px] border border-black/5 bg-white p-5 shadow-sm">
                            <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-[#a89078]">Quick Controls</p>
                            <div class="mt-3 flex gap-2">
                                <form action="{{ route('admin.users.block', $user) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full rounded-xl py-2.5 text-[10px] font-bold uppercase tracking-widest transition {{ $user->is_blocked ? 'bg-[#eef3ea] text-[#405038] hover:bg-[#d6dfcf]' : 'bg-[#f7e9e9] text-[#8c4343] hover:bg-[#f2d3d3]' }}">
                                        {{ $user->is_blocked ? 'Reinstate' : 'Suspend' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="py-20 text-center">
                <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-[#fbfaf8] text-[#a89078]">
                    <i class="fa-solid fa-user-slash text-2xl"></i>
                </div>
                <p class="mt-4 text-sm font-bold text-[#171717]">No users match your criteria.</p>
                <p class="mt-2 text-xs font-medium text-[#7a8a6b]">Try refining your search terms or filters.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-10 flex flex-col gap-6 border-t border-black/5 pt-8 lg:flex-row lg:items-center lg:justify-between">
        <p class="text-xs font-bold text-[#a89078]">Showing <span class="text-[#171717]">{{ $users->firstItem() ?? 0 }}</span> to <span class="text-[#171717]">{{ $users->lastItem() ?? 0 }}</span> of <span class="text-[#171717]">{{ $users->total() }}</span> members</p>
        <div class="admin-pagination">
            {{ $users->links() }}
        </div>
    </div>
</section>
@endsection

