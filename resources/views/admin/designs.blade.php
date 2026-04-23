@extends('admin.layout')

@section('title', 'Room Transformations')

@section('content')
<section class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
    <article class="rounded-[28px] border border-white/60 bg-white/72 p-6 shadow-[0_18px_50px_rgba(47,47,47,0.06)] backdrop-blur-xl">
        <p class="text-sm text-[color:rgba(47,47,47,0.62)]">Total designs</p>
        <p class="mt-3 text-3xl font-semibold text-[var(--color-charcoal)]">{{ number_format($summary['total']) }}</p>
    </article>
    <article class="rounded-[28px] border border-white/60 bg-white/72 p-6 shadow-[0_18px_50px_rgba(47,47,47,0.06)] backdrop-blur-xl">
        <p class="text-sm text-[color:rgba(47,47,47,0.62)]">Completed</p>
        <p class="mt-3 text-3xl font-semibold text-[var(--color-olive)]">{{ number_format($summary['completed']) }}</p>
    </article>
    <article class="rounded-[28px] border border-white/60 bg-white/72 p-6 shadow-[0_18px_50px_rgba(47,47,47,0.06)] backdrop-blur-xl">
        <p class="text-sm text-[color:rgba(47,47,47,0.62)]">Processing</p>
        <p class="mt-3 text-3xl font-semibold text-[var(--color-taupe)]">{{ number_format($summary['processing']) }}</p>
    </article>
    <article class="rounded-[28px] border border-white/60 bg-white/72 p-6 shadow-[0_18px_50px_rgba(47,47,47,0.06)] backdrop-blur-xl">
        <p class="text-sm text-[color:rgba(47,47,47,0.62)]">Failed</p>
        <p class="mt-3 text-3xl font-semibold text-[#9f5656]">{{ number_format($summary['failed']) }}</p>
    </article>
</section>

<section class="mt-6 rounded-[32px] border border-white/60 bg-white/72 p-6 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
    <div class="flex flex-col gap-4 border-b border-[rgba(47,47,47,0.08)] pb-5 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.26em] text-[var(--color-olive)]">Gallery</p>
            <h2 class="mt-3 font-[var(--font-display)] text-3xl leading-tight">All transformations</h2>
        </div>
        <form method="GET" class="flex items-center gap-3">
            <select name="status" onchange="this.form.submit()" class="rounded-full border border-[rgba(47,47,47,0.10)] bg-[rgba(247,246,242,0.84)] px-4 py-3 text-sm text-[var(--color-charcoal)] outline-none">
                <option value="">All Status</option>
                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="processing" {{ $status === 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </form>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-2">
        @forelse ($designs as $design)
            <article class="overflow-hidden rounded-[30px] border border-white/60 bg-[rgba(247,246,242,0.82)] shadow-[0_18px_50px_rgba(47,47,47,0.06)]">
                <div class="grid gap-px bg-[rgba(47,47,47,0.08)] sm:grid-cols-2">
                    <div class="relative bg-[rgba(247,246,242,0.92)] p-4">
                        <img src="{{ $design->original_image_url }}" alt="Original" class="h-72 w-full rounded-[22px] object-cover">
                        <span class="absolute left-7 top-7 rounded-full bg-[rgba(47,47,47,0.72)] px-3 py-2 text-[10px] font-semibold uppercase tracking-[0.18em] text-white">Original</span>
                    </div>
                    <div class="relative bg-[rgba(247,246,242,0.92)] p-4">
                        @if($design->generated_image_url)
                            <img src="{{ $design->generated_image_url }}" alt="Generated" class="h-72 w-full rounded-[22px] object-cover">
                        @else
                            <div class="flex h-72 w-full flex-col items-center justify-center rounded-[22px] bg-white text-sm text-[color:rgba(47,47,47,0.56)]">
                                <i class="fa-solid fa-spinner fa-spin text-lg"></i>
                                <span class="mt-3">{{ ucfirst($design->status) }}</span>
                            </div>
                        @endif
                        <span class="absolute left-7 top-7 rounded-full bg-[rgba(122,138,107,0.80)] px-3 py-2 text-[10px] font-semibold uppercase tracking-[0.18em] text-white">AI Result</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <p class="text-xl font-semibold text-[var(--color-charcoal)]">{{ $design->style->name ?? 'Custom Style' }}</p>
                            <p class="mt-2 text-sm text-[color:rgba(47,47,47,0.62)]">User: {{ $design->user->name ?? 'Guest' }}</p>
                            <p class="mt-1 text-sm text-[color:rgba(47,47,47,0.52)]">{{ $design->created_at->diffForHumans() }}</p>
                        </div>
                        @php
                            $statusClasses = match($design->status) {
                                'completed' => 'bg-[rgba(122,138,107,0.14)] text-[var(--color-olive)]',
                                'processing' => 'bg-[rgba(203,187,160,0.22)] text-[var(--color-taupe)]',
                                'failed' => 'bg-[rgba(170,80,80,0.12)] text-[#8c4343]',
                                default => 'bg-[rgba(47,47,47,0.08)] text-[var(--color-charcoal)]',
                            };
                        @endphp
                        <span class="inline-flex rounded-full px-3 py-2 text-xs font-semibold uppercase tracking-[0.14em] {{ $statusClasses }}">
                            {{ ucfirst($design->status) }}
                        </span>
                    </div>

                    <div class="mt-5 border-t border-[rgba(47,47,47,0.08)] pt-4 text-right">
                        <form action="{{ route('admin.designs.delete', $design) }}" method="POST" onsubmit="return confirm('Delete this design?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-full border border-[rgba(159,86,86,0.18)] bg-[rgba(159,86,86,0.10)] px-4 py-2 text-sm font-semibold text-[#8c4343] transition hover:bg-[rgba(159,86,86,0.16)]">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <p class="text-sm text-[color:rgba(47,47,47,0.56)]">No designs found matching the criteria.</p>
        @endforelse
    </div>

    <div class="mt-6 border-t border-[rgba(47,47,47,0.08)] pt-5">
        {{ $designs->links() }}
    </div>
</section>
@endsection
