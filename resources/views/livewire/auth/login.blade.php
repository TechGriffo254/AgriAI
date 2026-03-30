<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header
            :title="__('Welcome back')"
            :description="__('Sign in to continue managing your farms')"
        >
            <x-slot:icon>
                <svg class="w-7 h-7 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </x-slot:icon>
        </x-auth-header>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-5">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    {{ __('Email address') }}
                </label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="you@example.com"
                    class="w-full px-4 py-3 bg-agri-bg dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent transition-all"
                >
                @error('email')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        {{ __('Password') }}
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" wire:navigate class="text-sm text-agri-olive hover:text-agri-olive-dark dark:text-agri-lime dark:hover:text-agri-lime-light transition-colors">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                    class="w-full px-4 py-3 bg-agri-bg dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent transition-all"
                >
                @error('password')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center gap-2">
                <input
                    type="checkbox"
                    id="remember"
                    name="remember"
                    {{ old('remember') ? 'checked' : '' }}
                    class="w-4 h-4 rounded border-zinc-300 dark:border-zinc-600 text-agri-lime focus:ring-agri-lime bg-agri-bg dark:bg-zinc-900"
                >
                <label for="remember" class="text-sm text-zinc-600 dark:text-zinc-400">
                    {{ __('Remember me for 30 days') }}
                </label>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                data-test="login-button"
                class="w-full px-6 py-3 bg-agri-lime text-zinc-800 text-sm font-medium rounded-xl hover:bg-agri-lime-light focus:outline-none focus:ring-2 focus:ring-agri-lime focus:ring-offset-2 transition-all duration-200"
            >
                {{ __('Sign in') }}
            </button>
        </form>

        <!-- Divider -->
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-zinc-200 dark:border-zinc-700"></div>
            </div>
            <div class="relative flex justify-center text-xs">
                <span class="px-4 bg-white dark:bg-zinc-800 text-zinc-400">or</span>
            </div>
        </div>

        @if (Route::has('register'))
            <div class="text-center">
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('register') }}" wire:navigate class="font-medium text-agri-olive hover:text-agri-olive-dark dark:text-agri-lime dark:hover:text-agri-lime-light transition-colors">
                        {{ __('Create one free') }}
                    </a>
                </p>
            </div>
        @endif
    </div>
</x-layouts.auth>
