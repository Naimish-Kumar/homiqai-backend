@extends('layouts.web')

@section('title', 'Homiq AI – Shared Lookbook Moodboard')

@section('extra_css')
<!-- Handwriting Font for sticky notes -->
<link href="https://fonts.googleapis.com/css2?family=Architects+Daughter&family=Kalam:wght@700&display=swap" rel="stylesheet">
<style>
    .moodboard-canvas {
        position: relative;
        width: 100%;
        max-width: 900px;
        height: 480px;
        margin: 0 auto;
        border-radius: 32px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background-color: #0F172A;
        /* Replicate CanvasGridPainter */
        background-size: 25px 25px;
        background-image: 
            linear-gradient(to right, rgba(73, 169, 180, 0.04) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(73, 169, 180, 0.04) 1px, transparent 1px);
        box-shadow: inset 0 0 40px rgba(0, 0, 0, 0.3), 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .font-handwriting {
        font-family: 'Architects Daughter', cursive;
    }

    /* Toast Notification CSS */
    .toast-box {
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: #0F172A;
        border: 1px solid rgba(73, 169, 180, 0.3);
        border-radius: 16px;
        padding: 14px 24px;
        color: white;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 100;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5), 0 0 20px rgba(73, 169, 180, 0.1);
        transform: translateY(150%);
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .toast-box.show {
        transform: translateY(0);
    }
</style>
@endsection

@section('content')
<div class="pt-32 pb-24 container mx-auto px-6 max-w-6xl">
    <!-- Header -->
    <div class="text-center mb-12" data-aos="fade-up">
        <span class="text-xs font-extrabold tracking-[0.25em] text-[#49A9B4] uppercase bg-[#49A9B4]/10 px-4 py-2 rounded-full">DESIGN LOOKBOOK</span>
        <h1 class="text-4xl md:text-5xl font-black mt-4 mb-3 leading-tight tracking-tight outfit">
            {{ $moodboard->title }}
        </h1>
        @if($moodboard->description)
            <p class="text-white/60 text-lg max-w-xl mx-auto font-medium mb-2">
                {{ $moodboard->description }}
            </p>
        @endif
        <p class="text-white/40 text-sm font-semibold tracking-wider uppercase">
            Curated by <span class="text-white/70">{{ $moodboard->user->name ?? 'Homiq Designer' }}</span>
        </p>
    </div>

    <!-- Moodboard Canvas Visualizer -->
    <div class="mb-16" data-aos="fade-up" data-aos-delay="100">
        <div class="moodboard-canvas">
            @foreach($moodboard->items as $item)
                @if($item['type'] === 'color')
                    <!-- Color Swatch Circle -->
                    <div class="absolute rounded-full shadow-lg border-2 border-white/10 flex-shrink-0 transition-all hover:scale-110 duration-200 cursor-pointer"
                         style="left: {{ $item['x'] }}px; top: {{ $item['y'] }}px; width: {{ 60 * ($item['scale'] ?? 1.0) }}px; height: {{ 60 * ($item['scale'] ?? 1.0) }}px; background-color: {{ $item['url'] }}; transform: rotate({{ $item['rotation'] ?? 0.0 }}rad);"
                         onclick="copyHex('{{ $item['url'] }}')">
                    </div>
                @elseif($item['type'] === 'text')
                    <!-- Sticky Note -->
                    <div class="absolute bg-[#FFF9C4] text-black/80 px-5 py-4 rounded-xl shadow-lg font-handwriting select-none border border-[#FBC02D]/10 hover:scale-105 duration-200 cursor-default"
                         style="left: {{ $item['x'] }}px; top: {{ $item['y'] }}px; font-size: {{ 14 * ($item['scale'] ?? 1.0) }}px; transform: rotate({{ $item['rotation'] ?? 0.0 }}rad); max-width: 200px; word-wrap: break-word;">
                         {{ $item['text'] }}
                    </div>
                @else
                    <!-- Image Box (Material or Furniture) -->
                    <div class="absolute rounded-2xl overflow-hidden shadow-xl border border-white/10 hover:scale-105 transition-all duration-200 bg-white/5"
                         style="left: {{ $item['x'] }}px; top: {{ $item['y'] }}px; width: {{ 90 * ($item['scale'] ?? 1.0) }}px; height: {{ 90 * ($item['scale'] ?? 1.0) }}px; transform: rotate({{ $item['rotation'] ?? 0.0 }}rad);">
                         <img src="{{ $item['url'] }}" alt="Lookbook Asset" class="w-full h-full object-cover">
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Style Theme & Swatches section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 mb-20" data-aos="fade-up" data-aos-delay="200">
        <!-- Palette Header -->
        <div class="lg:col-span-1">
            <h2 class="text-3xl font-black mb-3 tracking-tight outfit">Color Palette</h2>
            <p class="text-white/50 leading-relaxed font-medium mb-6">
                Tap on any hex code swatch block to copy the color code directly to your clipboard. Use it in your designs or share it with your contractor.
            </p>
            @if($moodboard->style)
                <div class="glass px-6 py-4 rounded-2xl inline-flex items-center gap-3 border-[#49A9B4]/20">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#49A9B4] teal-glow"></span>
                    <span class="text-sm font-bold tracking-wider uppercase text-white/80">Style DNA: {{ $moodboard->style->name }}</span>
                </div>
            @endif
        </div>

        <!-- Palette Swatch Cards -->
        <div class="lg:col-span-2">
            @if(empty($moodboard->color_palette))
                <div class="glass p-10 text-center rounded-3xl">
                    <p class="text-white/40 font-semibold uppercase tracking-wider">No specific paint palette codes generated.</p>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                    @foreach($moodboard->color_palette as $hex)
                        <div class="glass p-5 rounded-3xl flex flex-col items-center group cursor-pointer hover:border-[#49A9B4]/30 transition-all duration-300" onclick="copyHex('{{ $hex }}')">
                            <div class="w-full h-20 rounded-2xl shadow-inner mb-4 transition-transform group-hover:scale-[1.02] duration-300" style="background-color: {{ $hex }}"></div>
                            <span class="font-mono text-base font-bold text-white/70 group-hover:text-[#49A9B4] transition-colors uppercase tracking-wider">{{ $hex }}</span>
                            <span class="text-[10px] font-extrabold tracking-[0.15em] text-[#49A9B4] opacity-0 group-hover:opacity-100 transition-opacity uppercase mt-1.5 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                Copy Color
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- App CTA Banner -->
    <div class="glass p-12 rounded-3xl text-center relative overflow-hidden border-[#49A9B4]/20" data-aos="zoom-y-out">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-[#49A9B4]/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-[#49A9B4]/10 rounded-full blur-3xl pointer-events-none"></div>
        
        <h2 class="text-3xl font-black mb-3 tracking-tight">Design Your Perfect Board</h2>
        <p class="text-white/60 max-w-xl mx-auto mb-8 leading-relaxed font-medium">
            Collect swatches, drop furniture catalogs, generate instant matching palettes using AI, and share the lookbook with contractors or friends.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="#" class="btn-primary px-8 py-4 rounded-full font-bold text-sm tracking-wider uppercase teal-glow inline-flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.523 15.3l-2.035-1.258a10.22 10.22 0 0 1-5.18-.017L8.28 15.28c-1.39.873-1.637 2.766-.516 3.935l1.01 1.053c.692.723 1.838.835 2.656.26l.722-.507c.806-.566 1.874-.566 2.68 0l.723.508c.817.575 1.964.462 2.656-.26l1.01-1.053c1.12-1.17.873-3.062-.516-3.935zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 14.5h-2v-2h2v2zm0-4h-2V7h2v5z"/></svg>
                Download App (iOS)
            </a>
            <a href="#" class="bg-white/5 border border-white/10 hover:bg-white/10 px-8 py-4 rounded-full font-bold text-sm tracking-wider uppercase inline-flex items-center justify-center gap-2 transition-all">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 20.285c0 1.066.86 1.861 1.854 1.861h14.292c.995 0 1.854-.795 1.854-1.861V3.715c0-1.066-.86-1.861-1.854-1.861H4.854C3.86 1.854 3 2.65 3 3.715v16.57zM17 18H7v-2h10v2zm0-4H7v-2h10v2zm0-4H7V8h10v2z"/></svg>
                Get it on Android
            </a>
        </div>
    </div>
</div>

<!-- Copy toast container -->
<div id="toast-box" class="toast-box">
    <div class="w-5 h-5 rounded-full bg-[#49A9B4] flex items-center justify-center text-white text-[10px]">✓</div>
    <span id="toast-message">Color copied to clipboard!</span>
</div>
@endsection

@section('extra_js')
<script>
    let toastTimeout = null;

    function copyHex(hex) {
        navigator.clipboard.writeText(hex).then(() => {
            showToast(`Hex code ${hex.toUpperCase()} copied successfully!`);
        }).catch(err => {
            console.error('Failed to copy color: ', err);
        });
    }

    function showToast(message) {
        const toast = document.getElementById('toast-box');
        const text = document.getElementById('toast-message');
        
        if (!toast || !text) return;
        
        text.innerText = message;
        toast.classList.add('show');
        
        if (toastTimeout) clearTimeout(toastTimeout);
        
        toastTimeout = setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }
</script>
@endsection
