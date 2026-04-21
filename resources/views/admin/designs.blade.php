@extends('admin.layout')

@section('title', 'Room Transformations')

@section('content')
<section class="metric-grid">
    <article class="metric-card"><span>Total Designs</span><strong>{{ number_format($summary['total']) }}</strong></article>
    <article class="metric-card"><span>Completed</span><strong style="color: #10b981;">{{ number_format($summary['completed']) }}</strong></article>
    <article class="metric-card"><span>Processing</span><strong style="color: #f59e0b;">{{ number_format($summary['processing']) }}</strong></article>
    <article class="metric-card"><span>Failed</span><strong style="color: #ef4444;">{{ number_format($summary['failed']) }}</strong></article>
</section>

<div class="panel" style="margin-top: 24px;">
    <div class="panel-header">
        <div>
            <p class="eyebrow">Gallery</p>
            <h2>All Transformations</h2>
        </div>
        <form method="GET" class="filter-form">
            <select name="status" onchange="this.form.submit()" class="form-control-sm">
                <option value="">All Status</option>
                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="processing" {{ $status === 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </form>
    </div>

    <div class="design-gallery">
        @forelse ($designs as $design)
            <article class="design-card">
                <div class="design-images">
                    <div class="img-wrap">
                        <img src="{{ $design->original_image_url }}" alt="Original">
                        <span>Original</span>
                    </div>
                    <div class="img-wrap">
                        @if($design->generated_image_url)
                            <img src="{{ $design->generated_image_url }}" alt="Generated">
                        @else
                            <div class="placeholder">
                                <i class="fa-solid fa-spinner fa-spin"></i>
                                <span>{{ ucfirst($design->status) }}</span>
                            </div>
                        @endif
                        <span>AI Result</span>
                    </div>
                </div>
                <div class="design-info">
                    <div class="info-top">
                        <strong>{{ $design->style->name ?? 'Custom Style' }}</strong>
                        <span class="status-tag status-{{ $design->status }}">{{ ucfirst($design->status) }}</span>
                    </div>
                    <p>User: {{ $design->user->name ?? 'Guest' }}</p>
                    <small>{{ $design->created_at->diffForHumans() }}</small>
                    
                    <div class="card-actions">
                        <form action="{{ route('admin.designs.delete', $design) }}" method="POST" onsubmit="return confirm('Delete this design?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-text-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <p class="empty-state">No designs found matching the criteria.</p>
        @endforelse
    </div>

    <div class="pagination-row">
        {{ $designs->links() }}
    </div>
</div>

<style>
    .design-gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem; margin-top: 1rem; }
    .design-card { background: white; border: 1px solid #e5e7eb; border-radius: 1rem; overflow: hidden; transition: transform 0.2s; }
    .design-card:hover { transform: translateY(-4px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
    .design-images { display: grid; grid-template-columns: 1fr 1fr; height: 160px; background: #f3f4f6; }
    .img-wrap { position: relative; height: 100%; overflow: hidden; border-right: 1px solid #e5e7eb; }
    .img-wrap:last-child { border-right: none; }
    .img-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .img-wrap span { position: absolute; bottom: 4px; left: 4px; background: rgba(0,0,0,0.5); color: white; padding: 2px 6px; border-radius: 4px; font-size: 10px; text-transform: uppercase; }
    .placeholder { height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #9ca3af; gap: 0.5rem; }
    .design-info { padding: 1rem; }
    .info-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; }
    .status-tag { font-size: 11px; padding: 2px 8px; border-radius: 9999px; font-weight: 600; }
    .status-completed { background: #ecfdf5; color: #065f46; }
    .status-failed { background: #fef2f2; color: #991b1b; }
    .status-processing { background: #fffbeb; color: #92400e; }
    .card-actions { margin-top: 1rem; padding-top: 0.5rem; border-top: 1px solid #f3f4f6; text-align: right; }
    .btn-text-danger { background: none; border: none; color: #ef4444; cursor: pointer; font-size: 13px; }
    .btn-text-danger:hover { text-decoration: underline; }
    .form-control-sm { padding: 0.5rem; border-radius: 0.5rem; border: 1px solid #d1d5db; }
</style>
@endsection

