@extends('admin.layout')

@section('title', 'Revenue & Subscriptions')

@section('content')
<section class="metric-grid">
    <article class="metric-card">
        <span>Estimated MRR</span>
        <strong>₹{{ number_format($summary['estimated_mrr']) }}</strong>
        <small>Active monthly recurring revenue</small>
    </article>
    <article class="metric-card">
        <span>Total Revenue</span>
        <strong>₹{{ number_format($summary['total_revenue']) }}</strong>
        <small>Lifetime processed</small>
    </article>
    <article class="metric-card">
        <span>Platform Split</span>
        <div style="display: flex; gap: 1rem; margin-top: 0.5rem;">
            <div style="text-align: center;">
                <small style="display: block;">iOS</small>
                <strong>{{ $summary['ios_users'] }}</strong>
            </div>
            <div style="text-align: center;">
                <small style="display: block;">Android</small>
                <strong>{{ $summary['android_users'] }}</strong>
            </div>
        </div>
    </article>
    <article class="metric-card">
        <span>Active Subs</span>
        <strong>{{ number_format($summary['active_subscriptions']) }}</strong>
        <small>Currently valid</small>
    </article>
</section>

<section class="panel">
    <div class="panel-header">
        <div>
            <p class="eyebrow">Transactions</p>
            <h2>Recent Store Purchases</h2>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Plan</th>
                    <th>Platform</th>
                    <th>Transaction ID</th>
                    <th>Status</th>
                    <th>Expiry</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentSubscriptions as $sub)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <span style="background: #4f46e5; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                    {{ strtoupper(substr($sub->user->name ?? 'U', 0, 1)) }}
                                </span>
                                <div>
                                    <strong>{{ $sub->user->name ?? 'Unknown' }}</strong>
                                    <small>{{ $sub->user->email ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; flex-direction: column;">
                                <strong>{{ $sub->package_name }}</strong>
                                <small>₹{{ number_format($sub->amount) }}</small>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-{{ $sub->platform }}">
                                {{ strtoupper($sub->platform) }}
                            </span>
                        </td>
                        <td>
                            <code style="font-size: 0.75rem; background: #f3f4f6; padding: 0.25rem; border-radius: 0.25rem;">
                                {{ Str::limit($sub->transaction_id, 12) }}
                            </code>
                        </td>
                        <td>
                            <span class="status-indicator status-{{ $sub->status }}"></span>
                            {{ ucfirst($sub->status) }}
                        </td>
                        <td>
                            {{ $sub->end_date->format('d M, Y') }}
                            <small style="display: block; color: {{ $sub->end_date->isPast() ? '#ef4444' : '#10b981' }}">
                                {{ $sub->end_date->diffForHumans() }}
                            </small>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">No transactions recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<style>
    .badge { padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
    .badge-ios { background: #f3f4f6; color: #1f2937; }
    .badge-android { background: #ecfdf5; color: #047857; }
    .status-indicator { display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: 0.5rem; }
    .status-active { background: #10b981; }
    .status-expired { background: #ef4444; }
</style>
@endsection

