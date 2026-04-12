@extends('admin.layout')

@section('title', 'Revenue')

@section('content')
<section class="metric-grid">
    <article class="metric-card"><span>Estimated MRR</span><strong>₹{{ number_format($summary['estimated_mrr']) }}</strong><small>Based on verified users</small></article>
    <article class="metric-card"><span>Premium users</span><strong>{{ number_format($summary['premium_users']) }}</strong><small>Email verified accounts</small></article>
    <article class="metric-card"><span>Free users</span><strong>{{ number_format($summary['free_users']) }}</strong><small>Awaiting upgrade</small></article>
    <article class="metric-card"><span>Monthly signups</span><strong>{{ number_format($summary['monthly_signups']) }}</strong><small>Current month</small></article>
</section>

<section class="panel">
    <div class="panel-header">
        <div>
            <p class="eyebrow">Subscribers</p>
            <h2>Recent premium accounts</h2>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Plan</th>
                    <th>Estimated value</th>
                    <th>Verified</th>
                </tr>
            </thead>
            <tbody>
                @forelse($premiumUsers as $user)
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
                        <td>Premium</td>
                        <td>₹199 / month</td>
                        <td>{{ $user->email_verified_at?->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state">No premium users yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
