@extends('admin.layout')

@section('title', '3D Layouts')

@section('content')
<!-- Visual Intelligence Metrics -->
<section class="grid gap-8 sm:grid-cols-2 xl:grid-cols-4">
    @foreach([
        ['label' => 'Total Layout Uploads', 'value' => $summary['total'], 'sub' => 'Total Archive', 'color' => 'text-[#7a8a6b]'],
        ['label' => 'AI Generated Rooms', 'value' => $summary['completed'], 'sub' => 'Completed Scans', 'color' => 'text-[#8b745d]'],
        ['label' => 'Active Scene Rendering', 'value' => $summary['processing'], 'sub' => 'Processing', 'color' => 'text-[#a89078]'],
        ['label' => 'AI Scan Incidents', 'value' => $summary['failed'], 'sub' => 'Failed Runs', 'color' => 'text-[#8c4343]']
    ] as $stat)
    <article class="group rounded-[36px] border border-black/[0.03] bg-white p-8 shadow-sm transition-all hover:-translate-y-1 hover:shadow-2xl hover:shadow-black/[0.04]">
        <p class="text-[10px] font-bold uppercase tracking-[0.3em] {{ $stat['color'] }}">{{ $stat['sub'] }}</p>
        <p class="mt-6 text-4xl font-bold tracking-tighter text-black">{{ is_numeric($stat['value']) ? number_format($stat['value']) : $stat['value'] }}</p>
        <p class="mt-3 text-[11px] font-bold text-[#5f5750]/60">{{ $stat['label'] }}</p>
    </article>
    @endforeach
</section>

<!-- Layouts Archive Grid -->
<section class="mt-8 rounded-[48px] border border-black/[0.03] bg-white p-10 shadow-xl shadow-black/[0.02]">
    <div class="flex flex-col gap-8 border-b border-black/[0.03] pb-10 xl:flex-row xl:items-center xl:justify-between">
        <div>
            <h2 class="font-[Playfair Display] text-4xl font-bold text-black italic">Layout Archives</h2>
            <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Floor plan uploads & AI 3D reconstructions</p>
        </div>
        
        <form method="GET" class="relative group">
            <select name="status" onchange="this.form.submit()" class="appearance-none rounded-[24px] border border-black/[0.04] bg-[#faf9f6] pl-8 pr-16 py-4 text-[13px] font-bold text-black outline-none transition-all hover:bg-white hover:ring-8 hover:ring-[#7a8a6b]/10 focus:ring-8 focus:ring-[#7a8a6b]/10">
                <option value="">All Layout States</option>
                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed 3D Scenes</option>
                <option value="processing" {{ $status === 'processing' ? 'selected' : '' }}>Currently Processing</option>
                <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>Failed Scans</option>
            </select>
            <i class="fa-solid fa-chevron-down absolute right-8 top-1/2 -translate-y-1/2 pointer-events-none text-[#a89078] text-[10px]"></i>
        </form>
    </div>

    <div class="mt-12 grid gap-12 xl:grid-cols-2">
        @forelse ($layouts as $layout)
            <article class="group relative flex flex-col overflow-hidden rounded-[48px] border border-black/[0.04] bg-[#fbfaf8] transition-all hover:bg-white hover:shadow-2xl hover:shadow-black/[0.04]">
                <div class="grid gap-6 p-6 sm:grid-cols-2">
                    <!-- Original Floor Plan -->
                    <div class="relative aspect-[4/5] overflow-hidden rounded-[36px] bg-black">
                        <img src="{{ $layout->floor_plan_url }}" alt="Floor Plan" class="h-full w-full object-cover transition duration-[1.5s] group-hover:scale-110 opacity-85">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <span class="absolute left-6 top-6 rounded-full bg-white/10 backdrop-blur-md border border-white/20 px-4 py-2 text-[9px] font-bold uppercase tracking-widest text-white">Floor Sketch</span>
                    </div>

                    <!-- 3D AI Output -->
                    <div class="relative aspect-[4/5] overflow-hidden rounded-[36px] bg-black">
                        @if($layout->result_3d_url)
                            <img src="{{ $layout->result_3d_url }}" alt="3D Output" class="h-full w-full object-cover transition duration-[1.5s] group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        @else
                            <div class="flex h-full w-full flex-col items-center justify-center bg-[#171717] text-white">
                                <div class="relative">
                                    <i class="fa-solid fa-cube text-4xl animate-bounce text-[#cbbba0] duration-1000"></i>
                                    <div class="absolute -inset-4 rounded-full border border-[#cbbba0]/20 animate-ping"></div>
                                </div>
                                <p class="mt-8 text-[10px] font-bold uppercase tracking-[0.4em] text-[#cbbba0]">{{ $layout->status }}</p>
                            </div>
                        @endif
                        <span class="absolute left-6 top-6 rounded-full bg-black/40 backdrop-blur-md border border-white/20 px-4 py-2 text-[9px] font-bold uppercase tracking-widest text-white">3D Render</span>
                    </div>
                </div>
                
                <div class="px-10 pb-10 pt-4">
                    <div class="flex flex-col gap-8 xl:flex-row xl:items-end xl:justify-between">
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <h3 class="font-[Playfair Display] text-3xl font-bold text-black italic leading-tight">{{ $layout->name }}</h3>
                                <span class="rounded-full bg-[#f1f3f0] px-4 py-1.5 text-[9px] font-bold uppercase tracking-widest text-[#7a8a6b]">
                                    {{ $layout->status }}
                                </span>
                            </div>
                            <div class="flex flex-wrap gap-8 text-[11px] font-bold uppercase tracking-widest text-[#a89078]">
                                <span class="flex items-center gap-2.5"><i class="fa-solid fa-user text-[10px]"></i> {{ $layout->user->name ?? 'Anonymous Client' }}</span>
                                <span class="flex items-center gap-2.5"><i class="fa-solid fa-clock text-[10px]"></i> {{ $layout->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <form action="{{ route('admin.layouts.delete', $layout) }}" method="POST" onsubmit="return confirm('Delete this layout scan permanently?')">
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
                    <i class="fa-solid fa-cube text-3xl"></i>
                </div>
                <h3 class="mt-10 font-[Playfair Display] text-3xl font-bold text-black italic">No layout scans recorded</h3>
                <p class="mt-4 text-sm font-medium text-[#7a8a6b] max-w-md mx-auto">No 3D layouts have been scanned or uploaded yet in the system.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-16 flex flex-col gap-8 border-t border-black/[0.03] pt-12 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex items-center gap-4">
            <span class="text-[11px] font-bold uppercase tracking-widest text-[#a89078]">Scan Archive Stream</span>
            <p class="text-[14px] font-bold text-black">
                Displaying 3D reconstruction requests
            </p>
        </div>
        <div class="admin-pagination">
            {{ $layouts->links() }}
        </div>
    </div>
</section>
@endsection
