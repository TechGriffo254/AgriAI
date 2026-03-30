<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header
            :title="__('Create your account')"
            :description="__('Start your smart farming journey today')"
        >
            <x-slot:icon>
                <svg class="w-7 h-7 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </x-slot:icon>
        </x-auth-header>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-5">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    {{ __('Full name') }}
                </label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="John Doe"
                    class="w-full px-4 py-3 bg-agri-bg dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent transition-all"
                >
                @error('name')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

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
                <label for="password" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    {{ __('Password') }}
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Create a strong password"
                    class="w-full px-4 py-3 bg-agri-bg dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent transition-all"
                >
                @error('password')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    {{ __('Confirm password') }}
                </label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Confirm your password"
                    class="w-full px-4 py-3 bg-agri-bg dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent transition-all"
                >
                @error('password_confirmation')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Terms -->
            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                {{ __('By creating an account, you agree to our') }}
                <a href="#" class="text-agri-olive hover:text-agri-olive-dark dark:text-agri-lime transition-colors">{{ __('Terms of Service') }}</a>
                {{ __('and') }}
                <a href="#" class="text-agri-olive hover:text-agri-olive-dark dark:text-agri-lime transition-colors">{{ __('Privacy Policy') }}</a>.
            </p>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full px-6 py-3 bg-agri-lime text-zinc-800 text-sm font-medium rounded-xl hover:bg-agri-lime-light focus:outline-none focus:ring-2 focus:ring-agri-lime focus:ring-offset-2 transition-all duration-200"
            >
                {{ __('Create account') }}
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

        <div class="text-center">
            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                {{ __('Already have an account?') }}
                <a href="{{ route('login') }}" wire:navigate class="font-medium text-agri-olive hover:text-agri-olive-dark dark:text-agri-lime dark:hover:text-agri-lime-light transition-colors">
                    {{ __('Sign in') }}
                </a>
            </p>
        </div>
    </div>
</x-layouts.auth>
