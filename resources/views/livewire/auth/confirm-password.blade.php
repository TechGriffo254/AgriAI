<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header
            :title="__('Confirm your password')"
            :description="__('This is a secure area. Please confirm your password to continue.')"
        >
            <x-slot:icon>
                <svg class="w-7 h-7 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </x-slot:icon>
        </x-auth-header>

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.confirm.store') }}" class="flex flex-col gap-5">
            @csrf

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
                    autofocus
                    autocomplete="current-password"
                    placeholder="Enter your password"
                    class="w-full px-4 py-3 bg-agri-bg dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent transition-all"
                >
                @error('password')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                data-test="confirm-password-button"
                class="w-full px-6 py-3 bg-agri-lime text-zinc-800 text-sm font-medium rounded-xl hover:bg-agri-lime-light focus:outline-none focus:ring-2 focus:ring-agri-lime focus:ring-offset-2 transition-all duration-200"
            >
                {{ __('Confirm password') }}
            </button>
        </form>
    </div>
</x-layouts.auth>
