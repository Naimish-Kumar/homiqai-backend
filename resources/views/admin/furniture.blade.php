@extends('admin.layout')

@section('title', 'Showroom')

@section('content')
<div class="space-y-10">
    <!-- Catalog Intelligence -->
    <section class="grid gap-10 md:grid-cols-3">
        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Total Inventory</p>
            <p class="mt-4 font-[Playfair Display] text-4xl font-bold text-black italic">{{ number_format($summary['total_products']) }}</p>
        </article>
        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Active Showcase</p>
            <p class="mt-4 font-[Playfair Display] text-4xl font-bold text-black italic">{{ number_format($summary['active_products']) }}</p>
        </article>
        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Visual Taxonomy</p>
            <p class="mt-4 font-[Playfair Display] text-4xl font-bold text-black italic">{{ number_format($summary['categories']) }}</p>
        </article>
    </section>

    <!-- Product Creation Console -->
    <section class="rounded-[56px] border border-black/[0.03] bg-white p-12 shadow-2xl shadow-black/[0.03]">
        <div class="flex flex-col gap-6 xl:flex-row xl:items-center xl:justify-between border-b border-black/[0.03] pb-10">
            <div>
                <h2 class="font-[Playfair Display] text-4xl font-bold text-black italic">Catalog Addition</h2>
                <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Register new architectural assets to the library</p>
            </div>
            <button type="submit" form="add-product-form" class="rounded-[28px] bg-black px-12 py-5 text-[11px] font-bold uppercase tracking-[0.2em] text-white shadow-2xl transition-all hover:scale-105 active:scale-95">Add to Library</button>
        </div>

        <form id="add-product-form" action="{{ route('admin.furniture.store') }}" method="POST" class="mt-12 grid gap-10 xl:grid-cols-3">
            @csrf
            <label class="block group">
                <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Manifest Name</span>
                <input type="text" name="name" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all" required>
            </label>
            <label class="block group">
                <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Taxonomy Class</span>
                <input type="text" name="category" placeholder="e.g. Sofa, Table, Decor" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all" required>
            </label>
            <label class="block group">
                <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Brand Identity</span>
                <input type="text" name="brand" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
            </label>
            <label class="block group xl:col-span-2">
                <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Media Vector (Image URL)</span>
                <input type="url" name="image_url" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
            </label>
            <label class="block group">
                <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Commerce Link</span>
                <input type="url" name="affiliate_link" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
            </label>
            
            <div class="grid gap-10 md:grid-cols-3 xl:col-span-3">
                <label class="block group">
                    <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Entry Price</span>
                    <input type="number" step="0.01" min="0" name="low_price" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                </label>
                <label class="block group">
                    <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Mid-Range Value</span>
                    <input type="number" step="0.01" min="0" name="medium_price" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                </label>
                <label class="block group">
                    <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Premium Tier</span>
                    <input type="number" step="0.01" min="0" name="high_price" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                </label>
            </div>

            <label class="block group xl:col-span-3">
                <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Style Associations</span>
                <select name="style_ids[]" multiple class="w-full rounded-[28px] border border-black/[0.04] bg-[#faf9f6] px-8 py-6 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all min-h-[160px]">
                    @foreach($styles as $style)
                        <option value="{{ $style->id }}" class="py-2">{{ $style->name }}</option>
                    @endforeach
                </select>
                <p class="mt-4 text-[10px] font-bold uppercase tracking-widest text-[#a89078] opacity-60">Hold Cmd/Ctrl to select multiple aesthetics</p>
            </label>
        </form>
    </section>

    <!-- Assets Inventory -->
    <section class="space-y-10">
        <h3 class="font-[Playfair Display] text-3xl font-bold text-black italic">Active Inventory</h3>
        
        <div class="grid gap-10">
            @forelse($products as $product)
                <article class="group rounded-[56px] border border-black/[0.03] bg-white p-10 shadow-xl shadow-black/[0.02] transition-all hover:shadow-2xl">
                    <form action="{{ route('admin.furniture.update', $product) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PATCH')
                        
                        <div class="flex flex-col gap-10 xl:flex-row">
                            <div class="relative w-full xl:w-[280px]">
                                <div class="aspect-square overflow-hidden rounded-[40px] bg-[#faf9f6] border border-black/[0.02]">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    @else
                                        <div class="flex h-full items-center justify-center">
                                            <i class="fa-solid fa-image text-4xl text-black/[0.05]"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="absolute -bottom-4 -right-4 flex gap-2">
                                    <button type="submit" class="flex h-14 w-14 items-center justify-center rounded-full bg-black text-white shadow-xl transition-all hover:scale-110 active:scale-95">
                                        <i class="fa-solid fa-check text-sm"></i>
                                    </button>
                                    <button form="delete-product-{{ $product->id }}" type="submit" class="flex h-14 w-14 items-center justify-center rounded-full bg-white border border-black/[0.05] text-[#8c4343] shadow-xl transition-all hover:scale-110 active:scale-95">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="flex-1 space-y-8">
                                <div class="grid gap-8 md:grid-cols-2">
                                    <label class="block">
                                        <span class="mb-3 block text-[10px] font-bold uppercase tracking-[0.2em] text-[#a89078]">Identity</span>
                                        <input type="text" name="name" value="{{ $product->name }}" class="w-full border-b border-black/[0.08] bg-transparent py-2 text-[18px] font-bold text-black outline-none focus:border-black transition-all">
                                    </label>
                                    <label class="block">
                                        <span class="mb-3 block text-[10px] font-bold uppercase tracking-[0.2em] text-[#a89078]">Classification</span>
                                        <input type="text" name="category" value="{{ $product->category }}" class="w-full border-b border-black/[0.08] bg-transparent py-2 text-[18px] font-bold text-black outline-none focus:border-black transition-all">
                                    </label>
                                </div>

                                <div class="grid gap-8 md:grid-cols-2">
                                    <label class="block">
                                        <span class="mb-3 block text-[10px] font-bold uppercase tracking-[0.2em] text-[#a89078]">Brand Architecture</span>
                                        <input type="text" name="brand" value="{{ $product->brand }}" class="w-full border-b border-black/[0.08] bg-transparent py-2 text-[15px] font-medium text-black outline-none focus:border-black transition-all">
                                    </label>
                                    <label class="block">
                                        <span class="mb-3 block text-[10px] font-bold uppercase tracking-[0.2em] text-[#a89078]">Protocol Link</span>
                                        <input type="url" name="affiliate_link" value="{{ $product->affiliate_link }}" class="w-full border-b border-black/[0.08] bg-transparent py-2 text-[13px] font-mono text-[#7a8a6b] outline-none focus:border-black transition-all">
                                    </label>
                                </div>

                                <div class="grid gap-6 md:grid-cols-4">
                                    @foreach(['low' => 'Entry', 'medium' => 'Mid', 'high' => 'Premium'] as $tier => $label)
                                        <label class="block">
                                            <span class="mb-2 block text-[9px] font-bold uppercase tracking-widest text-[#a89078]">{{ $label }} Price</span>
                                            <div class="relative">
                                                <span class="absolute left-0 top-1/2 -translate-y-1/2 text-[10px] font-bold opacity-30">$</span>
                                                <input type="number" step="0.01" min="0" name="{{ $tier }}_price" value="{{ $product->{$tier.'_price'} }}" class="w-full border-b border-black/[0.04] bg-transparent py-2 pl-4 text-[15px] font-bold text-black outline-none focus:border-black transition-all">
                                            </div>
                                        </label>
                                    @endforeach
                                    <label class="flex items-end pb-2">
                                        <div class="flex items-center gap-3 cursor-pointer">
                                            <input type="checkbox" name="is_active" value="1" @checked($product->is_active) class="h-5 w-5 rounded-full border-black/10 text-black focus:ring-black">
                                            <span class="text-[10px] font-bold uppercase tracking-widest text-black">Operational</span>
                                        </div>
                                    </label>
                                </div>

                                <div class="space-y-4">
                                    <span class="block text-[10px] font-bold uppercase tracking-[0.2em] text-[#a89078]">Aesthetic Anchors</span>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($product->styles as $style)
                                            <span class="rounded-full bg-[#7a8a6b]/10 px-6 py-2 text-[10px] font-bold uppercase tracking-widest text-[#7a8a6b]">{{ $style->name }}</span>
                                        @endforeach
                                        <select name="style_ids[]" multiple class="hidden">
                                            @foreach($styles as $style)
                                                <option value="{{ $style->id }}" @selected($product->styles->contains($style))>{{ $style->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form id="delete-product-{{ $product->id }}" action="{{ route('admin.furniture.delete', $product) }}" method="POST" onsubmit="return confirm('Archive this architectural asset?')">
                        @csrf
                        @method('DELETE')
                    </form>
                </article>
            @empty
                <div class="rounded-[56px] border border-black/[0.03] bg-white p-24 text-center shadow-xl shadow-black/[0.02]">
                    <i class="fa-solid fa-box-open text-5xl text-black/5 mb-8"></i>
                    <p class="text-[13px] font-bold text-black uppercase tracking-[0.3em] opacity-30">Archive empty. No assets found.</p>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
