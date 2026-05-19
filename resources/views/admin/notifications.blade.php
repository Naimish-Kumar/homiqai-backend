@extends('admin.layout')

@section('title', 'Studio')

@section('content')
<div class="space-y-10">
    <div class="grid grid-cols-1 gap-12 lg:grid-cols-3">
        <!-- Communication Studio -->
        <aside class="lg:col-span-1">
            <div class="rounded-[48px] border border-black/[0.03] bg-white p-10 shadow-2xl shadow-black/[0.03] sticky top-12">
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Studio</p>
                <h2 class="mt-4 font-[Playfair Display] text-3xl font-bold text-black italic mb-10">Create Dispatch</h2>
                
                <form action="{{ route('admin.notifications.send') }}" method="POST" class="space-y-8">
                    @csrf
                    <label class="block group">
                        <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Target Audience</span>
                        <select name="user_id" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none appearance-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all cursor-pointer">
                            <option value="">Global Broadcast (All)</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </label>

                    <div class="group">
                        <span class="mb-4 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078]">Dispatch Priority</span>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach(['info' => 'Protocol', 'update' => 'Release', 'promotion' => 'Offer', 'alert' => 'Critical'] as $val => $label)
                            <label class="relative flex items-center justify-center p-4 rounded-2xl border border-black/[0.03] bg-[#faf9f6] cursor-pointer hover:bg-white transition-all group/item">
                                <input type="radio" name="type" value="{{ $val }}" {{ $loop->first ? 'checked' : '' }} class="absolute opacity-0 peer">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-black/40 peer-checked:text-black transition-colors">{{ $label }}</span>
                                <div class="absolute inset-0 rounded-2xl ring-2 ring-black opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none"></div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <label class="block group">
                        <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Campaign Headline</span>
                        <input type="text" name="title" placeholder="Manifest Headline..." required class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                    </label>

                    <label class="block group">
                        <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Visual Narrative</span>
                        <textarea name="message" rows="4" placeholder="Draft your dispatch..." required class="w-full rounded-[24px] border border-black/[0.04] bg-[#faf9f6] px-6 py-5 text-[13px] font-medium leading-relaxed text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all"></textarea>
                    </label>

                    <button type="submit" class="w-full rounded-[28px] bg-black py-5 text-[11px] font-bold uppercase tracking-[0.2em] text-white shadow-2xl transition-all hover:scale-105 active:scale-95">
                        Authorize Broadcast
                    </button>
                </form>
            </div>
        </aside>

        <!-- Dispatch History -->
        <section class="lg:col-span-2">
            <div class="rounded-[56px] border border-black/[0.03] bg-white overflow-hidden shadow-2xl shadow-black/[0.03]">
                <header class="px-12 py-10 bg-[#faf9f6] border-b border-black/[0.03] flex items-center justify-between">
                    <div>
                        <h2 class="font-[Playfair Display] text-3xl font-bold text-black italic">Dispatch Manifest</h2>
                        <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Historical transmission archive</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[9px] font-bold uppercase tracking-widest text-[#a89078]">Aura Read Rate</p>
                        <p class="text-3xl font-[Playfair Display] font-bold text-black italic tabular-nums">{{ $summary['read_rate'] }}%</p>
                    </div>
                </header>

                <div class="divide-y divide-black/[0.02]">
                    @forelse($notifications as $n)
                    <article class="p-10 hover:bg-[#faf9f6]/50 transition-colors group">
                        <div class="flex items-start gap-8">
                            <div class="mt-1 flex h-14 w-14 shrink-0 items-center justify-center rounded-full border border-black/[0.03] bg-white shadow-sm transition-transform group-hover:scale-110">
                                @if($n->type == 'info') <i class="fa-solid fa-circle-info text-[#7a8a6b]"></i>
                                @elseif($n->type == 'update') <i class="fa-solid fa-rocket text-black"></i>
                                @elseif($n->type == 'promotion') <i class="fa-solid fa-star text-[#a89078]"></i>
                                @elseif($n->type == 'alert') <i class="fa-solid fa-bolt-lightning text-[#8c4343]"></i>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-center gap-4">
                                        <h3 class="text-[15px] font-bold text-black tracking-tight group-hover:text-[#7a8a6b] transition-colors">{{ $n->title }}</h3>
                                        <form action="{{ route('admin.notifications.delete', $n->id) }}" method="POST" onsubmit="return confirm('Purge dispatch from manifest?')" class="opacity-0 group-hover:opacity-100 transition-all translate-x-2 group-hover:translate-x-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[#8c4343] hover:scale-110 transition-transform">
                                                <i class="fa-solid fa-trash-can text-[11px]"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <span class="text-[10px] text-[#a89078] uppercase font-bold tracking-widest tabular-nums opacity-60">{{ $n->sent_at ? $n->sent_at->diffForHumans() : 'Standby' }}</span>
                                </div>
                                <p class="mt-3 text-[14px] font-medium text-black/70 leading-relaxed max-w-2xl">{{ $n->message }}</p>
                                <div class="mt-6 flex items-center gap-6">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[9px] font-bold text-[#a89078] uppercase tracking-widest">Vector:</span>
                                        <span class="text-[10px] font-bold text-black uppercase tracking-widest">{{ $n->user_id ? $n->user->name : 'Global' }}</span>
                                    </div>
                                    @if($n->is_read)
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-check-double text-[10px] text-[#7a8a6b]"></i>
                                        <span class="text-[9px] font-bold text-[#7a8a6b] uppercase tracking-widest">Acknowledged</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                    @empty
                    <div class="py-32 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fa-solid fa-satellite text-4xl text-black/5 mb-6"></i>
                            <p class="text-[13px] font-bold text-black uppercase tracking-[0.2em] opacity-30">No dispatch history documented.</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                @if($notifications->hasPages())
                <footer class="px-12 py-10 bg-[#faf9f6] border-t border-black/[0.03]">
                    <div class="pagination-editorial">
                        {{ $notifications->links() }}
                    </div>
                </footer>
                @endif
            </div>
        </section>
    </div>
</div>
@endsection

