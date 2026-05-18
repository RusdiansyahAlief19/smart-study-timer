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
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('darkMode', {
                isDark: localStorage.getItem('theme') !== 'light',
                
                init() {
                    // Apply theme on load
                    this.applyTheme();
                },
                
                toggle() {
                    this.isDark = !this.isDark;
                    this.applyTheme();
                },
                
                applyTheme() {
                    const theme = this.isDark ? 'dark' : 'light';
                    document.documentElement.setAttribute('data-theme', theme);
                    document.body.setAttribute('data-theme', theme);
                    localStorage.setItem('theme', theme);
                    
                    // Update body styles for immediate effect
                    if (theme === 'light') {
                        document.body.style.background = '#ffffff';
                        document.body.style.color = '#1e293b';
                    } else {
                        document.body.style.background = '#0d0f14';
                        document.body.style.color = '#e4e8f5';
                    }
                }
            });
        });
    </script>
    </head>
    <body class="antialiased" style="font-family:'Inter',sans-serif;background:#0d0f14;color:#e4e8f5;" x-data="{ showCredits: false, darkMode: Alpine.store('darkMode') }">
        <div class="min-h-screen relative overflow-hidden" style="background:#0d0f14;" :style="darkMode.isDark ? 'background:#0d0f14' : 'background:#ffffff'">
            <div style="position:absolute;inset:0;pointer-events:none;background:
                radial-gradient(900px 420px at 12% -8%, rgba(76, 128, 255, .17), transparent 60%),
                radial-gradient(760px 420px at 100% 0%, rgba(248, 90, 173, .10), transparent 62%);"
                :style="darkMode.isDark ? '' : 'background: radial-gradient(900px 420px at 12% -8%, rgba(59, 130, 246, .08), transparent 60%), radial-gradient(760px 420px at 100% 0%, rgba(236, 72, 153, .06), transparent 62%)'">
            </div>

            <div class="relative z-[9999] w-full pt-4 px-4 sm:px-6 pointer-events-none flex justify-center">
                <header class="inline-flex max-w-full rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.12)] border transition-colors duration-300 pointer-events-auto text-left" 
                style="backdrop-filter:blur(12px);" 
                :style="darkMode.isDark ? 'background:rgba(15,19,28,.85);border-color:rgba(69,86,126,.3)' : 'background:rgba(255,255,255,.95);border-color:rgba(226,232,240,.8)'">
                    <div class="px-6 md:px-10 h-16 flex items-center justify-center" style="gap: 170px;">
                        
                        <!-- Left: Logo -->
                        <div class="flex-shrink-0 flex items-center gap-4">
                            <a href="{{ route('dashboard') }}" class="logo-container flex items-center gap-2" id="buddleLogo" 
                            :style="darkMode.isDark ? 'color:#f0f5ff' : 'color:#111827'">
                                <div class="logo-image-wrapper">
                                    <img src="/images/buddle-logo.svg" alt="Buddle Logo" class="logo-image block h-8 w-auto" style="filter: brightness(0) invert(1);" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <svg class="logo-image block h-8 w-auto logo-fallback" style="color:#9fb2f7; display:none;" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                        <text x="20" y="28" text-anchor="middle" fill="currentColor" font-size="20" font-weight="bold">B</text>
                                        <circle cx="20" cy="20" r="18" fill="none" stroke="currentColor" stroke-width="1" opacity="0.3"/>
                                    </svg>
                                </div>
                                <span class="logo-text text-[15px] tracking-[0.05em] font-bold">Buddle</span>
                            </a>
                            
                            <!-- Streak / Guest Mode -->
                            @auth
                                <div class="hidden md:flex items-center gap-2 px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase ml-2" 
                                     style="background:rgba(74, 158, 255, 0.1);"
                                     :style="darkMode.isDark ? 'color:#74a0ff' : 'color:#2563eb'">
                                    <span>🔥 {{ Auth::user()->streak_count ?? 0 }} Day Streak</span>
                                </div>
                            @endauth
                        </div>

                        <!-- Center: Navigation Links -->
                        <div class="hidden md:flex items-center justify-center gap-6 text-sm font-semibold">
                            @if(!request()->routeIs('dashboard'))
                                <a href="{{ route('dashboard') }}" class="nav-item inline-block transition-colors px-3 py-2 rounded-lg" 
                                :style="darkMode.isDark ? 'color:#cbd5e1' : 'color:#475569'" onmouseover="this.style.color=darkMode.isDark?'#fff':'#000'" onmouseout="this.style.color=darkMode.isDark?'#cbd5e1':'#475569'">Timer</a>
                            @endif
                            @auth
                                <a href="{{ route('history') }}" class="nav-item inline-block transition-colors px-3 py-2 rounded-lg" 
                                :style="darkMode.isDark ? 'color:#cbd5e1' : 'color:#475569'" onmouseover="this.style.color=darkMode.isDark?'#fff':'#000'" onmouseout="this.style.color=darkMode.isDark?'#cbd5e1':'#475569'">History</a>
                                <a href="{{ route('analytics') }}" class="nav-item inline-block transition-colors px-3 py-2 rounded-lg" 
                                :style="darkMode.isDark ? 'color:#cbd5e1' : 'color:#475569'" onmouseover="this.style.color=darkMode.isDark?'#fff':'#000'" onmouseout="this.style.color=darkMode.isDark?'#cbd5e1':'#475569'">Analytics</a>
                                <a href="{{ route('credits') }}" class="nav-item inline-block transition-colors px-3 py-2 rounded-lg cursor-pointer" 
                                :style="darkMode.isDark ? 'color:#cbd5e1' : 'color:#475569'" onmouseover="this.style.color=darkMode.isDark?'#fff':'#000'" onmouseout="this.style.color=darkMode.isDark?'#cbd5e1':'#475569'">Credits</a>
                            @else
                                <a href="{{ route('login') }}" class="nav-item inline-block transition-colors px-3 py-2 rounded-lg opacity-50" 
                                :style="darkMode.isDark ? 'color:#cbd5e1' : 'color:#475569'">History🔒</a>
                            @endauth
                        </div>

                        <!-- Right: Actions & Theme -->
                        <div class="flex items-center gap-4 text-sm font-semibold">
                            <!-- Theme Toggle -->
                            <button @click="$store.darkMode.toggle()" 
                                    class="p-2 rounded-full transition-colors hover:bg-gray-100 dark:hover:bg-gray-800"
                                    :style="darkMode.isDark ? 'color:#cbd5e1' : 'color:#475569'"
                                    :title="$store.darkMode.isDark ? 'Switch to light mode' : 'Switch to dark mode'">
                                <svg x-show="$store.darkMode.isDark" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <svg x-show="!$store.darkMode.isDark" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </button>

                            <!-- Vertical Divider -->
                            <div class="h-6 w-px" :style="darkMode.isDark ? 'background:rgba(255,255,255,0.1)' : 'background:rgba(0,0,0,0.1)'"></div>

                            <!-- CTA Button -->
                            @auth
                                <form method="POST" action="{{ route('logout') }}" class="inline-block m-0 p-0">
                                    @csrf
                                    <button type="submit" class="nav-item block px-5 py-2 rounded-full transition-transform" 
                                            :style="darkMode.isDark ? 'background:#e4e8f5;color:#0f172a' : 'background:#0f172a;color:#ffffff'">
                                        Log Out
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="nav-item inline-block px-5 py-2 rounded-full transition-transform" 
                                   :style="darkMode.isDark ? 'background:#e4e8f5;color:#0f172a' : 'background:#0f172a;color:#ffffff'">
                                    Get Started
                                </a>
                            @endauth
                        </div>

                    </div>
                </header>
            </div>

            <main class="relative z-[2] pt-16">
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

        /* Credits Modal Styles */
        .glass-button {
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .glass-button:hover {
            transform: scale(1.1);
        }

        .floating-emoji {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-5px) rotate(5deg); }
        }

        .team-card {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .team-card:hover {
            transform: translateY(-5px);
        }

        .team-emoji {
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
        }

        .font-black {
            font-weight: 900;
        }
    </style>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Logo Buddle animation with anime.js
        const logoContainer = document.getElementById('buddleLogo');
        const logoImage = logoContainer?.querySelector('.logo-image');
        const logoText = logoContainer?.querySelector('.logo-text');
        
        // Credits modal animations
        window.modalEnter = function(el, done) {
            anime({
                targets: el,
                scale: [0, 0.8, 1.2, 1],
                rotate: [0, 180, 360, 0],
                opacity: [0, 1],
                duration: 800,
                easing: 'easeOutElastic(1, .5)',
                complete: done
            });
            
            // Animate background
            anime({
                targets: el,
                background: [
                    {value: 'rgba(21, 24, 32, 0)', duration: 0},
                    {value: 'rgba(21, 24, 32, 0.95)', duration: 400},
                    {value: 'rgba(21, 24, 32, 1)', duration: 400}
                ],
                duration: 800,
                easing: 'easeOutQuad'
            });
            
            // Animate team members with stagger
            const teamMembers = el.querySelectorAll('.team-member');
            anime({
                targets: teamMembers,
                translateY: [50, 0],
                opacity: [0, 1],
                scale: [0.8, 1],
                delay: anime.stagger(100, {start: 300}),
                duration: 600,
                easing: 'easeOutBack'
            });
            
            // Animate floating emojis
            const emojis = el.querySelectorAll('.team-member div:first-child');
            anime({
                targets: emojis,
                scale: [0, 1.3, 1],
                rotate: [0, 360],
                delay: anime.stagger(50, {start: 200}),
                duration: 800,
                easing: 'easeOutElastic(1, .5)'
            });
        };
        
        window.modalLeave = function(el, done) {
            anime({
                targets: el,
                scale: [1, 1.1, 0],
                opacity: [1, 0],
                rotate: [0, -10],
                duration: 500,
                easing: 'easeInBack',
                complete: done
            });
        };
        
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


    </script>

    <!-- Credits Modal -->
    <div x-show="showCredits" x-cloak 
         x-transition:enter="modalEnter"
         x-transition:leave="modalLeave"
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="background: rgba(0, 0, 0, 0.8); backdrop-filter: blur(4px);">
        
        <div @click.away="showCredits = false" 
             class="relative max-w-4xl w-full max-h-[90vh] overflow-y-auto credits-modal"
             :style="darkMode.isDark ? 'background: linear-gradient(135deg, #151820, #0a0f1d); border: 1px solid #1e2330; border-radius: 24px; padding: 0;' : 'background: linear-gradient(135deg, #ffffff, #f8fafc); border: 1px solid #e2e8f0; border-radius: 24px; padding: 0;'">
            
            <!-- Glass morphism background -->
            <div class="absolute inset-0 rounded-2xl opacity-50"
                 :style="darkMode.isDark ? 'background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05))' : 'background: linear-gradient(135deg, rgba(0,0,0,0.02), rgba(0,0,0,0.01))'">
            </div>
            
            <!-- Close Button -->
            <button @click="showCredits = false" 
                    class="absolute top-6 right-6 w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 glass-button"
                    :style="darkMode.isDark ? 'background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #e4e8f5' : 'background: rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.1); color: #03045e'"
                    onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 8px 32px rgba(74,158,255,0.3)'"
                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none'">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>

            <!-- Modal Content -->
            <div class="relative z-10 p-8">
                <!-- Modal Header -->
                <div class="text-center mb-10">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl flex items-center justify-center text-4xl floating-emoji"
                         :style="darkMode.isDark ? 'background: linear-gradient(135deg, rgba(74,158,255,0.2), rgba(74,158,255,0.1)); border: 2px solid rgba(74,158,255,0.3)' : 'background: linear-gradient(135deg, rgba(3,4,94,0.1), rgba(3,4,94,0.05)); border: 2px solid rgba(3,4,94,0.2)'">
                        🎯
                    </div>
                    <h2 class="text-3xl font-black mb-3 tracking-tight"
                         :style="darkMode.isDark ? 'background: linear-gradient(135deg, #74a0ff, #4ade80); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;' : 'background: linear-gradient(135deg, #03045e, #64748b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;'">
                        Meet Our Team
                    </h2>
                    <p class="text-lg opacity-80 max-w-md mx-auto"
                         :style="darkMode.isDark ? 'color: #9ca3af' : 'color: #64748b'">The brilliant minds behind ProjekTimer</p>
                </div>

                <!-- Team Members Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-10">
                    <!-- Team Member 1 -->
                    <div class="team-card relative overflow-hidden group"
                         :style="darkMode.isDark ? 'background: linear-gradient(135deg, rgba(74,158,255,0.1), rgba(74,158,255,0.05)); border: 1px solid rgba(74,158,255,0.2); border-radius: 20px' : 'background: linear-gradient(135deg, rgba(3,4,94,0.05), rgba(3,4,94,0.02)); border: 1px solid rgba(3,4,94,0.1); border-radius: 20px'">
                        
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mr-4 team-emoji"
                                     :style="darkMode.isDark ? 'background: rgba(74,158,255,0.2)' : 'background: rgba(3,4,94,0.1)'">
                                    👨‍💻
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold mb-1"
                                         :style="darkMode.isDark ? 'color: #e4e8f5' : 'color: #03045e'">Rusdiansyah Alief Prasetya</h3>
                                    <p class="text-sm font-medium opacity-90"
                                         :style="darkMode.isDark ? 'color: #74a0ff' : 'color: #03045e'">Full-Stack Developer</p>
                                </div>
                            </div>
                            <p class="text-sm opacity-70 leading-relaxed"
                                 :style="darkMode.isDark ? 'color: #9ca3af' : 'color: #64748b'">Backend development, API design, and system architecture</p>
                        </div>
                        
                        <!-- Hover effect -->
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"
                             :style="darkMode.isDark ? 'background: linear-gradient(135deg, rgba(74,158,255,0.15), rgba(74,158,255,0.08))' : 'background: linear-gradient(135deg, rgba(3,4,94,0.08), rgba(3,4,94,0.03))'">
                        </div>
                    </div>

                    <!-- Team Member 2 -->
                    <div class="team-card relative overflow-hidden group"
                         :style="darkMode.isDark ? 'background: linear-gradient(135deg, rgba(74,158,255,0.1), rgba(74,158,255,0.05)); border: 1px solid rgba(74,158,255,0.2); border-radius: 20px' : 'background: linear-gradient(135deg, rgba(3,4,94,0.05), rgba(3,4,94,0.02)); border: 1px solid rgba(3,4,94,0.1); border-radius: 20px'">
                        
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mr-4 team-emoji"
                                     :style="darkMode.isDark ? 'background: rgba(74,158,255,0.2)' : 'background: rgba(3,4,94,0.1)'">
                                    👩‍💻
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold mb-1"
                                         :style="darkMode.isDark ? 'color: #e4e8f5' : 'color: #03045e'">Aisha Maryam</h3>
                                    <p class="text-sm font-medium opacity-90"
                                         :style="darkMode.isDark ? 'color: #74a0ff' : 'color: #03045e'">Frontend Developer</p>
                                </div>
                            </div>
                            <p class="text-sm opacity-70 leading-relaxed"
                                 :style="darkMode.isDark ? 'color: #9ca3af' : 'color: #64748b'">UI/UX design, interactive components, and user experience</p>
                        </div>
                        
                        <!-- Hover effect -->
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"
                             :style="darkMode.isDark ? 'background: linear-gradient(135deg, rgba(74,158,255,0.15), rgba(74,158,255,0.08))' : 'background: linear-gradient(135deg, rgba(3,4,94,0.08), rgba(3,4,94,0.03))'">
                        </div>
                    </div>

                    <!-- Team Member 3 -->
                    <div class="team-card relative overflow-hidden group"
                         :style="darkMode.isDark ? 'background: linear-gradient(135deg, rgba(74,158,255,0.1), rgba(74,158,255,0.05)); border: 1px solid rgba(74,158,255,0.2); border-radius: 20px' : 'background: linear-gradient(135deg, rgba(3,4,94,0.05), rgba(3,4,94,0.02)); border: 1px solid rgba(3,4,94,0.1); border-radius: 20px'">
                        
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mr-4 team-emoji"
                                     :style="darkMode.isDark ? 'background: rgba(74,158,255,0.2)' : 'background: rgba(3,4,94,0.1)'">
                                    👩‍🔬
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold mb-1"
                                         :style="darkMode.isDark ? 'color: #e4e8f5' : 'color: #03045e'">Anindhita Faiza</h3>
                                    <p class="text-sm font-medium opacity-90"
                                         :style="darkMode.isDark ? 'color: #74a0ff' : 'color: #03045e'">Data Science Developer</p>
                                </div>
                            </div>
                            <p class="text-sm opacity-70 leading-relaxed"
                                 :style="darkMode.isDark ? 'color: #9ca3af' : 'color: #64748b'">Chronotype algorithms, data analysis, and analytics implementation</p>
                        </div>
                        
                        <!-- Hover effect -->
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"
                             :style="darkMode.isDark ? 'background: linear-gradient(135deg, rgba(74,158,255,0.15), rgba(74,158,255,0.08))' : 'background: linear-gradient(135deg, rgba(3,4,94,0.08), rgba(3,4,94,0.03))'">
                        </div>
                    </div>

                    <!-- Team Member 4 -->
                    <div class="team-card relative overflow-hidden group"
                         :style="darkMode.isDark ? 'background: linear-gradient(135deg, rgba(74,158,255,0.1), rgba(74,158,255,0.05)); border: 1px solid rgba(74,158,255,0.2); border-radius: 20px' : 'background: linear-gradient(135deg, rgba(3,4,94,0.05), rgba(3,4,94,0.02)); border: 1px solid rgba(3,4,94,0.1); border-radius: 20px'">
                        
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mr-4 team-emoji"
                                     :style="darkMode.isDark ? 'background: rgba(74,158,255,0.2)' : 'background: rgba(3,4,94,0.1)'">
                                    👩‍💻
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold mb-1"
                                         :style="darkMode.isDark ? 'color: #e4e8f5' : 'color: #03045e'">Shafa Rizwana Zarin</h3>
                                    <p class="text-sm font-medium opacity-90"
                                         :style="darkMode.isDark ? 'color: #74a0ff' : 'color: #03045e'">Full-Stack Developer</p>
                                </div>
                            </div>
                            <p class="text-sm opacity-70 leading-relaxed"
                                 :style="darkMode.isDark ? 'color: #9ca3af' : 'color: #64748b'">Frontend-backend integration, database design, and feature development</p>
                        </div>
                        
                        <!-- Hover effect -->
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"
                             :style="darkMode.isDark ? 'background: linear-gradient(135deg, rgba(74,158,255,0.15), rgba(74,158,255,0.08))' : 'background: linear-gradient(135deg, rgba(3,4,94,0.08), rgba(3,4,94,0.03))'">
                        </div>
                    </div>
                </div>

                <!-- Project Info -->
                <div class="relative overflow-hidden rounded-2xl p-6"
                     :style="darkMode.isDark ? 'background: linear-gradient(135deg, rgba(74,158,255,0.15), rgba(74,158,255,0.08)); border: 1px solid rgba(74,158,255,0.3)' : 'background: linear-gradient(135deg, rgba(3,4,94,0.08), rgba(3,4,94,0.03)); border: 1px solid rgba(3,4,94,0.2)'">
                    
                    <div class="text-center">
                        <h3 class="text-2xl font-bold mb-3"
                             :style="darkMode.isDark ? 'color: #74a0ff' : 'color: #03045e'">ProjekTimer</h3>
                        <p class="text-base mb-4 opacity-90"
                             :style="darkMode.isDark ? 'color: #e4e8f5' : 'color: #03045e'">A smart study timer application with personalized chronotype recommendations</p>
                        <div class="flex items-center justify-center space-x-4 text-sm opacity-80"
                             :style="darkMode.isDark ? 'color: #9ca3af' : 'color: #64748b'">
                            <span>🚀 Built with Laravel</span>
                            <span>⚡ Alpine.js</span>
                            <span>🎨 Modern Web Technologies</span>
                        </div>
                    </div>
                    
                    <!-- Decorative gradient -->
                    <div class="absolute inset-0 opacity-30 pointer-events-none"
                         :style="darkMode.isDark ? 'background: linear-gradient(45deg, transparent, rgba(74,158,255,0.1), transparent)' : 'background: linear-gradient(45deg, transparent, rgba(3,4,94,0.05), transparent)'">
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center pt-6 border-t"
                     :style="darkMode.isDark ? 'border-color: rgba(255,255,255,0.1)' : 'border-color: rgba(0,0,0,0.05)'">
                    <p class="text-sm opacity-70"
                         :style="darkMode.isDark ? 'color: #9ca3af' : 'color: #64748b'">
                        © 2024 ProjekTimer Team. Made with ❤️ for better study habits.
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    
    <script type="module">
    import { animate, stagger } from 'https://esm.sh/animejs@4.0.0-beta.88';

    document.addEventListener('DOMContentLoaded', () => {
        // ==========================================
        // Human-made Interactive Navbar Links (AnimeJS v4)
        // ==========================================
        const navItems = document.querySelectorAll('.nav-item');
        
        // Staggered entrance animation for navbar links
        animate(navItems, {
            y: [-20, 0],
            opacity: [0, 1],
            delay: stagger(100, { start: 500 }),
            duration: 800,
            ease: 'outElastic(1, .6)'
        });

        // Hover animations using v4 syntax
        navItems.forEach(item => {
            // Create a subtle magnetic effect on mousemove
            item.addEventListener('mousemove', (e) => {
                const rect = item.getBoundingClientRect();
                const xOffset = e.clientX - rect.left - rect.width / 2;
                const yOffset = e.clientY - rect.top - rect.height / 2;
                
                if (item.animHover) item.animHover.pause();
                item.animHover = animate(item, {
                    x: xOffset * 0.15,
                    y: yOffset * 0.15,
                    scale: 1.05,
                    duration: 50,
                    ease: 'outQuad'
                });
            });

            // Enter: organic elastic scale up
            item.addEventListener('mouseenter', () => {
                if (item.animHover) item.animHover.pause();
                item.animHover = animate(item, {
                    scale: 1.05,
                    y: -2,
                    rotate: (Math.random() * 2 - 1), // random subtle rotation
                    duration: 800,
                    ease: 'outElastic(1.2, .5)'
                });
            });

            // Leave: spring back to normal
            item.addEventListener('mouseleave', () => {
                if (item.animHover) item.animHover.pause();
                item.animHover = animate(item, {
                    x: 0,
                    y: 0,
                    scale: 1,
                    rotate: 0,
                    duration: 600,
                    ease: 'outElastic(1, .5)'
                });
            });

            // Click: squish effect
            item.addEventListener('mousedown', () => {
                if (item.animHover) item.animHover.pause();
                item.animHover = animate(item, {
                    scale: 0.95,
                    duration: 100,
                    ease: 'outQuad'
                });
            });
            
            item.addEventListener('mouseup', () => {
                if (item.animHover) item.animHover.pause();
                item.animHover = animate(item, {
                    scale: 1.05,
                    duration: 600,
                    ease: 'outElastic(1, .5)'
                });
            });
        });
    });
    </script>
    </body>
</html>
