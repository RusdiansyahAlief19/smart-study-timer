<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b dark:bg-gray-900/90 dark:border-gray-700 bg-white/90 border-gray-200" style="backdrop-filter:blur(10px);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <!-- Logo Buddle - Ganti dengan logo kamu -->
                    <img src="/images/buddle-logo.svg" alt="Buddle Logo" class="block h-8 w-auto dark:invert" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <!-- Fallback SVG sementara -->
                    <svg class="block h-8 w-auto dark:text-blue-400 text-blue-600" style="display:none;" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                        <text x="20" y="28" text-anchor="middle" fill="currentColor" font-size="20" font-weight="bold">B</text>
                        <circle cx="20" cy="20" r="18" fill="none" stroke="currentColor" stroke-width="1" opacity="0.3"/>
                    </svg>
                    <h2 class="logo-buddle-text font-semibold text-sm tracking-wide dark:text-gray-200 text-gray-900 m-0 p-0" style="display:inline-block;">Buddle</h2>
                </a>
            </div>

            <div class="hidden md:flex items-center gap-2">
                @if(!request()->routeIs('dashboard'))
                <a href="{{ route('dashboard') }}"
                   class="px-3 py-2 text-sm rounded-lg transition border border-transparent dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800 text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                    Focus
                </a>
                @endif
                <a href="{{ route('history') }}"
                   class="px-3 py-2 text-sm rounded-lg transition border {{ request()->routeIs('history') ? 'bg-blue-500/20 border-blue-400 text-blue-200 dark:bg-blue-500/20 dark:border-blue-400 dark:text-blue-200' : 'border-transparent dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800 text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                    History
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="px-3 py-2 text-sm rounded-lg transition border {{ request()->routeIs('profile.*') ? 'bg-blue-500/20 border-blue-400 text-blue-200 dark:bg-blue-500/20 dark:border-blue-400 dark:text-blue-200' : 'border-transparent dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800 text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                    Profile
                </a>
            </div>

            <div class="hidden md:flex items-center gap-3">
                <!-- Theme Toggle Button -->
                <button @click="$store.darkMode.toggle()" 
                        class="p-2 rounded-lg border transition dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800 border-gray-300 text-gray-600 hover:bg-gray-100"
                        :title="$store.darkMode.isDark ? 'Switch to light mode' : 'Switch to dark mode'">
                    <svg x-show="$store.darkMode.isDark" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <svg x-show="!$store.darkMode.isDark" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>
                
                @auth
                <div class="text-right">
                    <p class="text-xs font-semibold dark:text-gray-200 text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] dark:text-gray-400 text-gray-500">{{ Auth::user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-3 py-2 rounded-lg text-xs border transition dark:border-gray-600 dark:text-blue-400 dark:hover:bg-gray-800 border-gray-300 text-blue-600 hover:bg-gray-100">
                        Log Out
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="px-3 py-2 rounded-lg text-xs border transition dark:border-gray-600 dark:text-blue-400 dark:hover:bg-gray-800 border-gray-300 text-blue-600 hover:bg-gray-100">
                    Sign In
                </a>
                @endauth
            </div>

            <div class="md:hidden">
                <button @click="open = !open" class="p-2 rounded-md border dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800 border-gray-300 text-gray-600 hover:bg-gray-100">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden border-t dark:border-gray-700 border-gray-200">
        <div class="px-4 py-3 space-y-2">
            @if(!request()->routeIs('dashboard'))
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm dark:text-gray-300 text-gray-600">Focus</a>
            @endif
            <a href="{{ route('history') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('history') ? 'bg-blue-500/20 text-blue-200 dark:bg-blue-500/20 dark:text-blue-200' : 'dark:text-gray-300 text-gray-600' }}">History</a>
            @auth
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('profile.*') ? 'bg-blue-500/20 text-blue-200 dark:bg-blue-500/20 dark:text-blue-200' : 'dark:text-gray-300 text-gray-600' }}">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-sm dark:text-red-300 text-red-600">Log Out</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg text-sm dark:text-gray-300 text-gray-600">Sign In</a>
            @endauth
        </div>
    </div>
</nav>

<script type="module">
import { animate, stagger, splitText } from 'https://esm.sh/animejs@4.0.0-beta.88';

document.addEventListener('DOMContentLoaded', () => {
    const { chars } = splitText('.logo-buddle-text', { words: false, chars: true });

    animate(chars, {
        y: [
            { to: '-0.75rem', ease: 'outExpo', duration: 600 },
            { to: 0, ease: 'outBounce', duration: 800, delay: 100 }
        ],
        rotate: {
            from: '-1turn',
            delay: 0
        },
        delay: stagger(50),
        ease: 'inOutCirc',
        loopDelay: 1000,
        loop: true
    });
});
</script>
