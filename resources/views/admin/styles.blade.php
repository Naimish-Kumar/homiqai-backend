@section('content')
<!-- Aesthetic Configuration Surface -->
<section class="rounded-[48px] border border-black/[0.03] bg-white p-10 shadow-xl shadow-black/[0.02]">
    <div class="flex flex-col gap-8 border-b border-black/[0.03] pb-10 xl:flex-row xl:items-center xl:justify-between">
        <div>
            <h2 class="font-[Playfair Display] text-4xl font-bold text-black italic">Aesthetic Library</h2>
            <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">AI Engine & prompt engineering core</p>
        </div>
        <button onclick="document.getElementById('addStyleForm').classList.toggle('hidden')" class="group flex items-center gap-4 rounded-[24px] bg-black px-8 py-4.5 text-[11px] font-bold uppercase tracking-[0.2em] text-white transition-all hover:scale-105 active:scale-95 shadow-xl shadow-black/10">
            <i class="fa-solid fa-plus transition-transform group-hover:rotate-90"></i>
            Register New Aesthetic
        </button>
    </div>

    <!-- Creation Intelligence Drawer -->
    <div id="addStyleForm" class="hidden mt-10 animate-in fade-in slide-in-from-top-6 duration-700">
        <div class="rounded-[44px] bg-[#faf9f6] border border-black/[0.03] p-10 shadow-inner">
            <form action="{{ route('admin.styles.store') }}" method="POST" class="space-y-10">
                @csrf
                <div class="grid gap-10 md:grid-cols-2">
                    <label class="block group">
                        <span class="mb-4 block text-[10px] font-bold uppercase tracking-[0.3em] text-[#a89078] group-focus-within:text-black transition-colors">Aesthetic Identity</span>
                        <input type="text" name="name" required placeholder="e.g. Scandi-Minimalist" class="w-full rounded-[20px] border border-black/[0.04] bg-white px-6 py-5 text-[14px] font-bold text-black outline-none shadow-sm focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                    </label>
                    <label class="block group">
                        <span class="mb-4 block text-[10px] font-bold uppercase tracking-[0.3em] text-[#a89078] group-focus-within:text-black transition-colors">Visual Reference URL</span>
                        <input type="url" name="thumbnail_url" placeholder="Direct image link (Unsplash, Cloudinary...)" class="w-full rounded-[20px] border border-black/[0.04] bg-white px-6 py-5 text-[14px] font-bold text-black outline-none shadow-sm focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                    </label>
                </div>
                <div class="grid gap-10 md:grid-cols-3">
                    @foreach(['low' => 'Economy Tier', 'medium' => 'Standard Tier', 'high' => 'Luxury Tier'] as $key => $label)
                    <label class="block group">
                        <span class="mb-4 block text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b] group-focus-within:text-black transition-colors">{{ $label }}</span>
                        <textarea name="prompt_{{ $key }}" rows="5" placeholder="Define the AI behavior for {{ strtolower($label) }}..." class="w-full rounded-[24px] border border-black/[0.04] bg-white px-6 py-5 text-[13px] font-medium leading-relaxed text-black outline-none shadow-sm focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all"></textarea>
                    </label>
                    @endforeach
                </div>
                <div class="flex items-center gap-6 pt-4">
                    <button type="submit" class="rounded-[20px] bg-black px-10 py-5 text-[11px] font-bold uppercase tracking-[0.2em] text-white shadow-2xl transition-all hover:scale-105 active:scale-95">Initialize Style</button>
                    <button type="button" onclick="document.getElementById('addStyleForm').classList.add('hidden')" class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#8c4343] hover:underline underline-offset-8 transition-all">Cancel Operation</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Managed Aesthetic Grid -->
    <div class="mt-12 space-y-12">
        @forelse ($styles as $style)
            <article class="group relative rounded-[48px] border border-black/[0.04] bg-[#fbfaf8] p-2 transition-all hover:shadow-2xl hover:shadow-black/[0.04]">
                <form action="{{ route('admin.styles.update', $style) }}" method="POST" class="rounded-[46px] bg-white p-10">
                    @csrf @method('PATCH')
                    
                    <div class="flex flex-col gap-10 border-b border-black/[0.03] pb-10 xl:flex-row xl:items-center">
                        <div class="flex flex-1 items-center gap-8">
                            <div class="relative group/thumb h-24 w-24 overflow-hidden rounded-[32px] border border-black/[0.04] bg-[#fbfaf8] shadow-lg">
                                <img src="{{ $style->thumbnail_url }}" alt="" class="h-full w-full object-cover transition-transform duration-700 group-hover/thumb:scale-110">
                                <div class="absolute inset-0 bg-black/10 opacity-0 group-hover/thumb:opacity-100 transition-opacity"></div>
                            </div>
                            <div>
                                <h3 class="font-[Playfair Display] text-3xl font-bold text-black italic">{{ $style->name }}</h3>
                                <div class="mt-3 flex items-center gap-4">
                                    <span class="rounded-full bg-[#f1f3f0] px-3 py-1 text-[9px] font-bold uppercase tracking-widest text-[#7a8a6b]">ID: #{{ str_pad($style->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    <span class="text-[11px] font-bold text-[#a89078]">{{ number_format($style->room_designs_count) }} Generations Influenced</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <button type="submit" class="rounded-[20px] bg-black px-8 py-4 text-[10px] font-bold uppercase tracking-[0.2em] text-white shadow-xl transition-all hover:scale-105 active:scale-95">
                                Deploy Changes
                            </button>
                            <button form="delete-style-{{ $style->id }}" type="submit" class="rounded-[20px] border border-black/[0.04] bg-white p-4 text-[#8c4343] shadow-sm hover:bg-[#f7e9e9] hover:border-[#f7e9e9] transition-all">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mt-10 space-y-10">
                        <div class="grid gap-10 md:grid-cols-2">
                            <label class="block group">
                                <span class="mb-4 block text-[10px] font-bold uppercase tracking-[0.3em] text-[#a89078] group-focus-within:text-black transition-colors">Aesthetic Name</span>
                                <input type="text" name="name" value="{{ $style->name }}" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                            </label>
                            <label class="block group">
                                <span class="mb-4 block text-[10px] font-bold uppercase tracking-[0.3em] text-[#a89078] group-focus-within:text-black transition-colors">Thumbnail Asset URL</span>
                                <input type="url" name="thumbnail_url" value="{{ $style->thumbnail_url }}" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                            </label>
                        </div>
                        
                        <label class="block group">
                            <span class="mb-4 block text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b] group-focus-within:text-black transition-colors">Global System Prompt Prefix</span>
                            <textarea name="prompt_prefix" rows="2" class="w-full rounded-[24px] border border-black/[0.04] bg-[#faf9f6] px-6 py-5 text-[13px] font-medium leading-relaxed text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">{{ $style->prompt_prefix }}</textarea>
                        </label>

                        <div class="grid gap-10 md:grid-cols-3">
                            @foreach(['low' => 'Economy (Low)', 'medium' => 'Standard (Mid)', 'high' => 'Luxury (High)'] as $key => $label)
                            <label class="block group">
                                <span class="mb-4 block text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b] group-focus-within:text-black transition-colors">{{ $label }}</span>
                                <textarea name="prompt_{{ $key }}" rows="6" class="w-full rounded-[24px] border border-black/[0.04] bg-[#faf9f6] px-6 py-5 text-[13px] font-medium leading-relaxed text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">{{ $style->{"prompt_{$key}"} }}</textarea>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </form>
                <form id="delete-style-{{ $style->id }}" action="{{ route('admin.styles.delete', $style) }}" method="POST" onsubmit="return confirm('Retire and delete aesthetic \'{{ $style->name }}\'? Permanent action.')">
                    @csrf @method('DELETE')
                </form>
            </article>
        @empty
            <div class="py-40 text-center">
                <div class="inline-flex h-24 w-24 items-center justify-center rounded-[40px] bg-[#fbfaf8] text-[#a89078] shadow-inner">
                    <i class="fa-solid fa-palette text-3xl"></i>
                </div>
                <h3 class="mt-10 font-[Playfair Display] text-3xl font-bold text-black italic">Library is currently empty</h3>
                <p class="mt-4 text-sm font-medium text-[#7a8a6b] max-w-md mx-auto">No design aesthetics have been registered. Initialize the engine by adding your first style.</p>
            </div>
        @endforelse
    </div>
</section>
@endsection


