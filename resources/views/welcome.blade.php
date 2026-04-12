<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homiq AI | Reimagine Your Space with AI Precision</title>
    <link rel="stylesheet" href="{{ asset('css/modern.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <style>
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            padding-top: 100px;
            overflow: hidden;
        }

        .hero-image-overlay {
            position: absolute;
            top: 0;
            right: 0;
            width: 55%;
            height: 100%;
            background: url("{{ asset('images/hero-studio.png') }}") no-repeat center right;
            background-size: cover;
            mask-image: linear-gradient(to left, black 60%, transparent 100%);
            -webkit-mask-image: linear-gradient(to left, black 60%, transparent 100%);
            z-index: -1;
            opacity: 0.8;
        }

        .glow-sphere {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, var(--neon-blue) 0%, transparent 70%);
            filter: blur(100px);
            opacity: 0.15;
            z-index: -2;
        }

        .nav-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .nav-bar.scrolled {
            background: rgba(10, 11, 16, 0.8);
            backdrop-filter: blur(20px);
            padding: 15px 0;
            border-bottom: 1px solid var(--glass-border);
        }

        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .text-gradient {
            background: var(--grad-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: var(--radius-sm);
            background: rgba(58, 134, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            color: var(--neon-blue);
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 60px;
        }

        .footer {
            padding: 80px 0 40px;
            border-top: 1px solid var(--glass-border);
            margin-top: 100px;
        }
    </style>
</head>
<body>

    <nav class="nav-bar">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Homiq AI" style="height: 44px; width: auto;">
            </div>
            <div style="display: flex; gap: 40px; align-items: center;">
                <a href="#features" style="text-decoration: none; color: var(--text-secondary); font-weight: 500;">Features</a>
                <a href="#pricing" style="text-decoration: none; color: var(--text-secondary); font-weight: 500;">Pricing</a>
                <a href="{{ route('admin.dashboard') }}" class="btn-glass" style="padding: 10px 24px;">Admin Portal</a>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="hero-image-overlay"></div>
        <div class="glow-sphere" style="top: -200px; left: -200px;"></div>
        
        <div class="container" style="position: relative;">
            <div style="max-width: 650px;" data-aos="fade-right">
                <div style="display: inline-flex; align-items: center; gap: 10px; background: rgba(58, 134, 255, 0.1); padding: 8px 16px; border-radius: 50px; margin-bottom: 30px;">
                    <span style="width: 8px; height: 8px; background: var(--neon-blue); border-radius: 50%; box-shadow: 0 0 10px var(--neon-blue);"></span>
                    <span style="font-size: 12px; font-weight: 700; letter-spacing: 2px; color: var(--neon-blue); text-transform: uppercase;">Next-Gen AI Interior Studio</span>
                </div>
                
                <h1 style="font-size: 84px; line-height: 1; margin-bottom: 30px; letter-spacing: -4px;">
                    Reimagine Your Home <br>
                    <span class="text-gradient">With AI Precision.</span>
                </h1>
                
                <p style="font-size: 20px; color: var(--text-secondary); margin-bottom: 50px; line-height: 1.6;">
                    Upload a photo and watch Homiq AI transform your space in seconds. 
                    The perfect fusion of architectural intelligence and artistic style.
                </p>
                
                <div style="display: flex; gap: 20px; align-items: center;">
                    <a href="#" class="btn-primary">Generate Your Design</a>
                    <a href="#features" class="btn-glass">Explore Features</a>
                </div>

                <div style="margin-top: 80px; display: flex; gap: 60px;">
                    <div>
                        <div class="font-heading" style="font-size: 32px; color: var(--text-primary);">25k+</div>
                        <div style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">Home Designs Generated</div>
                    </div>
                    <div style="width: 1px; height: 50px; background: var(--glass-border);"></div>
                    <div>
                        <div class="font-heading" style="font-size: 32px; color: var(--text-primary);">4.9/5</div>
                        <div style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">Architectural Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" style="padding: 120px 0;">
        <div class="container">
            <div style="text-align: center; max-width: 800px; margin: 0 auto 80px;">
                <h2 style="font-size: 48px; margin-bottom: 20px;">Intelligent Design Features</h2>
                <p style="color: var(--text-secondary); font-size: 18px;">Built for homeowners who demand excellence. Our AI understands depth, material science, and aesthetic harmony.</p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px;">
                <div class="glass-card" style="padding: 40px;" data-aos="fade-up">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                    </div>
                    <h3 style="font-size: 24px; margin-bottom: 15px;">Depth Awareness</h3>
                    <p style="color: var(--text-secondary);">Advanced neural nets map your room's coordinates for hyper-realistic furniture placement and lighting.</p>
                </div>
                
                <div class="glass-card" style="padding: 40px;" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-icon" style="background: rgba(131, 56, 236, 0.1); color: var(--neon-purple);">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </div>
                    <h3 style="font-size: 24px; margin-bottom: 15px;">Material Simulation</h3>
                    <p style="color: var(--text-secondary);">Simulate textures from marble finish to oak wood with physical accuracy and light reflection.</p>
                </div>
                
                <div class="glass-card" style="padding: 40px;" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-icon" style="background: rgba(6, 214, 160, 0.1); color: var(--success);">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                    </div>
                    <h3 style="font-size: 24px; margin-bottom: 15px;">Eco-Optimizer</h3>
                    <p style="color: var(--text-secondary);">Get design suggestions that maximize natural light and energy efficiency for your specific region.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="pricing" style="padding: 100px 0; background: var(--midnight-light);">
        <div class="container">
            <div style="text-align: center; max-width: 800px; margin: 0 auto 60px;">
                <h2 style="font-size: 48px; margin-bottom: 20px;">Affordable Architectural Luxury</h2>
                <p style="color: var(--text-secondary); font-size: 18px;">Unlock the full power of Homiq AI with our premium tiers.</p>
            </div>
            
            <div class="pricing-grid">
                <div class="glass-card" style="padding: 50px; text-align: center;" data-aos="zoom-in">
                    <h4 style="color: var(--text-secondary); text-transform: uppercase; font-size: 14px; margin-bottom: 10px;">Entry</h4>
                    <div class="font-heading" style="font-size: 56px; margin-bottom: 30px;">Free</div>
                    <ul style="list-style: none; text-align: left; margin-bottom: 40px; padding: 0 20px;">
                        <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                            <span style="color: var(--success);">✓</span> 3 AI Generations Included
                        </li>
                        <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                            <span style="color: var(--success);">✓</span> Standard Material Library
                        </li>
                        <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 10px; color: var(--text-secondary); opacity: 0.5;">
                            <span>✕</span> High-Resolution Exports
                        </li>
                    </ul>
                    <a href="#" class="btn-glass" style="width: 100%;">Get Started</a>
                </div>
                
                <div class="glass-card" style="padding: 50px; text-align: center; border: 1px solid var(--neon-blue); position: relative; background: rgba(58, 134, 255, 0.05);" data-aos="zoom-in" data-aos-delay="100">
                    <div style="position: absolute; top: 20px; right: 20px; background: var(--neon-blue); font-size: 10px; font-weight: 800; padding: 4px 12px; border-radius: 20px;">BEST VALUE</div>
                    <h4 style="color: var(--neon-blue); text-transform: uppercase; font-size: 14px; margin-bottom: 10px;">Premium Elite</h4>
                    <div class="font-heading" style="font-size: 56px; margin-bottom: 30px;">₹199<span style="font-size: 20px; color: var(--text-secondary);">/mo</span></div>
                    <ul style="list-style: none; text-align: left; margin-bottom: 40px; padding: 0 20px;">
                        <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                            <span style="color: var(--neon-blue);">✓</span> Unlimited AI Generations
                        </li>
                        <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                            <span style="color: var(--neon-blue);">✓</span> Elite 8K Materials
                        </li>
                        <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                            <span style="color: var(--neon-blue);">✓</span> Priority Cloud Processing
                        </li>
                    </ul>
                    <a href="#" class="btn-primary" style="width: 100%;">Go Premium Elite</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 60px;">
                <div style="max-width: 300px;">
                    <div class="logo" style="margin-bottom: 20px;">
                        <img src="{{ asset('images/logo.png') }}" alt="Homiq AI" style="height: 38px; width: auto;">
                    </div>
                    <p style="color: var(--text-secondary); font-size: 14px;">Defining the future of interior design with state-of-the-art artificial intelligence.</p>
                </div>
                <div style="display: flex; gap: 80px;">
                    <div>
                        <h5 style="margin-bottom: 20px;">Studio</h5>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <a href="#" style="color: var(--text-secondary); text-decoration: none; font-size: 14px;">Styles</a>
                            <a href="#" style="color: var(--text-secondary); text-decoration: none; font-size: 14px;">Materials</a>
                            <a href="#" style="color: var(--text-secondary); text-decoration: none; font-size: 14px;">Gallery</a>
                        </div>
                    </div>
                    <div>
                        <h5 style="margin-bottom: 20px;">Company</h5>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <a href="#" style="color: var(--text-secondary); text-decoration: none; font-size: 14px;">About</a>
                            <a href="#" style="color: var(--text-secondary); text-decoration: none; font-size: 14px;">Privacy</a>
                            <a href="#" style="color: var(--text-secondary); text-decoration: none; font-size: 14px;">Terms</a>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--glass-border); pt-40; padding-top: 40px;">
                <p style="color: var(--text-secondary); font-size: 12px;">© 2026 Homiq AI Studio. All rights reserved.</p>
                <div style="display: flex; gap: 20px;">
                    <!-- Social Icons (Simulated) -->
                    <span style="color: var(--text-secondary); font-size: 14px;">TW</span>
                    <span style="color: var(--text-secondary); font-size: 14px;">IG</span>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            easing: 'ease-out-cubic'
        });

        window.addEventListener('scroll', () => {
            const nav = document.querySelector('.nav-bar');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
