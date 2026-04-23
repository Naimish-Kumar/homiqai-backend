@extends('layouts.marketing')

@section('title', 'Privacy Policy | Homiq')
@section('meta_description', 'Read the Homiq privacy policy and learn how we handle account information, uploaded room images, and app usage data.')

@section('content')
<section class="mx-auto max-w-5xl px-5 py-16 sm:px-6 lg:px-8 lg:py-24">
    <div class="max-w-3xl">
        <p class="text-sm font-semibold uppercase tracking-[0.28em] text-[var(--color-olive)]">Privacy Policy</p>
        <h1 class="mt-4 font-[var(--font-display)] text-5xl leading-tight sm:text-6xl">Your data should be handled with clarity and care.</h1>
        <p class="mt-6 text-lg leading-8 text-[color:rgba(47,47,47,0.7)]">This page explains the types of information Homiq may collect and how that information is used to provide the app experience.</p>
    </div>

    <div class="mt-14 space-y-6">
        <article class="rounded-[32px] border border-white/60 bg-white/72 p-8 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
            <h2 class="font-[var(--font-display)] text-3xl">Information We May Collect</h2>
            <p class="mt-5 text-sm leading-8 text-[color:rgba(47,47,47,0.68)]">Homiq may collect account details such as your name, email address, and login credentials, along with room images, design preferences, saved ideas, and subscription-related information needed to operate the app.</p>
        </article>

        <article class="rounded-[32px] border border-white/60 bg-white/72 p-8 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
            <h2 class="font-[var(--font-display)] text-3xl">How We Use Information</h2>
            <p class="mt-5 text-sm leading-8 text-[color:rgba(47,47,47,0.68)]">We use this information to create and manage your account, process room designs, improve app features, support subscriptions, respond to support requests, and keep the service secure and reliable.</p>
        </article>

        <article class="rounded-[32px] border border-white/60 bg-white/72 p-8 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
            <h2 class="font-[var(--font-display)] text-3xl">Account Deletion</h2>
            <p class="mt-5 text-sm leading-8 text-[color:rgba(47,47,47,0.68)]">You can request deletion of your Homiq account from the <a href="{{ route('delete-account') }}" class="font-semibold text-[var(--color-charcoal)] underline decoration-[rgba(47,47,47,0.2)] underline-offset-4">Delete Account</a> page. When deletion is completed, associated design records and related stored data tied to the account are removed from the platform.</p>
        </article>

        <article class="rounded-[32px] border border-white/60 bg-white/72 p-8 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
            <h2 class="font-[var(--font-display)] text-3xl">Contact</h2>
            <p class="mt-5 text-sm leading-8 text-[color:rgba(47,47,47,0.68)]">If you have questions about privacy, account access, or data deletion, please contact us through the <a href="{{ route('contact') }}" class="font-semibold text-[var(--color-charcoal)] underline decoration-[rgba(47,47,47,0.2)] underline-offset-4">Contact</a> page.</p>
        </article>
    </div>
</section>
@endsection
