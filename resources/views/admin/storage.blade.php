@extends('admin.layout')

@section('title', 'Storage Management')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-[32px] border border-black/5 bg-white p-6 shadow-[0_16px_40px_rgba(31,31,31,0.04)]">
            <p class="text-xs font-semibold uppercase tracking-wider text-[#7a8a6b]">Total Files</p>
            <p class="mt-2 text-3xl font-bold text-[#171717]">{{ $summary['total_files'] }}</p>
        </div>
        <div class="rounded-[32px] border border-black/5 bg-white p-6 shadow-[0_16px_40px_rgba(31,31,31,0.04)]">
            <p class="text-xs font-semibold uppercase tracking-wider text-[#7a8a6b]">Storage Used</p>
            <p class="mt-2 text-3xl font-bold text-[#171717]">{{ $summary['total_size'] }} MB</p>
        </div>
        <div class="rounded-[32px] border border-black/5 bg-white p-6 shadow-[0_16px_40px_rgba(31,31,31,0.04)]">
            <p class="text-xs font-semibold uppercase tracking-wider text-[#7a8a6b]">Designs Record</p>
            <p class="mt-2 text-3xl font-bold text-[#171717]">{{ $summary['designs_count'] }}</p>
        </div>
        <div class="rounded-[32px] border border-black/5 bg-white p-6 shadow-[0_16px_40px_rgba(31,31,31,0.04)]">
            <p class="text-xs font-semibold uppercase tracking-wider text-[#7a8a6b]">Monthly Growth</p>
            <p class="mt-2 text-3xl font-bold text-[#171717]">+12%</p>
        </div>
    </div>

    <div class="rounded-[34px] border border-black/6 bg-white p-8 shadow-[0_22px_60px_rgba(31,31,31,0.06)]">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-[Playfair Display] text-2xl text-[#171717]">Cleanup Tools</h2>
            <i class="fa-solid fa-broom text-[#7a8a6b]"></i>
        </div>
        
        <div class="bg-[#f8f5ef] rounded-[24px] p-6 border border-black/5">
            <p class="text-sm text-[#5f5a52] mb-4">Automatically delete design data and associated images older than a specific number of days to save storage costs.</p>
            <form action="{{ route('admin.storage.cleanup') }}" method="POST" class="flex flex-wrap items-center gap-4">
                @csrf
                @method('DELETE')
                <div class="flex items-center gap-3">
                    <label class="text-sm font-medium">Older than</label>
                    <input type="number" name="days" value="30" class="w-20 rounded-xl border-black/10 px-4 py-2 text-sm focus:border-[#7a8a6b] focus:ring-[#7a8a6b]">
                    <span class="text-sm">days</span>
                </div>
                <button type="submit" onclick="return confirm('Are you sure you want to delete old data? This action cannot be undone.')" class="rounded-full bg-[#171717] px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-black">
                    Run Cleanup Now
                </button>
            </form>
        </div>
    </div>

    <div class="rounded-[34px] border border-black/6 bg-white p-8 shadow-[0_22px_60px_rgba(31,31,31,0.06)]">
        <h2 class="font-[Playfair Display] text-2xl text-[#171717] mb-6">Recent Files Managed</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-black/5 text-xs font-semibold uppercase tracking-wider text-[#7a8a6b]">
                        <th class="pb-4">Design ID</th>
                        <th class="pb-4">User</th>
                        <th class="pb-4">Original Image</th>
                        <th class="pb-4">Generated Image</th>
                        <th class="pb-4 text-right">Created At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @foreach($recentFiles as $design)
                    <tr>
                        <td class="py-4 text-sm font-medium">#{{ $design->id }}</td>
                        <td class="py-4 text-sm">{{ $design->user->name ?? 'Anonymous' }}</td>
                        <td class="py-4 text-sm">
                            @if($design->original_image_path)
                                <a href="{{ Storage::url($design->original_image_path) }}" target="_blank" class="text-[#7a8a6b] hover:underline">View Image</a>
                            @else
                                <span class="text-black/30">N/A</span>
                            @endif
                        </td>
                        <td class="py-4 text-sm">
                            @if($design->generated_image_path)
                                <a href="{{ Storage::url($design->generated_image_path) }}" target="_blank" class="text-[#7a8a6b] hover:underline">View Image</a>
                            @else
                                <span class="text-black/30">N/A</span>
                            @endif
                        </td>
                        <td class="py-4 text-right text-xs text-[#5f5a52]">{{ $design->created_at->format('M d, H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
