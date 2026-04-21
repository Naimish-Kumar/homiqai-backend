@extends('admin.layout')

@section('title', 'Users')

@section('content')
<section class="metric-grid compact">
    <article class="metric-card"><span>Total users</span><strong>{{ number_format($summary['total_users']) }}</strong></article>
    <article class="metric-card"><span>Admins</span><strong>{{ number_format($summary['admins']) }}</strong></article>
    <article class="metric-card"><span>Premium</span><strong>{{ number_format($summary['premium']) }}</strong></article>
</section>

<section class="panel">
    <div class="panel-header">
        <div>
            <p class="eyebrow">People</p>
            <h2>Customer directory</h2>
        </div>
        <form action="{{ route('admin.users') }}" method="GET" class="search-form">
            <input type="search" name="search" value="{{ $search }}" placeholder="Search name or email">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Designs</th>
                    <th>Account Type</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                <div>
                                    <strong>{{ $user->name }}</strong>
                                    <small>{{ $user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->is_admin ? 'Admin' : 'Customer' }}</td>
                        <td>{{ number_format($user->room_designs_count) }}</td>
                        <td>
                            @if($user->is_premium)
                                <span class="status completed" style="background: #fef3c7; color: #92400e; border: 1px solid #fde68a;">
                                    <i class="fa-solid fa-crown" style="font-size: 0.75rem;"></i> Premium
                                </span>
                            @else
                                <span class="status pending">Basic</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No users matched your search.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-row">
        <span>Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users</span>
        <div>{{ $users->links() }}</div>
    </div>
</section>
@endsection
