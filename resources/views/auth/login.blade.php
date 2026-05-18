<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-2">Welcome Back</h2>
        <p class="text-gray-400 text-sm">Sign in to continue your focus journey</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="relative group">
            <label for="email" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 ml-4">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                   class="w-full bg-gray-900/60 border border-gray-700/50 rounded-full px-5 py-3 text-gray-200 placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 hover:border-blue-500/50 hover:bg-gray-800/80 transition-all duration-300 shadow-inner"
                   placeholder="you@example.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs ml-4" />
        </div>

        <!-- Password -->
        <div class="relative group">
            <div class="flex justify-between items-center mb-2 ml-4 mr-4">
                <label for="password" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-blue-400 hover:text-blue-300 hover:underline transition-all">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full bg-gray-900/60 border border-gray-700/50 rounded-full px-5 py-3 text-gray-200 placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 hover:border-blue-500/50 hover:bg-gray-800/80 transition-all duration-300 shadow-inner"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs ml-4" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center ml-2">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="w-5 h-5 rounded-full border-gray-600/50 bg-gray-900/60 text-blue-500 focus:ring-2 focus:ring-blue-500/50 focus:ring-offset-0 cursor-pointer transition-all duration-300 mr-3 shadow-inner group-hover:border-blue-400 group-hover:shadow-[0_0_10px_rgba(59,130,246,0.3)]" name="remember">
                <span class="text-sm font-medium text-gray-400 group-hover:text-blue-300 transition-colors duration-300">Remember me</span>
            </label>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full relative overflow-hidden group bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-600 bg-[length:200%_auto] hover:bg-right text-white font-bold py-3.5 px-6 rounded-full shadow-[0_4px_20px_rgba(37,99,235,0.4)] hover:shadow-[0_8px_30px_rgba(37,99,235,0.6)] transition-all duration-500 transform hover:-translate-y-1 active:translate-y-0">
                <span class="relative z-10 flex items-center justify-center gap-2">
                    Log In to Dashboard
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </span>
                <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out rounded-full"></div>
            </button>
        </div>

        @if (Route::has('register'))
            <div class="text-center mt-8">
                <p class="text-sm text-gray-400 font-medium">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-blue-400 font-bold hover:text-blue-300 transition-all relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-blue-400 hover:after:w-full after:transition-all after:duration-300 ml-1">Sign up here</a>
                </p>
            </div>
        @endif
    </form>
</x-guest-layout>
