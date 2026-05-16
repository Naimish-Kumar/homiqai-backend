@extends('admin.layout')

@section('title', 'Gallery')

@section('content')
@section('content')
<!-- Visual Intelligence Metrics -->
<section class="grid gap-8 sm:grid-cols-2 xl:grid-cols-5">
    @foreach([
        ['label' => 'Generation Volume', 'value' => $summary['total'], 'sub' => 'Total Archive', 'color' => 'text-[#7a8a6b]'],
        ['label' => 'High Quality Output', 'value' => $summary['completed'], 'sub' => 'Successful', 'color' => 'text-[#8b745d]'],
        ['label' => 'Active Rendering', 'value' => $summary['processing'], 'sub' => 'In Progress', 'color' => 'text-[#a89078]'],
        ['label' => 'Rendering Failures', 'value' => $summary['failed'], 'sub' => 'Requires Audit', 'color' => 'text-[#8c4343]'],
        ['label' => 'Operational Cost', 'value' => '₹' . number_format($summary['estimated_cost'], 0), 'sub' => 'Cloud Compute', 'color' => 'text-[#7a8a6b]']
    ] as $stat)
    <article class="group rounded-[36px] border border-black/[0.03] bg-white p-8 shadow-sm transition-all hover:-translate-y-1 hover:shadow-2xl hover:shadow-black/[0.04]">
        <p class="text-[10px] font-bold uppercase tracking-[0.3em] {{ $stat['color'] }}">{{ $stat['sub'] }}</p>
        <p class="mt-6 text-4xl font-bold tracking-tighter text-black">{{ is_numeric($stat['value']) ? number_format($stat['value']) : $stat['value'] }}</p>
        <p class="mt-3 text-[11px] font-bold text-[#5f5750]/60">{{ $stat['label'] }}</p>
    </article>
    @endforeach
</section>

<!-- Transformation Gallery -->
<section class="mt-8 rounded-[48px] border border-black/[0.03] bg-white p-10 shadow-xl shadow-black/[0.02]">
    <div class="flex flex-col gap-8 border-b border-black/[0.03] pb-10 xl:flex-row xl:items-center xl:justify-between">
        <div>
            <h2 class="font-[Playfair Display] text-4xl font-bold text-black italic">Visual Archive</h2>
            <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Room transformations & AI generations</p>
        </div>
        
        <form method="GET" class="relative group">
            <select name="status" onchange="this.form.submit()" class="appearance-none rounded-[24px] border border-black/[0.04] bg-[#faf9f6] pl-8 pr-16 py-4 text-[13px] font-bold text-black outline-none transition-all hover:bg-white hover:ring-8 hover:ring-[#7a8a6b]/10 focus:ring-8 focus:ring-[#7a8a6b]/10">
                <option value="">All Transformation States</option>
                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Successful Renderings</option>
                <option value="processing" {{ $status === 'processing' ? 'selected' : '' }}>Currently Rendering</option>
                <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>Failed Generations</option>
            </select>
            <i class="fa-solid fa-chevron-down absolute right-8 top-1/2 -translate-y-1/2 pointer-events-none text-[#a89078] text-[10px]"></i>
        </form>
    </div>

    <div class="mt-12 grid gap-12 xl:grid-cols-2">
        @forelse ($designs as $design)
            <article class="group relative flex flex-col overflow-hidden rounded-[48px] border border-black/[0.04] bg-[#fbfaf8] transition-all hover:bg-white hover:shadow-2xl hover:shadow-black/[0.04]">
                <div class="grid gap-6 p-6 sm:grid-cols-2">
                    <!-- Before State -->
                    <div class="relative aspect-[4/5] overflow-hidden rounded-[36px] bg-black">
                        <img src="{{ $design->original_image_url }}" alt="Original" class="h-full w-full object-cover transition duration-[1.5s] group-hover:scale-110 opacity-80">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <span class="absolute left-6 top-6 rounded-full bg-white/10 backdrop-blur-md border border-white/20 px-4 py-2 text-[9px] font-bold uppercase tracking-widest text-white">Source Input</span>
                    </div>

                    <!-- After State -->
                    <div class="relative aspect-[4/5] overflow-hidden rounded-[36px] bg-black">
                        @if($design->generated_image_url)
                            <img src="{{ $design->generated_image_url }}" alt="Generated" class="h-full w-full object-cover transition duration-[1.5s] group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        @else
                            <div class="flex h-full w-full flex-col items-center justify-center bg-[#171717] text-white">
                                <div class="relative">
                                    <i class="fa-solid fa-wand-magic-sparkles text-4xl animate-pulse text-[#cbbba0]"></i>
                                    <div class="absolute -inset-4 rounded-full border border-[#cbbba0]/20 animate-ping"></div>
                                </div>
                                <p class="mt-8 text-[10px] font-bold uppercase tracking-[0.4em] text-[#cbbba0]">{{ $design->status }}</p>
                            </div>
                        @endif
                        <span class="absolute left-6 top-6 rounded-full bg-black/40 backdrop-blur-md border border-white/20 px-4 py-2 text-[9px] font-bold uppercase tracking-widest text-white">AI Vision</span>
                    </div>
                </div>
                
                <div class="px-10 pb-10 pt-4">
                    <div class="flex flex-col gap-8 xl:flex-row xl:items-end xl:justify-between">
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <h3 class="font-[Playfair Display] text-3xl font-bold text-black italic leading-tight">{{ $design->style->name ?? 'Atmospheric Custom' }}</h3>
                                <span class="rounded-full bg-[#f1f3f0] px-4 py-1.5 text-[9px] font-bold uppercase tracking-widest text-[#7a8a6b]">
                                    {{ $design->budget }} Tier
                                </span>
                            </div>
                            <div class="flex flex-wrap gap-8 text-[11px] font-bold uppercase tracking-widest text-[#a89078]">
                                <span class="flex items-center gap-2.5"><i class="fa-solid fa-fingerprint text-[10px]"></i> {{ $design->user->name ?? 'Anonymous Client' }}</span>
                                <span class="flex items-center gap-2.5"><i class="fa-solid fa-microchip text-[10px]"></i> ₹{{ number_format(($design->metadata['estimated_cost_inr'] ?? 12) / 100, 2) }} Gen Cost</span>
                                <span class="flex items-center gap-2.5"><i class="fa-solid fa-clock-rotate-left text-[10px]"></i> {{ $design->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            @if($design->status === 'failed')
                                <form action="{{ route('admin.designs.retry', $design) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="rounded-2xl bg-black px-8 py-3.5 text-[10px] font-bold uppercase tracking-widest text-white shadow-xl transition hover:scale-105 active:scale-95">
                                        Re-Render
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.designs.delete', $design) }}" method="POST" onsubmit="return confirm('Archive this generation permanently?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="rounded-2xl border border-black/[0.04] bg-white p-3.5 text-[#8c4343] shadow-sm hover:bg-[#f7e9e9] hover:border-[#f7e9e9] transition-all">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="py-40 text-center xl:col-span-2">
                <div class="inline-flex h-24 w-24 items-center justify-center rounded-[40px] bg-[#fbfaf8] text-[#a89078] shadow-inner">
                    <i class="fa-solid fa-camera-retro text-3xl"></i>
                </div>
                <h3 class="mt-10 font-[Playfair Display] text-3xl font-bold text-black italic">Archive is currently empty</h3>
                <p class="mt-4 text-sm font-medium text-[#7a8a6b] max-w-md mx-auto">No transformation cycles have been initiated for the selected filter or the database is fresh.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Intelligence -->
    <div class="mt-16 flex flex-col gap-8 border-t border-black/[0.03] pt-12 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex items-center gap-4">
            <span class="text-[11px] font-bold uppercase tracking-widest text-[#a89078]">Archive Stream</span>
            <p class="text-[14px] font-bold text-black">
                Displaying the visual history of Homiq AI
            </p>
        </div>
        <div class="admin-pagination">
            {{ $designs->links() }}
        </div>
    </div>
</section>
@endsection


