<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homiq Admin | @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .admin-pagination nav > div:first-child {
            display: none;
        }

        .admin-pagination nav > div:last-child,
        .admin-pagination nav span,
        .admin-pagination nav a {
            align-items: center;
            display: flex;
            flex-wrap: wrap;
            gap: 0.45rem;
        }

        .admin-pagination nav a,
        .admin-pagination nav span[aria-current="page"] span,
        .admin-pagination nav > div:last-child > span {
            background: #ffffff;
            border: 1px solid rgba(26, 26, 26, 0.10);
            border-radius: 9999px;
            color: #1f1f1f;
            font-size: 0.875rem;
            font-weight: 600;
            min-height: 2.6rem;
            padding: 0.65rem 1rem;
        }

        .admin-pagination nav span[aria-current="page"] span {
            background: #1f1f1f;
            border-color: #1f1f1f;
            color: #ffffff;
        }
    </style>
</head>
<body class="min-h-screen selection:bg-[#cbbba0]/30 font-[Poppins] text-[#171717] antialiased">
    <!-- Sophisticated Background System -->
    <div class="fixed inset-0 -z-20 bg-[#faf9f6]"></div>
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] h-[50%] w-[50%] rounded-full bg-[#f1ece4] blur-[120px] opacity-40 animate-pulse" style="animation-duration: 8s"></div>
        <div class="absolute top-[20%] -right-[5%] h-[40%] w-[40%] rounded-full bg-[#eef3ea] blur-[100px] opacity-30 animate-pulse" style="animation-duration: 10s"></div>
        <div class="absolute bottom-[10%] left-[20%] h-[35%] w-[35%] rounded-full bg-[#f7f2ed] blur-[80px] opacity-40 animate-pulse" style="animation-duration: 12s"></div>
    </div>

    <div class="flex h-screen min-h-screen overflow-hidden">
        <!-- Premium Sidebar -->
        <aside class="relative z-30 hidden w-[320px] shrink-0 border-r border-black/[0.04] bg-white/60 backdrop-blur-3xl transition-all duration-500 lg:block">
            <div class="flex h-full flex-col p-8">
                <!-- Brand Identity -->
                <div class="flex items-center gap-5 px-2">
                    <div class="group relative flex h-14 w-14 items-center justify-center overflow-hidden rounded-[22px] bg-black shadow-2xl shadow-black/20 transition-transform hover:scale-105 active:scale-95">
                        <div class="absolute inset-0 bg-gradient-to-tr from-white/10 to-transparent"></div>
                        <i class="fa-solid fa-h text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="font-[Playfair Display] text-2xl font-bold tracking-tight text-black">Homiq</h1>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#7a8a6b] animate-pulse"></span>
                            <p class="text-[9px] font-bold uppercase tracking-[0.3em] text-[#a89078]">Admin Studio</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Architecture -->
                <nav class="mt-12 flex-1 space-y-10 overflow-y-auto pr-2 custom-scrollbar">
                    <!-- Section: Intelligence -->
                    <div class="space-y-4">
                        <p class="px-3 text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]/80">Intelligence</p>
                        <div class="space-y-1.5">
                            <a href="{{ route('admin.dashboard') }}" class="group relative flex items-center gap-4 rounded-2xl px-5 py-4 transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-black text-white shadow-xl shadow-black/10 translate-x-1' : 'text-[#5f5750] hover:bg-black/[0.03] hover:text-black' }}">
                                <i class="fa-solid fa-chart-pie text-sm {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-[#a89078] group-hover:text-[#7a8a6b]' }}"></i>
                                <span class="text-[14px] font-bold tracking-tight">Insights</span>
                            </a>
                            <a href="{{ route('admin.subscriptions') }}" class="group relative flex items-center gap-4 rounded-2xl px-5 py-4 transition-all duration-300 {{ request()->routeIs('admin.subscriptions') ? 'bg-black text-white shadow-xl shadow-black/10 translate-x-1' : 'text-[#5f5750] hover:bg-black/[0.03] hover:text-black' }}">
                                <i class="fa-solid fa-file-invoice-dollar text-sm {{ request()->routeIs('admin.subscriptions') ? 'text-white' : 'text-[#a89078] group-hover:text-[#7a8a6b]' }}"></i>
                                <span class="text-[14px] font-bold tracking-tight">Revenue</span>
                            </a>
                        </div>
                    </div>

                    <!-- Section: Operations -->
                    <div class="space-y-4">
                        <p class="px-3 text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]/80">Operations</p>
                        <div class="space-y-1.5">
                            <a href="{{ route('admin.users') }}" class="group relative flex items-center gap-4 rounded-2xl px-5 py-4 transition-all duration-300 {{ request()->routeIs('admin.users') ? 'bg-black text-white shadow-xl shadow-black/10 translate-x-1' : 'text-[#5f5750] hover:bg-black/[0.03] hover:text-black' }}">
                                <i class="fa-solid fa-users-viewfinder text-sm {{ request()->routeIs('admin.users') ? 'text-white' : 'text-[#a89078] group-hover:text-[#7a8a6b]' }}"></i>
                                <span class="text-[14px] font-bold tracking-tight">Community</span>
                            </a>
                            <a href="{{ route('admin.designs') }}" class="group relative flex items-center gap-4 rounded-2xl px-5 py-4 transition-all duration-300 {{ request()->routeIs('admin.designs') ? 'bg-black text-white shadow-xl shadow-black/10 translate-x-1' : 'text-[#5f5750] hover:bg-black/[0.03] hover:text-black' }}">
                                <i class="fa-solid fa-wand-magic-sparkles text-sm {{ request()->routeIs('admin.designs') ? 'text-white' : 'text-[#a89078] group-hover:text-[#7a8a6b]' }}"></i>
                                <span class="text-[14px] font-bold tracking-tight">Gallery</span>
                            </a>
                            <a href="{{ route('admin.styles') }}" class="group relative flex items-center gap-4 rounded-2xl px-5 py-4 transition-all duration-300 {{ request()->routeIs('admin.styles') ? 'bg-black text-white shadow-xl shadow-black/10 translate-x-1' : 'text-[#5f5750] hover:bg-black/[0.03] hover:text-black' }}">
                                <i class="fa-solid fa-swatchbook text-sm {{ request()->routeIs('admin.styles') ? 'text-white' : 'text-[#a89078] group-hover:text-[#7a8a6b]' }}"></i>
                                <span class="text-[14px] font-bold tracking-tight">Library</span>
                            </a>
                            <a href="{{ route('admin.furniture') }}" class="group relative flex items-center gap-4 rounded-2xl px-5 py-4 transition-all duration-300 {{ request()->routeIs('admin.furniture') ? 'bg-black text-white shadow-xl shadow-black/10 translate-x-1' : 'text-[#5f5750] hover:bg-black/[0.03] hover:text-black' }}">
                                <i class="fa-solid fa-couch text-sm {{ request()->routeIs('admin.furniture') ? 'text-white' : 'text-[#a89078] group-hover:text-[#7a8a6b]' }}"></i>
                                <span class="text-[14px] font-bold tracking-tight">Showroom</span>
                            </a>
                        </div>
                    </div>

                    <!-- Section: Communication -->
                    <div class="space-y-4">
                        <p class="px-3 text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]/80">Communication</p>
                        <div class="space-y-1.5">
                            <a href="{{ route('admin.notifications') }}" class="group relative flex items-center gap-4 rounded-2xl px-5 py-4 transition-all duration-300 {{ request()->routeIs('admin.notifications') ? 'bg-black text-white shadow-xl shadow-black/10 translate-x-1' : 'text-[#5f5750] hover:bg-black/[0.03] hover:text-black' }}">
                                <i class="fa-solid fa-paper-plane text-sm {{ request()->routeIs('admin.notifications') ? 'text-white' : 'text-[#a89078] group-hover:text-[#7a8a6b]' }}"></i>
                                <span class="text-[14px] font-bold tracking-tight">Studio</span>
                            </a>
                            <a href="{{ route('admin.feedback') }}" class="group relative flex items-center gap-4 rounded-2xl px-5 py-4 transition-all duration-300 {{ request()->routeIs('admin.feedback') ? 'bg-black text-white shadow-xl shadow-black/10 translate-x-1' : 'text-[#5f5750] hover:bg-black/[0.03] hover:text-black' }}">
                                <i class="fa-solid fa-comment-dots text-sm {{ request()->routeIs('admin.feedback') ? 'text-white' : 'text-[#a89078] group-hover:text-[#7a8a6b]' }}"></i>
                                <span class="text-[14px] font-bold tracking-tight">Sentiment</span>
                            </a>
                        </div>
                    </div>

                    <!-- Section: Management -->
                    <div class="space-y-4">
                        <p class="px-3 text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]/80">Management</p>
                        <div class="space-y-1.5">
                            <a href="{{ route('admin.storage') }}" class="group relative flex items-center gap-4 rounded-2xl px-5 py-4 transition-all duration-300 {{ request()->routeIs('admin.storage') ? 'bg-black text-white shadow-xl shadow-black/10 translate-x-1' : 'text-[#5f5750] hover:bg-black/[0.03] hover:text-black' }}">
                                <i class="fa-solid fa-hard-drive text-sm {{ request()->routeIs('admin.storage') ? 'text-white' : 'text-[#a89078] group-hover:text-[#7a8a6b]' }}"></i>
                                <span class="text-[14px] font-bold tracking-tight">Storage</span>
                            </a>
                            <a href="{{ route('admin.logs') }}" class="group relative flex items-center gap-4 rounded-2xl px-5 py-4 transition-all duration-300 {{ request()->routeIs('admin.logs') ? 'bg-black text-white shadow-xl shadow-black/10 translate-x-1' : 'text-[#5f5750] hover:bg-black/[0.03] hover:text-black' }}">
                                <i class="fa-solid fa-shield-halved text-sm {{ request()->routeIs('admin.logs') ? 'text-white' : 'text-[#a89078] group-hover:text-[#7a8a6b]' }}"></i>
                                <span class="text-[14px] font-bold tracking-tight">Security Logs</span>
                            </a>
                            <a href="{{ route('admin.settings') }}" class="group relative flex items-center gap-4 rounded-2xl px-5 py-4 transition-all duration-300 {{ request()->routeIs('admin.settings') ? 'bg-black text-white shadow-xl shadow-black/10 translate-x-1' : 'text-[#5f5750] hover:bg-black/[0.03] hover:text-black' }}">
                                <i class="fa-solid fa-sliders text-sm {{ request()->routeIs('admin.settings') ? 'text-white' : 'text-[#a89078] group-hover:text-[#7a8a6b]' }}"></i>
                                <span class="text-[14px] font-bold tracking-tight">Configuration</span>
                            </a>
                        </div>
                    </div>
                </nav>

                <!-- Actions Footer -->
                <div class="mt-auto space-y-3 pt-10">
                    <a href="/" class="group flex items-center justify-center gap-3 rounded-[24px] bg-white border border-black/[0.03] py-4 text-[11px] font-bold uppercase tracking-widest text-black shadow-sm transition-all hover:bg-black hover:text-white hover:shadow-xl hover:shadow-black/10">
                        <i class="fa-solid fa-globe text-[10px] opacity-70 group-hover:rotate-12 transition-transform"></i>
                        Live Site
                    </a>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex w-full items-center justify-center gap-3 rounded-[24px] py-4 text-[11px] font-bold uppercase tracking-widest text-[#8c4343] transition-all hover:bg-[#8c4343]/[0.03]">
                            <i class="fa-solid fa-power-off text-[10px] opacity-70"></i>
                            Sign out
                        </button>
                    </form>
                </div>

            </div>
        </aside>

        <!-- Main Viewport -->
        <main class="relative flex flex-1 flex-col overflow-hidden">
            <!-- Glass Header -->
            <header class="relative z-20 flex h-28 items-center justify-between px-10 shrink-0 lg:px-14">
                <div class="flex flex-col">
                    <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-[#7a8a6b]">Management Console</p>
                    <h2 class="mt-2 font-[Playfair Display] text-4xl font-bold tracking-tight text-black leading-none">@yield('title', 'Insights')</h2>
                </div>

                <!-- Admin Profile Card -->
                <a href="{{ route('admin.settings') }}" class="group relative flex items-center gap-5 rounded-[28px] border border-black/[0.04] bg-white/50 p-2.5 pr-6 backdrop-blur-2xl transition-all hover:bg-white hover:shadow-2xl hover:shadow-black/5 active:scale-95">
                    <div class="relative">
                        <div class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-[20px] bg-[#fbfaf8] text-lg font-bold text-black shadow-inner ring-1 ring-black/[0.05]">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="absolute -right-0.5 -bottom-0.5 h-3.5 w-3.5 rounded-full border-2 border-white bg-[#7a8a6b]"></span>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-[13px] font-bold text-black leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] font-semibold text-[#a89078] leading-tight">Master Admin</p>
                    </div>
                </a>
            </header>

            <!-- Content Area with Custom Scroll -->
            <div class="flex-1 overflow-y-auto px-10 pb-16 custom-scrollbar lg:px-14">
                <div class="max-w-[1600px] mx-auto animate-in fade-in slide-in-from-bottom-4 duration-700">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { 
            background: rgba(0, 0, 0, 0.04); 
            border-radius: 20px; 
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(0, 0, 0, 0.08); }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
    </style>
</body>
</html>
