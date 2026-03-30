<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-agri-bg antialiased dark:bg-zinc-900">
        <div class="flex min-h-svh">
            <!-- Left Side - Decorative Panel (hidden on mobile) -->
            <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-[#4a6d2a] via-[#3d5a23] to-[#2d4a1a] overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <defs>
                            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#grid)" />
                    </svg>
                </div>

                <!-- Content -->
                <div class="relative z-10 flex flex-col justify-between p-12 w-full">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center gap-3" wire:navigate>
                        <div class="grid grid-cols-2 gap-1">
                            <div class="w-3 h-3 bg-[#c5d82d] rounded-sm"></div>
                            <div class="w-3 h-3 bg-[#c5d82d] rounded-sm"></div>
                            <div class="w-3 h-3 bg-[#c5d82d] rounded-sm"></div>
                            <div class="w-3 h-3 bg-[#c5d82d] rounded-sm"></div>
                        </div>
                        <span class="text-2xl font-semibold text-white">{{ config('app.name', 'AgriAI') }}</span>
                    </a>

                    <!-- Middle Content -->
                    <div class="space-y-8">
                        <div class="max-w-md">
                            <h2 class="text-4xl font-light text-white leading-tight mb-4">
                                Smart farming for a
                                <span class="text-[#c5d82d] italic">sustainable</span>
                                future
                            </h2>
                            <p class="text-white/70 text-lg">
                                Leverage AI-powered insights to optimize your farm operations and increase crop yields.
                            </p>
                        </div>

                        <!-- Stats -->
                        <div class="flex gap-8">
                            <div>
                                <div class="text-3xl font-light text-[#c5d82d]">32%</div>
                                <div class="text-sm text-white/60">Yield Increase</div>
                            </div>
                            <div>
                                <div class="text-3xl font-light text-[#c5d82d]">24/7</div>
                                <div class="text-sm text-white/60">AI Monitoring</div>
                            </div>
                            <div>
                                <div class="text-3xl font-light text-[#c5d82d]">50+</div>
                                <div class="text-sm text-white/60">Crop Types</div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Quote -->
                    <div class="max-w-sm">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#c5d82d]" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white font-medium">Trusted by farmers</p>
                                <p class="text-white/60 text-sm">Across East Africa</p>
                            </div>
                        </div>
                        <p class="text-white/50 text-sm italic">
                            "AgriAI has transformed how we manage our crops. The insights are invaluable."
                        </p>
                    </div>
                </div>

                <!-- Decorative Elements -->
                <div class="absolute bottom-0 right-0 w-64 h-64 bg-[#c5d82d]/10 rounded-full blur-3xl"></div>
                <div class="absolute top-1/4 right-1/4 w-32 h-32 bg-[#c5d82d]/5 rounded-full blur-2xl"></div>
            </div>

            <!-- Right Side - Auth Form -->
            <div class="flex-1 flex flex-col items-center justify-center p-6 lg:p-12">
                <!-- Mobile Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 mb-8 lg:hidden" wire:navigate>
                    <div class="grid grid-cols-2 gap-0.5">
                        <div class="w-2.5 h-2.5 bg-[#c5d82d] rounded-sm"></div>
                        <div class="w-2.5 h-2.5 bg-[#c5d82d] rounded-sm"></div>
                        <div class="w-2.5 h-2.5 bg-[#c5d82d] rounded-sm"></div>
                        <div class="w-2.5 h-2.5 bg-[#c5d82d] rounded-sm"></div>
                    </div>
                    <span class="text-xl font-semibold text-zinc-800 dark:text-white">{{ config('app.name', 'AgriAI') }}</span>
                </a>

                <!-- Form Container -->
                <div class="w-full max-w-md">
                    <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-xl shadow-zinc-200/50 dark:shadow-zinc-900/50 p-8 border border-zinc-100 dark:border-zinc-700">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center text-sm text-zinc-500 dark:text-zinc-400">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'AgriAI') }}. All rights reserved.</p>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
