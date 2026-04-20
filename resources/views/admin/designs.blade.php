@extends('admin.layout')
@section('title', 'Designs')

@section('content')
<div class="admin-section">
    <div class="stat-grid" style="grid-template-columns: repeat(4, 1fr);">
        <div class="stat-card"><p class="eyebrow">Total</p><h2>{{ $summary['total'] }}</h2></div>
        <div class="stat-card"><p class="eyebrow">Completed</p><h2>{{ $summary['completed'] }}</h2></div>
        <div class="stat-card"><p class="eyebrow">Processing</p><h2>{{ $summary['processing'] }}</h2></div>
        <div class="stat-card"><p class="eyebrow">Failed</p><h2>{{ $summary['failed'] }}</h2></div>
    </div>

    <div class="admin-card" style="margin-top: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3>All Designs</h3>
            <form method="GET" style="display: flex; gap: 8px;">
                <select name="status" onchange="this.form.submit()" style="padding: 8px 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <option value="">All Status</option>
                    <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="processing" {{ $status === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </form>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Style</th>
                    <th>Budget</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($designs as $design)
                <tr>
                    <td>#{{ $design->id }}</td>
                    <td>{{ $design->user->name ?? 'Deleted User' }}</td>
                    <td>{{ $design->style->name ?? '—' }}</td>
                    <td><span class="badge">{{ ucfirst($design->budget) }}</span></td>
                    <td>
                        <span class="badge {{ $design->status === 'completed' ? 'badge-success' : ($design->status === 'failed' ? 'badge-danger' : 'badge-warning') }}">
                            {{ ucfirst($design->status) }}
                        </span>
                    </td>
                    <td>{{ $design->created_at->diffForHumans() }}</td>
                    <td>
                        <form action="{{ route('admin.designs.delete', $design) }}" method="POST" onsubmit="return confirm('Delete this design?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align: center; padding: 32px;">No designs found</td></tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 16px;">{{ $designs->links() }}</div>
    </div>
</div>
@endsection
