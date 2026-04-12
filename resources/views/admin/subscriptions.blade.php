@extends('admin.layout')

@section('title', 'SUBSCRIPTIONS')

@section('content')
<div class="animate-fade">
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
        
        <!-- Pending Verification -->
        <div>
            <div style="margin-bottom: 30px;">
                <h2 class="font-heading" style="font-size: 28px;">Revenue Verification</h2>
                <p style="color: var(--text-secondary); font-size: 14px;">Review and approve manual payment receipts from mobile users.</p>
            </div>

            <div style="display: flex; flex-direction: column; gap: 20px;">
                @foreach($pendingReceipts as $user)
                <div class="glass-card" style="padding: 24px; display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; gap: 20px; align-items: center;">
                        <div style="width: 60px; height: 60px; border-radius: 12px; background: var(--navy); display: flex; align-items: center; justify-content: center; color: var(--neon-blue);">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </div>
                        <div>
                            <div style="font-weight: 700; font-size: 16px;">{{ $user->name }}</div>
                            <div style="font-size: 12px; color: var(--text-secondary);">Submitted {{ $user->created_at->diffForHumans() }} • <strong>Premium Lite Plan</strong></div>
                        </div>
                    </div>
                    <div style="display: flex; gap: 12px;">
                        <a href="#" class="btn-glass" style="padding: 10px 20px; font-size: 12px; text-decoration: none;">View Receipt</a>
                        <form action="#" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-primary" style="padding: 10px 20px; font-size: 12px;">Approve Access</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Financial Summary -->
        <div>
            <h3 class="font-heading" style="margin-bottom: 24px;">REVENUE METRICS</h3>
            
            <div class="glass" style="padding: 30px; margin-bottom: 30px;">
                <div style="color: var(--text-secondary); font-size: 11px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">Monthly Recurring Revenue</div>
                <div class="font-heading" style="font-size: 42px; color: var(--success);">₹24,850</div>
                <div style="font-size: 12px; color: var(--text-secondary);">+8.4% from last month</div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 15px;">
                <div class="glass" style="padding: 20px; display: flex; justify-content: space-between;">
                    <span style="font-size: 14px; color: var(--text-secondary);">Premium Elite</span>
                    <span style="font-weight: 700;">143 Users</span>
                </div>
                <div class="glass" style="padding: 20px; display: flex; justify-content: space-between;">
                    <span style="font-size: 14px; color: var(--text-secondary);">Standard Plus</span>
                    <span style="font-weight: 700;">258 Users</span>
                </div>
                <div class="glass" style="padding: 20px; display: flex; justify-content: space-between;">
                    <span style="font-size: 14px; color: var(--text-secondary);">Free Tier</span>
                    <span style="font-weight: 700;">1,240 Users</span>
                </div>
            </div>

            <div class="glass-card" style="margin-top: 30px; padding: 30px; background: rgba(58, 134, 255, 0.05);">
                <h4 style="font-size: 14px; margin-bottom: 15px;">Automatic Stripe Integration</h4>
                <p style="font-size: 12px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 20px;">Your automated Stripe webhooks are currently processing 85% of global revenue. 15% remains on manual mobile verification.</p>
                <button class="btn-glass" style="width: 100%; font-size: 12px;">Config Webhooks</button>
            </div>
        </div>

    </div>
</div>
@endsection
