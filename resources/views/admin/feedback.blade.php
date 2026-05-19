@extends('admin.layout')

@section('title', 'Sentiment')

@section('content')
<div class="space-y-12">
    <!-- Sentiment Intelligence -->
    <section class="grid grid-cols-1 gap-10 sm:grid-cols-3">
        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Volume Metric</p>
            <div class="mt-4">
                <span class="font-[Playfair Display] text-4xl font-bold text-black italic">{{ number_format($summary['total']) }}</span>
                <p class="mt-2 text-[10px] font-bold text-[#a89078] uppercase tracking-widest opacity-60">Total Dispatches</p>
            </div>
        </article>

        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Sentiment Aura</p>
            <div class="mt-4 flex items-center gap-4">
                <span class="font-[Playfair Display] text-4xl font-bold text-black italic">{{ $summary['average_rating'] }}</span>
                <div class="flex items-center gap-1">
                    @for($i=1; $i<=5; $i++)
                        <i class="fa-solid fa-star text-[12px] {{ $i <= floor($summary['average_rating']) ? 'text-[#a89078]' : 'text-black/5' }}"></i>
                    @endfor
                </div>
            </div>
            <p class="mt-2 text-[10px] font-bold text-[#a89078] uppercase tracking-widest opacity-60">Weighted Average</p>
        </article>

        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Pending Audit</p>
            <div class="mt-4">
                <span class="font-[Playfair Display] text-4xl font-bold text-black italic">{{ number_format($summary['pending']) }}</span>
                <p class="mt-2 text-[10px] font-bold text-[#8c4343] uppercase tracking-widest opacity-60">Requires Review</p>
            </div>
        </article>
    </section>

    <!-- Sentiment Manifest -->
    <section class="rounded-[56px] border border-black/[0.03] bg-white overflow-hidden shadow-2xl shadow-black/[0.03]">
        <header class="px-12 py-10 bg-[#faf9f6] border-b border-black/[0.03] flex items-center justify-between">
            <div>
                <h2 class="font-[Playfair Display] text-3xl font-bold text-black italic">Sentiment Manifest</h2>
                <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Chronological user experience archive</p>
            </div>
            <div class="flex gap-4">
                <span class="px-6 py-3 rounded-full bg-white border border-black/[0.03] text-[10px] font-bold uppercase tracking-widest text-[#a89078] shadow-sm">All Styles</span>
                <span class="px-6 py-3 rounded-full bg-black text-[10px] font-bold uppercase tracking-widest text-white shadow-xl shadow-black/10">Recent First</span>
            </div>
        </header>

        <div class="divide-y divide-black/[0.02]">
            @forelse($feedbacks as $item)
            <article class="p-12 hover:bg-[#faf9f6]/50 transition-colors group">
                <div class="flex justify-between items-start mb-8">
                    <div class="flex items-center gap-6">
                        <div class="h-14 w-14 rounded-full bg-black flex items-center justify-center text-white text-[13px] font-bold shadow-lg shadow-black/5">
                            {{ strtoupper(substr($item->user->name ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-[15px] font-bold text-black group-hover:text-[#7a8a6b] transition-colors">{{ $item->user->name ?? 'Anonymous Identity' }}</p>
                            <p class="text-[11px] font-bold text-[#a89078] uppercase tracking-[0.2em] mt-1 opacity-60">{{ $item->user->email ?? 'N/A' }} • {{ $item->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 bg-[#faf9f6] px-4 py-2.5 rounded-full border border-black/[0.02]">
                        @for($i=1; $i<=5; $i++)
                            <i class="fa-solid fa-star text-[10px] {{ $i <= $item->rating ? 'text-[#a89078]' : 'text-black/5' }}"></i>
                        @endfor
                    </div>
                </div>
                
                <div class="ml-20">
                    <p class="text-[16px] font-medium text-black/80 leading-relaxed italic max-w-3xl mb-8">"{{ $item->comment ?? 'No narrative provided for this session.' }}"</p>
                    
                    <div class="flex flex-wrap items-center gap-6">
                        @if($item->roomDesign)
                        <div class="inline-flex items-center gap-4 rounded-2xl bg-[#faf9f6] border border-black/[0.02] pl-3 pr-6 py-2.5 group/design">
                            <div class="h-10 w-10 rounded-xl bg-white border border-black/[0.03] flex items-center justify-center text-[#7a8a6b] shadow-sm group-hover/design:scale-110 transition-transform">
                                <i class="fa-solid fa-wand-magic-sparkles text-[12px]"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-black uppercase tracking-widest">Design Manifest</p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-[12px] font-bold text-[#a89078]">#{{ $item->room_design_id }}</span>
                                    <a href="{{ route('admin.designs') }}" class="text-[9px] font-black text-[#7a8a6b] uppercase tracking-tighter hover:underline">Inspect</a>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-center">
                            @if($item->status == 'pending')
                            <form action="{{ route('admin.feedback.update', $item) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="reviewed">
                                <button type="submit" class="rounded-full bg-black/5 px-8 py-3 text-[10px] font-bold uppercase tracking-[0.2em] text-black hover:bg-black hover:text-white transition-all">
                                    Acknowledge Sentiment
                                </button>
                            </form>
                            @else
                            <div class="flex items-center gap-3 rounded-full bg-[#7a8a6b]/10 px-6 py-3">
                                <i class="fa-solid fa-check-double text-[10px] text-[#7a8a6b]"></i>
                                <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#7a8a6b]">Audit Complete</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </article>
            @empty
            <div class="py-40 text-center">
                <div class="flex flex-col items-center">
                    <i class="fa-solid fa-comments text-5xl text-black/5 mb-8"></i>
                    <p class="text-[13px] font-bold text-black uppercase tracking-[0.2em] opacity-30">No sentiment records found in manifest.</p>
                </div>
            </div>
            @endforelse
        </div>
        
        @if($feedbacks->hasPages())
        <footer class="px-12 py-10 bg-[#faf9f6] border-t border-black/[0.03]">
            <div class="pagination-editorial">
                {{ $feedbacks->links() }}
            </div>
        </footer>
        @endif
    </section>
</div>
@endsection

