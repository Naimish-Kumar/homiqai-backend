@extends('layouts.web')

@section('title', 'Homiq AI – Shared Room Design Concept')

@section('extra_css')
<style>
    .split-slider-container {
        position: relative;
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        aspect-ratio: 16 / 10;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .split-slider-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        pointer-events: none;
    }

    #after-image {
        z-index: 2;
        clip-path: polygon(0 0, 50% 0, 50% 100%, 0 100%);
        transition: clip-path 0.05s linear;
    }

    .slider-divider {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #49A9B4;
        left: 50%;
        z-index: 3;
        cursor: ew-resize;
        transform: translateX(-50%);
        box-shadow: 0 0 15px rgba(73, 169, 180, 0.8);
    }

    .slider-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 44px;
        height: 44px;
        background: #49A9B4;
        border-radius: 50%;
        border: 3px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        box-shadow: 0 0 20px rgba(73, 169, 180, 0.6);
        pointer-events: none;
    }

    .badge-label {
        position: absolute;
        bottom: 20px;
        padding: 8px 16px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 12px;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 4;
    }

    .badge-before {
        right: 20px;
        background: rgba(15, 23, 42, 0.6);
        color: rgba(255, 255, 255, 0.7);
    }

    .badge-after {
        left: 20px;
        background: rgba(73, 169, 180, 0.6);
        color: white;
    }
</style>
@endsection

@section('content')
<div class="pt-32 pb-24 container mx-auto px-6 max-w-6xl">
    <!-- Header -->
    <div class="text-center mb-12" data-aos="fade-up">
        <span class="text-xs font-extrabold tracking-[0.25em] text-[#49A9B4] uppercase bg-[#49A9B4]/10 px-4 py-2 rounded-full">DESIGN EXCLUSIVE</span>
        <h1 class="text-4xl md:text-5xl font-black mt-4 mb-3 leading-tight tracking-tight">
            {{ ucwords(str_replace('_', ' ', $design->room_type)) }} Redesign
        </h1>
        <p class="text-white/60 text-lg max-w-xl mx-auto font-medium">
            AI-powered interior concept shared by <span class="text-white font-semibold">{{ $design->user->name ?? 'Homiq User' }}</span>
        </p>
    </div>

    <!-- Main Comparison Section -->
    <div class="mb-16" data-aos="fade-up" data-aos-delay="100">
        <div class="split-slider-container" id="slider-container">
            <!-- Original Image (Before) -->
            <img src="{{ $originalUrl }}" alt="Original Room" class="split-slider-image">
            <span class="badge-label badge-before">Before (Original)</span>

            <!-- Generated Image (After) -->
            <img src="{{ $generatedUrl }}" id="after-image" alt="AI Redesign" class="split-slider-image">
            <span class="badge-label badge-after">After (AI Redesigned)</span>

            <!-- Draggable Divider -->
            <div class="slider-divider" id="slider-divider">
                <div class="slider-button">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 9l-4 3 4 3m8-6l4 3-4 3"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Design Specification Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-20" data-aos="fade-up" data-aos-delay="200">
        <!-- Room Info -->
        <div class="glass p-8 rounded-3xl flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-[#49A9B4] flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-white/50 tracking-wider uppercase mb-1">Space Type</h3>
                <p class="text-xl font-bold">{{ ucwords(str_replace('_', ' ', $design->room_type)) }}</p>
                <p class="text-sm text-white/40 mt-1">Uploaded and scanned space</p>
            </div>
        </div>

        <!-- Style Info -->
        <div class="glass p-8 rounded-3xl flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-[#49A9B4] flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-white/50 tracking-wider uppercase mb-1">Aesthetic Theme</h3>
                <p class="text-xl font-bold">{{ $design->style->name ?? 'Modern Theme' }}</p>
                <p class="text-sm text-white/40 mt-1">AI-generated design profile</p>
            </div>
        </div>

        <!-- Budget Info -->
        <div class="glass p-8 rounded-3xl flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-[#49A9B4] flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-white/50 tracking-wider uppercase mb-1">Budget Tier</h3>
                <p class="text-xl font-bold">
                    @if($design->budget === 'low')
                        Budget-Friendly (Low)
                    @elseif($design->budget === 'medium')
                        Mid-Range (Medium)
                    @else
                        Premium (High)
                    @endif
                </p>
                <p class="text-sm text-white/40 mt-1">
                    @if($design->budget === 'low')
                        ₹50K – ₹1.5L
                    @elseif($design->budget === 'medium')
                        ₹1.5L – ₹5L
                    @else
                        ₹5L+
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Shop the Look Section -->
    <div class="mb-20" data-aos="fade-up" data-aos-delay="300">
        <h2 class="text-3xl font-black mb-2 tracking-tight outfit">Shop the Look</h2>
        <p class="text-white/40 font-semibold mb-10 tracking-wide uppercase text-sm">Recommended Products & Affiliate Matches</p>

        @if($design->furnitureRecommendations->isEmpty())
            <div class="glass p-12 text-center rounded-3xl">
                <svg class="w-12 h-12 text-white/20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <p class="text-white/50 font-medium">No direct catalog product matches mapped for this configuration.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($design->furnitureRecommendations as $item)
                    <div class="glass rounded-3xl overflow-hidden group hover:border-[#49A9B4]/30 transition-all duration-300">
                        <div class="relative aspect-square overflow-hidden bg-white/5">
                            <img src="{{ $item->image_url ?? 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?q=80&w=600&auto=format&fit=crop' }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute top-4 right-4 bg-black/60 backdrop-blur-md px-3 py-1.5 rounded-full text-sm font-bold text-[#49A9B4] border border-white/5">
                                ₹{{ number_format($item->price) }}
                            </span>
                        </div>
                        <div class="p-6">
                            <h4 class="font-bold text-lg text-white mb-1 group-hover:text-[#49A9B4] transition-colors truncate">{{ $item->name }}</h4>
                            <p class="text-xs font-semibold uppercase tracking-wider text-white/40 mb-5">Homiq Partner Catalog</p>
                            
                            <a href="{{ $item->purchase_link }}" target="_blank" rel="noopener" class="w-full btn-primary text-center block py-3.5 rounded-2xl font-bold text-sm tracking-wider uppercase">
                                Buy Product
                            </a>
                            <p class="text-[10px] text-center text-white/20 mt-2 font-medium">Affiliate referral link. Terms apply.</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- App CTA Banner -->
    <div class="glass p-12 rounded-3xl text-center relative overflow-hidden border-[#49A9B4]/20" data-aos="zoom-y-out">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-[#49A9B4]/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-[#49A9B4]/10 rounded-full blur-3xl pointer-events-none"></div>
        
        <h2 class="text-3xl font-black mb-3 tracking-tight">Visualize Your Own Home</h2>
        <p class="text-white/60 max-w-xl mx-auto mb-8 leading-relaxed font-medium">
            Scan your rooms, choose your signature aesthetics, and swap products in high fidelity. Get photorealistic 3D renders instantly with Homiq AI.
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
@endsection

@section('extra_js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('slider-container');
        const afterImage = document.getElementById('after-image');
        const divider = document.getElementById('slider-divider');

        if (!container || !afterImage || !divider) return;

        let isDragging = false;

        function updateSlider(clientX) {
            const rect = container.getBoundingClientRect();
            let x = clientX - rect.left;
            
            // Constrain
            if (x < 0) x = 0;
            if (x > rect.width) x = rect.width;
            
            const percentage = (x / rect.width) * 100;
            
            // Move divider
            divider.style.left = percentage + '%';
            // Clip image
            afterImage.style.clipPath = `polygon(0 0, ${percentage}% 0, ${percentage}% 100%, 0 100%)`;
        }

        // Mouse Events
        container.addEventListener('mousedown', function (e) {
            isDragging = true;
            updateSlider(e.clientX);
        });

        window.addEventListener('mouseup', function () {
            isDragging = false;
        });

        window.addEventListener('mousemove', function (e) {
            if (!isDragging) return;
            updateSlider(e.clientX);
        });

        // Touch Events
        container.addEventListener('touchstart', function (e) {
            isDragging = true;
            updateSlider(e.touches[0].clientX);
        });

        window.addEventListener('touchend', function () {
            isDragging = false;
        });

        window.addEventListener('touchmove', function (e) {
            if (!isDragging) return;
            updateSlider(e.touches[0].clientX);
        });
    });
</script>
@endsection
