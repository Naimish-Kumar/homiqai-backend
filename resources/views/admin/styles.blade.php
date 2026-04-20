@extends('admin.layout')
@section('title', 'Styles')

@section('content')
<div class="admin-section">
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h3>Design Styles ({{ $styles->count() }})</h3>
            <button onclick="document.getElementById('addStyleForm').style.display='block'" class="btn-sm btn-primary">+ Add Style</button>
        </div>

        {{-- Add Style Form --}}
        <div id="addStyleForm" style="display: none; margin-bottom: 24px; padding: 20px; background: #f8fafc; border-radius: 12px;">
            <form action="{{ route('admin.styles.store') }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div>
                        <label style="font-weight: 600; font-size: 13px;">Style Name</label>
                        <input type="text" name="name" required placeholder="e.g. Bohemian" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 4px;">
                    </div>
                    <div>
                        <label style="font-weight: 600; font-size: 13px;">Thumbnail URL</label>
                        <input type="url" name="thumbnail_url" placeholder="https://..." style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 4px;">
                    </div>
                </div>
                <div style="margin-top: 12px;">
                    <label style="font-weight: 600; font-size: 13px;">AI Prompt Prefix</label>
                    <textarea name="prompt_prefix" rows="2" placeholder="Describe the style for AI..." style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 4px;"></textarea>
                </div>
                <div style="margin-top: 12px; display: flex; gap: 8px;">
                    <button type="submit" class="btn-sm btn-primary">Save Style</button>
                    <button type="button" onclick="document.getElementById('addStyleForm').style.display='none'" class="btn-sm">Cancel</button>
                </div>
            </form>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Prompt Prefix</th>
                    <th>Designs</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($styles as $style)
                <tr>
                    <td>#{{ $style->id }}</td>
                    <td><strong>{{ $style->name }}</strong></td>
                    <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $style->prompt_prefix ?? '—' }}</td>
                    <td>{{ $style->room_designs_count }}</td>
                    <td style="display: flex; gap: 6px;">
                        <form action="{{ route('admin.styles.delete', $style) }}" method="POST" onsubmit="return confirm('Delete style \'{{ $style->name }}\'? This will also delete all associated designs.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align: center; padding: 32px;">No styles configured yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
