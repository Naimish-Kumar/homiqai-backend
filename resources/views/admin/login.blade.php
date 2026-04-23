<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Homiq</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f5f1ea] font-[Poppins] text-[#171717] antialiased">
    <div class="fixed inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,_rgba(203,187,160,0.30),_transparent_28%),radial-gradient(circle_at_bottom_right,_rgba(122,138,107,0.12),_transparent_24%),linear-gradient(180deg,_#fbfaf8_0%,_#f5f1ea_55%,_#eee4d8_100%)]"></div>

    <main class="mx-auto grid min-h-screen max-w-7xl items-center gap-8 px-5 py-8 sm:px-6 lg:grid-cols-[minmax(0,1.08fr)_minmax(360px,0.92fr)] lg:px-8">
        <section class="relative overflow-hidden rounded-[40px] bg-[#171717] p-6 text-white shadow-[0_35px_100px_rgba(0,0,0,0.22)] sm:p-8 lg:p-10">
            <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(23,23,23,0.18),rgba(23,23,23,0.78))]"></div>
            <img src="{{ asset('images/hero.png') }}" alt="Modern Homiq interior" class="absolute inset-0 h-full w-full object-cover opacity-45">

            <div class="relative z-10 flex h-full flex-col justify-between gap-10">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Homiq logo" class="h-14 w-14 rounded-2xl border border-white/10 bg-white/90 object-cover">
                    <div>
                        <p class="font-[Playfair Display] text-3xl leading-none text-white">Homiq</p>
                        <p class="mt-1 text-xs font-semibold uppercase tracking-[0.28em] text-[#d8cab4]">Admin Studio</p>
                    </div>
                </div>

                <div class="max-w-xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#d8cab4]">Secure admin access</p>
                    <h1 class="mt-5 font-[Playfair Display] text-5xl leading-[1.02] text-white sm:text-6xl">Manage Homiq with clarity, control, and better visibility.</h1>
                    <p class="mt-6 max-w-lg text-base leading-8 text-white/78">Monitor users, room transformations, subscriptions, and system settings from a focused workspace designed to feel premium and easy on the eyes.</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-[24px] border border-white/10 bg-white/8 p-5">
                        <p class="text-xs uppercase tracking-[0.2em] text-[#d8cab4]">Users</p>
                        <p class="mt-2 text-2xl font-semibold text-white">People</p>
                    </div>
                    <div class="rounded-[24px] border border-white/10 bg-white/8 p-5">
                        <p class="text-xs uppercase tracking-[0.2em] text-[#d8cab4]">Designs</p>
                        <p class="mt-2 text-2xl font-semibold text-white">Gallery</p>
                    </div>
                    <div class="rounded-[24px] border border-white/10 bg-white/8 p-5">
                        <p class="text-xs uppercase tracking-[0.2em] text-[#d8cab4]">Revenue</p>
                        <p class="mt-2 text-2xl font-semibold text-white">Premium</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-[36px] border border-black/6 bg-white p-6 shadow-[0_28px_80px_rgba(31,31,31,0.10)] sm:p-8">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.26em] text-[#7a8a6b]">Admin Sign In</p>
                    <h2 class="mt-3 font-[Playfair Display] text-4xl leading-tight text-[#171717]">Welcome back</h2>
                </div>
                <a href="{{ route('home') }}" class="rounded-full border border-black/8 bg-[#faf7f2] px-4 py-2 text-sm font-semibold text-[#171717] transition hover:bg-[#f0e8dc]">
                    Back
                </a>
            </div>

            <p class="mt-4 text-sm leading-7 text-[#5f5a52]">Only approved administrators can access the Homiq control panel.</p>

            <form action="{{ route('admin.login.store') }}" method="POST" class="mt-8 space-y-5">
                @csrf

                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-[#171717]">Email address</span>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full rounded-[18px] border border-black/10 bg-[#faf7f2] px-4 py-4 text-sm text-[#171717] outline-none transition focus:border-[#a89078] focus:bg-white">
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-[#171717]">Password</span>
                    <input type="password" name="password" required class="w-full rounded-[18px] border border-black/10 bg-[#faf7f2] px-4 py-4 text-sm text-[#171717] outline-none transition focus:border-[#a89078] focus:bg-white">
                </label>

                <label class="flex items-center gap-3 text-sm text-[#4f4a43]">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-black/20 text-[#171717] focus:ring-[#a89078]">
                    <span>Keep me signed in</span>
                </label>

                @if ($errors->any())
                    <div class="rounded-[20px] border border-[#ebd0d0] bg-[#fbefef] px-4 py-3 text-sm font-medium text-[#8c4343]">
                        {{ $errors->first() }}
                    </div>
                @endif

                <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-[#171717] px-6 py-4 text-sm font-semibold text-white transition hover:bg-[#2a2a2a]">
                    Sign in securely
                </button>
            </form>
        </section>
    </main>
</body>
</html>
