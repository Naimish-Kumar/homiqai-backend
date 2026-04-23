@extends('admin.layout')

@section('title', 'Feedback & Ratings')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
        <div class="rounded-[32px] border border-black/5 bg-white p-6 shadow-[0_16px_40px_rgba(31,31,31,0.04)] text-center">
            <p class="text-xs font-semibold uppercase tracking-wider text-[#7a8a6b]">Total Feedback</p>
            <p class="mt-2 text-3xl font-bold text-[#171717]">{{ $summary['total'] }}</p>
        </div>
        <div class="rounded-[32px] border border-black/5 bg-white p-6 shadow-[0_16px_40px_rgba(31,31,31,0.04)] text-center">
            <p class="text-xs font-semibold uppercase tracking-wider text-[#7a8a6b]">Average Rating</p>
            <div class="mt-2 flex items-center justify-center gap-2">
                <p class="text-3xl font-bold text-[#171717]">{{ $summary['average_rating'] }}</p>
                <i class="fa-solid fa-star text-yellow-400"></i>
            </div>
        </div>
        <div class="rounded-[32px] border border-black/5 bg-white p-6 shadow-[0_16_40px_rgba(31,31,31,0.04)] text-center">
            <p class="text-xs font-semibold uppercase tracking-wider text-[#7a8a6b]">Pending Review</p>
            <p class="mt-2 text-3xl font-bold text-[#171717]">{{ $summary['pending'] }}</p>
        </div>
    </div>

    <div class="rounded-[34px] border border-black/6 bg-white overflow-hidden shadow-[0_22px_60px_rgba(31,31,31,0.06)]">
        <div class="px-8 py-6 border-b border-black/5 flex justify-between items-center">
            <h2 class="font-[Playfair Display] text-2xl text-[#171717]">User Reviews</h2>
            <div class="flex gap-2">
                <span class="px-3 py-1 rounded-full bg-[#f8f5ef] text-xs font-medium border border-black/5">All Styles</span>
                <span class="px-3 py-1 rounded-full bg-[#f8f5ef] text-xs font-medium border border-black/5">Recent First</span>
            </div>
        </div>
        <div class="divide-y divide-black/5">
            @forelse($feedbacks as $item)
            <div class="p-8 hover:bg-[#fbfaf8] transition">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-4">
                        <div class="h-10 w-10 rounded-full bg-[#171717] flex items-center justify-center text-white text-sm font-bold">
                            {{ strtoupper(substr($item->user->name ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-[#171717]">{{ $item->user->name ?? 'Anonymous' }}</p>
                            <p class="text-xs text-[#5f5a52]">{{ $item->user->email ?? 'N/A' }} • {{ $item->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1">
                        @for($i=1; $i<=5; $i++)
                            <i class="fa-solid fa-star text-sm {{ $i <= $item->rating ? 'text-yellow-400' : 'text-black/10' }}"></i>
                        @endfor
                    </div>
                </div>
                
                <div class="ml-14">
                    <p class="text-sm text-[#171717] leading-relaxed mb-4 italic">"{{ $item->comment ?? 'No comment provided.' }}"</p>
                    
                    @if($item->roomDesign)
                    <div class="mb-4 inline-flex items-center gap-2 rounded-xl bg-[#f8f5ef] px-3 py-2 border border-black/5">
                        <i class="fa-solid fa-wand-magic-sparkles text-xs text-[#7a8a6b]"></i>
                        <span class="text-xs font-medium">Design #{{ $item->room_design_id }}</span>
                        <a href="{{ route('admin.designs') }}" class="text-[10px] text-[#7a8a6b] hover:underline uppercase font-bold tracking-tighter">View Design</a>
                    </div>
                    @endif

                    <div class="flex items-center gap-3">
                        @if($item->status == 'pending')
                        <form action="{{ route('admin.feedback.update', $item) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="reviewed">
                            <button type="submit" class="text-xs font-bold uppercase tracking-widest text-[#7a8a6b] hover:text-[#171717]">Mark as Reviewed</button>
                        </form>
                        @else
                        <span class="text-[10px] font-bold uppercase tracking-widest text-[#7a8a6b] bg-[#eef3ea] px-2 py-1 rounded">Reviewed</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="p-20 text-center">
                <i class="fa-solid fa-comments text-5xl text-black/10 mb-4"></i>
                <p class="text-[#5f5a52]">No feedback received yet.</p>
            </div>
            @endforelse
        </div>
        
        @if($feedbacks->hasPages())
        <div class="px-8 py-6 border-t border-black/5 bg-[#fbfaf8]">
            {{ $feedbacks->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
