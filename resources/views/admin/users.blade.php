@extends('admin.layout')

@section('title', 'Users')

@section('content')
<section class="grid gap-6 md:grid-cols-3">
    <article class="rounded-[28px] border border-white/60 bg-white/72 p-6 shadow-[0_18px_50px_rgba(47,47,47,0.06)] backdrop-blur-xl">
        <p class="text-sm text-[color:rgba(47,47,47,0.62)]">Total users</p>
        <p class="mt-3 text-3xl font-semibold text-[var(--color-charcoal)]">{{ number_format($summary['total_users']) }}</p>
    </article>
    <article class="rounded-[28px] border border-white/60 bg-white/72 p-6 shadow-[0_18px_50px_rgba(47,47,47,0.06)] backdrop-blur-xl">
        <p class="text-sm text-[color:rgba(47,47,47,0.62)]">Admins</p>
        <p class="mt-3 text-3xl font-semibold text-[var(--color-charcoal)]">{{ number_format($summary['admins']) }}</p>
    </article>
    <article class="rounded-[28px] border border-white/60 bg-white/72 p-6 shadow-[0_18px_50px_rgba(47,47,47,0.06)] backdrop-blur-xl">
        <p class="text-sm text-[color:rgba(47,47,47,0.62)]">Premium users</p>
        <p class="mt-3 text-3xl font-semibold text-[var(--color-charcoal)]">{{ number_format($summary['premium']) }}</p>
    </article>
</section>

<section class="mt-6 rounded-[32px] border border-white/60 bg-white/72 p-6 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
    <div class="flex flex-col gap-4 border-b border-[rgba(47,47,47,0.08)] pb-5 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.26em] text-[var(--color-olive)]">People</p>
            <h2 class="mt-3 font-[var(--font-display)] text-3xl leading-tight">Customer directory</h2>
        </div>
        <form action="{{ route('admin.users') }}" method="GET" class="flex w-full max-w-md items-center gap-3 rounded-full border border-[rgba(47,47,47,0.10)] bg-[rgba(247,246,242,0.84)] px-4 py-3">
            <input type="search" name="search" value="{{ $search }}" placeholder="Search name or email" class="w-full bg-transparent text-sm text-[var(--color-charcoal)] outline-none placeholder:text-[color:rgba(47,47,47,0.42)]">
            <button type="submit" class="rounded-full bg-[var(--color-charcoal)] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[var(--color-taupe)]">Search</button>
        </form>
    </div>

    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full text-left">
            <thead>
                <tr class="text-xs font-semibold uppercase tracking-[0.24em] text-[color:rgba(47,47,47,0.46)]">
                    <th class="pb-4 pr-4">User</th>
                    <th class="pb-4 pr-4">Role</th>
                    <th class="pb-4 pr-4">Designs</th>
                    <th class="pb-4 pr-4">Account Type</th>
                    <th class="pb-4">Joined</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[rgba(47,47,47,0.08)]">
                @forelse($users as $user)
                    <tr>
                        <td class="py-4 pr-4">
                            <div class="flex items-center gap-3">
                                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-[rgba(203,187,160,0.25)] font-semibold text-[var(--color-charcoal)]">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                                <div>
                                    <p class="font-semibold text-[var(--color-charcoal)]">{{ $user->name }}</p>
                                    <p class="text-sm text-[color:rgba(47,47,47,0.56)]">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 pr-4 text-sm text-[color:rgba(47,47,47,0.72)]">{{ $user->is_admin ? 'Admin' : 'Customer' }}</td>
                        <td class="py-4 pr-4 text-sm text-[color:rgba(47,47,47,0.72)]">{{ number_format($user->room_designs_count) }}</td>
                        <td class="py-4 pr-4">
                            @if($user->is_premium)
                                <span class="inline-flex items-center gap-2 rounded-full bg-[rgba(203,187,160,0.22)] px-3 py-2 text-xs font-semibold uppercase tracking-[0.14em] text-[var(--color-taupe)]">
                                    <i class="fa-solid fa-crown text-[10px]"></i> Premium
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-[rgba(47,47,47,0.08)] px-3 py-2 text-xs font-semibold uppercase tracking-[0.14em] text-[var(--color-charcoal)]">
                                    Basic
                                </span>
                            @endif
                        </td>
                        <td class="py-4 text-sm text-[color:rgba(47,47,47,0.58)]">{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-sm text-[color:rgba(47,47,47,0.56)]">No users matched your search.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex flex-col gap-4 border-t border-[rgba(47,47,47,0.08)] pt-5 text-sm text-[color:rgba(47,47,47,0.58)] lg:flex-row lg:items-center lg:justify-between">
        <span>Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users</span>
        <div>{{ $users->links() }}</div>
    </div>
</section>
@endsection
