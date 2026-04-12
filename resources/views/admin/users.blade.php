@extends('admin.layout')

@section('title', 'USER MANAGEMENT')

@section('content')
<div class="animate-fade">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px;">
        <div>
            <h2 class="font-heading" style="font-size: 28px;">Registered Clients</h2>
            <p style="color: var(--text-secondary); font-size: 14px;">Oversee and manage your global user base.</p>
        </div>
        <div style="display: flex; gap: 15px;">
            <div class="glass" style="padding: 10px 20px; display: flex; align-items: center; gap: 10px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" placeholder="Search users..." style="background: transparent; border: none; color: white; outline: none; font-size: 14px; width: 200px;">
            </div>
            <button class="btn-primary" style="padding: 10px 24px; font-size: 13px;">Export CSV</button>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>User / Identifier</th>
                    <th>Email Address</th>
                    <th>Sub Status</th>
                    <th>Designs</th>
                    <th>Joined</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="width: 40px; height: 40px; border-radius: 12px; background: var(--navy); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--neon-blue);">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 600; font-size: 15px;">{{ $user->name }}</div>
                                <div style="font-size: 12px; color: var(--text-secondary);">ID: #{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size: 14px;">{{ $user->email }}</td>
                    <td>
                        @if($user->email_verified_at)
                            <span class="badge badge-success">Premium</span>
                        @else
                            <span class="badge" style="background: rgba(255, 255, 255, 0.05); color: var(--text-secondary);">Standard</span>
                        @endif
                    </td>
                    <td style="font-weight: 600;">{{ $user->room_designs_count ?? rand(1, 15) }}</td> <!-- Mocked count fallback -->
                    <td style="font-size: 13px; color: var(--text-secondary);">{{ $user->created_at->format('M d, Y') }}</td>
                    <td style="text-align: right;">
                        <div style="display: flex; gap: 10px; justify-content: flex-end;">
                            <a href="#" class="btn-glass" style="padding: 6px 12px; font-size: 11px; text-decoration: none;">View</a>
                            <form action="#" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-glass" style="padding: 6px 12px; font-size: 11px; color: var(--danger); border-color: rgba(239, 71, 111, 0.2);">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 30px; display: flex; justify-content: space-between; align-items: center;">
        <div style="font-size: 13px; color: var(--text-secondary);">
            Showing <span style="color: white; font-weight: 600;">{{ $users->firstItem() ?? 0 }}</span> to <span style="color: white; font-weight: 600;">{{ $users->lastItem() ?? 0 }}</span> of <span style="color: white; font-weight: 600;">{{ $users->total() ?? 0 }}</span> users
        </div>
        <div style="display: flex; gap: 10px;">
            @if($users->previousPageUrl())
                <a href="{{ $users->previousPageUrl() }}" class="btn-glass" style="padding: 8px 16px; font-size: 12px;">Previous</a>
            @endif
            @if($users->nextPageUrl())
                <a href="{{ $users->nextPageUrl() }}" class="btn-glass" style="padding: 8px 16px; font-size: 12px;">Next</a>
            @endif
        </div>
    </div>
</div>
@endsection
