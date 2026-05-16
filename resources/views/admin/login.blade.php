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
<body class="min-h-screen selection:bg-[#cbbba0]/30 font-[Poppins] text-[#171717] antialiased overflow-hidden">
    <!-- Sophisticated Background System -->
    <div class="fixed inset-0 -z-20 bg-[#faf9f6]"></div>
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] h-[50%] w-[50%] rounded-full bg-[#f1ece4] blur-[120px] opacity-40 animate-pulse" style="animation-duration: 8s"></div>
        <div class="absolute top-[20%] -right-[5%] h-[40%] w-[40%] rounded-full bg-[#eef3ea] blur-[100px] opacity-30 animate-pulse" style="animation-duration: 10s"></div>
        <div class="absolute bottom-[10%] left-[20%] h-[35%] w-[35%] rounded-full bg-[#f7f2ed] blur-[80px] opacity-40 animate-pulse" style="animation-duration: 12s"></div>
    </div>

    <main class="relative z-10 mx-auto flex min-h-screen max-w-7xl items-center justify-center px-6 py-12">
        <div class="grid w-full gap-16 lg:grid-cols-2 lg:items-center">
            <!-- Brand & Narrative -->
            <section class="hidden lg:block space-y-12">
                <div class="flex items-center gap-6">
                    <div class="flex h-16 w-16 items-center justify-center rounded-[24px] bg-black shadow-2xl shadow-black/20">
                        <i class="fa-solid fa-h text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="font-[Playfair Display] text-4xl font-bold tracking-tight text-black italic">Homiq</h1>
                        <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-[#7a8a6b] mt-1">Admin Studio</p>
                    </div>
                </div>

                <div class="space-y-8">
                    <h2 class="font-[Playfair Display] text-6xl font-bold leading-[1.1] text-black italic">
                        Commanding the <span class="text-[#a89078] not-italic">Future of Interior AI.</span>
                    </h2>
                    <p class="max-w-lg text-[16px] leading-relaxed font-medium text-[#5f5750]/80">
                        Experience total oversight of the Homiq ecosystem. Manage spatial transformations, audit community growth, and steer the trajectory of our generative design engine from a single, high-fidelity workspace.
                    </p>
                </div>

                <div class="flex gap-12">
                    <div class="space-y-2">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#a89078]">Status</p>
                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-[#7a8a6b] animate-pulse"></span>
                            <p class="text-[13px] font-bold text-black">Systems Operational</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#a89078]">Security</p>
                        <p class="text-[13px] font-bold text-black">End-to-End Encrypted</p>
                    </div>
                </div>
            </section>

            <!-- Authentication Interface -->
            <section class="mx-auto w-full max-w-[500px]">
                <div class="rounded-[56px] border border-black/[0.03] bg-white p-12 shadow-2xl shadow-black/[0.03]">
                    <div class="mb-10 lg:hidden flex flex-col items-center text-center">
                         <div class="h-16 w-16 mb-6 flex items-center justify-center rounded-[24px] bg-black shadow-xl">
                            <i class="fa-solid fa-h text-2xl text-white"></i>
                        </div>
                        <h1 class="font-[Playfair Display] text-3xl font-bold text-black italic">Homiq Admin</h1>
                    </div>

                    <header class="mb-10">
                        <h3 class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b] mb-3">Identity Verification</h3>
                        <h2 class="font-[Playfair Display] text-4xl font-bold text-black italic">Welcome Back.</h2>
                    </header>

                    <form action="{{ route('admin.login.store') }}" method="POST" class="space-y-8">
                        @csrf
                        <div class="space-y-6">
                            <label class="block group">
                                <span class="mb-3 block text-[10px] font-bold uppercase tracking-widest text-[#a89078] group-focus-within:text-black transition-colors">Admin Identifier</span>
                                <div class="relative">
                                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@homiq.ai" class="w-full rounded-[24px] border border-black/[0.04] bg-[#faf9f6] px-6 py-5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                                    <i class="fa-solid fa-envelope absolute right-6 top-1/2 -translate-y-1/2 text-[#a89078] text-[12px] opacity-40"></i>
                                </div>
                            </label>

                            <label class="block group">
                                <span class="mb-3 block text-[10px] font-bold uppercase tracking-widest text-[#a89078] group-focus-within:text-black transition-colors">Security Protocol</span>
                                <div class="relative">
                                    <input type="password" name="password" required placeholder="••••••••" class="w-full rounded-[24px] border border-black/[0.04] bg-[#faf9f6] px-6 py-5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                                    <i class="fa-solid fa-lock absolute right-6 top-1/2 -translate-y-1/2 text-[#a89078] text-[12px] opacity-40"></i>
                                </div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="remember" value="1" class="h-5 w-5 rounded-lg border-black/[0.05] bg-[#faf9f6] text-black focus:ring-offset-0 focus:ring-0 transition-all cursor-pointer">
                                <span class="text-[11px] font-bold uppercase tracking-widest text-[#a89078] group-hover:text-black transition-colors">Persistent Session</span>
                            </label>
                        </div>

                        @if ($errors->any())
                            <div class="rounded-3xl bg-[#8c4343]/[0.03] border border-[#8c4343]/10 px-6 py-4">
                                <p class="text-[11px] font-bold text-[#8c4343] uppercase tracking-widest leading-relaxed">
                                    <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                                    {{ $errors->first() }}
                                </p>
                            </div>
                        @endif

                        <button type="submit" class="group relative w-full overflow-hidden rounded-[28px] bg-black py-6 text-[11px] font-bold uppercase tracking-[0.3em] text-white shadow-2xl shadow-black/20 transition-all hover:scale-[1.02] active:scale-95">
                            <span class="relative z-10 flex items-center justify-center gap-3">
                                Initialize Secure Access
                                <i class="fa-solid fa-arrow-right text-[9px] group-hover:translate-x-2 transition-transform"></i>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-tr from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </button>
                    </form>

                    <footer class="mt-12 text-center">
                        <a href="{{ route('home') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#a89078] hover:text-black transition-colors flex items-center justify-center gap-2">
                            <i class="fa-solid fa-arrow-left text-[8px]"></i>
                            Return to Public Domain
                        </a>
                    </footer>
                </div>
            </section>
        </div>
    </main>
</body>

</html>
