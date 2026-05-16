@section('content')
<div class="max-w-5xl space-y-12">
    <!-- Identity Header -->
    <header class="rounded-[56px] border border-black/[0.03] bg-white p-12 shadow-2xl shadow-black/[0.03]">
        <div class="flex items-center gap-10">
            <div class="relative group">
                <div class="flex h-32 w-32 items-center justify-center rounded-full bg-black text-4xl font-bold text-white shadow-2xl transition-transform group-hover:scale-105">
                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                </div>
                <div class="absolute -bottom-2 -right-2 h-10 w-10 rounded-full bg-[#7a8a6b] border-4 border-white flex items-center justify-center text-white shadow-lg">
                    <i class="fa-solid fa-shield-halved text-[14px]"></i>
                </div>
            </div>
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-[#7a8a6b]">Authorized Personnel</p>
                <h2 class="mt-3 font-[Playfair Display] text-5xl font-bold text-black italic">{{ $admin->name }}</h2>
                <p class="mt-3 text-[11px] font-bold text-[#a89078] uppercase tracking-[0.2em] opacity-60">System Administrator • Level 0 Access</p>
            </div>
        </div>
    </header>

    <!-- Configuration Panel -->
    <section class="rounded-[56px] border border-black/[0.03] bg-white overflow-hidden shadow-2xl shadow-black/[0.03]">
        <header class="px-12 py-10 bg-[#faf9f6] border-b border-black/[0.03]">
            <h2 class="font-[Playfair Display] text-3xl font-bold text-black italic">Identity Configuration</h2>
            <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Modify administrative credentials and security protocols</p>
        </header>

        <div class="p-12">
            <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-12">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                    <!-- Protocol A: Credentials -->
                    <div class="space-y-10">
                        <div class="flex items-center gap-4">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#faf9f6] border border-black/[0.03] text-[10px] font-bold text-black">01</span>
                            <h3 class="text-[11px] font-bold uppercase tracking-[0.3em] text-[#a89078]">Core Credentials</h3>
                        </div>
                        
                        <div class="space-y-8">
                            <label class="block group">
                                <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Legal Identity</span>
                                <input type="text" name="name" value="{{ old('name', $admin->name) }}" required 
                                    class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                                @error('name') <p class="mt-2 text-[10px] font-bold text-[#8c4343] uppercase tracking-widest">{{ $message }}</p> @enderror
                            </label>

                            <label class="block group">
                                <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Digital Vector</span>
                                <input type="email" name="email" value="{{ old('email', $admin->email) }}" required 
                                    class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                                @error('email') <p class="mt-2 text-[10px] font-bold text-[#8c4343] uppercase tracking-widest">{{ $message }}</p> @enderror
                            </label>
                        </div>
                    </div>

                    <!-- Protocol B: Security -->
                    <div class="space-y-10">
                        <div class="flex items-center gap-4">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#faf9f6] border border-black/[0.03] text-[10px] font-bold text-black">02</span>
                            <h3 class="text-[11px] font-bold uppercase tracking-[0.3em] text-[#a89078]">Security Layer</h3>
                        </div>
                        
                        <div class="space-y-8">
                            <label class="block group">
                                <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">New Passphrase</span>
                                <input type="password" name="password" placeholder="Leave dormant to maintain current" 
                                    class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                                @error('password') <p class="mt-2 text-[10px] font-bold text-[#8c4343] uppercase tracking-widest">{{ $message }}</p> @enderror
                            </label>

                            <label class="block group">
                                <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Verify Layer</span>
                                <input type="password" name="password_confirmation" placeholder="Confirm security string" 
                                    class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                            </label>
                        </div>
                    </div>
                </div>

                <footer class="pt-10 border-t border-black/[0.03] flex justify-end">
                    <button type="submit" class="rounded-[28px] bg-black px-12 py-5 text-[11px] font-bold uppercase tracking-[0.2em] text-white shadow-2xl transition-all hover:scale-105 active:scale-95">
                        Commit Identity Updates
                    </button>
                </footer>
            </form>
        </div>
    </section>

    <!-- Status Manifest -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-10">
        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Initiation</p>
            <p class="mt-4 font-[Playfair Display] text-3xl font-bold text-black italic">{{ $admin->created_at->format('M Y') }}</p>
            <p class="mt-2 text-[10px] font-bold text-[#a89078] uppercase tracking-widest opacity-60">Entry Date</p>
        </article>

        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Activity</p>
            <p class="mt-4 font-[Playfair Display] text-3xl font-bold text-black italic">{{ now()->format('D, j M') }}</p>
            <p class="mt-2 text-[10px] font-bold text-[#a89078] uppercase tracking-widest opacity-60">Last Transmission</p>
        </article>

        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Privilege</p>
            <p class="mt-4 font-[Playfair Display] text-3xl font-bold text-black italic">Superuser</p>
            <p class="mt-2 text-[10px] font-bold text-[#a89078] uppercase tracking-widest opacity-60">Master Directive</p>
        </article>
    </section>
</div>
@endsection

