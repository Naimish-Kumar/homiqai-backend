@extends('admin.layout')

@section('title', 'Storage')

@section('content')
<div class="space-y-12">
    <!-- Resource Telemetry -->
    <section class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4">
        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Cloud Inventory</p>
            <div class="mt-4">
                <span class="font-[Playfair Display] text-4xl font-bold text-black italic">{{ number_format($summary['total_files']) }}</span>
                <p class="mt-2 text-[10px] font-bold text-[#a89078] uppercase tracking-widest opacity-60">Total Objects</p>
            </div>
        </article>

        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Volume Metric</p>
            <div class="mt-4">
                <span class="font-[Playfair Display] text-4xl font-bold text-black italic">{{ $summary['total_size'] }} MB</span>
                <p class="mt-2 text-[10px] font-bold text-[#a89078] uppercase tracking-widest opacity-60">Total Capacity Used</p>
            </div>
        </article>

        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Visual Archive</p>
            <div class="mt-4">
                <span class="font-[Playfair Display] text-4xl font-bold text-black italic">{{ number_format($summary['designs_count']) }}</span>
                <p class="mt-2 text-[10px] font-bold text-[#a89078] uppercase tracking-widest opacity-60">Design Records</p>
            </div>
        </article>

        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Ingestion Rate</p>
            <div class="mt-4">
                <span class="font-[Playfair Display] text-4xl font-bold text-black italic">+12%</span>
                <p class="mt-2 text-[10px] font-bold text-[#a89078] uppercase tracking-widest opacity-60">Monthly Delta</p>
            </div>
        </article>
    </section>

    <!-- Maintenance Protocol -->
    <section class="rounded-[56px] border border-black/[0.03] bg-white p-12 shadow-2xl shadow-black/[0.03]">
        <header class="flex items-center justify-between mb-10">
            <div>
                <h2 class="font-[Playfair Display] text-3xl font-bold text-black italic">Maintenance Protocol</h2>
                <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Automated archive purging & optimization</p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#faf9f6] border border-black/[0.03]">
                <i class="fa-solid fa-broom-ball text-black"></i>
            </div>
        </header>
        
        <div class="bg-[#faf9f6] rounded-[40px] p-10 border border-black/[0.02]">
            <p class="text-[14px] font-medium text-black/60 leading-relaxed max-w-2xl mb-10">Authorize the systematic removal of design artifacts and associated assets exceeding the defined maturity threshold. This procedure optimizes infrastructure costs and enhances system performance.</p>
            
            <form action="{{ route('admin.storage.cleanup') }}" method="POST" class="flex flex-wrap items-center gap-10">
                @csrf
                @method('DELETE')
                <label class="flex items-center gap-6">
                    <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078]">Maturity Threshold:</span>
                    <div class="relative flex items-center">
                        <input type="number" name="days" value="30" class="w-32 rounded-[18px] border border-black/[0.04] bg-white px-6 py-3.5 text-[14px] font-bold text-black outline-none focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                        <span class="ml-4 text-[10px] font-bold uppercase tracking-widest text-black/40">Days</span>
                    </div>
                </label>
                <button type="submit" onclick="return confirm('Authorize systematic purge? This action is irreversible.')" class="rounded-[24px] bg-black px-10 py-4 text-[11px] font-bold uppercase tracking-[0.2em] text-white shadow-2xl transition-all hover:scale-105 active:scale-95">
                    Execute Purge
                </button>
            </form>
        </div>
    </section>

    <!-- Asset Manifest -->
    <section class="rounded-[56px] border border-black/[0.03] bg-white overflow-hidden shadow-2xl shadow-black/[0.03]">
        <header class="px-12 py-10 bg-[#faf9f6] border-b border-black/[0.03]">
            <h2 class="font-[Playfair Display] text-3xl font-bold text-black italic">Asset Manifest</h2>
            <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Real-time managed object registry</p>
        </header>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-bold uppercase tracking-[0.25em] text-[#a89078] bg-white border-b border-black/[0.02]">
                        <th class="pl-12 pr-6 py-8">Object ID</th>
                        <th class="px-6 py-8">Originator</th>
                        <th class="px-6 py-8">Source Vector</th>
                        <th class="px-6 py-8">Output Layer</th>
                        <th class="pl-6 pr-12 py-8 text-right">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/[0.02]">
                    @foreach($recentFiles as $design)
                    <tr class="hover:bg-[#faf9f6]/50 transition-colors group">
                        <td class="pl-12 pr-6 py-7">
                            <span class="text-[14px] font-bold text-black">#{{ $design->id }}</span>
                        </td>
                        <td class="px-6 py-7">
                            <span class="text-[14px] font-bold text-black group-hover:text-[#7a8a6b] transition-colors">{{ $design->user->name ?? 'Anonymous' }}</span>
                        </td>
                        <td class="px-6 py-7">
                            @if($design->original_image_path)
                                <a href="{{ Storage::url($design->original_image_path) }}" target="_blank" class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-[10px] font-bold uppercase tracking-widest bg-black/5 text-black hover:bg-black hover:text-white transition-all">
                                    <i class="fa-solid fa-eye text-[12px]"></i> View Source
                                </a>
                            @else
                                <span class="text-[10px] font-bold uppercase tracking-widest text-black/20">Empty</span>
                            @endif
                        </td>
                        <td class="px-6 py-7">
                            @if($design->generated_image_path)
                                <a href="{{ Storage::url($design->generated_image_path) }}" target="_blank" class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-[10px] font-bold uppercase tracking-widest bg-[#7a8a6b]/10 text-[#7a8a6b] hover:bg-[#7a8a6b] hover:text-white transition-all">
                                    <i class="fa-solid fa-sparkles text-[12px]"></i> View Output
                                </a>
                            @else
                                <span class="text-[10px] font-bold uppercase tracking-widest text-black/20">Standby</span>
                            @endif
                        </td>
                        <td class="pl-6 pr-12 py-7 text-right">
                            <p class="text-[13px] font-bold text-black tabular-nums">{{ $design->created_at->format('M d') }}</p>
                            <p class="mt-1 text-[10px] font-bold uppercase tracking-widest text-[#a89078] opacity-60">{{ $design->created_at->format('H:i') }}</p>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection

