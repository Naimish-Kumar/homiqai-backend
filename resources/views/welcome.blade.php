<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homiq AI | Rose Gold Interior Studio</title>
    <link rel="stylesheet" href="{{ asset('css/modern.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .site-nav {
            background: rgba(17, 16, 18, 0.78);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--glass-border);
            left: 0;
            position: fixed;
            right: 0;
            top: 0;
            z-index: 20;
        }

        .site-nav-inner,
        .site-container {
            margin: 0 auto;
            max-width: 1180px;
            padding: 0 24px;
        }

        .site-nav-inner {
            align-items: center;
            display: flex;
            justify-content: space-between;
            min-height: 78px;
            gap: 24px;
        }

        .site-logo {
            align-items: center;
            display: flex;
            gap: 12px;
            text-decoration: none;
        }

        .site-logo img {
            height: 42px;
            width: auto;
        }

        .site-logo span {
            color: var(--text-secondary);
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .site-links {
            align-items: center;
            display: flex;
            gap: 28px;
        }

        .site-links a {
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
            text-transform: uppercase;
        }

        .site-links a:hover {
            color: var(--rose);
        }

        .hero-section {
            align-items: center;
            background:
                linear-gradient(90deg, rgba(17, 16, 18, 0.96) 0%, rgba(17, 16, 18, 0.82) 42%, rgba(17, 16, 18, 0.38) 100%),
                url("{{ asset('images/hero-studio.png') }}") center right / cover no-repeat;
            display: flex;
            min-height: 92svh;
            padding: 126px 0 82px;
        }

        .hero-copy {
            max-width: 680px;
        }

        .hero-kicker {
            align-items: center;
            background: rgba(183, 110, 121, 0.14);
            border: 1px solid rgba(231, 166, 161, 0.24);
            border-radius: 8px;
            color: var(--rose-light);
            display: inline-flex;
            font-size: 12px;
            font-weight: 900;
            gap: 10px;
            margin-bottom: 26px;
            padding: 8px 12px;
            text-transform: uppercase;
        }

        .hero-kicker i {
            color: var(--rose-gold);
        }

        .hero-copy h1 {
            font-size: clamp(46px, 8vw, 84px);
            line-height: 0.98;
            margin: 0 0 24px;
            max-width: 820px;
        }

        .hero-copy p {
            color: var(--text-secondary);
            font-size: clamp(17px, 2vw, 21px);
            margin: 0 0 34px;
            max-width: 620px;
        }

        .hero-actions,
        .hero-stats {
            align-items: center;
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .hero-stats {
            border-top: 1px solid var(--glass-border);
            gap: 32px;
            margin-top: 58px;
            padding-top: 26px;
        }

        .hero-stat {
            display: grid;
            gap: 2px;
        }

        .hero-stat strong {
            font-family: 'Outfit', sans-serif;
            font-size: 32px;
            line-height: 1;
        }

        .hero-stat span {
            color: var(--text-secondary);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .section-band {
            padding: 92px 0;
        }

        .section-band.alt {
            background: var(--midnight-light);
        }

        .section-heading {
            display: grid;
            gap: 12px;
            margin: 0 auto 42px;
            max-width: 720px;
            text-align: center;
        }

        .section-heading h2 {
            font-size: clamp(32px, 5vw, 52px);
            line-height: 1;
            margin: 0;
        }

        .section-heading p {
            color: var(--text-secondary);
            font-size: 17px;
            margin: 0;
        }

        .feature-grid,
        .showcase-grid,
        .pricing-grid {
            display: grid;
            gap: 20px;
        }

        .feature-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .feature-card,
        .pricing-card,
        .showcase-copy {
            padding: 28px;
        }

        .feature-icon {
            align-items: center;
            background: rgba(183, 110, 121, 0.13);
            border: 1px solid rgba(231, 166, 161, 0.24);
            border-radius: 8px;
            color: var(--rose-gold);
            display: flex;
            height: 54px;
            justify-content: center;
            margin-bottom: 22px;
            width: 54px;
        }

        .feature-card h3,
        .pricing-card h3,
        .showcase-copy h3 {
            font-size: 24px;
            margin: 0 0 10px;
        }

        .feature-card p,
        .pricing-card p,
        .showcase-copy p,
        .feature-card li,
        .pricing-card li {
            color: var(--text-secondary);
        }

        .showcase-grid {
            align-items: stretch;
            grid-template-columns: minmax(0, 1.1fr) minmax(0, 0.9fr);
        }

        .showcase-image {
            border-radius: 8px;
            min-height: 470px;
            overflow: hidden;
            position: relative;
        }

        .showcase-image img {
            display: block;
            height: 100%;
            object-fit: cover;
            width: 100%;
        }

        .showcase-chip {
            background: rgba(17, 16, 18, 0.76);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            bottom: 18px;
            display: grid;
            gap: 3px;
            left: 18px;
            padding: 14px 16px;
            position: absolute;
        }

        .showcase-chip strong {
            color: var(--rose-light);
        }

        .showcase-copy {
            display: grid;
            gap: 18px;
        }

        .process-list {
            display: grid;
            gap: 12px;
        }

        .process-list div {
            align-items: flex-start;
            display: flex;
            gap: 14px;
        }

        .process-list span {
            align-items: center;
            background: var(--grad-primary);
            border-radius: 8px;
            color: var(--midnight);
            display: flex;
            flex: 0 0 auto;
            font-weight: 900;
            height: 34px;
            justify-content: center;
            width: 34px;
        }

        .pricing-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            margin: 0 auto;
            max-width: 900px;
        }

        .pricing-card.featured {
            background: linear-gradient(180deg, rgba(183, 110, 121, 0.18), rgba(255, 255, 255, 0.035));
            border-color: rgba(231, 166, 161, 0.48);
        }

        .price {
            font-family: 'Outfit', sans-serif;
            font-size: 52px;
            font-weight: 900;
            line-height: 1;
            margin: 20px 0;
        }

        .pricing-card ul {
            display: grid;
            gap: 12px;
            list-style: none;
            margin: 0 0 28px;
            padding: 0;
        }

        .site-footer {
            border-top: 1px solid var(--glass-border);
            padding: 42px 0;
        }

        .site-footer .site-container {
            align-items: center;
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .site-footer p {
            color: var(--text-secondary);
            margin: 0;
        }

        @media (max-width: 900px) {
            .site-links a:not(.btn-primary) {
                display: none;
            }

            .feature-grid,
            .showcase-grid,
            .pricing-grid {
                grid-template-columns: 1fr;
            }

            .showcase-image {
                min-height: 340px;
            }

            .hero-section {
                background:
                    linear-gradient(180deg, rgba(17, 16, 18, 0.94) 0%, rgba(17, 16, 18, 0.7) 100%),
                    url("{{ asset('images/hero-studio.png') }}") center / cover no-repeat;
                min-height: 88svh;
            }

            .site-footer .site-container {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <nav class="site-nav">
        <div class="site-nav-inner">
            <a href="{{ route('home') }}" class="site-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Homiq AI">
                <span>Rose Gold Studio</span>
            </a>
            <div class="site-links">
                <a href="#features">Features</a>
                <a href="#studio">Studio</a>
                <a href="#pricing">Pricing</a>
                <a href="{{ route('admin.dashboard') }}" class="btn-glass">Dashboard</a>
            </div>
        </div>
    </nav>

    <main>
        <section class="hero-section">
            <div class="site-container">
                <div class="hero-copy">
                    <div class="hero-kicker"><i class="fa-solid fa-wand-magic-sparkles"></i> AI Interior Design Studio</div>
                    <h1>Design a home that feels composed, warm, and unmistakably yours.</h1>
                    <p>Upload a room photo, choose your mood, and let Homiq AI create refined interiors with rose gold accents, natural textures, and precise layout intelligence.</p>
                    <div class="hero-actions">
                        <a href="#pricing" class="btn-primary">Start Designing</a>
                        <a href="#studio" class="btn-glass">View Studio Flow</a>
                    </div>
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <strong>25k+</strong>
                            <span>Designs generated</span>
                        </div>
                        <div class="hero-stat">
                            <strong>4.9</strong>
                            <span>Average rating</span>
                        </div>
                        <div class="hero-stat">
                            <strong>60s</strong>
                            <span>Concept previews</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-band" id="features">
            <div class="site-container">
                <div class="section-heading">
                    <p class="eyebrow">Refined by intelligence</p>
                    <h2>A calmer way to redesign every room.</h2>
                    <p>Homiq reads your photo, understands scale, and prepares design directions you can actually imagine living with.</p>
                </div>

                <div class="feature-grid">
                    <article class="glass-card feature-card">
                        <div class="feature-icon"><i class="fa-solid fa-ruler-combined"></i></div>
                        <h3>Room-aware layouts</h3>
                        <p>Furniture placement respects walls, circulation, light, and visual balance for realistic room concepts.</p>
                    </article>
                    <article class="glass-card feature-card">
                        <div class="feature-icon"><i class="fa-solid fa-palette"></i></div>
                        <h3>Curated style moods</h3>
                        <p>Explore minimalist, Indian, Scandinavian, and premium rose gold palettes without losing the room's character.</p>
                    </article>
                    <article class="glass-card feature-card">
                        <div class="feature-icon"><i class="fa-solid fa-layer-group"></i></div>
                        <h3>Material guidance</h3>
                        <p>Pair metals, fabrics, floors, lighting, and wall finishes with suggestions that feel cohesive from the first draft.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section-band alt" id="studio">
            <div class="site-container">
                <div class="showcase-grid">
                    <div class="showcase-image">
                        <img src="{{ asset('images/hero_transformation.png') }}" alt="AI transformed living room">
                        <div class="showcase-chip">
                            <strong>Rose Gold Luxe</strong>
                            <span>Warm metal accents, soft seating, balanced light.</span>
                        </div>
                    </div>
                    <article class="glass-card showcase-copy">
                        <p class="eyebrow">Studio flow</p>
                        <h3>From room photo to polished direction.</h3>
                        <p>Move from a blank room to a finished design path with fewer guesses and a clearer sense of what belongs in the space.</p>
                        <div class="process-list">
                            <div>
                                <span>1</span>
                                <p>Upload your room and choose the style mood that fits your home.</p>
                            </div>
                            <div>
                                <span>2</span>
                                <p>Generate realistic concepts with coordinated furniture, materials, and lighting.</p>
                            </div>
                            <div>
                                <span>3</span>
                                <p>Save the direction, compare alternatives, and continue refining your favorite look.</p>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="section-band" id="pricing">
            <div class="site-container">
                <div class="section-heading">
                    <p class="eyebrow">Simple plans</p>
                    <h2>Start small or keep designing.</h2>
                    <p>Choose the plan that fits your renovation rhythm.</p>
                </div>
                <div class="pricing-grid">
                    <article class="glass-card pricing-card">
                        <h3>Free</h3>
                        <p>For quick room experiments.</p>
                        <div class="price">₹0</div>
                        <ul>
                            <li>3 AI room generations</li>
                            <li>Core style library</li>
                            <li>Standard preview quality</li>
                        </ul>
                        <a href="#" class="btn-glass">Try Free</a>
                    </article>
                    <article class="glass-card pricing-card featured">
                        <h3>Premium</h3>
                        <p>For complete home design planning.</p>
                        <div class="price">₹199<span style="font-size: 18px; color: var(--text-secondary);">/mo</span></div>
                        <ul>
                            <li>Unlimited AI generations</li>
                            <li>Premium material directions</li>
                            <li>Priority processing and exports</li>
                        </ul>
                        <a href="#" class="btn-primary">Go Premium</a>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="site-container">
            <a href="{{ route('home') }}" class="site-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Homiq AI">
                <span>Homiq AI</span>
            </a>
            <p>© 2026 Homiq AI. Interior design, made softer and smarter.</p>
        </div>
    </footer>
</body>
</html>
