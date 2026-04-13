@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<section class="dashboard-hero">
    <div>
        <p class="eyebrow">Command center</p>
        <h2>Rose gold operations for every design moment.</h2>
        <p>Watch room transformations, user growth, and style demand from one polished workspace.</p>
    </div>
    <div class="dashboard-hero-card">
        <span>Monthly designs</span>
        <strong>{{ number_format($stats['monthly_designs']) }}</strong>
        <small>{{ number_format($stats['today_designs']) }} created today</small>
    </div>
</section>

<section class="metric-grid">
    <article class="metric-card">
        <i class="fa-solid fa-users metric-icon"></i>
        <span>Total users</span>
        <strong>{{ number_format($stats['total_users']) }}</strong>
        <small>{{ number_format($stats['monthly_users']) }} joined this month</small>
    </article>
    <article class="metric-card">
        <i class="fa-solid fa-wand-magic-sparkles metric-icon"></i>
        <span>Designs generated</span>
        <strong>{{ number_format($stats['total_designs']) }}</strong>
        <small>{{ number_format($stats['today_designs']) }} created today</small>
    </article>
    <article class="metric-card">
        <i class="fa-solid fa-chart-line metric-icon"></i>
        <span>Active users</span>
        <strong>{{ number_format($stats['active_users']) }}</strong>
        <small>Last 30 days</small>
    </article>
    <article class="metric-card">
        <i class="fa-solid fa-circle-check metric-icon"></i>
        <span>Verified users</span>
        <strong>{{ $stats['conversion_rate'] }}%</strong>
        <small>{{ number_format($stats['verified_users']) }} verified accounts</small>
    </article>
</section>

<section class="dashboard-grid">
    <div class="panel panel-large">
        <div class="panel-header">
            <div>
                <p class="eyebrow">Latest activity</p>
                <h2>Recent room transformations</h2>
            </div>
            <a href="{{ route('admin.users') }}" class="text-link">Manage users</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Style</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stats['recent_activity'] as $activity)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <span>{{ strtoupper(substr($activity->user->name ?? 'G', 0, 1)) }}</span>
                                    <div>
                                        <strong>{{ $activity->user->name ?? 'Guest User' }}</strong>
                                        <small>{{ $activity->user->email ?? 'No email attached' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $activity->style->name ?? 'Unassigned' }}</td>
                            <td><span class="status {{ $activity->status }}">{{ ucfirst($activity->status) }}</span></td>
                            <td>{{ $activity->created_at?->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-state">No room designs have been generated yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <div>
                <p class="eyebrow">Pipeline</p>
                <h2>Design status</h2>
            </div>
        </div>
        <div class="status-list">
            <div><span>Completed</span><strong>{{ number_format($stats['completed_designs']) }}</strong></div>
            <div><span>Processing</span><strong>{{ number_format($stats['processing_designs']) }}</strong></div>
            <div><span>Pending</span><strong>{{ number_format($stats['pending_designs']) }}</strong></div>
            <div><span>Failed</span><strong>{{ number_format($stats['failed_designs']) }}</strong></div>
        </div>
    </div>
</section>

<section class="dashboard-grid lower">
    <div class="panel">
        <div class="panel-header">
            <div>
                <p class="eyebrow">Seven days</p>
                <h2>Growth snapshot</h2>
            </div>
        </div>
        <div class="mini-chart">
            @php
                $maxValue = max(1, $stats['growth']->max(fn ($day) => max($day['users'], $day['designs'])));
            @endphp
            @foreach($stats['growth'] as $day)
                <div>
                    <span class="bar users" style="height: {{ max(8, ($day['users'] / $maxValue) * 120) }}px"></span>
                    <span class="bar designs" style="height: {{ max(8, ($day['designs'] / $maxValue) * 120) }}px"></span>
                    <small>{{ $day['label'] }}</small>
                </div>
            @endforeach
        </div>
        <div class="chart-legend">
            <span><i class="legend-users"></i>Users</span>
            <span><i class="legend-designs"></i>Designs</span>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <div>
                <p class="eyebrow">Style demand</p>
                <h2>Top styles</h2>
            </div>
        </div>
        <div class="status-list">
            @forelse($stats['top_styles'] as $style)
                <div><span>{{ $style->name }}</span><strong>{{ number_format($style->room_designs_count) }}</strong></div>
            @empty
                <p class="empty-state">No styles are available yet.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
