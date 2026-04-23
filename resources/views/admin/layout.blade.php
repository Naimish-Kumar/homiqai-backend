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
<body class="min-h-screen bg-[#f5f1ea] font-[Poppins] text-[#1f1f1f] antialiased">
    <div class="fixed inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,_rgba(203,187,160,0.28),_transparent_28%),radial-gradient(circle_at_top_right,_rgba(122,138,107,0.16),_transparent_24%),linear-gradient(180deg,_#fbfaf8_0%,_#f5f1ea_55%,_#efe7dd_100%)]"></div>

    <div class="min-h-screen lg:grid lg:grid-cols-[290px_minmax(0,1fr)]">
        <aside class="border-b border-black/8 bg-[#171717] px-5 py-6 text-white lg:min-h-screen lg:border-b-0 lg:border-r lg:border-white/8 lg:px-6 lg:py-8">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Homiq logo" class="h-12 w-12 rounded-2xl border border-white/10 bg-white/90 object-cover shadow-[0_16px_32px_rgba(0,0,0,0.25)]">
                <div>
                    <p class="font-[Playfair Display] text-2xl leading-none text-white">Homiq</p>
                    <p class="mt-1 text-[11px] font-semibold uppercase tracking-[0.28em] text-[#d8cab4]">Admin Studio</p>
                </div>
            </a>

            <nav class="mt-8 space-y-6">
                <div class="space-y-2">
                    <p class="px-3 text-[11px] font-semibold uppercase tracking-[0.28em] text-[#bba884]">Analytics</p>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-white text-[#1f1f1f] shadow-[0_18px_32px_rgba(0,0,0,0.22)]' : 'text-white/74 hover:bg-white/8 hover:text-white' }}">
                        <i class="fa-solid fa-chart-pie w-5"></i>
                        <span>Insights</span>
                    </a>
                </div>

                <div class="space-y-2">
                    <p class="px-3 text-[11px] font-semibold uppercase tracking-[0.28em] text-[#bba884]">Resources</p>
                    <a href="{{ route('admin.users') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.users') ? 'bg-white text-[#1f1f1f] shadow-[0_18px_32px_rgba(0,0,0,0.22)]' : 'text-white/74 hover:bg-white/8 hover:text-white' }}">
                        <i class="fa-solid fa-user-shield w-5"></i>
                        <span>Users</span>
                    </a>
                    <a href="{{ route('admin.designs') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.designs') ? 'bg-white text-[#1f1f1f] shadow-[0_18px_32px_rgba(0,0,0,0.22)]' : 'text-white/74 hover:bg-white/8 hover:text-white' }}">
                        <i class="fa-solid fa-wand-magic-sparkles w-5"></i>
                        <span>Gallery</span>
                    </a>
                    <a href="{{ route('admin.styles') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.styles') ? 'bg-white text-[#1f1f1f] shadow-[0_18px_32px_rgba(0,0,0,0.22)]' : 'text-white/74 hover:bg-white/8 hover:text-white' }}">
                        <i class="fa-solid fa-swatchbook w-5"></i>
                        <span>Library</span>
                    </a>
                    <a href="{{ route('admin.furniture') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.furniture*') ? 'bg-white text-[#1f1f1f] shadow-[0_18px_32px_rgba(0,0,0,0.22)]' : 'text-white/74 hover:bg-white/8 hover:text-white' }}">
                        <i class="fa-solid fa-couch w-5"></i>
                        <span>Furniture</span>
                    </a>
                    <a href="{{ route('admin.storage') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.storage') ? 'bg-white text-[#1f1f1f] shadow-[0_18px_32px_rgba(0,0,0,0.22)]' : 'text-white/74 hover:bg-white/8 hover:text-white' }}">
                        <i class="fa-solid fa-hard-drive w-5"></i>
                        <span>Storage</span>
                    </a>
                </div>

                <div class="space-y-2">
                    <p class="px-3 text-[11px] font-semibold uppercase tracking-[0.28em] text-[#bba884]">Operations</p>
                    <a href="{{ route('admin.subscriptions') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.subscriptions') ? 'bg-white text-[#1f1f1f] shadow-[0_18px_32px_rgba(0,0,0,0.22)]' : 'text-white/74 hover:bg-white/8 hover:text-white' }}">
                        <i class="fa-solid fa-gem w-5"></i>
                        <span>Premium</span>
                    </a>
                    <a href="{{ route('admin.feedback') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.feedback') ? 'bg-white text-[#1f1f1f] shadow-[0_18px_32px_rgba(0,0,0,0.22)]' : 'text-white/74 hover:bg-white/8 hover:text-white' }}">
                        <i class="fa-solid fa-comment-dots w-5"></i>
                        <span>Feedback</span>
                    </a>
                    <a href="{{ route('admin.notifications') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.notifications') ? 'bg-white text-[#1f1f1f] shadow-[0_18px_32px_rgba(0,0,0,0.22)]' : 'text-white/74 hover:bg-white/8 hover:text-white' }}">
                        <i class="fa-solid fa-bell w-5"></i>
                        <span>Campaigns</span>
                    </a>
                    <a href="{{ route('admin.logs') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.logs') ? 'bg-white text-[#1f1f1f] shadow-[0_18px_32px_rgba(0,0,0,0.22)]' : 'text-white/74 hover:bg-white/8 hover:text-white' }}">
                        <i class="fa-solid fa-list-check w-5"></i>
                        <span>System Logs</span>
                    </a>
                    <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.settings') ? 'bg-white text-[#1f1f1f] shadow-[0_18px_32px_rgba(0,0,0,0.22)]' : 'text-white/74 hover:bg-white/8 hover:text-white' }}">
                        <i class="fa-solid fa-sliders w-5"></i>
                        <span>Config</span>
                    </a>
                    <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.profile') ? 'bg-white text-[#1f1f1f] shadow-[0_18px_32px_rgba(0,0,0,0.22)]' : 'text-white/74 hover:bg-white/8 hover:text-white' }}">
                        <i class="fa-solid fa-user-gear w-5"></i>
                        <span>My Profile</span>
                    </a>
                </div>
            </nav>

            <div class="mt-8 rounded-[28px] border border-white/10 bg-white/6 p-4">
                <a href="{{ route('home') }}" class="inline-flex w-full items-center justify-center rounded-full border border-white/12 bg-white/10 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/16">
                    Back to website
                </a>
                <form action="{{ route('admin.logout') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-[#d8cab4] px-4 py-3 text-sm font-semibold text-[#1f1f1f] transition hover:bg-[#cbbba0]">
                        Sign out
                    </button>
                </form>
            </div>
        </aside>

        <main class="px-5 py-6 sm:px-6 lg:px-10 lg:py-8">
            <header class="mb-8 rounded-[34px] border border-black/6 bg-white px-6 py-6 shadow-[0_22px_60px_rgba(31,31,31,0.08)] lg:px-8">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#7a8a6b]">Homiq Operations</p>
                        <h1 class="mt-3 font-[Playfair Display] text-4xl leading-tight text-[#171717] sm:text-5xl">@yield('title', 'Dashboard')</h1>
                    </div>
                    <a href="{{ route('admin.profile') }}" class="flex items-center gap-4 rounded-[24px] border border-black/6 bg-[#f8f5ef] px-4 py-3 hover:border-black/20 transition group">
                        <div>
                            <p class="text-sm font-semibold text-[#171717] group-hover:text-black">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-[#5f5a52]">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#171717] text-sm font-semibold text-white shadow-md group-hover:scale-105 transition">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </a>
                </div>
            </header>

            @if (session('status'))
                <div class="mb-6 rounded-[24px] border border-[#d6dfcf] bg-[#eef3ea] px-5 py-4 text-sm font-medium text-[#243020] shadow-[0_12px_30px_rgba(31,31,31,0.04)]">
                    {{ session('status') }}
                </div>
            @endif

            <div class="admin-pagination">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
