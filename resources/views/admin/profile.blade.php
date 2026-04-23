@extends('admin.layout')

@section('title', 'Admin Profile')

@section('content')
<div class="max-w-4xl">
    <div class="rounded-[34px] border border-black/6 bg-white overflow-hidden shadow-[0_22px_60px_rgba(31,31,31,0.06)]">
        <div class="px-8 py-8 border-b border-black/5 bg-[#fbfaf8]">
            <div class="flex items-center gap-6">
                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-[#171717] text-2xl font-bold text-white shadow-xl">
                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="font-[Playfair Display] text-3xl text-[#171717]">{{ $admin->name }}</h2>
                    <p class="text-[#7a8a6b] font-medium text-sm">System Administrator</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-8">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Basic Info -->
                    <div class="space-y-6">
                        <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-[#bba884]">Basic Information</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-[#7a8a6b] mb-2">Display Name</label>
                                <input type="text" name="name" value="{{ old('name', $admin->name) }}" required 
                                    class="w-full rounded-2xl border-black/10 px-4 py-3 text-sm focus:border-[#7a8a6b] focus:ring-[#7a8a6b] bg-[#fbfaf8]">
                                @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-[#7a8a6b] mb-2">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $admin->email) }}" required 
                                    class="w-full rounded-2xl border-black/10 px-4 py-3 text-sm focus:border-[#7a8a6b] focus:ring-[#7a8a6b] bg-[#fbfaf8]">
                                @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Security -->
                    <div class="space-y-6">
                        <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-[#bba884]">Security & Password</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-[#7a8a6b] mb-2">New Password (Optional)</label>
                                <input type="password" name="password" placeholder="Leave blank to keep current" 
                                    class="w-full rounded-2xl border-black/10 px-4 py-3 text-sm focus:border-[#7a8a6b] focus:ring-[#7a8a6b] bg-[#fbfaf8]">
                                @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-[#7a8a6b] mb-2">Confirm Password</label>
                                <input type="password" name="password_confirmation" placeholder="Confirm new password" 
                                    class="w-full rounded-2xl border-black/10 px-4 py-3 text-sm focus:border-[#7a8a6b] focus:ring-[#7a8a6b] bg-[#fbfaf8]">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-black/5 flex justify-end">
                    <button type="submit" class="rounded-full bg-[#171717] px-10 py-4 text-sm font-bold text-white shadow-lg hover:bg-black transition-all hover:scale-[1.02] active:scale-[0.98]">
                        Update Profile Details
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats or Info -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="rounded-3xl border border-black/5 bg-white p-6 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-widest text-[#7a8a6b]">Member Since</p>
            <p class="mt-2 text-lg font-bold text-[#171717]">{{ $admin->created_at->format('M Y') }}</p>
        </div>
        <div class="rounded-3xl border border-black/5 bg-white p-6 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-widest text-[#7a8a6b]">Last Login</p>
            <p class="mt-2 text-lg font-bold text-[#171717]">{{ now()->format('D, j M') }}</p>
        </div>
        <div class="rounded-3xl border border-black/5 bg-white p-6 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-widest text-[#7a8a6b]">Admin Role</p>
            <p class="mt-2 text-lg font-bold text-[#171717]">Superuser</p>
        </div>
    </div>
</div>
@endsection
