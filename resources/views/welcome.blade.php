<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homiq – Interior Design & Room Planner</title>
    <meta
        name="description"
        content="Plan, design, and decorate your home with ease using Homiq. Explore ideas, visualize rooms, and build your dream space."
    >
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[var(--color-cream)] text-[var(--color-charcoal)] antialiased">
    <div class="page-shell relative overflow-x-clip">
        <div class="absolute inset-x-0 top-0 -z-10 h-[42rem] bg-[radial-gradient(circle_at_top_left,_rgba(203,187,160,0.38),_transparent_38%),radial-gradient(circle_at_top_right,_rgba(122,138,107,0.16),_transparent_30%),linear-gradient(180deg,_#fbfaf7_0%,_#f7f6f2_58%,_#f4f0ea_100%)]"></div>

        <header class="sticky top-0 z-50 border-b border-white/35 bg-[rgba(247,246,242,0.72)] backdrop-blur-xl">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 sm:px-6 lg:px-8">
                <a href="#top" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Homiq logo" class="h-11 w-11 rounded-2xl border border-white/60 object-cover shadow-[0_14px_40px_rgba(47,47,47,0.08)]">
                    <div>
                        <p class="font-[var(--font-display)] text-2xl leading-none tracking-[0.02em]">Homiq</p>
                        <p class="text-xs font-medium uppercase tracking-[0.28em] text-[color:rgba(47,47,47,0.55)]">Interior Design App</p>
                    </div>
                </a>

                <nav class="hidden items-center gap-8 text-sm font-medium text-[color:rgba(47,47,47,0.7)] md:flex">
                    <a class="transition hover:text-[var(--color-charcoal)]" href="#features">Features</a>
                    <a class="transition hover:text-[var(--color-charcoal)]" href="#screens">Screens</a>
                    <a class="transition hover:text-[var(--color-charcoal)]" href="#how-it-works">How It Works</a>
                    <a class="transition hover:text-[var(--color-charcoal)]" href="#reviews">Reviews</a>
                </nav>

                <a href="#download" class="hidden rounded-full bg-[var(--color-charcoal)] px-5 py-3 text-sm font-semibold text-white shadow-[0_18px_30px_rgba(47,47,47,0.16)] transition duration-300 hover:scale-[1.02] hover:bg-[var(--color-olive)] md:inline-flex">Download App</a>
            </div>
        </header>

        <main id="top">
            <section class="mx-auto grid max-w-7xl gap-14 px-5 pb-20 pt-10 sm:px-6 md:pt-16 lg:grid-cols-[minmax(0,1.05fr)_minmax(0,0.95fr)] lg:items-center lg:gap-20 lg:px-8 lg:pb-28">
                <div class="reveal space-y-8">
                    <div class="inline-flex items-center gap-2 rounded-full border border-white/60 bg-white/60 px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-[var(--color-olive)] shadow-[0_12px_24px_rgba(47,47,47,0.05)] backdrop-blur-md">
                        Elegant planning for modern homes
                    </div>

                    <div class="space-y-6">
                        <h1 class="max-w-2xl font-[var(--font-display)] text-5xl leading-[0.98] text-[var(--color-charcoal)] sm:text-6xl lg:text-7xl">
                            Design Your Dream Space
                        </h1>
                        <p class="max-w-xl text-base leading-8 text-[color:rgba(47,47,47,0.72)] sm:text-lg">
                            Plan, design, and decorate your home with ease using Homiq. Discover inspiration, visualize layouts, and turn every room into a calm, beautiful space you love.
                        </p>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row">
                        <a href="#download" class="inline-flex items-center justify-center rounded-full bg-[var(--color-charcoal)] px-7 py-4 text-sm font-semibold text-white shadow-[0_22px_36px_rgba(47,47,47,0.18)] transition duration-300 hover:scale-[1.02] hover:bg-[var(--color-taupe)]">
                            Download App
                        </a>
                        <a href="#features" class="inline-flex items-center justify-center rounded-full border border-[rgba(47,47,47,0.12)] bg-white/70 px-7 py-4 text-sm font-semibold text-[var(--color-charcoal)] shadow-[0_12px_28px_rgba(47,47,47,0.06)] backdrop-blur-md transition duration-300 hover:scale-[1.02] hover:border-[rgba(47,47,47,0.22)]">
                            Explore Features
                        </a>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="rounded-[24px] border border-white/55 bg-white/60 p-5 shadow-[0_18px_45px_rgba(47,47,47,0.06)] backdrop-blur-md">
                            <p class="text-3xl font-semibold text-[var(--color-charcoal)]">4.8/5</p>
                            <p class="mt-2 text-sm text-[color:rgba(47,47,47,0.62)]">Loved by design-forward homeowners</p>
                        </div>
                        <div class="rounded-[24px] border border-white/55 bg-white/60 p-5 shadow-[0_18px_45px_rgba(47,47,47,0.06)] backdrop-blur-md">
                            <p class="text-3xl font-semibold text-[var(--color-charcoal)]">2D + 3D</p>
                            <p class="mt-2 text-sm text-[color:rgba(47,47,47,0.62)]">Room planning that feels intuitive</p>
                        </div>
                        <div class="rounded-[24px] border border-white/55 bg-white/60 p-5 shadow-[0_18px_45px_rgba(47,47,47,0.06)] backdrop-blur-md">
                            <p class="text-3xl font-semibold text-[var(--color-charcoal)]">Curated</p>
                            <p class="mt-2 text-sm text-[color:rgba(47,47,47,0.62)]">Ideas, decor, and designer guidance</p>
                        </div>
                    </div>
                </div>

                <div class="reveal relative">
                    <div class="absolute -left-8 top-8 hidden h-40 w-40 rounded-full bg-[rgba(122,138,107,0.18)] blur-3xl lg:block"></div>
                    <div class="absolute -right-12 bottom-16 hidden h-48 w-48 rounded-full bg-[rgba(203,187,160,0.34)] blur-3xl lg:block"></div>

                    <div class="relative mx-auto max-w-xl">
                        <div class="rounded-[34px] border border-white/60 bg-white/60 p-4 shadow-[0_30px_80px_rgba(47,47,47,0.10)] backdrop-blur-xl">
                            <img src="{{ asset('images/hero.png') }}" alt="Warm interior designed with Homiq" class="h-[22rem] w-full rounded-[28px] object-cover sm:h-[28rem] lg:h-[36rem]">
                        </div>

                        <div class="absolute -left-2 top-10 w-40 rounded-[28px] border border-white/60 bg-white/75 p-3 shadow-[0_25px_50px_rgba(47,47,47,0.10)] backdrop-blur-xl sm:-left-10 sm:w-44">
                            <img src="{{ asset('images/sereenshot_1.png') }}" alt="Homiq home screen" class="h-72 w-full rounded-[22px] object-cover object-top">
                        </div>

                        <div class="absolute -right-2 bottom-10 w-40 rounded-[28px] border border-white/60 bg-white/75 p-3 shadow-[0_25px_50px_rgba(47,47,47,0.10)] backdrop-blur-xl sm:-right-10 sm:w-44">
                            <img src="{{ asset('images/sereenshot_2.png') }}" alt="Homiq planner screen" class="h-72 w-full rounded-[22px] object-cover object-top">
                        </div>

                        <div class="absolute left-1/2 top-6 hidden -translate-x-1/2 rounded-full border border-white/60 bg-[rgba(247,246,242,0.84)] px-5 py-3 text-sm font-medium text-[var(--color-charcoal)] shadow-[0_18px_40px_rgba(47,47,47,0.08)] backdrop-blur-xl md:flex">
                            Premium iPhone-style preview
                        </div>
                    </div>
                </div>
            </section>

            <section class="mx-auto max-w-7xl px-5 py-16 sm:px-6 lg:px-8">
                <div class="reveal rounded-[32px] border border-white/50 bg-[linear-gradient(135deg,rgba(255,255,255,0.72),rgba(255,255,255,0.45))] p-8 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl sm:p-10">
                    <div class="grid gap-8 md:grid-cols-[minmax(0,0.75fr)_minmax(0,1.25fr)] md:items-center">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.28em] text-[var(--color-olive)]">Trusted by thoughtful decorators</p>
                            <h2 class="mt-4 font-[var(--font-display)] text-3xl leading-tight sm:text-4xl">A calmer way to shape every room in your home</h2>
                        </div>
                        <div class="grid gap-6 text-sm text-[color:rgba(47,47,47,0.68)] sm:grid-cols-3">
                            <div>
                                <p class="text-3xl font-semibold text-[var(--color-charcoal)]">50k+</p>
                                <p class="mt-2 leading-7">Design ideas saved and organized by home lovers.</p>
                            </div>
                            <div>
                                <p class="text-3xl font-semibold text-[var(--color-charcoal)]">12min</p>
                                <p class="mt-2 leading-7">Average time to sketch a room and visualize changes.</p>
                            </div>
                            <div>
                                <p class="text-3xl font-semibold text-[var(--color-charcoal)]">Top rated</p>
                                <p class="mt-2 leading-7">Praised for simplicity, elegance, and useful planning tools.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="features" class="mx-auto max-w-7xl px-5 py-20 sm:px-6 lg:px-8">
                <div class="reveal mx-auto max-w-2xl text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.28em] text-[var(--color-olive)]">Features</p>
                    <h2 class="mt-4 font-[var(--font-display)] text-4xl leading-tight sm:text-5xl">Everything you need to imagine, plan, and refine your interiors</h2>
                    <p class="mt-5 text-base leading-8 text-[color:rgba(47,47,47,0.68)]">Built for homeowners, renters, and design enthusiasts who want beautiful rooms without a complicated workflow.</p>
                </div>

                <div class="mt-14 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @php
                        $features = [
                            ['title' => 'Discover Design Ideas', 'description' => 'Browse warm, modern inspiration curated for living rooms, bedrooms, kitchens, and more.'],
                            ['title' => 'Smart Room Planner', 'description' => 'Lay out your room in intuitive 2D and visualize it with immersive 3D previews.'],
                            ['title' => 'Save & Organize Ideas', 'description' => 'Bookmark styles, palettes, and layouts so your next design decision feels effortless.'],
                            ['title' => 'Furniture & Decor Collection', 'description' => 'Explore a refined collection of furniture and finishing touches that suit your space.'],
                            ['title' => 'Connect with Designers', 'description' => 'Move from inspiration to execution with expert guidance when you need a professional eye.'],
                            ['title' => 'Visualize Transformations', 'description' => 'Compare before-and-after room concepts and confidently commit to your favorite direction.'],
                        ];
                    @endphp

                    @foreach ($features as $feature)
                        <article class="reveal group rounded-[28px] border border-white/60 bg-white/70 p-7 shadow-[0_18px_50px_rgba(47,47,47,0.06)] backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:shadow-[0_30px_60px_rgba(47,47,47,0.10)]">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[rgba(203,187,160,0.24)] text-[var(--color-charcoal)] transition duration-300 group-hover:scale-105 group-hover:bg-[rgba(122,138,107,0.20)]">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.75 12a7.25 7.25 0 1 1 14.5 0a7.25 7.25 0 0 1-14.5 0Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m15 9-3.75 3.75L9 10.5"/>
                                </svg>
                            </div>
                            <h3 class="mt-6 text-2xl font-semibold text-[var(--color-charcoal)]">{{ $feature['title'] }}</h3>
                            <p class="mt-4 text-sm leading-7 text-[color:rgba(47,47,47,0.68)]">{{ $feature['description'] }}</p>
                        </article>
                    @endforeach
                </div>
            </section>

            <section id="screens" class="bg-[linear-gradient(180deg,rgba(168,144,120,0.08),rgba(247,246,242,0.9))]">
                <div class="mx-auto max-w-7xl px-5 py-20 sm:px-6 lg:px-8">
                    <div class="reveal flex flex-col gap-5 text-center">
                        <p class="text-sm font-semibold uppercase tracking-[0.28em] text-[var(--color-olive)]">App Screens</p>
                        <h2 class="font-[var(--font-display)] text-4xl leading-tight sm:text-5xl">A refined mobile experience that keeps the focus on your home</h2>
                    </div>

                    <div class="mt-14 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                        @foreach (range(1, 6) as $screen)
                            <figure class="reveal rounded-[30px] border border-white/60 bg-white/72 p-4 shadow-[0_24px_65px_rgba(47,47,47,0.08)] backdrop-blur-xl transition duration-300 hover:scale-[1.015]">
                                <img
                                    src="{{ asset('images/sereenshot_' . $screen . '.png') }}"
                                    alt="Homiq app screen {{ $screen }}"
                                    class="h-[26rem] w-full rounded-[24px] object-cover object-top"
                                >
                            </figure>
                        @endforeach
                    </div>
                </div>
            </section>

            <section id="how-it-works" class="mx-auto max-w-7xl px-5 py-20 sm:px-6 lg:px-8">
                <div class="grid gap-10 lg:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)] lg:items-center">
                    <div class="reveal">
                        <p class="text-sm font-semibold uppercase tracking-[0.28em] text-[var(--color-olive)]">How It Works</p>
                        <h2 class="mt-4 font-[var(--font-display)] text-4xl leading-tight sm:text-5xl">Three simple steps from inspiration to a finished room</h2>
                        <p class="mt-5 max-w-xl text-base leading-8 text-[color:rgba(47,47,47,0.68)]">Homiq makes the process feel light and intuitive, whether you are refreshing one corner or planning a full makeover.</p>

                        <div class="mt-8 overflow-hidden rounded-[32px] border border-white/60 bg-white/70 p-4 shadow-[0_22px_58px_rgba(47,47,47,0.08)] backdrop-blur-xl">
                            <img src="{{ asset('images/hero_transformation.png') }}" alt="Interior transformation preview" class="h-[25rem] w-full rounded-[26px] object-cover">
                        </div>
                    </div>

                    <div class="space-y-5">
                        @php
                            $steps = [
                                ['number' => '01', 'title' => 'Explore Ideas', 'description' => 'Save beautifully curated rooms, colors, and styles that match your taste.'],
                                ['number' => '02', 'title' => 'Plan Your Room', 'description' => 'Arrange furniture, test layouts, and preview your design in 2D and 3D.'],
                                ['number' => '03', 'title' => 'Create Your Dream Space', 'description' => 'Refine details, shortlist decor, and move forward with clarity and confidence.'],
                            ];
                        @endphp

                        @foreach ($steps as $step)
                            <article class="reveal rounded-[28px] border border-white/60 bg-white/72 p-7 shadow-[0_20px_55px_rgba(47,47,47,0.06)] backdrop-blur-xl">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[rgba(122,138,107,0.16)] text-lg font-semibold text-[var(--color-olive)]">
                                        {{ $step['number'] }}
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-semibold text-[var(--color-charcoal)]">{{ $step['title'] }}</h3>
                                        <p class="mt-3 text-sm leading-7 text-[color:rgba(47,47,47,0.68)]">{{ $step['description'] }}</p>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section id="reviews" class="bg-[linear-gradient(180deg,rgba(122,138,107,0.08),rgba(247,246,242,1))]">
                <div class="mx-auto max-w-7xl px-5 py-20 sm:px-6 lg:px-8">
                    <div class="reveal mx-auto max-w-2xl text-center">
                        <p class="text-sm font-semibold uppercase tracking-[0.28em] text-[var(--color-olive)]">Testimonials</p>
                        <h2 class="mt-4 font-[var(--font-display)] text-4xl leading-tight sm:text-5xl">Trusted by people creating more intentional homes</h2>
                    </div>

                    <div class="mt-14 grid gap-6 lg:grid-cols-3">
                        @php
                            $reviews = [
                                ['name' => 'Maya Kapoor', 'role' => 'Apartment Owner', 'quote' => 'Homiq made redesigning my living room feel calm instead of overwhelming. The planning tools are genuinely beautiful to use.'],
                                ['name' => 'Ethan Brooks', 'role' => 'First-Time Homeowner', 'quote' => 'The app helped me test layouts before buying furniture. It saved me time, money, and a lot of second-guessing.'],
                                ['name' => 'Sofia Bennett', 'role' => 'Design Enthusiast', 'quote' => 'It feels premium, thoughtful, and simple. I love how easy it is to save inspiration and turn it into a real room plan.'],
                            ];
                        @endphp

                        @foreach ($reviews as $review)
                            <article class="reveal rounded-[30px] border border-white/60 bg-white/74 p-7 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
                                <div class="flex items-center gap-1 text-[var(--color-taupe)]" aria-label="4.8 out of 5 stars">
                                    @foreach (range(1, 5) as $star)
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                            <path d="M11.48 3.5a.56.56 0 0 1 1.04 0l2.1 5.08 5.49.44a.56.56 0 0 1 .32.98l-4.18 3.58 1.28 5.34a.56.56 0 0 1-.84.6L12 16.74l-4.69 2.78a.56.56 0 0 1-.84-.6l1.28-5.34-4.18-3.58a.56.56 0 0 1 .32-.98l5.49-.44 2.1-5.08Z"/>
                                        </svg>
                                    @endforeach
                                </div>
                                <p class="mt-5 text-base leading-8 text-[color:rgba(47,47,47,0.72)]">“{{ $review['quote'] }}”</p>
                                <div class="mt-6 flex items-center gap-4">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[rgba(203,187,160,0.28)] font-semibold text-[var(--color-charcoal)]">
                                        {{ strtoupper(substr($review['name'], 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-[var(--color-charcoal)]">{{ $review['name'] }}</p>
                                        <p class="text-sm text-[color:rgba(47,47,47,0.58)]">{{ $review['role'] }}</p>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section id="download" class="mx-auto max-w-7xl px-5 py-20 sm:px-6 lg:px-8">
                <div class="reveal rounded-[36px] border border-white/60 bg-[linear-gradient(135deg,rgba(47,47,47,0.96),rgba(63,63,63,0.92),rgba(122,138,107,0.88))] px-6 py-12 text-white shadow-[0_35px_90px_rgba(47,47,47,0.22)] sm:px-10 lg:px-14 lg:py-14">
                    <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-center">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.28em] text-[rgba(247,246,242,0.72)]">Start Designing Today</p>
                            <h2 class="mt-4 max-w-2xl font-[var(--font-display)] text-4xl leading-tight sm:text-5xl">Bring elegance, clarity, and confidence to every room you design.</h2>
                            <p class="mt-5 max-w-2xl text-base leading-8 text-[rgba(247,246,242,0.78)]">Download Homiq and turn inspiration into a home that feels beautifully yours.</p>
                        </div>

                        <div class="flex flex-col gap-4 sm:flex-row lg:flex-col">
                            <a href="#" aria-disabled="true" class="inline-flex items-center justify-center rounded-full bg-white px-7 py-4 text-sm font-semibold text-[var(--color-charcoal)] opacity-70 transition duration-300 hover:scale-[1.02]">
                                Download on App Store
                            </a>
                            <a href="https://play.google.com/store/apps/details?id=com.homiq.acrocoder" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/10 px-7 py-4 text-sm font-semibold text-white backdrop-blur-md transition duration-300 hover:scale-[1.02] hover:bg-white/16">
                                Get it on Play Store
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-[rgba(47,47,47,0.08)] bg-[rgba(255,255,255,0.42)]">
            <div class="mx-auto grid max-w-7xl gap-10 px-5 py-10 sm:px-6 lg:grid-cols-[minmax(0,1fr)_auto_auto] lg:px-8">
                <div class="max-w-md">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Homiq logo" class="h-11 w-11 rounded-2xl border border-white/60 object-cover shadow-[0_14px_36px_rgba(47,47,47,0.08)]">
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
                        <a class="transition hover:text-[var(--color-charcoal)]" href="#">About</a>
                        <a class="transition hover:text-[var(--color-charcoal)]" href="#">Privacy Policy</a>
                        <a class="transition hover:text-[var(--color-charcoal)]" href="#">Contact</a>
                    </div>
                </div>

                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-[var(--color-olive)]">Social</p>
                    <div class="mt-4 flex items-center gap-3">
                        @foreach (['IG', 'PI', 'FB'] as $social)
                            <a href="#" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-[rgba(47,47,47,0.10)] bg-white/72 text-xs font-semibold text-[var(--color-charcoal)] transition duration-300 hover:scale-105 hover:border-[rgba(47,47,47,0.18)]">
                                {{ $social }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
