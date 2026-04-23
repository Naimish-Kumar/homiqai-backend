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
    <link rel="stylesheet" href="{{ asset('css/modern.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[var(--color-cream)] text-[var(--color-charcoal)] antialiased">
    <div class="absolute inset-x-0 top-0 -z-10 h-[30rem] bg-[radial-gradient(circle_at_top_left,_rgba(203,187,160,0.34),_transparent_35%),radial-gradient(circle_at_top_right,_rgba(122,138,107,0.14),_transparent_28%),linear-gradient(180deg,_#fbfaf7_0%,_#f7f6f2_64%,_#f4efe7_100%)]"></div>

    <div class="flex min-h-screen flex-col lg:flex-row">
        <aside class="border-b border-white/45 bg-[rgba(255,255,255,0.52)] px-5 py-6 backdrop-blur-xl lg:min-h-screen lg:w-[290px] lg:border-b-0 lg:border-r lg:px-6 lg:py-8">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Homiq logo" class="h-12 w-12 rounded-2xl border border-white/60 bg-white/85 object-cover shadow-[0_16px_36px_rgba(47,47,47,0.08)]">
                <div>
                    <p class="font-[var(--font-display)] text-2xl leading-none">Homiq</p>
                    <p class="text-xs font-medium uppercase tracking-[0.28em] text-[color:rgba(47,47,47,0.56)]">Admin Studio</p>
                </div>
            </a>

            <nav class="mt-8 space-y-6">
                <div class="space-y-2">
                    <p class="px-3 text-[11px] font-semibold uppercase tracking-[0.28em] text-[var(--color-olive)]">Analytics</p>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-[var(--color-charcoal)] text-white shadow-[0_18px_30px_rgba(47,47,47,0.16)]' : 'text-[color:rgba(47,47,47,0.72)] hover:bg-white/70' }}">
                        <i class="fa-solid fa-chart-pie w-5"></i>
                        <span>Insights</span>
                    </a>
                </div>

                <div class="space-y-2">
                    <p class="px-3 text-[11px] font-semibold uppercase tracking-[0.28em] text-[var(--color-olive)]">Resources</p>
                    <a href="{{ route('admin.users') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.users') ? 'bg-[var(--color-charcoal)] text-white shadow-[0_18px_30px_rgba(47,47,47,0.16)]' : 'text-[color:rgba(47,47,47,0.72)] hover:bg-white/70' }}">
                        <i class="fa-solid fa-user-shield w-5"></i>
                        <span>Users</span>
                    </a>
                    <a href="{{ route('admin.designs') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.designs') ? 'bg-[var(--color-charcoal)] text-white shadow-[0_18px_30px_rgba(47,47,47,0.16)]' : 'text-[color:rgba(47,47,47,0.72)] hover:bg-white/70' }}">
                        <i class="fa-solid fa-wand-magic-sparkles w-5"></i>
                        <span>Gallery</span>
                    </a>
                    <a href="{{ route('admin.styles') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.styles') ? 'bg-[var(--color-charcoal)] text-white shadow-[0_18px_30px_rgba(47,47,47,0.16)]' : 'text-[color:rgba(47,47,47,0.72)] hover:bg-white/70' }}">
                        <i class="fa-solid fa-swatchbook w-5"></i>
                        <span>Library</span>
                    </a>
                </div>

                <div class="space-y-2">
                    <p class="px-3 text-[11px] font-semibold uppercase tracking-[0.28em] text-[var(--color-olive)]">Operations</p>
                    <a href="{{ route('admin.subscriptions') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.subscriptions') ? 'bg-[var(--color-charcoal)] text-white shadow-[0_18px_30px_rgba(47,47,47,0.16)]' : 'text-[color:rgba(47,47,47,0.72)] hover:bg-white/70' }}">
                        <i class="fa-solid fa-gem w-5"></i>
                        <span>Premium</span>
                    </a>
                    <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.settings') ? 'bg-[var(--color-charcoal)] text-white shadow-[0_18px_30px_rgba(47,47,47,0.16)]' : 'text-[color:rgba(47,47,47,0.72)] hover:bg-white/70' }}">
                        <i class="fa-solid fa-sliders w-5"></i>
                        <span>Config</span>
                    </a>
                </div>
            </nav>

            <div class="mt-8 space-y-3 rounded-[28px] border border-white/60 bg-white/62 p-4 shadow-[0_18px_40px_rgba(47,47,47,0.06)] backdrop-blur-xl">
                <a href="{{ route('home') }}" class="inline-flex w-full items-center justify-center rounded-full border border-[rgba(47,47,47,0.10)] bg-white/75 px-4 py-3 text-sm font-semibold text-[var(--color-charcoal)] transition hover:scale-[1.01]">
                    Back to website
                </a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-[var(--color-charcoal)] px-4 py-3 text-sm font-semibold text-white transition hover:scale-[1.01] hover:bg-[var(--color-taupe)]">
                        Sign out
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 px-5 py-6 sm:px-6 lg:px-10 lg:py-8">
            <header class="mb-8 flex flex-col gap-5 rounded-[32px] border border-white/60 bg-white/58 p-6 shadow-[0_20px_55px_rgba(47,47,47,0.06)] backdrop-blur-xl md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[var(--color-olive)]">Homiq Operations</p>
                    <h1 class="mt-3 font-[var(--font-display)] text-4xl leading-tight sm:text-5xl">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-4 rounded-[24px] border border-white/60 bg-[rgba(247,246,242,0.76)] px-4 py-3 shadow-[0_14px_34px_rgba(47,47,47,0.05)]">
                    <div>
                        <p class="text-sm font-semibold text-[var(--color-charcoal)]">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-[color:rgba(47,47,47,0.58)]">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[var(--color-charcoal)] text-sm font-semibold text-white">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            @if (session('status'))
                <div class="mb-6 rounded-[22px] border border-[rgba(122,138,107,0.18)] bg-[rgba(122,138,107,0.10)] px-5 py-4 text-sm font-medium text-[var(--color-charcoal)] shadow-[0_12px_30px_rgba(47,47,47,0.04)]">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
