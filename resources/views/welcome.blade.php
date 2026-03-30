<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="AgriAI - Smart farming solutions powered by artificial intelligence. Optimize your farm operations with AI-driven insights.">

    <title>{{ config('app.name', 'AgriAI') }} - Smart Farming Solutions</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
        }
    </style>
</head>
<body class="bg-[#f8f8f6] text-zinc-900 antialiased">
    <!-- Navigation -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-[#f8f8f6]/90 backdrop-blur-md">
        <nav class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <div class="grid grid-cols-2 gap-0.5">
                        <div class="w-2.5 h-2.5 bg-[#c5d82d] rounded-sm"></div>
                        <div class="w-2.5 h-2.5 bg-[#c5d82d] rounded-sm"></div>
                        <div class="w-2.5 h-2.5 bg-[#c5d82d] rounded-sm"></div>
                        <div class="w-2.5 h-2.5 bg-[#c5d82d] rounded-sm"></div>
                    </div>
                    <span class="text-xl font-semibold text-zinc-800 ml-1">AgriAI</span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center gap-2">
                    <a href="#about" class="px-5 py-2.5 text-sm font-medium text-zinc-600 hover:text-zinc-900 rounded-full transition-colors">About</a>
                    <a href="#features" class="px-5 py-2.5 text-sm font-medium text-zinc-600 hover:text-zinc-900 rounded-full transition-colors">Features</a>
                    <a href="#" class="px-5 py-2.5 text-sm font-medium text-zinc-900 bg-white rounded-full shadow-sm border border-zinc-200 flex items-center gap-2">
                        <div class="grid grid-cols-2 gap-0.5">
                            <div class="w-1.5 h-1.5 bg-[#c5d82d] rounded-[2px]"></div>
                            <div class="w-1.5 h-1.5 bg-[#c5d82d] rounded-[2px]"></div>
                            <div class="w-1.5 h-1.5 bg-[#c5d82d] rounded-[2px]"></div>
                            <div class="w-1.5 h-1.5 bg-[#c5d82d] rounded-[2px]"></div>
                        </div>
                        Home
                    </a>
                    <a href="#features" class="px-5 py-2.5 text-sm font-medium text-zinc-600 hover:text-zinc-900 rounded-full transition-colors">Solutions</a>
                    <a href="#about" class="px-5 py-2.5 text-sm font-medium text-zinc-600 hover:text-zinc-900 rounded-full transition-colors">Insights</a>
                </div>

                <!-- Right Side -->
                <div class="flex items-center gap-3">
                    <button class="w-10 h-10 rounded-full bg-white border border-zinc-200 flex items-center justify-center hover:bg-zinc-50 transition-colors">
                        <svg class="w-5 h-5 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="w-10 h-10 rounded-full bg-[#c5d82d] flex items-center justify-center hover:bg-[#b5c82d] transition-colors">
                                <svg class="w-5 h-5 text-zinc-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="hidden sm:flex items-center text-sm font-medium text-zinc-600 hover:text-zinc-900 transition-colors">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="w-10 h-10 rounded-full bg-[#c5d82d] flex items-center justify-center hover:bg-[#b5c82d] transition-colors">
                                    <svg class="w-5 h-5 text-zinc-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="relative pt-28 pb-0 min-h-screen overflow-hidden">
            <!-- Background with grass image overlay -->
            <div class="absolute inset-0 bg-gradient-to-b from-[#f8f8f6] via-[#f8f8f6] to-[#e8ead8]"></div>

            <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="pt-8 lg:pt-16">
                        <h1 class="text-4xl sm:text-5xl lg:text-[3.5rem] font-light leading-[1.1] text-zinc-800 mb-6">
                            AI-powered insights for
                            <span class="text-[#8b9a2d] italic font-normal">crop monitoring,</span>
                            and precision farming
                        </h1>
                        <p class="text-zinc-500 text-base mb-8 max-w-md">
                            Transform your farm operations with intelligent analysis and real-time recommendations.
                        </p>

                        <a href="{{ Route::has('register') ? route('register') : '#' }}" class="inline-flex items-center gap-3 px-6 py-3.5 bg-zinc-800 text-white rounded-full text-sm font-medium hover:bg-zinc-700 transition-colors group">
                            <div class="grid grid-cols-2 gap-0.5">
                                <div class="w-1.5 h-1.5 bg-[#c5d82d] rounded-[2px]"></div>
                                <div class="w-1.5 h-1.5 bg-[#c5d82d] rounded-[2px]"></div>
                                <div class="w-1.5 h-1.5 bg-[#c5d82d] rounded-[2px]"></div>
                                <div class="w-1.5 h-1.5 bg-[#c5d82d] rounded-[2px]"></div>
                            </div>
                            Explore Solutions
                        </a>
                    </div>

                    <!-- Right Content - Hero Image Area -->
                    <div class="relative">
                        <!-- Decorative card -->
                        <div class="absolute -right-4 top-1/2 transform -translate-y-1/2 z-20">
                            <div class="bg-zinc-800 text-white rounded-2xl p-5 w-44">
                                <div class="text-3xl font-light mb-1">32%</div>
                                <div class="text-xs text-zinc-400 leading-tight">Increased crop yield through AI optimization</div>
                                <div class="mt-3 w-8 h-8 bg-[#c5d82d] rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-zinc-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Main image placeholder with gradient overlay -->
                        <div class="relative h-[500px] lg:h-[600px] rounded-3xl overflow-hidden bg-gradient-to-t from-[#4a6d2a] via-[#6b8c3a] to-[#a8c76a]">
                            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%20400%20400%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cfilter%20id%3D%22noiseFilter%22%3E%3CfeTurbulence%20type%3D%22fractalNoise%22%20baseFrequency%3D%220.9%22%20numOctaves%3D%223%22%20stitchTiles%3D%22stitch%22%2F%3E%3C%2Ffilter%3E%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20filter%3D%22url%28%23noiseFilter%29%22%2F%3E%3C%2Fsvg%3E')] opacity-10"></div>

                            <!-- Floating elements to simulate crops/field -->
                            <div class="absolute bottom-0 left-0 right-0 h-3/4 bg-gradient-to-t from-[#2d4a1a] via-[#4a6d2a] to-transparent"></div>

                            <!-- Central icon/device representation -->
                            <div class="absolute top-1/3 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                <div class="w-32 h-32 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Stats Bar -->
            <div class="absolute bottom-0 left-0 right-0 bg-white/80 backdrop-blur-sm border-t border-zinc-200">
                <div class="max-w-7xl mx-auto px-6 lg:px-8 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2 px-4 py-2 bg-[#f0f4d4] rounded-lg">
                                <span class="text-2xl font-light text-zinc-800">6</span>
                                <span class="text-xs text-zinc-500">Fields<br/>Active</span>
                            </div>
                            <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-lg border border-zinc-200">
                                <span class="text-2xl font-light text-zinc-800">9</span>
                                <span class="text-xs text-zinc-500">Crops<br/>Monitored</span>
                            </div>
                        </div>

                        <div class="hidden sm:flex items-center gap-2">
                            <button class="px-4 py-2 bg-[#c5d82d] text-zinc-800 text-sm font-medium rounded-lg hover:bg-[#b5c82d] transition-colors">
                                Get Started
                            </button>
                            <button class="px-4 py-2 bg-zinc-200 text-zinc-600 text-sm font-medium rounded-lg hover:bg-zinc-300 transition-colors">
                                Learn More
                            </button>
                        </div>

                        <div class="flex items-center gap-3 text-sm text-zinc-500">
                            <button class="w-8 h-8 rounded-full border border-zinc-300 flex items-center justify-center hover:bg-zinc-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                            </button>
                            <span>1 of 3</span>
                            <button class="w-8 h-8 rounded-full border border-zinc-300 flex items-center justify-center hover:bg-zinc-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="inline-block px-4 py-1.5 bg-[#f0f4d4] text-[#6b7a24] text-sm font-medium rounded-full mb-4">Features</span>
                    <h2 class="text-3xl sm:text-4xl font-light text-zinc-800">Everything you need to <span class="italic text-[#8b9a2d]">grow smarter</span></h2>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Feature Card 1 -->
                    <div class="group p-8 bg-[#f8f8f6] rounded-3xl hover:bg-[#f0f4d4] transition-all duration-300">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mb-6 shadow-sm group-hover:shadow-md transition-shadow">
                            <svg class="w-7 h-7 text-[#8b9a2d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-zinc-800 mb-3">AI Crop Analysis</h3>
                        <p class="text-zinc-500 text-sm leading-relaxed">Instant crop health assessments with personalized recommendations using machine learning.</p>
                    </div>

                    <!-- Feature Card 2 -->
                    <div class="group p-8 bg-[#f8f8f6] rounded-3xl hover:bg-[#f0f4d4] transition-all duration-300">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mb-6 shadow-sm group-hover:shadow-md transition-shadow">
                            <svg class="w-7 h-7 text-[#8b9a2d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-zinc-800 mb-3">Weather Forecasting</h3>
                        <p class="text-zinc-500 text-sm leading-relaxed">Location-specific weather predictions for planning irrigation and harvesting schedules.</p>
                    </div>

                    <!-- Feature Card 3 -->
                    <div class="group p-8 bg-[#f8f8f6] rounded-3xl hover:bg-[#f0f4d4] transition-all duration-300">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mb-6 shadow-sm group-hover:shadow-md transition-shadow">
                            <svg class="w-7 h-7 text-[#8b9a2d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-zinc-800 mb-3">Pest Detection</h3>
                        <p class="text-zinc-500 text-sm leading-relaxed">Early detection of pests and diseases with AI-powered image analysis.</p>
                    </div>

                    <!-- Feature Card 4 -->
                    <div class="group p-8 bg-[#f8f8f6] rounded-3xl hover:bg-[#f0f4d4] transition-all duration-300">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mb-6 shadow-sm group-hover:shadow-md transition-shadow">
                            <svg class="w-7 h-7 text-[#8b9a2d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-zinc-800 mb-3">Market Insights</h3>
                        <p class="text-zinc-500 text-sm leading-relaxed">Real-time market prices and demand forecasts to maximize profits.</p>
                    </div>

                    <!-- Feature Card 5 -->
                    <div class="group p-8 bg-[#f8f8f6] rounded-3xl hover:bg-[#f0f4d4] transition-all duration-300">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mb-6 shadow-sm group-hover:shadow-md transition-shadow">
                            <svg class="w-7 h-7 text-[#8b9a2d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-zinc-800 mb-3">Soil Analysis</h3>
                        <p class="text-zinc-500 text-sm leading-relaxed">Track soil health and get fertilizer recommendations based on conditions.</p>
                    </div>

                    <!-- Feature Card 6 -->
                    <div class="group p-8 bg-[#f8f8f6] rounded-3xl hover:bg-[#f0f4d4] transition-all duration-300">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mb-6 shadow-sm group-hover:shadow-md transition-shadow">
                            <svg class="w-7 h-7 text-[#8b9a2d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-zinc-800 mb-3">Task Management</h3>
                        <p class="text-zinc-500 text-sm leading-relaxed">Smart scheduling based on weather and crop requirements.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-20 bg-[#f8f8f6]">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="text-center p-8 bg-white rounded-3xl">
                        <div class="text-4xl lg:text-5xl font-light text-zinc-800 mb-2">10K+</div>
                        <div class="text-sm text-zinc-500">Active Farmers</div>
                    </div>
                    <div class="text-center p-8 bg-white rounded-3xl">
                        <div class="text-4xl lg:text-5xl font-light text-zinc-800 mb-2">500K</div>
                        <div class="text-sm text-zinc-500">Acres Analyzed</div>
                    </div>
                    <div class="text-center p-8 bg-white rounded-3xl">
                        <div class="text-4xl lg:text-5xl font-light text-zinc-800 mb-2">95%</div>
                        <div class="text-sm text-zinc-500">Accuracy Rate</div>
                    </div>
                    <div class="text-center p-8 bg-[#c5d82d] rounded-3xl">
                        <div class="text-4xl lg:text-5xl font-light text-zinc-800 mb-2">30%</div>
                        <div class="text-sm text-zinc-700">Yield Increase</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section id="about" class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="inline-block px-4 py-1.5 bg-[#f0f4d4] text-[#6b7a24] text-sm font-medium rounded-full mb-4">How It Works</span>
                    <h2 class="text-3xl sm:text-4xl font-light text-zinc-800">Get started in <span class="italic text-[#8b9a2d]">3 simple steps</span></h2>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-[#c5d82d] text-zinc-800 rounded-3xl flex items-center justify-center text-3xl font-light mx-auto mb-6">1</div>
                        <h3 class="text-xl font-medium text-zinc-800 mb-3">Create Your Profile</h3>
                        <p class="text-zinc-500 text-sm leading-relaxed">Sign up and add details about your farm, crops, and location.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-20 h-20 bg-[#c5d82d] text-zinc-800 rounded-3xl flex items-center justify-center text-3xl font-light mx-auto mb-6">2</div>
                        <h3 class="text-xl font-medium text-zinc-800 mb-3">Connect Your Data</h3>
                        <p class="text-zinc-500 text-sm leading-relaxed">Upload images or connect sensors to start receiving insights.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-20 h-20 bg-[#c5d82d] text-zinc-800 rounded-3xl flex items-center justify-center text-3xl font-light mx-auto mb-6">3</div>
                        <h3 class="text-xl font-medium text-zinc-800 mb-3">Grow Smarter</h3>
                        <p class="text-zinc-500 text-sm leading-relaxed">Get actionable recommendations and track your progress.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-24 bg-zinc-800">
            <div class="max-w-4xl mx-auto px-6 lg:px-8 text-center">
                <div class="inline-block mb-8">
                    <div class="grid grid-cols-2 gap-1">
                        <div class="w-4 h-4 bg-[#c5d82d] rounded-sm"></div>
                        <div class="w-4 h-4 bg-[#c5d82d] rounded-sm"></div>
                        <div class="w-4 h-4 bg-[#c5d82d] rounded-sm"></div>
                        <div class="w-4 h-4 bg-[#c5d82d] rounded-sm"></div>
                    </div>
                </div>
                <h2 class="text-3xl sm:text-4xl font-light text-white mb-6">Ready to transform your farm?</h2>
                <p class="text-zinc-400 mb-10 max-w-xl mx-auto">
                    Join thousands of farmers already using AgriAI to grow smarter and harvest more.
                </p>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-[#c5d82d] text-zinc-800 text-base font-medium rounded-full hover:bg-[#d5e83d] transition-colors">
                        Get Started Free
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                @endif
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-[#f8f8f6] py-16">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12">
                <!-- Brand -->
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="grid grid-cols-2 gap-0.5">
                            <div class="w-2.5 h-2.5 bg-[#c5d82d] rounded-sm"></div>
                            <div class="w-2.5 h-2.5 bg-[#c5d82d] rounded-sm"></div>
                            <div class="w-2.5 h-2.5 bg-[#c5d82d] rounded-sm"></div>
                            <div class="w-2.5 h-2.5 bg-[#c5d82d] rounded-sm"></div>
                        </div>
                        <span class="text-xl font-semibold text-zinc-800 ml-1">AgriAI</span>
                    </div>
                    <p class="text-zinc-500 text-sm max-w-sm leading-relaxed">
                        Empowering farmers with AI-driven insights for smarter, more sustainable agriculture.
                    </p>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="font-medium text-zinc-800 mb-4">Product</h4>
                    <ul class="space-y-3 text-sm text-zinc-500">
                        <li><a href="#features" class="hover:text-[#8b9a2d] transition-colors">Features</a></li>
                        <li><a href="#about" class="hover:text-[#8b9a2d] transition-colors">How It Works</a></li>
                        <li><a href="#" class="hover:text-[#8b9a2d] transition-colors">Pricing</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-medium text-zinc-800 mb-4">Company</h4>
                    <ul class="space-y-3 text-sm text-zinc-500">
                        <li><a href="#" class="hover:text-[#8b9a2d] transition-colors">About</a></li>
                        <li><a href="#" class="hover:text-[#8b9a2d] transition-colors">Contact</a></li>
                        <li><a href="#" class="hover:text-[#8b9a2d] transition-colors">Privacy</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-zinc-200 mt-12 pt-8 text-center text-zinc-500 text-sm">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'AgriAI') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>

