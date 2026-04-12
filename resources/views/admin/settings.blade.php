@extends('admin.layout')

@section('title', 'Settings')

@section('content')
<section class="dashboard-grid">
    <div class="panel">
        <div class="panel-header">
            <div>
                <p class="eyebrow">Configuration</p>
                <h2>Service status</h2>
            </div>
        </div>
        <div class="status-list">
            @foreach($credentials as $label => $value)
                <div><span>{{ str($label)->replace('_', ' ')->title() }}</span><strong>{{ $value }}</strong></div>
            @endforeach
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <div>
                <p class="eyebrow">Runtime</p>
                <h2>System health</h2>
            </div>
        </div>
        <div class="status-list">
            @foreach($system as $label => $value)
                <div><span>{{ str($label)->replace('_', ' ')->title() }}</span><strong>{{ $value }}</strong></div>
            @endforeach
        </div>
    </div>
</section>

<section class="panel">
    <div class="panel-header">
        <div>
            <p class="eyebrow">Design catalog</p>
            <h2>Available styles</h2>
        </div>
    </div>
    <div class="style-grid">
        @forelse($styles as $style)
            <article class="style-card">
                <img src="{{ asset($style->thumbnail_url) }}" alt="{{ $style->name }}">
                <div>
                    <h3>{{ $style->name }}</h3>
                    <p>{{ $style->prompt_prefix }}</p>
                    <span>{{ number_format($style->room_designs_count) }} designs</span>
                </div>
            </article>
        @empty
            <p class="empty-state">No styles have been seeded yet.</p>
        @endforelse
    </div>
</section>
@endsection
