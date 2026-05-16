@extends('admin.layout')

@section('title', 'Gallery')

@section('content')
<section class="grid gap-6 sm:grid-cols-2 xl:grid-cols-5">
    <article class="rounded-[32px] border border-black/5 bg-white p-7 shadow-[0_18px_50px_rgba(31,31,31,0.04)]">
        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#a89078]">Total Volume</p>
        <p class="mt-4 text-3xl font-bold text-[#171717]">{{ number_format($summary['total']) }}</p>
        <p class="mt-2 text-xs font-semibold text-[#7a8a6b]">Designs generated</p>
    </article>
    <article class="rounded-[32px] border border-black/5 bg-white p-7 shadow-[0_18px_50px_rgba(31,31,31,0.04)]">
        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#7a8a6b]">Successful</p>
        <p class="mt-4 text-3xl font-bold text-[#171717]">{{ number_format($summary['completed']) }}</p>
        <p class="mt-2 text-xs font-semibold text-[#7a8a6b]">High quality output</p>
    </article>
    <article class="rounded-[32px] border border-black/5 bg-white p-7 shadow-[0_18px_50px_rgba(31,31,31,0.04)]">
        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#7a8a6b]">In Progress</p>
        <p class="mt-4 text-3xl font-bold text-[#171717]">{{ number_format($summary['processing']) }}</p>
        <p class="mt-2 text-xs font-semibold text-[#a89078]">Active generation</p>
    </article>
    <article class="rounded-[32px] border border-black/5 bg-white p-7 shadow-[0_18px_50_rgba(31,31,31,0.04)]">
        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#8c4343]">Failures</p>
        <p class="mt-4 text-3xl font-bold text-[#171717]">{{ number_format($summary['failed']) }}</p>
        <p class="mt-2 text-xs font-semibold text-[#8c4343]">Requires retry</p>
    </article>
    <article class="rounded-[32px] border border-black/5 bg-white p-7 shadow-[0_18px_50px_rgba(31,31,31,0.04)]">
        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#7a8a6b]">Compute Cost</p>
        <p class="mt-4 text-3xl font-bold text-[#171717]">₹{{ number_format($summary['estimated_cost'], 0) }}</p>
        <p class="mt-2 text-xs font-semibold text-[#7a8a6b]">Cloud infrastructure</p>
    </article>
</section>

<section class="mt-6 rounded-[40px] border border-black/5 bg-white p-8 shadow-[0_22px_60px_rgba(31,31,31,0.06)]">
    <div class="flex flex-col gap-5 border-b border-black/5 pb-8 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Visual Archive</p>
            <h2 class="mt-3 font-[Playfair Display] text-3xl font-bold text-[#171717]">Room Transformations</h2>
        </div>
        <form method="GET" class="flex items-center gap-4">
            <div class="relative">
                <select name="status" onchange="this.form.submit()" class="appearance-none rounded-2xl border border-black/5 bg-[#fbfaf8] pl-5 pr-12 py-3 text-sm font-bold text-[#171717] outline-none transition hover:bg-[#faf7f2]">
                    <option value="">All Status</option>
                    <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="processing" {{ $status === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
                <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-[#a89078] text-[10px]"></i>
            </div>
        </form>
    </div>

    <div class="mt-10 grid gap-8 xl:grid-cols-2">
        @forelse ($designs as $design)
            <article class="group overflow-hidden rounded-[40px] border border-black/5 bg-[#fbfaf8] transition hover:bg-[#faf7f2] hover:shadow-xl">
                <div class="grid gap-4 p-5 sm:grid-cols-2">
                    <div class="relative group/img overflow-hidden rounded-[32px]">
                        <img src="{{ $design->original_image_url }}" alt="Original" class="h-80 w-full object-cover transition duration-700 group-hover/img:scale-110">
                        <div class="absolute inset-0 bg-black/20 opacity-0 transition group-hover/img:opacity-100"></div>
                        <span class="absolute left-6 top-6 rounded-full bg-white/90 backdrop-blur-md px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-[#171717] shadow-lg">Original</span>
                    </div>
                    <div class="relative group/img overflow-hidden rounded-[32px]">
                        @if($design->generated_image_url)
                            <img src="{{ $design->generated_image_url }}" alt="Generated" class="h-80 w-full object-cover transition duration-700 group-hover/img:scale-110">
                            <div class="absolute inset-0 bg-black/20 opacity-0 transition group-hover/img:opacity-100"></div>
                        @else
                            <div class="flex h-80 w-full flex-col items-center justify-center bg-white text-sm font-bold text-[#a89078]">
                                <i class="fa-solid fa-spinner fa-spin text-2xl"></i>
                                <span class="mt-4 uppercase tracking-widest text-[10px]">{{ $design->status }}</span>
                            </div>
                        @endif
                        <span class="absolute left-6 top-6 rounded-full bg-[#171717] px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-white shadow-lg">AI Vision</span>
                    </div>
                </div>
                
                <div class="px-8 py-7">
                    <div class="flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <h3 class="text-2xl font-bold text-[#171717]">{{ $design->style->name ?? 'Modern Custom' }}</h3>
                                <span class="inline-flex rounded-full bg-[#eef3ea] px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-[#405038]">
                                    {{ $design->budget }}
                                </span>
                            </div>
                            <div class="flex flex-wrap gap-6 text-xs font-bold text-[#7a8a6b]">
                                <span class="flex items-center gap-2"><i class="fa-solid fa-user"></i> {{ $design->user->name ?? 'Guest Member' }}</span>
                                <span class="flex items-center gap-2"><i class="fa-solid fa-coins"></i> ₹{{ number_format(($design->metadata['estimated_cost_inr'] ?? 12) / 100, 2) }}</span>
                                <span class="flex items-center gap-2"><i class="fa-solid fa-clock"></i> {{ $design->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            @if($design->status === 'failed')
                                <form action="{{ route('admin.designs.retry', $design) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="rounded-2xl bg-[#171717] px-5 py-3 text-[10px] font-bold uppercase tracking-widest text-white shadow-lg hover:scale-105 transition">
                                        Retry
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.designs.delete', $design) }}" method="POST" onsubmit="return confirm('Archive this design?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-2xl bg-white border border-black/5 p-3 text-[#8c4343] shadow-sm hover:bg-[#f7e9e9] transition">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="py-24 text-center xl:col-span-2">
                <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-[#fbfaf8] text-[#a89078]">
                    <i class="fa-solid fa-images text-3xl"></i>
                </div>
                <p class="mt-6 text-lg font-bold text-[#171717]">No transformations found.</p>
                <p class="mt-2 text-sm font-medium text-[#7a8a6b]">Either no requests have been made or they don't match your filter.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-12 flex items-center justify-between border-t border-black/5 pt-10">
        <p class="text-xs font-bold text-[#a89078]">Displaying gallery stream</p>
        <div class="admin-pagination">
            {{ $designs->links() }}
        </div>
    </div>
</section>
@endsection

