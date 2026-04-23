@extends('admin.layout')

@section('title', 'Notification Campaigns')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- Send Notification Form -->
        <div class="lg:col-span-1">
            <div class="rounded-[34px] border border-black/6 bg-white p-8 shadow-[0_22px_60px_rgba(31,31,31,0.06)] sticky top-8">
                <h2 class="font-[Playfair Display] text-2xl text-[#171717] mb-6">Create Campaign</h2>
                
                <form action="{{ route('admin.notifications.send') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#7a8a6b] mb-2">Target Audience</label>
                        <select name="user_id" class="w-full rounded-2xl border-black/10 px-4 py-3 text-sm focus:border-[#7a8a6b] focus:ring-[#7a8a6b]">
                            <option value="">All Users (Broadcast)</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#7a8a6b] mb-2">Type</label>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach(['info', 'update', 'promotion', 'alert'] as $type)
                            <label class="flex items-center gap-2 p-3 rounded-xl border border-black/5 bg-[#f8f5ef] cursor-pointer hover:bg-white transition">
                                <input type="radio" name="type" value="{{ $type }}" {{ $loop->first ? 'checked' : '' }} class="text-[#7a8a6b] focus:ring-[#7a8a6b]">
                                <span class="text-xs font-medium capitalize">{{ $type }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#7a8a6b] mb-2">Campaign Title</label>
                        <input type="text" name="title" placeholder="e.g. New Style Available! ✨" required class="w-full rounded-2xl border-black/10 px-4 py-3 text-sm focus:border-[#7a8a6b] focus:ring-[#7a8a6b]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#7a8a6b] mb-2">Message Content</label>
                        <textarea name="message" rows="4" placeholder="Enter your notification message here..." required class="w-full rounded-2xl border-black/10 px-4 py-3 text-sm focus:border-[#7a8a6b] focus:ring-[#7a8a6b]"></textarea>
                    </div>

                    <button type="submit" class="w-full rounded-full bg-[#171717] py-4 text-sm font-bold text-white shadow-[0_12px_24px_rgba(0,0,0,0.15)] transition hover:bg-black">
                        Send Campaign Now
                    </button>
                </form>
            </div>
        </div>

        <!-- History -->
        <div class="lg:col-span-2">
            <div class="rounded-[34px] border border-black/6 bg-white overflow-hidden shadow-[0_22px_60px_rgba(31,31,31,0.06)]">
                <div class="px-8 py-6 border-b border-black/5 bg-[#fbfaf8] flex justify-between items-center">
                    <h2 class="font-[Playfair Display] text-2xl text-[#171717]">Recent Campaigns</h2>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-[#7a8a6b]">Read Rate</p>
                            <p class="text-lg font-bold text-[#171717]">{{ $summary['read_rate'] }}%</p>
                        </div>
                    </div>
                </div>

                <div class="divide-y divide-black/5">
                    @forelse($notifications as $n)
                    <div class="p-6 hover:bg-[#fbfaf8] transition">
                        <div class="flex items-start gap-4">
                            <div class="mt-1 flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-black/5 bg-[#f8f5ef]">
                                @if($n->type == 'info') <i class="fa-solid fa-circle-info text-blue-500"></i>
                                @elseif($n->type == 'update') <i class="fa-solid fa-rocket text-purple-500"></i>
                                @elseif($n->type == 'promotion') <i class="fa-solid fa-tag text-green-500"></i>
                                @elseif($n->type == 'alert') <i class="fa-solid fa-triangle-exclamation text-red-500"></i>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-sm font-bold text-[#171717]">{{ $n->title }}</h3>
                                    <span class="text-[10px] text-[#5f5a52] uppercase font-bold tracking-widest">{{ $n->sent_at ? $n->sent_at->diffForHumans() : 'Scheduled' }}</span>
                                </div>
                                <p class="mt-1 text-sm text-[#5f5a52] leading-relaxed">{{ $n->message }}</p>
                                <div class="mt-3 flex items-center gap-4">
                                    <span class="text-[10px] font-bold text-[#7a8a6b] uppercase tracking-tighter">
                                        Target: {{ $n->user_id ? $n->user->name : 'All Users' }}
                                    </span>
                                    @if($n->is_read)
                                    <span class="flex items-center gap-1 text-[10px] font-bold text-green-600 uppercase tracking-tighter">
                                        <i class="fa-solid fa-check-double"></i> Read
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-20 text-center">
                        <i class="fa-solid fa-paper-plane text-5xl text-black/10 mb-4"></i>
                        <p class="text-[#5f5a52]">No campaigns sent yet.</p>
                    </div>
                    @endforelse
                </div>

                @if($notifications->hasPages())
                <div class="px-8 py-4 border-t border-black/5 bg-[#fbfaf8]">
                    {{ $notifications->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
