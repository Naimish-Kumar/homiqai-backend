@extends('admin.layout')

@section('title', 'Library')

@section('content')
<section class="rounded-[40px] border border-black/5 bg-white p-8 shadow-[0_22px_60px_rgba(31,31,31,0.06)]">
    <div class="flex flex-col gap-6 border-b border-black/5 pb-8 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">AI Engine Config</p>
            <h2 class="mt-3 font-[Playfair Display] text-3xl font-bold text-[#171717]">Design Styles ({{ $styles->count() }})</h2>
        </div>
        <button onclick="document.getElementById('addStyleForm').classList.toggle('hidden')" class="group flex items-center gap-3 rounded-2xl bg-[#171717] px-6 py-3.5 text-xs font-bold uppercase tracking-widest text-white transition hover:bg-black shadow-lg">
            <i class="fa-solid fa-plus transition group-hover:rotate-90"></i>
            New Aesthetic
        </button>
    </div>

    <!-- Add Style Drawer -->
    <div id="addStyleForm" class="hidden mt-8 animate-in fade-in slide-in-from-top-4 duration-500">
        <div class="rounded-[36px] bg-[#fbfaf8] border border-black/5 p-8 shadow-inner">
            <form action="{{ route('admin.styles.store') }}" method="POST" class="space-y-8">
                @csrf
                <div class="grid gap-8 md:grid-cols-2">
                    <label class="block">
                        <span class="mb-3 block text-[10px] font-bold uppercase tracking-[0.2em] text-[#a89078]">Aesthetic Name</span>
                        <input type="text" name="name" required placeholder="e.g. Scandi-Minimalist" class="w-full rounded-2xl border border-black/5 bg-white px-5 py-4 text-sm font-medium text-[#171717] outline-none shadow-sm focus:ring-2 focus:ring-[#7a8a6b]/20">
                    </label>
                    <label class="block">
                        <span class="mb-3 block text-[10px] font-bold uppercase tracking-[0.2em] text-[#a89078]">Preview Image URL</span>
                        <input type="url" name="thumbnail_url" placeholder="https://unsplash.com/..." class="w-full rounded-2xl border border-black/5 bg-white px-5 py-4 text-sm font-medium text-[#171717] outline-none shadow-sm focus:ring-2 focus:ring-[#7a8a6b]/20">
                    </label>
                </div>
                <div class="grid gap-8 md:grid-cols-3">
                    <label class="block">
                        <span class="mb-3 block text-[10px] font-bold uppercase tracking-[0.2em] text-[#7a8a6b]">Prompt (Economy)</span>
                        <textarea name="prompt_low" rows="4" placeholder="Instruction for budget transformations..." class="w-full rounded-2xl border border-black/5 bg-white px-5 py-4 text-sm font-medium text-[#171717] outline-none shadow-sm focus:ring-2 focus:ring-[#7a8a6b]/20"></textarea>
                    </label>
                    <label class="block">
                        <span class="mb-3 block text-[10px] font-bold uppercase tracking-[0.2em] text-[#7a8a6b]">Prompt (Mid-Range)</span>
                        <textarea name="prompt_medium" rows="4" placeholder="Instruction for standard transformations..." class="w-full rounded-2xl border border-black/5 bg-white px-5 py-4 text-sm font-medium text-[#171717] outline-none shadow-sm focus:ring-2 focus:ring-[#7a8a6b]/20"></textarea>
                    </label>
                    <label class="block">
                        <span class="mb-3 block text-[10px] font-bold uppercase tracking-[0.2em] text-[#7a8a6b]">Prompt (Premium)</span>
                        <textarea name="prompt_high" rows="4" placeholder="Instruction for luxury transformations..." class="w-full rounded-2xl border border-black/5 bg-white px-5 py-4 text-sm font-medium text-[#171717] outline-none shadow-sm focus:ring-2 focus:ring-[#7a8a6b]/20"></textarea>
                    </label>
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="rounded-2xl bg-[#171717] px-8 py-4 text-xs font-bold uppercase tracking-widest text-white transition hover:bg-black shadow-lg">Create Style</button>
                    <button type="button" onclick="document.getElementById('addStyleForm').classList.add('hidden')" class="rounded-2xl border border-black/5 bg-white px-8 py-4 text-xs font-bold uppercase tracking-widest text-[#171717] transition hover:bg-gray-50">Discard</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-10 space-y-10">
        @forelse ($styles as $style)
            <div class="relative rounded-[40px] border border-black/5 bg-[#fbfaf8] p-1 transition hover:shadow-xl">
                <form action="{{ route('admin.styles.update', $style) }}" method="POST" class="rounded-[38px] bg-white p-8">
                    @csrf
                    @method('PATCH')
                    
                    <div class="flex flex-col gap-6 border-b border-black/5 pb-8 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-center gap-6">
                            <div class="h-20 w-20 overflow-hidden rounded-[24px] border border-black/5 bg-[#fbfaf8] shadow-sm">
                                <img src="{{ $style->thumbnail_url }}" alt="" class="h-full w-full object-cover">
                            </div>
                            <div>
                                <h3 class="font-[Playfair Display] text-2xl font-bold text-[#171717]">{{ $style->name }}</h3>
                                <p class="mt-1 text-xs font-bold uppercase tracking-widest text-[#7a8a6b]">System ID: #{{ $style->id }} • {{ $style->room_designs_count }} usages</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button type="submit" class="rounded-2xl bg-[#171717] px-6 py-3.5 text-xs font-bold uppercase tracking-widest text-white shadow-lg hover:bg-black transition">
                                Push Update
                            </button>
                            <button form="delete-style-{{ $style->id }}" type="submit" class="rounded-2xl bg-white border border-black/5 p-3.5 text-[#8c4343] shadow-sm hover:bg-[#f7e9e9] transition">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mt-8 space-y-8">
                        <div class="grid gap-8 md:grid-cols-2">
                            <label class="block">
                                <span class="mb-3 block text-[10px] font-bold uppercase tracking-[0.2em] text-[#a89078]">Display Name</span>
                                <input type="text" name="name" value="{{ $style->name }}" class="w-full rounded-2xl border border-black/5 bg-[#fbfaf8] px-5 py-4 text-sm font-medium text-[#171717] outline-none">
                            </label>
                            <label class="block">
                                <span class="mb-3 block text-[10px] font-bold uppercase tracking-[0.2em] text-[#a89078]">Thumbnail Asset URL</span>
                                <input type="url" name="thumbnail_url" value="{{ $style->thumbnail_url }}" class="w-full rounded-2xl border border-black/5 bg-[#fbfaf8] px-5 py-4 text-sm font-medium text-[#171717] outline-none">
                            </label>
                        </div>
                        
                        <label class="block">
                            <span class="mb-3 block text-[10px] font-bold uppercase tracking-[0.2em] text-[#7a8a6b]">Core System Prompt Prefix</span>
                            <textarea name="prompt_prefix" rows="2" class="w-full rounded-2xl border border-black/5 bg-[#fbfaf8] px-5 py-4 text-sm font-medium text-[#171717] outline-none">{{ $style->prompt_prefix }}</textarea>
                        </label>

                        <div class="grid gap-8 md:grid-cols-3">
                            <label class="block">
                                <span class="mb-3 block text-[10px] font-bold uppercase tracking-[0.2em] text-[#7a8a6b]">Economy (Low)</span>
                                <textarea name="prompt_low" rows="4" class="w-full rounded-2xl border border-black/5 bg-[#fbfaf8] px-5 py-4 text-sm font-medium text-[#171717] outline-none">{{ $style->prompt_low }}</textarea>
                            </label>
                            <label class="block">
                                <span class="mb-3 block text-[10px] font-bold uppercase tracking-[0.2em] text-[#7a8a6b]">Standard (Medium)</span>
                                <textarea name="prompt_medium" rows="4" class="w-full rounded-2xl border border-black/5 bg-[#fbfaf8] px-5 py-4 text-sm font-medium text-[#171717] outline-none">{{ $style->prompt_medium }}</textarea>
                            </label>
                            <label class="block">
                                <span class="mb-3 block text-[10px] font-bold uppercase tracking-[0.2em] text-[#7a8a6b]">Luxury (High)</span>
                                <textarea name="prompt_high" rows="4" class="w-full rounded-2xl border border-black/5 bg-[#fbfaf8] px-5 py-4 text-sm font-medium text-[#171717] outline-none">{{ $style->prompt_high }}</textarea>
                            </label>
                        </div>
                    </div>
                </form>
                <form id="delete-style-{{ $style->id }}" action="{{ route('admin.styles.delete', $style) }}" method="POST" onsubmit="return confirm('Deprioritize and delete style \'{{ $style->name }}\'? Warning: Permanent action.')">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        @empty
            <div class="py-24 text-center">
                <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-[#fbfaf8] text-[#a89078]">
                    <i class="fa-solid fa-palette text-3xl"></i>
                </div>
                <p class="mt-6 text-lg font-bold text-[#171717]">No styles found in the library.</p>
                <p class="mt-2 text-sm font-medium text-[#7a8a6b]">Initialize your first aesthetic using the button above.</p>
            </div>
        @endforelse
    </div>
</section>
@endsection

