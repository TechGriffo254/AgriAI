<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <div
            class="relative w-full h-auto"
            x-cloak
            x-data="{
                showRecoveryInput: @js($errors->has('recovery_code')),
                code: '',
                recovery_code: '',
                toggleInput() {
                    this.showRecoveryInput = !this.showRecoveryInput;
                    this.code = '';
                    this.recovery_code = '';
                    $dispatch('clear-2fa-auth-code');
                    $nextTick(() => {
                        this.showRecoveryInput
                            ? this.$refs.recovery_code?.focus()
                            : $dispatch('focus-2fa-auth-code');
                    });
                },
            }"
        >
            <div x-show="!showRecoveryInput">
                <x-auth-header
                    :title="__('Two-factor authentication')"
                    :description="__('Enter the 6-digit code from your authenticator app')"
                >
                    <x-slot:icon>
                        <svg class="w-7 h-7 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </x-slot:icon>
                </x-auth-header>
            </div>

            <div x-show="showRecoveryInput">
                <x-auth-header
                    :title="__('Recovery code')"
                    :description="__('Enter one of your emergency recovery codes')"
                >
                    <x-slot:icon>
                        <svg class="w-7 h-7 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </x-slot:icon>
                </x-auth-header>
            </div>

            <form method="POST" action="{{ route('two-factor.login.store') }}" class="mt-6">
                @csrf

                <div class="space-y-5">
                    <!-- OTP Code Input -->
                    <div x-show="!showRecoveryInput">
                        <div class="flex items-center justify-center my-4">
                            <div class="flex gap-2">
                                @for ($i = 0; $i < 6; $i++)
                                    <input
                                        type="text"
                                        maxlength="1"
                                        x-ref="otp{{ $i }}"
                                        class="w-12 h-14 text-center text-xl font-semibold bg-agri-bg dark:bg-zinc-900 border-2 border-zinc-200 dark:border-zinc-700 rounded-xl text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent transition-all"
                                        @input="
                                            if ($event.target.value.length === 1 && {{ $i }} < 5) {
                                                $refs.otp{{ $i + 1 }}.focus();
                                            }
                                            code = Array.from({length: 6}, (_, i) => $refs['otp' + i].value).join('');
                                        "
                                        @keydown.backspace="
                                            if ($event.target.value === '' && {{ $i }} > 0) {
                                                $refs.otp{{ $i - 1 }}.focus();
                                            }
                                        "
                                        @paste.prevent="
                                            const paste = ($event.clipboardData.getData('text')).slice(0, 6);
                                            [...paste].forEach((char, i) => {
                                                if ($refs['otp' + i]) $refs['otp' + i].value = char;
                                            });
                                            code = paste;
                                            $refs.otp5.focus();
                                        "
                                    >
                                @endfor
                            </div>
                            <input type="hidden" name="code" x-model="code">
                        </div>
                        @error('code')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Recovery Code Input -->
                    <div x-show="showRecoveryInput">
                        <div class="my-4">
                            <label for="recovery_code" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                {{ __('Recovery code') }}
                            </label>
                            <input
                                type="text"
                                id="recovery_code"
                                name="recovery_code"
                                x-ref="recovery_code"
                                x-bind:required="showRecoveryInput"
                                autocomplete="one-time-code"
                                x-model="recovery_code"
                                placeholder="XXXX-XXXX-XXXX"
                                class="w-full px-4 py-3 bg-agri-bg dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent transition-all text-center tracking-widest"
                            >
                        </div>
                        @error('recovery_code')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full px-6 py-3 bg-agri-lime text-zinc-800 text-sm font-medium rounded-xl hover:bg-agri-lime-light focus:outline-none focus:ring-2 focus:ring-agri-lime focus:ring-offset-2 transition-all duration-200"
                    >
                        {{ __('Verify & continue') }}
                    </button>
                </div>

                <!-- Toggle Link -->
                <div class="mt-5 text-sm text-center">
                    <span class="text-zinc-500 dark:text-zinc-400">{{ __('or you can') }}</span>
                    <button
                        type="button"
                        @click="toggleInput()"
                        class="ml-1 font-medium text-agri-olive hover:text-agri-olive-dark dark:text-agri-lime dark:hover:text-agri-lime-light transition-colors"
                    >
                        <span x-show="!showRecoveryInput">{{ __('use a recovery code') }}</span>
                        <span x-show="showRecoveryInput">{{ __('use an authenticator code') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.auth>
