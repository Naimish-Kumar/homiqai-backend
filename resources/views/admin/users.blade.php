@extends('admin.layout')

@section('title', 'Users')

@section('content')
<section class="grid gap-6 md:grid-cols-4">
    <article class="rounded-[28px] border border-black/6 bg-white p-6 shadow-[0_18px_50px_rgba(31,31,31,0.06)]">
        <p class="text-sm text-[#5e564e]">Total users</p>
        <p class="mt-3 text-3xl font-semibold text-[#171717]">{{ number_format($summary['total_users']) }}</p>
    </article>
    <article class="rounded-[28px] border border-black/6 bg-white p-6 shadow-[0_18px_50px_rgba(31,31,31,0.06)]">
        <p class="text-sm text-[#5e564e]">Admins</p>
        <p class="mt-3 text-3xl font-semibold text-[#171717]">{{ number_format($summary['admins']) }}</p>
    </article>
    <article class="rounded-[28px] border border-black/6 bg-white p-6 shadow-[0_18px_50px_rgba(31,31,31,0.06)]">
        <p class="text-sm text-[#5e564e]">Premium users</p>
        <p class="mt-3 text-3xl font-semibold text-[#171717]">{{ number_format($summary['premium']) }}</p>
    </article>
    <article class="rounded-[28px] border border-black/6 bg-white p-6 shadow-[0_18px_50px_rgba(31,31,31,0.06)]">
        <p class="text-sm text-[#5e564e]">Blocked users</p>
        <p class="mt-3 text-3xl font-semibold text-[#171717]">{{ number_format($summary['blocked']) }}</p>
    </article>
</section>

<section class="mt-6 rounded-[32px] border border-black/6 bg-white p-6 shadow-[0_22px_60px_rgba(31,31,31,0.07)]">
    <div class="flex flex-col gap-4 border-b border-black/6 pb-5 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.26em] text-[#7a8a6b]">People</p>
            <h2 class="mt-3 font-[Playfair Display] text-3xl leading-tight text-[#171717]">User management</h2>
        </div>
        <form action="{{ route('admin.users') }}" method="GET" class="flex w-full max-w-md items-center gap-3 rounded-full border border-black/8 bg-[#faf7f2] px-4 py-3">
            <input type="search" name="search" value="{{ $search }}" placeholder="Search name or email" class="w-full bg-transparent text-sm text-[#171717] outline-none placeholder:text-[#8b8175]">
            <button type="submit" class="rounded-full bg-[#171717] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#2a2a2a]">Search</button>
        </form>
    </div>

    <div class="mt-6 space-y-5">
        @forelse($users as $user)
            @php
                $latestSubscription = $user->subscriptions->first();
                $hasActiveSubscription = $latestSubscription && $latestSubscription->status === 'active' && $latestSubscription->end_date?->isFuture();
            @endphp
            <article class="rounded-[28px] border border-black/6 bg-[#faf7f2] p-5">
                <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
                    <div class="flex items-start gap-4">
                        <span class="flex h-12 w-12 items-center justify-center rounded-full bg-[#f0e7d9] font-semibold text-[#171717]">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                        <div>
                            <div class="flex flex-wrap items-center gap-3">
                                <p class="text-lg font-semibold text-[#171717]">{{ $user->name }}</p>
                                @if($user->is_admin)
                                    <span class="rounded-full bg-[#f1ece6] px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em] text-[#433d36]">Admin</span>
                                @endif
                                @if($user->is_blocked)
                                    <span class="rounded-full bg-[#f7e9e9] px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em] text-[#8c4343]">Blocked</span>
                                @endif
                            </div>
                            <p class="mt-1 text-sm text-[#5f5750]">{{ $user->email ?: 'No email provided' }}</p>
                            <div class="mt-4 flex flex-wrap gap-5 text-sm text-[#5f5750]">
                                <span><strong class="text-[#171717]">{{ number_format($user->room_designs_count) }}</strong> designs</span>
                                <span><strong class="text-[#171717]">{{ $user->free_designs_left ?? 0 }}</strong> credits left</span>
                                <span><strong class="text-[#171717]">{{ $hasActiveSubscription || $user->is_premium ? 'Premium' : 'Free' }}</strong> subscription</span>
                                <span><strong class="text-[#171717]">{{ $user->created_at->format('M d, Y') }}</strong> joined</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-3 md:grid-cols-3 xl:min-w-[40rem]">
                        <form action="{{ route('admin.users.credits', $user) }}" method="POST" class="rounded-[22px] border border-black/6 bg-white p-4">
                            @csrf
                            @method('PATCH')
                            <label class="block text-xs font-semibold uppercase tracking-[0.18em] text-[#7a8a6b]">Credits</label>
                            <div class="mt-3 flex items-center gap-2">
                                <input type="number" min="0" name="free_designs_left" value="{{ $user->free_designs_left ?? 0 }}" class="w-full rounded-full border border-black/8 bg-[#faf7f2] px-4 py-2 text-sm text-[#171717] outline-none">
                                <button type="submit" class="rounded-full bg-[#171717] px-4 py-2 text-xs font-semibold text-white">Save</button>
                            </div>
                        </form>

                        <form action="{{ route('admin.users.subscription', $user) }}" method="POST" class="rounded-[22px] border border-black/6 bg-white p-4">
                            @csrf
                            @method('PATCH')
                            <label class="block text-xs font-semibold uppercase tracking-[0.18em] text-[#7a8a6b]">Subscription</label>
                            <div class="mt-3 flex items-center gap-2">
                                <select name="is_premium" class="w-full rounded-full border border-black/8 bg-[#faf7f2] px-4 py-2 text-sm text-[#171717] outline-none">
                                    <option value="0" @selected(! $user->is_premium)>Free</option>
                                    <option value="1" @selected($user->is_premium)>Premium</option>
                                </select>
                                <button type="submit" class="rounded-full bg-[#171717] px-4 py-2 text-xs font-semibold text-white">Save</button>
                            </div>
                            @if($latestSubscription)
                                <p class="mt-2 text-xs text-[#6a625a]">Latest expiry: {{ $latestSubscription->end_date?->format('M d, Y') }}</p>
                            @endif
                        </form>

                        <form action="{{ route('admin.users.block', $user) }}" method="POST" class="rounded-[22px] border border-black/6 bg-white p-4">
                            @csrf
                            @method('PATCH')
                            <label class="block text-xs font-semibold uppercase tracking-[0.18em] text-[#7a8a6b]">Access</label>
                            <p class="mt-3 text-sm text-[#5f5750]">{{ $user->is_blocked ? 'Currently blocked from login and AI requests.' : 'Currently allowed to use the app.' }}</p>
                            <button type="submit" class="mt-3 rounded-full px-4 py-2 text-xs font-semibold {{ $user->is_blocked ? 'bg-[#eef3ea] text-[#405038]' : 'bg-[#f7e9e9] text-[#8c4343]' }}">
                                {{ $user->is_blocked ? 'Unblock User' : 'Block User' }}
                            </button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <div class="py-8 text-center text-sm text-[#6a625a]">No users matched your search.</div>
        @endforelse
    </div>

    <div class="mt-6 flex flex-col gap-4 border-t border-black/6 pt-5 text-sm text-[#6a625a] lg:flex-row lg:items-center lg:justify-between">
        <span>Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users</span>
        <div>{{ $users->links() }}</div>
    </div>
</section>
@endsection
