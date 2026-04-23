@extends('admin.layout')

@section('title', 'Styles')

@section('content')
<section class="rounded-[32px] border border-white/60 bg-white/72 p-6 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
    <div class="flex flex-col gap-4 border-b border-[rgba(47,47,47,0.08)] pb-5 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.26em] text-[var(--color-olive)]">Library</p>
            <h2 class="mt-3 font-[var(--font-display)] text-3xl leading-tight">Design styles ({{ $styles->count() }})</h2>
        </div>
        <button onclick="document.getElementById('addStyleForm').classList.toggle('hidden')" class="rounded-full bg-[var(--color-charcoal)] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[var(--color-taupe)]">
            + Add Style
        </button>
    </div>

    <div id="addStyleForm" class="hidden mt-6 rounded-[28px] bg-[rgba(247,246,242,0.82)] p-5">
        <form action="{{ route('admin.styles.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid gap-4 md:grid-cols-2">
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-[var(--color-charcoal)]">Style Name</span>
                    <input type="text" name="name" required placeholder="e.g. Bohemian" class="w-full rounded-[18px] border border-[rgba(47,47,47,0.10)] bg-white px-4 py-3 text-sm outline-none">
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-[var(--color-charcoal)]">Thumbnail URL</span>
                    <input type="url" name="thumbnail_url" placeholder="https://..." class="w-full rounded-[18px] border border-[rgba(47,47,47,0.10)] bg-white px-4 py-3 text-sm outline-none">
                </label>
            </div>
            <label class="block">
                <span class="mb-2 block text-sm font-semibold text-[var(--color-charcoal)]">AI Prompt Prefix</span>
                <textarea name="prompt_prefix" rows="3" placeholder="Describe the style for AI..." class="w-full rounded-[18px] border border-[rgba(47,47,47,0.10)] bg-white px-4 py-3 text-sm outline-none"></textarea>
            </label>
            <div class="flex gap-3">
                <button type="submit" class="rounded-full bg-[var(--color-charcoal)] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[var(--color-taupe)]">Save Style</button>
                <button type="button" onclick="document.getElementById('addStyleForm').classList.add('hidden')" class="rounded-full border border-[rgba(47,47,47,0.10)] bg-white px-5 py-3 text-sm font-semibold text-[var(--color-charcoal)]">Cancel</button>
            </div>
        </form>
    </div>

    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full text-left">
            <thead>
                <tr class="text-xs font-semibold uppercase tracking-[0.24em] text-[color:rgba(47,47,47,0.46)]">
                    <th class="pb-4 pr-4">ID</th>
                    <th class="pb-4 pr-4">Name</th>
                    <th class="pb-4 pr-4">Prompt Prefix</th>
                    <th class="pb-4 pr-4">Designs</th>
                    <th class="pb-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[rgba(47,47,47,0.08)]">
                @forelse ($styles as $style)
                    <tr>
                        <td class="py-4 pr-4 text-sm text-[color:rgba(47,47,47,0.68)]">#{{ $style->id }}</td>
                        <td class="py-4 pr-4 font-semibold text-[var(--color-charcoal)]">{{ $style->name }}</td>
                        <td class="max-w-[20rem] py-4 pr-4 text-sm text-[color:rgba(47,47,47,0.62)]">{{ $style->prompt_prefix ?? '—' }}</td>
                        <td class="py-4 pr-4 text-sm text-[color:rgba(47,47,47,0.68)]">{{ $style->room_designs_count }}</td>
                        <td class="py-4">
                            <form action="{{ route('admin.styles.delete', $style) }}" method="POST" onsubmit="return confirm('Delete style \'{{ $style->name }}\'? This will also delete all associated designs.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-full border border-[rgba(159,86,86,0.18)] bg-[rgba(159,86,86,0.10)] px-4 py-2 text-sm font-semibold text-[#8c4343] transition hover:bg-[rgba(159,86,86,0.16)]">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-sm text-[color:rgba(47,47,47,0.56)]">No styles configured yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
