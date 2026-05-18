<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ProjekTimer') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased" style="font-family:'Inter',sans-serif;background:#0d0f14;color:#e4e8f5;">
        <div class="min-h-screen relative flex flex-col justify-center items-center overflow-hidden px-4" style="background:#0d0f14;">
            
            <!-- Ambient Background Gradients -->
            <div style="position:absolute;inset:0;pointer-events:none;background:
                radial-gradient(900px 420px at 12% -8%, rgba(76, 128, 255, .17), transparent 60%),
                radial-gradient(760px 420px at 100% 0%, rgba(248, 90, 173, .10), transparent 62%);">
            </div>

            <!-- Subtle Grid Background -->
            <div class="absolute inset-0 z-0 opacity-20 pointer-events-none" style="background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px); background-size: 30px 30px;"></div>

            <!-- Logo Area -->
            <div class="relative z-10 mb-8 auth-logo" style="transform: translateY(-20px);">
                <a href="/" class="flex flex-col items-center gap-3 transition-transform hover:scale-105">
                    <img src="/images/buddle-logo.svg" alt="Buddle Logo" class="h-14 w-auto" style="filter: brightness(0) invert(1) drop-shadow(0 0 10px rgba(74, 158, 255, 0.5));" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <div style="display:none;" class="w-14 h-14 rounded-full bg-blue-500/20 border border-blue-400/30 flex items-center justify-center text-blue-400 font-bold text-2xl shadow-[0_0_15px_rgba(59,130,246,0.3)]">
                        B
                    </div>
                    <span class="logo-buddle-text text-3xl font-black tracking-wider" style="display:inline-block; background: linear-gradient(135deg, #f0f5ff, #74a0ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Buddle</span>
                </a>
            </div>

            <!-- Glassmorphism Card Container -->
            <div class="relative z-10 w-full sm:max-w-md px-8 py-10 overflow-hidden sm:rounded-[2rem] rounded-3xl shadow-[0_8px_32px_rgba(0,0,0,0.4)] border border-[rgba(255,255,255,0.08)] auth-card"
                 style="background: linear-gradient(145deg, rgba(20,25,35,0.7), rgba(15,19,28,0.9)); backdrop-filter:blur(20px); -webkit-backdrop-filter:blur(20px); transform: translateY(20px);">
                {{ $slot }}
            </div>
            
            <!-- Footer text -->
            <div class="relative z-10 mt-8 text-center text-xs opacity-50 auth-footer">
                &copy; {{ date('Y') }} ProjekTimer Team. Focus better.
            </div>
        </div>

        <!-- Stable Anime.js v3 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                
                // 1. Manually Split Text for Logo Bounce
                const logoText = document.querySelector('.logo-buddle-text');
                if(logoText) {
                    const text = logoText.textContent;
                    logoText.innerHTML = '';
                    for(let i=0; i < text.length; i++) {
                        const span = document.createElement('span');
                        span.textContent = text[i] === ' ' ? '\u00A0' : text[i];
                        span.style.display = 'inline-block';
                        logoText.appendChild(span);
                    }

                    // 2. Animate Characters (Replicating user's v4 logic)
                    anime({
                        targets: '.logo-buddle-text span',
                        translateY: [
                            { value: '-1.5rem', easing: 'easeOutExpo', duration: 600 },
                            { value: 0, easing: 'easeOutBounce', duration: 800, delay: 100 }
                        ],
                        rotate: [
                            { value: '-1turn', duration: 0 },
                            { value: '0turn', duration: 1400, easing: 'easeOutExpo' }
                        ],
                        delay: anime.stagger(50, { start: 1000 }),
                        easing: 'easeInOutCirc',
                        loop: true,
                        loopDelay: 2000
                    });
                }

                // Entrance animations
                anime({
                    targets: '.auth-logo',
                    translateY: [20, 0],
                    opacity: [0, 1],
                    duration: 1000,
                    easing: 'easeOutElastic(1, .6)',
                    delay: 200
                });

                anime({
                    targets: '.auth-card',
                    translateY: [30, 0],
                    opacity: [0, 1],
                    duration: 1000,
                    easing: 'easeOutElastic(1, .8)',
                    delay: 400
                });
                
                anime({
                    targets: '.auth-footer',
                    opacity: [0, 0.5],
                    duration: 1000,
                    easing: 'linear',
                    delay: 800
                });
            });
        </script>
    </body>
</html>
