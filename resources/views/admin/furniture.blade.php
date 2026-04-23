@extends('admin.layout')

@section('title', 'Furniture Catalog')

@section('content')
<section class="grid gap-6 md:grid-cols-3">
    <article class="rounded-[28px] border border-black/6 bg-white p-6 shadow-[0_18px_50px_rgba(31,31,31,0.06)]">
        <p class="text-sm text-[#5e564e]">Total products</p>
        <p class="mt-3 text-3xl font-semibold text-[#171717]">{{ number_format($summary['total_products']) }}</p>
    </article>
    <article class="rounded-[28px] border border-black/6 bg-white p-6 shadow-[0_18px_50px_rgba(31,31,31,0.06)]">
        <p class="text-sm text-[#5e564e]">Active products</p>
        <p class="mt-3 text-3xl font-semibold text-[#171717]">{{ number_format($summary['active_products']) }}</p>
    </article>
    <article class="rounded-[28px] border border-black/6 bg-white p-6 shadow-[0_18px_50px_rgba(31,31,31,0.06)]">
        <p class="text-sm text-[#5e564e]">Categories</p>
        <p class="mt-3 text-3xl font-semibold text-[#171717]">{{ number_format($summary['categories']) }}</p>
    </article>
</section>

<section class="mt-6 rounded-[32px] border border-black/6 bg-white p-6 shadow-[0_22px_60px_rgba(31,31,31,0.07)]">
    <div class="border-b border-black/6 pb-5">
        <p class="text-xs font-semibold uppercase tracking-[0.26em] text-[#7a8a6b]">Furniture CMS</p>
        <h2 class="mt-3 font-[Playfair Display] text-3xl leading-tight text-[#171717]">Add products and tag them to styles</h2>
    </div>

    <form action="{{ route('admin.furniture.store') }}" method="POST" class="mt-6 grid gap-4 xl:grid-cols-3">
        @csrf
        <input type="text" name="name" placeholder="Product name" class="rounded-[18px] border border-black/8 bg-[#faf7f2] px-4 py-3 text-sm outline-none" required>
        <input type="text" name="category" placeholder="Category: sofa, table, decor" class="rounded-[18px] border border-black/8 bg-[#faf7f2] px-4 py-3 text-sm outline-none" required>
        <input type="text" name="brand" placeholder="Brand" class="rounded-[18px] border border-black/8 bg-[#faf7f2] px-4 py-3 text-sm outline-none">
        <input type="url" name="image_url" placeholder="Image URL" class="rounded-[18px] border border-black/8 bg-[#faf7f2] px-4 py-3 text-sm outline-none xl:col-span-2">
        <input type="url" name="affiliate_link" placeholder="Affiliate link" class="rounded-[18px] border border-black/8 bg-[#faf7f2] px-4 py-3 text-sm outline-none">
        <input type="number" step="0.01" min="0" name="low_price" placeholder="Low price" class="rounded-[18px] border border-black/8 bg-[#faf7f2] px-4 py-3 text-sm outline-none">
        <input type="number" step="0.01" min="0" name="medium_price" placeholder="Medium price" class="rounded-[18px] border border-black/8 bg-[#faf7f2] px-4 py-3 text-sm outline-none">
        <input type="number" step="0.01" min="0" name="high_price" placeholder="High price" class="rounded-[18px] border border-black/8 bg-[#faf7f2] px-4 py-3 text-sm outline-none">
        <select name="style_ids[]" multiple class="rounded-[18px] border border-black/8 bg-[#faf7f2] px-4 py-3 text-sm outline-none xl:col-span-2">
            @foreach($styles as $style)
                <option value="{{ $style->id }}">{{ $style->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-full bg-[#171717] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#2a2a2a]">Add Product</button>
    </form>
</section>

<section class="mt-6 space-y-5">
    @forelse($products as $product)
        <article class="rounded-[30px] border border-black/6 bg-white p-5 shadow-[0_18px_50px_rgba(31,31,31,0.06)]">
            <form action="{{ route('admin.furniture.update', $product) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div class="grid gap-4 xl:grid-cols-[140px_minmax(0,1fr)_minmax(0,1fr)]">
                    <div class="overflow-hidden rounded-[22px] bg-[#faf7f2]">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-32 w-full object-cover">
                        @else
                            <div class="flex h-32 items-center justify-center text-sm text-[#6a625a]">No image</div>
                        @endif
                    </div>
                    <div class="grid gap-3 md:grid-cols-2 xl:col-span-2">
                        <input type="text" name="name" value="{{ $product->name }}" class="rounded-[18px] border border-black/8 bg-[#faf7f2] px-4 py-3 text-sm outline-none" required>
                        <input type="text" name="category" value="{{ $product->category }}" class="rounded-[18px] border border-black/8 bg-[#faf7f2] px-4 py-3 text-sm outline-none" required>
                        <input type="text" name="brand" value="{{ $product->brand }}" class="rounded-[18px] border border-black/8 bg-[#faf7f2] px-4 py-3 text-sm outline-none">
                        <input type="url" name="image_url" value="{{ $product->image_url }}" class="rounded-[18px] border border-black/8 bg-[#faf7f2] px-4 py-3 text-sm outline-none">
                        <input type="url" name="affiliate_link" value="{{ $product->affiliate_link }}" class="rounded-[18px] border border-black/8 bg-[#faf7f2] px-4 py-3 text-sm outline-none md:col-span-2">
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-4">
                    <input type="number" step="0.01" min="0" name="low_price" value="{{ $product->low_price }}" placeholder="Low price" class="rounded-[18px] border border-black/8 bg-[#faf7f2] px-4 py-3 text-sm outline-none">
                    <input type="number" step="0.01" min="0" name="medium_price" value="{{ $product->medium_price }}" placeholder="Medium price" class="rounded-[18px] border border-black/8 bg-[#faf7f2] px-4 py-3 text-sm outline-none">
                    <input type="number" step="0.01" min="0" name="high_price" value="{{ $product->high_price }}" placeholder="High price" class="rounded-[18px] border border-black/8 bg-[#faf7f2] px-4 py-3 text-sm outline-none">
                    <label class="flex items-center gap-3 rounded-[18px] border border-black/8 bg-[#faf7f2] px-4 py-3 text-sm text-[#171717]">
                        <input type="checkbox" name="is_active" value="1" @checked($product->is_active)>
                        <span>Active product</span>
                    </label>
                </div>

                <select name="style_ids[]" multiple class="w-full rounded-[18px] border border-black/8 bg-[#faf7f2] px-4 py-3 text-sm outline-none">
                    @foreach($styles as $style)
                        <option value="{{ $style->id }}" @selected($product->styles->contains($style))>{{ $style->name }}</option>
                    @endforeach
                </select>

                <div class="flex flex-wrap gap-3">
                    @foreach($product->styles as $style)
                        <span class="rounded-full bg-[#eef3ea] px-3 py-2 text-xs font-semibold uppercase tracking-[0.14em] text-[#405038]">{{ $style->name }}</span>
                    @endforeach
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    <button type="submit" class="rounded-full bg-[#171717] px-4 py-2 text-sm font-semibold text-white">Update</button>
                    <button form="delete-product-{{ $product->id }}" type="submit" class="rounded-full border border-[rgba(159,86,86,0.18)] bg-[rgba(159,86,86,0.10)] px-4 py-2 text-sm font-semibold text-[#8c4343]">Delete</button>
                </div>
            </form>
            <form id="delete-product-{{ $product->id }}" action="{{ route('admin.furniture.delete', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                @csrf
                @method('DELETE')
            </form>
        </article>
    @empty
        <div class="rounded-[30px] border border-black/6 bg-white p-8 text-sm text-[#6a625a] shadow-[0_18px_50px_rgba(31,31,31,0.06)]">
            No furniture products added yet.
        </div>
    @endforelse
</section>
@endsection
