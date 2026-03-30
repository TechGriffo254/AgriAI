<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header
            :title="__('Verify your email')"
            :description="__('Check your inbox for the verification link we sent you')"
        >
            <x-slot:icon>
                <svg class="w-7 h-7 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </x-slot:icon>
        </x-auth-header>

        <div class="p-4 bg-agri-bg-alt dark:bg-zinc-700/30 border border-agri-lime/30 dark:border-agri-lime/20 rounded-xl">
            <p class="text-sm text-zinc-600 dark:text-zinc-300 text-center">
                {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm text-green-700 dark:text-green-300">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                </div>
            </div>
        @endif

        <div class="flex flex-col gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button
                    type="submit"
                    class="w-full px-6 py-3 bg-agri-lime text-zinc-800 text-sm font-medium rounded-xl hover:bg-agri-lime-light focus:outline-none focus:ring-2 focus:ring-agri-lime focus:ring-offset-2 transition-all duration-200"
                >
                    {{ __('Resend verification email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    data-test="logout-button"
                    class="w-full px-6 py-3 bg-transparent text-zinc-600 dark:text-zinc-400 text-sm font-medium rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-zinc-400 focus:ring-offset-2 transition-all duration-200"
                >
                    {{ __('Sign out') }}
                </button>
            </form>
        </div>

        <!-- Help Text -->
        <div class="text-center">
            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                {{ __("Didn't receive the email? Check your spam folder or") }}
                <button type="submit" form="resend-form" class="text-agri-olive hover:text-agri-olive-dark dark:text-agri-lime transition-colors">
                    {{ __('try again') }}
                </button>.
            </p>
        </div>
    </div>
</x-layouts.auth>
