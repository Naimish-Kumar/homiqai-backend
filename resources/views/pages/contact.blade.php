@extends('layouts.marketing')

@section('title', 'Contact Homiq')
@section('meta_description', 'Contact the Homiq team for support, privacy questions, or account help.')

@section('content')
<section class="mx-auto max-w-7xl px-5 py-16 sm:px-6 lg:px-8 lg:py-24">
    <div class="max-w-3xl">
        <p class="text-sm font-semibold uppercase tracking-[0.28em] text-[var(--color-olive)]">Contact</p>
        <h1 class="mt-4 font-[var(--font-display)] text-5xl leading-tight sm:text-6xl">We’re here to help with support, privacy, and account questions.</h1>
        <p class="mt-6 text-lg leading-8 text-[color:rgba(47,47,47,0.7)]">If you need help with the app, account access, subscriptions, or deletion requests, use the contact details below.</p>
    </div>

    <div class="mt-14 grid gap-6 lg:grid-cols-3">
        <article class="rounded-[32px] border border-white/60 bg-white/72 p-8 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
            <h2 class="font-[var(--font-display)] text-3xl">Support Email</h2>
            <p class="mt-5 text-sm leading-8 text-[color:rgba(47,47,47,0.68)]">support@homiq.app</p>
        </article>

        <article class="rounded-[32px] border border-white/60 bg-white/72 p-8 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
            <h2 class="font-[var(--font-display)] text-3xl">Privacy Requests</h2>
            <p class="mt-5 text-sm leading-8 text-[color:rgba(47,47,47,0.68)]">privacy@homiq.app</p>
        </article>

        <article class="rounded-[32px] border border-white/60 bg-white/72 p-8 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
            <h2 class="font-[var(--font-display)] text-3xl">Delete Account</h2>
            <p class="mt-5 text-sm leading-8 text-[color:rgba(47,47,47,0.68)]">Use the dedicated <a href="{{ route('delete-account') }}" class="font-semibold text-[var(--color-charcoal)] underline decoration-[rgba(47,47,47,0.2)] underline-offset-4">Delete Account</a> page for self-service removal.</p>
        </article>
    </div>
</section>
@endsection
