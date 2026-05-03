<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b" style="background:rgba(13,15,20,.9);border-color:#1e2330;backdrop-filter:blur(10px);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <!-- Logo Buddle - Ganti dengan logo kamu -->
                    <img src="/images/buddle-logo.svg" alt="Buddle Logo" class="block h-8 w-auto" style="filter: brightness(0) invert(1);" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <!-- Fallback SVG sementara -->
                    <svg class="block h-8 w-auto" style="color:#9fb2f7; display:none;" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                        <text x="20" y="28" text-anchor="middle" fill="currentColor" font-size="20" font-weight="bold">B</text>
                        <circle cx="20" cy="20" r="18" fill="none" stroke="currentColor" stroke-width="1" opacity="0.3"/>
                    </svg>
                    <span class="font-semibold text-sm tracking-wide" style="color:#e4e8f5;">Buddle</span>
                </a>
            </div>

            <div class="hidden md:flex items-center gap-2">
                @if(!request()->routeIs('dashboard'))
                <a href="{{ route('dashboard') }}"
                   class="px-3 py-2 text-sm rounded-lg transition border border-transparent text-slate-300 hover:text-white hover:bg-slate-800">
                    Focus
                </a>
                @endif
                <a href="{{ route('history') }}"
                   class="px-3 py-2 text-sm rounded-lg transition border {{ request()->routeIs('history') ? 'bg-blue-500/20 border-blue-400 text-blue-200' : 'border-transparent text-slate-300 hover:text-white hover:bg-slate-800' }}">
                    History
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="px-3 py-2 text-sm rounded-lg transition border {{ request()->routeIs('profile.*') ? 'bg-blue-500/20 border-blue-400 text-blue-200' : 'border-transparent text-slate-300 hover:text-white hover:bg-slate-800' }}">
                    Profile
                </a>
            </div>

            <div class="hidden md:flex items-center gap-3">
                @auth
                <div class="text-right">
                    <p class="text-xs font-semibold" style="color:#e4e8f5;">{{ Auth::user()->name }}</p>
                    <p class="text-[11px]" style="color:#6b7394;">{{ Auth::user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-3 py-2 rounded-lg text-xs border transition" style="border-color:#2d3447;color:#9fb2f7;">
                        Log Out
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="px-3 py-2 rounded-lg text-xs border transition" style="border-color:#2d3447;color:#9fb2f7;">
                    Sign In
                </a>
                @endauth
            </div>

            <div class="md:hidden">
                <button @click="open = !open" class="p-2 rounded-md border" style="border-color:#2d3447;color:#9fb2f7;">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden border-t" style="border-color:#1e2330;">
        <div class="px-4 py-3 space-y-2">
            @if(!request()->routeIs('dashboard'))
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm text-slate-300">Focus</a>
            @endif
            <a href="{{ route('history') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('history') ? 'bg-blue-500/20 text-blue-200' : 'text-slate-300' }}">History</a>
            @auth
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('profile.*') ? 'bg-blue-500/20 text-blue-200' : 'text-slate-300' }}">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-sm text-rose-300">Log Out</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg text-sm text-slate-300">Sign In</a>
            @endauth
        </div>
    </div>
</nav>
