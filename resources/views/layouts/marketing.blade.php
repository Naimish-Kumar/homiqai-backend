<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Homiq')</title>
    <meta name="description" content="@yield('meta_description', 'Homiq helps you plan, design, and decorate your home with ease.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[var(--color-cream)] text-[var(--color-charcoal)] antialiased">
    <div class="relative overflow-x-clip">
        <div class="absolute inset-x-0 top-0 -z-10 h-[32rem] bg-[radial-gradient(circle_at_top_left,_rgba(203,187,160,0.35),_transparent_34%),radial-gradient(circle_at_top_right,_rgba(122,138,107,0.16),_transparent_28%),linear-gradient(180deg,_#fbfaf7_0%,_#f7f6f2_58%,_#f2ede6_100%)]"></div>

        <header class="sticky top-0 z-50 border-b border-white/35 bg-[rgba(247,246,242,0.74)] backdrop-blur-xl">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Homiq logo" class="h-11 w-11 rounded-2xl border border-white/60 bg-white/80 object-cover shadow-[0_14px_40px_rgba(47,47,47,0.08)]">
                    <div>
                        <p class="font-[var(--font-display)] text-2xl leading-none">Homiq</p>
                        <p class="text-xs font-medium uppercase tracking-[0.28em] text-[color:rgba(47,47,47,0.55)]">Interior Design App</p>
                    </div>
                </a>

                <nav class="hidden items-center gap-7 text-sm font-medium text-[color:rgba(47,47,47,0.72)] md:flex">
                    <a href="{{ route('about') }}" class="transition hover:text-[var(--color-charcoal)]">About</a>
                    <a href="{{ route('privacy') }}" class="transition hover:text-[var(--color-charcoal)]">Privacy Policy</a>
                    <a href="{{ route('contact') }}" class="transition hover:text-[var(--color-charcoal)]">Contact</a>
                    <a href="{{ route('delete-account') }}" class="transition hover:text-[var(--color-charcoal)]">Delete Account</a>
                </nav>

                <a href="{{ route('home') }}#download" class="hidden rounded-full bg-[var(--color-charcoal)] px-5 py-3 text-sm font-semibold text-white shadow-[0_18px_30px_rgba(47,47,47,0.16)] transition duration-300 hover:scale-[1.02] hover:bg-[var(--color-olive)] md:inline-flex">Download App</a>
            </div>
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="mt-16 border-t border-[rgba(47,47,47,0.08)] bg-[rgba(255,255,255,0.42)]">
            <div class="mx-auto grid max-w-7xl gap-10 px-5 py-10 sm:px-6 lg:grid-cols-[minmax(0,1fr)_auto_auto] lg:px-8">
                <div class="max-w-md">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Homiq logo" class="h-11 w-11 rounded-2xl border border-white/60 bg-white/80 object-cover shadow-[0_14px_36px_rgba(47,47,47,0.08)]">
                        <div>
                            <p class="font-[var(--font-display)] text-2xl leading-none">Homiq</p>
                            <p class="text-xs font-medium uppercase tracking-[0.24em] text-[color:rgba(47,47,47,0.58)]">Interior Design & Room Planner</p>
                        </div>
                    </div>
                    <p class="mt-4 text-sm leading-7 text-[color:rgba(47,47,47,0.66)]">A premium mobile experience for discovering ideas, planning rooms, and creating a home that feels calm, intentional, and beautifully designed.</p>
                </div>

                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-[var(--color-olive)]">Links</p>
                    <div class="mt-4 flex flex-col gap-3 text-sm text-[color:rgba(47,47,47,0.7)]">
                        <a class="transition hover:text-[var(--color-charcoal)]" href="{{ route('about') }}">About</a>
                        <a class="transition hover:text-[var(--color-charcoal)]" href="{{ route('privacy') }}">Privacy Policy</a>
                        <a class="transition hover:text-[var(--color-charcoal)]" href="{{ route('contact') }}">Contact</a>
                        <a class="transition hover:text-[var(--color-charcoal)]" href="{{ route('delete-account') }}">Delete Account</a>
                    </div>
                </div>

                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-[var(--color-olive)]">Store</p>
                    <div class="mt-4 flex flex-col gap-3 text-sm text-[color:rgba(47,47,47,0.7)]">
                        <a href="https://play.google.com/store/apps/details?id=com.homiq.acrocoder" target="_blank" rel="noopener noreferrer" class="transition hover:text-[var(--color-charcoal)]">Google Play</a>
                        <span class="opacity-60">App Store Coming Soon</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
