<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-2">Forgot Password</h2>
        <p class="text-gray-400 text-sm px-4">No problem. Just let us know your email address and we will email you a password reset link.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-green-400 text-sm text-center" :status="session('status')" />

    @if (session('reset_link_preview'))
        <div class="mb-6 rounded-3xl border border-amber-500/30 bg-amber-500/10 p-5 text-sm text-amber-200 backdrop-blur-sm shadow-[0_0_15px_rgba(245,158,11,0.15)] relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-r from-amber-500/0 via-amber-500/10 to-amber-500/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000 ease-in-out"></div>
            <div class="relative z-10 flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="font-bold tracking-wider text-xs uppercase text-amber-400">Development Preview</p>
            </div>
            <a href="{{ session('reset_link_preview') }}" class="relative z-10 mt-2 block break-all text-amber-300 hover:text-amber-100 hover:underline transition-colors bg-amber-900/40 rounded-xl p-3 border border-amber-500/20">
                {{ session('reset_link_preview') }}
            </a>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="relative group">
            <label for="email" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 ml-4">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                   class="w-full bg-gray-900/60 border border-gray-700/50 rounded-full px-5 py-3 text-gray-200 placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 hover:border-blue-500/50 hover:bg-gray-800/80 transition-all duration-300 shadow-inner"
                   placeholder="you@example.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs ml-4" />
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full relative overflow-hidden group bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-600 bg-[length:200%_auto] hover:bg-right text-white font-bold py-3.5 px-6 rounded-full shadow-[0_4px_20px_rgba(37,99,235,0.4)] hover:shadow-[0_8px_30px_rgba(37,99,235,0.6)] transition-all duration-500 transform hover:-translate-y-1 active:translate-y-0">
                <span class="relative z-10 flex items-center justify-center gap-2">
                    Send Reset Link
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </span>
                <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out rounded-full"></div>
            </button>
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-400 hover:text-blue-300 transition-colors inline-flex items-center gap-1 group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to Login
            </a>
        </div>
    </form>
</x-guest-layout>
