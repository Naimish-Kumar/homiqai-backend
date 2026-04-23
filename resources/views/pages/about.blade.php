@extends('layouts.marketing')

@section('title', 'About Homiq')
@section('meta_description', 'Learn about Homiq, the interior design and room planner app built to make home design feel calm, modern, and accessible.')

@section('content')
<section class="mx-auto max-w-7xl px-5 py-16 sm:px-6 lg:px-8 lg:py-24">
    <div class="max-w-3xl">
        <p class="text-sm font-semibold uppercase tracking-[0.28em] text-[var(--color-olive)]">About Us</p>
        <h1 class="mt-4 font-[var(--font-display)] text-5xl leading-tight sm:text-6xl">A more thoughtful way to design the spaces you live in.</h1>
        <p class="mt-6 text-lg leading-8 text-[color:rgba(47,47,47,0.7)]">Homiq was created for people who want a home that feels beautiful, personal, and well planned without needing complex design software.</p>
    </div>

    <div class="mt-14 grid gap-6 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)]">
        <article class="rounded-[32px] border border-white/60 bg-white/72 p-8 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
            <h2 class="font-[var(--font-display)] text-3xl">What Homiq Does</h2>
            <p class="mt-5 text-sm leading-8 text-[color:rgba(47,47,47,0.68)]">Homiq helps users discover design inspiration, plan rooms in 2D and 3D, organize saved ideas, and move from concept to decision with more confidence. Our goal is to make interior design feel approachable while still delivering a premium, elegant experience.</p>
            <p class="mt-5 text-sm leading-8 text-[color:rgba(47,47,47,0.68)]">We focus on calm visual planning, curated inspiration, and practical tools that help homeowners, renters, and design enthusiasts create spaces that feel intentional and lived-in.</p>
        </article>

        <div class="space-y-6">
            <article class="rounded-[32px] border border-white/60 bg-white/72 p-8 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
                <h2 class="font-[var(--font-display)] text-3xl">Our Mission</h2>
                <p class="mt-5 text-sm leading-8 text-[color:rgba(47,47,47,0.68)]">To make home design simpler, more inspiring, and more useful for everyday people.</p>
            </article>

            <article class="rounded-[32px] border border-white/60 bg-white/72 p-8 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
                <h2 class="font-[var(--font-display)] text-3xl">Why It Matters</h2>
                <p class="mt-5 text-sm leading-8 text-[color:rgba(47,47,47,0.68)]">A well-designed space shapes how we rest, work, and feel at home. Homiq exists to make that process smoother and more joyful.</p>
            </article>
        </div>
    </div>
</section>
@endsection
