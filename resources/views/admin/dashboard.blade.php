@extends('admin.layout')

@section('title', 'DASHBOARD')

@section('content')
<div class="animate-fade">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 40px;">
        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div style="color: var(--text-secondary); font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">Total Active Users</div>
                <span class="badge badge-success">+12%</span>
            </div>
            <div class="font-heading" style="font-size: 32px;">{{ number_format($stats['total_users']) }}</div>
            <div style="font-size: 11px; color: var(--text-secondary);">Across all platforms</div>
        </div>

        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div style="color: var(--text-secondary); font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">AI Designs Generated</div>
                <span class="badge badge-success">+24%</span>
            </div>
            <div class="font-heading" style="font-size: 32px;">{{ number_format($stats['total_designs']) }}</div>
            <div style="font-size: 11px; color: var(--text-secondary);">High precision renders</div>
        </div>

        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div style="color: var(--text-secondary); font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">Premium Subscriptions</div>
                <span class="badge badge-warning">PRO</span>
            </div>
            <div class="font-heading" style="font-size: 32px;">{{ number_format($stats['total_users'] * 0.15) }}</div> <!-- Mocked % -->
            <div style="font-size: 11px; color: var(--text-secondary);">Conversion rate tracking</div>
        </div>

        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div style="color: var(--text-secondary); font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">System Health</div>
                <span class="badge badge-success">OPTIMAL</span>
            </div>
            <div class="font-heading" style="font-size: 32px;">99.9%</div>
            <div style="font-size: 11px; color: var(--text-secondary);">Server uptime</div>
        </div>
    </div>

    <div style="display: grid; grid-cols: 1 lg:grid-cols-3; gap: 40px;">
        <!-- Recent Activity -->
        <div style="grid-column: span 2;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 class="font-heading">RECENT TRANSFORMATIONS</h3>
                <a href="#" style="color: var(--neon-blue); text-decoration: none; font-size: 12px; font-weight: 600; text-transform: uppercase;">View All</a>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>User Instance</th>
                            <th>Style Requested</th>
                            <th>Status</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['recent_activity'] as $activity)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: var(--navy); display: flex; align-items: center; justify-content: center; font-size: 12px; color: var(--neon-blue);">
                                        {{ strtoupper(substr($activity->user->name ?? 'G', 0, 1)) }}
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500;">{{ $activity->user->name ?? 'Guest User' }}</div>
                                </div>
                            </td>
                            <td><span class="badge" style="background: rgba(131, 56, 236, 0.1); color: var(--neon-purple);">{{ $activity->style_name ?? 'Modern' }}</span></td>
                            <td><span class="badge badge-success">RENDERED</span></td>
                            <td style="font-size: 12px; color: var(--text-secondary);">{{ $activity->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- System Alerts / Shortcuts -->
        <div>
            <h3 class="font-heading" style="margin-bottom: 20px;">QUICK ACTIONS</h3>
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; cursor: pointer;">
                    <div style="width: 48px; border-radius: 12px; height: 48px; background: rgba(58, 134, 255, 0.1); display: flex; align-items: center; justify-content: center; color: var(--neon-blue);">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18z"></path><path d="M12 8v4"></path><path d="M12 16h.01"></path></svg>
                    </div>
                    <div>
                        <div style="font-weight: 600; font-size: 14px;">System Audit</div>
                        <div style="font-size: 11px; color: var(--text-secondary);">Check API logs & quotas</div>
                    </div>
                </div>

                <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; cursor: pointer;">
                    <div style="width: 48px; border-radius: 12px; height: 48px; background: rgba(131, 56, 236, 0.1); display: flex; align-items: center; justify-content: center; color: var(--neon-purple);">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20"></path><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    </div>
                    <div>
                        <div style="font-weight: 600; font-size: 14px;">Revenue Center</div>
                        <div style="font-size: 11px; color: var(--text-secondary);">View manual receipts</div>
                    </div>
                </div>

                <div style="margin-top: 20px; padding: 30px; border-radius: 20px; background: var(--grad-primary); position: relative; overflow: hidden;">
                    <div style="position: relative; z-index: 1;">
                        <div style="font-weight: 800; font-size: 18px; margin-bottom: 5px;">PRO VERSION</div>
                        <p style="font-size: 12px; opacity: 0.8; margin-bottom: 20px;">Unlock advanced architectural analytics and user behavior mapping.</p>
                        <button class="btn-glass" style="background: rgba(255, 255, 255, 0.2); border: none; font-size: 12px; padding: 8px 20px;">Upgrade Hub</button>
                    </div>
                    <div style="position: absolute; right: -20px; bottom: -20px; font-size: 120px; opacity: 0.1; font-weight: 900;">AI</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
