<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-2">Create Account</h2>
        <p class="text-gray-400 text-sm">Join us to master your study habits</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div class="relative group">
            <label for="name" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 ml-4">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                   class="w-full bg-gray-900/60 border border-gray-700/50 rounded-full px-5 py-3 text-gray-200 placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 hover:border-blue-500/50 hover:bg-gray-800/80 transition-all duration-300 shadow-inner"
                   placeholder="John Doe">
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400 text-xs ml-4" />
        </div>

        <!-- Email Address -->
        <div class="relative group">
            <label for="email" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 ml-4">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                   class="w-full bg-gray-900/60 border border-gray-700/50 rounded-full px-5 py-3 text-gray-200 placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 hover:border-blue-500/50 hover:bg-gray-800/80 transition-all duration-300 shadow-inner"
                   placeholder="you@example.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs ml-4" />
        </div>

        <!-- Password -->
        <div class="relative group">
            <label for="password" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 ml-4">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full bg-gray-900/60 border border-gray-700/50 rounded-full px-5 py-3 text-gray-200 placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 hover:border-blue-500/50 hover:bg-gray-800/80 transition-all duration-300 shadow-inner"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs ml-4" />
        </div>

        <!-- Confirm Password -->
        <div class="relative group">
            <label for="password_confirmation" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 ml-4">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full bg-gray-900/60 border border-gray-700/50 rounded-full px-5 py-3 text-gray-200 placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 hover:border-blue-500/50 hover:bg-gray-800/80 transition-all duration-300 shadow-inner"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400 text-xs ml-4" />
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full relative overflow-hidden group bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-600 bg-[length:200%_auto] hover:bg-right text-white font-bold py-3.5 px-6 rounded-full shadow-[0_4px_20px_rgba(37,99,235,0.4)] hover:shadow-[0_8px_30px_rgba(37,99,235,0.6)] transition-all duration-500 transform hover:-translate-y-1 active:translate-y-0">
                <span class="relative z-10 flex items-center justify-center gap-2">
                    Create Account
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </span>
                <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out rounded-full"></div>
            </button>
        </div>

        <div class="text-center mt-8">
            <p class="text-sm text-gray-400 font-medium">
                Already registered? 
                <a href="{{ route('login') }}" class="text-blue-400 font-bold hover:text-blue-300 transition-all relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-blue-400 hover:after:w-full after:transition-all after:duration-300 ml-1">Log in here</a>
            </p>
        </div>
    </form>
</x-guest-layout>
