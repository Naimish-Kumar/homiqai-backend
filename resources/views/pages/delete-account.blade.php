@extends('layouts.marketing')

@section('title', 'Delete Homiq Account')
@section('meta_description', 'Delete your Homiq account and associated data from the website.')

@section('content')
<section class="mx-auto max-w-7xl px-5 py-16 sm:px-6 lg:px-8 lg:py-24">
    <div class="max-w-3xl">
        <p class="text-sm font-semibold uppercase tracking-[0.28em] text-[var(--color-olive)]">Delete Account</p>
        <h1 class="mt-4 font-[var(--font-display)] text-5xl leading-tight sm:text-6xl">Remove your Homiq account and related design data.</h1>
        <p class="mt-6 text-lg leading-8 text-[color:rgba(47,47,47,0.7)]">Use this page if you want to permanently delete your Homiq account. This action removes the account and associated room design data and cannot be undone.</p>
    </div>

    <div class="mt-14 grid gap-6 lg:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)]">
        <article class="rounded-[32px] border border-white/60 bg-white/72 p-8 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
            <h2 class="font-[var(--font-display)] text-3xl">Before You Continue</h2>
            <div class="mt-5 space-y-4 text-sm leading-8 text-[color:rgba(47,47,47,0.68)]">
                <p>Your account will be permanently removed.</p>
                <p>Saved room designs and related records linked to your account will also be deleted.</p>
                <p>If you signed up with a social login and do not have a password, contact support for manual help.</p>
            </div>
        </article>

        <section class="rounded-[32px] border border-white/60 bg-white/72 p-8 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
            @if (session('status'))
                <div class="mb-6 rounded-[22px] border border-[rgba(122,138,107,0.18)] bg-[rgba(122,138,107,0.10)] px-5 py-4 text-sm font-medium text-[var(--color-charcoal)]">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-[22px] border border-[rgba(159,86,86,0.18)] bg-[rgba(159,86,86,0.08)] px-5 py-4 text-sm font-medium text-[#8c4343]">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('delete-account.destroy') }}" method="POST" class="space-y-5">
                @csrf
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-[var(--color-charcoal)]">Email address</span>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-[18px] border border-[rgba(47,47,47,0.10)] bg-[rgba(247,246,242,0.84)] px-4 py-4 text-sm outline-none">
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-[var(--color-charcoal)]">Password</span>
                    <input type="password" name="password" required class="w-full rounded-[18px] border border-[rgba(47,47,47,0.10)] bg-[rgba(247,246,242,0.84)] px-4 py-4 text-sm outline-none">
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-[var(--color-charcoal)]">Type DELETE to confirm</span>
                    <input type="text" name="confirmation" value="{{ old('confirmation') }}" required class="w-full rounded-[18px] border border-[rgba(47,47,47,0.10)] bg-[rgba(247,246,242,0.84)] px-4 py-4 text-sm uppercase outline-none">
                </label>

                <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-[var(--color-charcoal)] px-6 py-4 text-sm font-semibold text-white transition hover:bg-[var(--color-taupe)]">
                    Permanently Delete Account
                </button>
            </form>
        </section>
    </div>
</section>
@endsection
