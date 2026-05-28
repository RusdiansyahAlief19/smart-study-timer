<section>
    <header class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-lg font-medium" style="color: var(--col-text)">
                {{ __('Your Level & Experience') }}
            </h2>
            <p class="mt-1 text-sm" style="color: var(--col-subtle)">
                {{ __('Keep studying to level up and unlock new ranks.') }}
            </p>
        </div>
        <div class="text-right">
            <span class="inline-flex items-center justify-center px-4 py-2 text-sm font-bold uppercase tracking-wider rounded-full shadow-sm" style="background: var(--accent-dim); color: var(--accent); border: 1px solid rgba(74, 158, 255, 0.2);">
                Level {{ $user->level }}
            </span>
        </div>
    </header>

    <div class="mt-6">
        <div class="flex justify-between items-end mb-2">
            <div>
                <p class="text-2xl font-bold" style="color: var(--col-text);">
                    {{ $levelTitle }}
                </p>
            </div>
            <div class="text-sm font-semibold" style="color: var(--col-subtle);">
                <span style="color: var(--col-text);">{{ number_format($currentXP) }}</span> / {{ number_format($nextLevelBaseXP) }} XP
            </div>
        </div>
        
        <!-- Progress Bar -->
        <div class="w-full rounded-full h-3.5 mb-4" style="background: var(--col-border); overflow: hidden;">
            <div class="h-3.5 rounded-full transition-all duration-1000 ease-out relative" 
                 style="background: linear-gradient(90deg, var(--accent) 0%, #60a5fa 100%); width: {{ $xpProgress }}%;">
                 <div class="absolute top-0 left-0 right-0 bottom-0 opacity-30" style="background-image: linear-gradient(45deg, rgba(255,255,255,.15) 25%, transparent 25%, transparent 50%, rgba(255,255,255,.15) 50%, rgba(255,255,255,.15) 75%, transparent 75%, transparent); background-size: 1rem 1rem;"></div>
            </div>
        </div>
        
        <p class="text-sm text-center" style="color: var(--col-subtle);">
            @if($xpProgress >= 100)
                {{ __('You are ready to level up! Complete a session to rank up.') }}
            @else
                {{ number_format($nextLevelBaseXP - $currentXP) }} {{ __('XP needed for next level') }}
            @endif
        </p>
    </div>
</section>
