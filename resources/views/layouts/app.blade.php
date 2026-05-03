<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="antialiased" style="font-family:'Inter',sans-serif;background:#0d0f14;color:#e4e8f5;" x-data="{ showCredits: false }">
        <div class="min-h-screen relative overflow-hidden" style="background:#0d0f14;">
            <div style="position:absolute;inset:0;pointer-events:none;background:
                radial-gradient(900px 420px at 12% -8%, rgba(76, 128, 255, .17), transparent 60%),
                radial-gradient(760px 420px at 100% 0%, rgba(248, 90, 173, .10), transparent 62%);">
            </div>

            <header class="sticky top-0 z-30 border-b" style="background:rgba(10,13,22,.62);border-color:rgba(69,86,126,.22);backdrop-filter:blur(10px);">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                    <a href="{{ route('dashboard') }}" class="logo-container flex items-center gap-2" style="color:#f0f5ff;" id="buddleLogo">
                    <!-- Logo Buddle dengan animasi -->
                    <div class="logo-image-wrapper">
                        <img src="/images/buddle-logo.svg" alt="Buddle Logo" class="logo-image block h-8 w-auto" style="filter: brightness(0) invert(1);" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <!-- Fallback SVG dengan animasi -->
                        <svg class="logo-image block h-8 w-auto logo-fallback" style="color:#9fb2f7; display:none;" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                            <text x="20" y="28" text-anchor="middle" fill="currentColor" font-size="20" font-weight="bold">B</text>
                            <circle cx="20" cy="20" r="18" fill="none" stroke="currentColor" stroke-width="1" opacity="0.3"/>
                        </svg>
                    </div>
                    <span class="logo-text text-sm tracking-[0.14em] uppercase font-semibold">Buddle</span>
                </a>
                    <div class="hidden md:flex items-center gap-2 text-xs">
                        @auth
                            <div class="hidden md:flex items-center gap-2 px-2.5 py-1.5 rounded-lg border" style="border-color:#2e3957;color:#9fb2f7;">
                                <span>Streak</span>
                                <span class="font-semibold">{{ Auth::user()->streak_count ?? 0 }} hari</span>
                            </div>
                        @else
                            <div class="hidden md:flex items-center gap-2 px-2.5 py-1.5 rounded-lg border" style="border-color:#4a4125;color:#f0d792;">
                                <span>Guest Mode</span>
                            </div>
                        @endauth
                    </div>
                    <div class="flex items-center gap-2 text-xs">
                        @if(!request()->routeIs('dashboard'))
                        <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded-lg border transition" style="border-color:#2e3957;color:#9fb2f7;">Timer</a>
                        @endif
                        @auth
                            <a href="{{ route('history') }}" class="px-3 py-1.5 rounded-lg border transition" style="border-color:#2e3957;color:#9fb2f7;">History</a>
                            <a href="{{ route('analytics') }}" class="px-3 py-1.5 rounded-lg border transition" style="border-color:#2e3957;color:#9fb2f7;">Analytics</a>
                            <button @click="showCredits = true" class="px-3 py-1.5 rounded-lg border transition" style="border-color:#2e3957;color:#9fb2f7;background:transparent;border:none;cursor:pointer;">Credits</button>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 rounded-lg border" style="border-color:#3f2d3b;color:#ff9dcf;">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="px-3 py-1.5 rounded-lg border transition" style="border-color:#4a4125;color:#f0d792;">History 🔒</a>
                            <a href="{{ route('register') }}" class="px-3 py-1.5 rounded-lg border transition" style="border-color:#2e3957;color:#9fb2f7;">Register</a>
                            <a href="{{ route('login') }}" class="px-3 py-1.5 rounded-lg border transition" style="border-color:#3f2d3b;color:#ff9dcf;">Login</a>
                        @endauth
                    </div>
                </div>
            </header>

            <main class="relative z-[2]">
                {{ $slot }}
            </main>
        </div>
    <style>
        .logo-container {
            display: inline-flex;
            align-items: center;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .logo-container:hover {
            transform: scale(1.05);
        }
        
        .logo-image-wrapper {
            position: relative;
            display: inline-block;
        }
        
        .logo-image {
            transition: all 0.3s ease;
        }
        
        .logo-text {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .logo-container:hover .logo-image {
            transform: rotate(360deg) scale(1.1);
        }
        
        .logo-container:hover .logo-text {
            color: #4a9eff;
            transform: translateY(-2px);
        }
        
        .logo-pulse {
            animation: logoPulse 2s infinite;
        }
        
        @keyframes logoPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .logo-glow {
            filter: drop-shadow(0 0 10px rgba(74, 158, 255, 0.8));
        }
        
        .logo-float {
            animation: logoFloat 3s ease-in-out infinite;
        }
        
        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-3px); }
        }
    </style>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Logo Buddle animation with anime.js
        const logoContainer = document.getElementById('buddleLogo');
        const logoImage = logoContainer?.querySelector('.logo-image');
        const logoText = logoContainer?.querySelector('.logo-text');
        
        if (logoContainer && logoImage && logoText) {
            // Initial entrance animation
            anime({
                targets: [logoImage, logoText],
                translateY: [-30, 0],
                opacity: [0, 1],
                delay: anime.stagger(200),
                duration: 800,
                easing: 'easeOutElastic(1, .5)'
            });
            
            // Hover animation
            logoContainer.addEventListener('mouseenter', function() {
                anime({
                    targets: logoImage,
                    rotate: '1turn',
                    scale: [1, 1.2, 1],
                    duration: 600,
                    easing: 'easeInOutQuad'
                });
                
                anime({
                    targets: logoText,
                    color: [
                        {value: '#f0f5ff', duration: 0},
                        {value: '#4a9eff', duration: 300},
                        {value: '#f0f5ff', duration: 300}
                    ],
                    duration: 600,
                    easing: 'linear'
                });
            });
            
            // Click animation
            logoContainer.addEventListener('click', function(e) {
                anime({
                    targets: logoImage,
                    scale: [1, 0.8, 1.2, 1],
                    rotate: [0, 180, 360],
                    duration: 800,
                    easing: 'easeInOutBack'
                });
                
                anime({
                    targets: logoText,
                    scale: [1, 0.9, 1.1, 1],
                    duration: 600,
                    easing: 'easeInOutBack'
                });
            });
            
            // Continuous subtle floating animation
            anime({
                targets: logoContainer,
                translateY: [0, -2, 0],
                duration: 4000,
                easing: 'easeInOutSine',
                direction: 'alternate',
                loop: true
            });
            
            // Periodic glow effect
            setInterval(function() {
                anime({
                    targets: logoImage,
                    filter: [
                        {value: 'brightness(0) invert(1)', duration: 0},
                        {value: 'brightness(0) invert(1) drop-shadow(0 0 15px rgba(74, 158, 255, 0.8))', duration: 500},
                        {value: 'brightness(0) invert(1)', duration: 500}
                    ],
                    duration: 1000,
                    easing: 'easeInOutQuad'
                });
            }, 6000);
        }
    });
    </script>

    <!-- Credits Modal -->
    <div x-show="showCredits" x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="background: rgba(0, 0, 0, 0.8); backdrop-filter: blur(4px);">
        
        <div @click.away="showCredits = false" 
             class="relative max-w-2xl w-full max-h-[90vh] overflow-y-auto"
             style="background: #151820; border: 1px solid #1e2330; border-radius: 20px; padding: 2rem;">
            
            <!-- Close Button -->
            <button @click="showCredits = false" 
                    class="absolute top-4 right-4 p-2 rounded-lg transition"
                    style="background: transparent; border: 1px solid #3a3f52; color: #6b7394; cursor: pointer;"
                    onmouseover="this.style.borderColor='#74a0ff'; this.style.color='#74a0ff';"
                    onmouseout="this.style.borderColor='#3a3f52'; this.style.color='#6b7394';">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>

            <!-- Modal Header -->
            <div class="text-center mb-8">
                <div style="font-size: 3rem; margin-bottom: 1rem;">👥</div>
                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem; background: linear-gradient(135deg, #74a0ff, #4ade80); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    Meet Our Team
                </h2>
                <p style="color: #6b7394; font-size: 1rem;">The brilliant minds behind ProjekTimer</p>
            </div>

            <!-- Team Members -->
            <div class="space-y-6">
                <!-- Team Members Grid - Equal Roles -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                    <div class="team-member" style="background: #0d0f14; border: 1px solid #1e2330; border-radius: 16px; padding: 1.5rem;">
                        <div style="font-size: 2.5rem; margin-bottom: 1rem;">👨‍💻</div>
                        <div style="font-size: 1.1rem; font-weight: 600; color: #e4e8f5; margin-bottom: 0.25rem;">Rusdiansyah Alief Prasetya</div>
                        <div style="color: #74a0ff; font-weight: 500; margin-bottom: 0.5rem;">Full-Stack Developer</div>
                        <div style="color: #6b7394; font-size: 0.875rem;">Backend development, API design, and system architecture</div>
                    </div>

                    <div class="team-member" style="background: #0d0f14; border: 1px solid #1e2330; border-radius: 16px; padding: 1.5rem;">
                        <div style="font-size: 2.5rem; margin-bottom: 1rem;">👩‍💻</div>
                        <div style="font-size: 1.1rem; font-weight: 600; color: #e4e8f5; margin-bottom: 0.25rem;">Aisha Maryam</div>
                        <div style="color: #74a0ff; font-weight: 500; margin-bottom: 0.5rem;">Frontend Developer</div>
                        <div style="color: #6b7394; font-size: 0.875rem;">UI/UX design, interactive components, and user experience</div>
                    </div>

                    <div class="team-member" style="background: #0d0f14; border: 1px solid #1e2330; border-radius: 16px; padding: 1.5rem;">
                        <div style="font-size: 2.5rem; margin-bottom: 1rem;">👩‍�</div>
                        <div style="font-size: 1.1rem; font-weight: 600; color: #e4e8f5; margin-bottom: 0.25rem;">Anindhita Faiza</div>
                        <div style="color: #74a0ff; font-weight: 500; margin-bottom: 0.5rem;">Data Science Developer</div>
                        <div style="color: #6b7394; font-size: 0.875rem;">Chronotype algorithms, data analysis, and analytics implementation</div>
                    </div>

                    <div class="team-member" style="background: #0d0f14; border: 1px solid #1e2330; border-radius: 16px; padding: 1.5rem;">
                        <div style="font-size: 2.5rem; margin-bottom: 1rem;">👩‍💻</div>
                        <div style="font-size: 1.1rem; font-weight: 600; color: #e4e8f5; margin-bottom: 0.25rem;">Shafa Rizwana Zarin</div>
                        <div style="color: #74a0ff; font-weight: 500; margin-bottom: 0.5rem;">Full-Stack Developer</div>
                        <div style="color: #6b7394; font-size: 0.875rem;">Frontend-backend integration, database design, and feature development</div>
                    </div>
                </div>
            </div>

            <!-- Project Info -->
            <div style="margin-top: 2rem; padding: 1.5rem; background: rgba(74, 158, 255, 0.1); border: 1px solid #74a0ff; border-radius: 12px;">
                <div style="text-align: center;">
                    <div style="font-size: 1.25rem; font-weight: 700; color: #74a0ff; margin-bottom: 0.5rem;">ProjekTimer</div>
                    <div style="color: #e4e8f5; margin-bottom: 1rem;">A smart study timer application with personalized chronotype recommendations</div>
                    <div style="color: #6b7394; font-size: 0.875rem;">Built with Laravel, Alpine.js, and modern web technologies</div>
                </div>
            </div>

            <!-- Footer -->
            <div style="text-align: center; margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #1e2330;">
                <div style="color: #6b7394; font-size: 0.875rem;">
                    © 2024 ProjekTimer Team. Made with ❤️ for better study habits.
                </div>
            </div>
        </div>
    </div>
    
    </body>
</html>
