<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Homiq AI – Your AI Interior Designer')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    
    <style>
        :root {
            --bg-primary: #0F172A;
            --brand-teal: #49A9B4;
            --brand-teal-glow: rgba(73, 169, 180, 0.4);
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: white;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, .outfit {
            font-family: 'Outfit', sans-serif;
        }

        .glass {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
        }

        .teal-glow {
            box-shadow: 0 0 30px var(--brand-teal-glow);
        }

        .text-gradient {
            background: linear-gradient(135deg, #fff 0%, var(--brand-teal) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-primary {
            background: var(--brand-teal);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px var(--brand-teal-glow);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-primary);
        }
        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--brand-teal);
        }

        .slider-handle {
            width: 4px;
            height: 100%;
            background: var(--brand-teal);
            position: absolute;
            left: 50%;
            top: 0;
            z-index: 10;
            cursor: ew-resize;
        }

        .slider-handle::after {
            content: '↔';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            background: var(--brand-teal);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            box-shadow: 0 0 20px var(--brand-teal-glow);
        }
    </style>

    @yield('extra_css')
</head>
<body class="antialiased">
    
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass border-b border-white/5 py-6">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#49A9B4] rounded-xl flex items-center justify-center teal-glow">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
                <span class="text-2xl font-black tracking-tighter outfit uppercase">Homiq <span class="text-[#49A9B4]">AI</span></span>
            </div>
            
            <div class="hidden md:flex items-center gap-10">
                <a href="#features" class="text-sm font-semibold text-white/70 hover:text-[#49A9B4] transition-colors">FEATURES</a>
                <a href="#how-it-works" class="text-sm font-semibold text-white/70 hover:text-[#49A9B4] transition-colors">HOW IT WORKS</a>
                <a href="#styles" class="text-sm font-semibold text-white/70 hover:text-[#49A9B4] transition-colors">STYLES</a>
                <a href="#pricing" class="text-sm font-semibold text-white/70 hover:text-[#49A9B4] transition-colors">PRICING</a>
            </div>

            <div class="flex items-center gap-4">
                <a href="/admin" class="hidden sm:block text-sm font-bold text-white/40 hover:text-white transition-colors uppercase tracking-widest px-4 border-r border-white/10">Admin</a>
                <a href="#" class="btn-primary px-8 py-3 rounded-full font-bold text-sm tracking-wider uppercase">Download App</a>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-black/40 py-20 border-t border-white/5">
        <div class="container mx-auto px-6 text-center">
            <div class="flex items-center justify-center gap-3 mb-8">
                <div class="w-10 h-10 bg-[#49A9B4] rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
                <span class="text-2xl font-black tracking-tighter outfit uppercase">Homiq <span class="text-[#49A9B4]">AI</span></span>
            </div>
            <p class="text-white/40 max-w-md mx-auto mb-10 leading-relaxed font-medium">Reimagining interior design with localized AI intelligence. Truly stunning results in seconds.</p>
            <div class="flex justify-center gap-10 mb-12 text-sm font-bold tracking-widest text-white/60">
                <a href="#" class="hover:text-white transition-colors uppercase">Instagram</a>
                <a href="#" class="hover:text-white transition-colors uppercase">Twitter</a>
                <a href="#" class="hover:text-white transition-colors uppercase">LinkedIn</a>
            </div>
            <p class="text-white/20 text-xs font-bold tracking-[0.2em] uppercase">&copy; 2026 Homiq AI. Built with precision.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            easing: 'ease-out-cubic'
        });
    </script>
    @yield('extra_js')
</body>
</html>
