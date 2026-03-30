<div>
    <x-theme.agri-page-header
        title="Weather"
        description="Monitor weather conditions for your farms"
    />

    <!-- Farm Selector -->
    <div class="mb-6">
        <div class="max-w-xs">
            <label for="farm-select" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                Select Farm
            </label>
            <select
                id="farm-select"
                wire:model.live="selectedFarmId"
                class="w-full px-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
            >
                <option value="">Select a farm</option>
                @foreach($farms as $farm)
                    <option value="{{ $farm->id }}">{{ $farm->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if($farms->isEmpty())
        <x-theme.agri-empty
            title="No farms yet"
            description="Add a farm to start monitoring weather conditions"
            action-text="Add Your First Farm"
            :action-href="route('farms.create')"
        >
            <x-slot:icon>
                <svg class="w-10 h-10 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                </svg>
            </x-slot:icon>
        </x-theme.agri-empty>
    @elseif(!$selectedFarmId)
        <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700 text-center py-12">
            <svg class="w-16 h-16 text-zinc-300 dark:text-zinc-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
            </svg>
            <p class="text-zinc-500 dark:text-zinc-400">Select a farm to view weather conditions</p>
        </x-theme.agri-card>
    @elseif($loading)
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700 animate-pulse">
                    <div class="h-48 bg-zinc-200 dark:bg-zinc-700 rounded-xl"></div>
                </x-theme.agri-card>
            </div>
            <div>
                <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700 animate-pulse">
                    <div class="h-48 bg-zinc-200 dark:bg-zinc-700 rounded-xl"></div>
                </x-theme.agri-card>
            </div>
        </div>
    @elseif($error)
        <x-theme.agri-card variant="white" class="border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-red-800 dark:text-red-200">Error</h3>
                    <p class="text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
                </div>
                <button
                    wire:click="fetchWeather"
                    class="ml-auto px-4 py-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors"
                >
                    Retry
                </button>
            </div>
        </x-theme.agri-card>
    @else
        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Current Weather -->
            <div class="lg:col-span-2 space-y-6">
                @if($currentWeather)
                    <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <!-- Main Weather Info -->
                            <div class="flex items-center gap-6">
                                <div class="w-24 h-24 bg-gradient-to-br from-agri-lime/20 to-agri-lime/5 dark:from-agri-lime/10 dark:to-transparent rounded-2xl flex items-center justify-center">
                                    @php
                                        $iconName = $this->getWeatherIcon($currentWeather['icon']);
                                    @endphp
                                    @if($iconName === 'sun')
                                        <svg class="w-14 h-14 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    @elseif($iconName === 'cloud-sun')
                                        <svg class="w-14 h-14 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                        </svg>
                                    @elseif($iconName === 'cloud')
                                        <svg class="w-14 h-14 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                        </svg>
                                    @elseif($iconName === 'cloud-rain')
                                        <svg class="w-14 h-14 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 19v2m4-2v2m4-2v2" />
                                        </svg>
                                    @elseif($iconName === 'cloud-lightning')
                                        <svg class="w-14 h-14 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    @else
                                        <svg class="w-14 h-14 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-5xl font-light text-zinc-800 dark:text-white">
                                        {{ $currentWeather['temperature'] }}°C
                                    </p>
                                    <p class="text-lg text-zinc-600 dark:text-zinc-400 mt-1">
                                        {{ $currentWeather['description'] }}
                                    </p>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-500 mt-1">
                                        Feels like {{ $currentWeather['feels_like'] }}°C
                                    </p>
                                </div>
                            </div>

                            <!-- Farm Info -->
                            @if($selectedFarm)
                                <div class="text-right">
                                    <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $selectedFarm->name }}</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ collect([$selectedFarm->city, $selectedFarm->country])->filter()->implode(', ') }}
                                    </p>
                                    <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-2">
                                        Updated {{ now()->format('g:i A') }}
                                    </p>
                                    <button
                                        wire:click="fetchWeather"
                                        class="mt-2 text-xs text-agri-olive hover:text-agri-olive-dark dark:text-agri-lime dark:hover:text-agri-lime-light transition-colors"
                                    >
                                        ↻ Refresh
                                    </button>
                                </div>
                            @endif
                        </div>

                        <!-- Weather Details Grid -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                            <div class="text-center p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                                <svg class="w-6 h-6 text-blue-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                </svg>
                                <p class="text-2xl font-light text-zinc-800 dark:text-white">{{ $currentWeather['humidity'] }}%</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Humidity</p>
                            </div>
                            <div class="text-center p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                                <svg class="w-6 h-6 text-zinc-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                                <p class="text-2xl font-light text-zinc-800 dark:text-white">{{ $currentWeather['wind_speed'] }} km/h</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Wind Speed</p>
                            </div>
                            <div class="text-center p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                                <svg class="w-6 h-6 text-purple-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <p class="text-2xl font-light text-zinc-800 dark:text-white">{{ $currentWeather['pressure'] }} hPa</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Pressure</p>
                            </div>
                            <div class="text-center p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                                <svg class="w-6 h-6 text-yellow-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <p class="text-2xl font-light text-zinc-800 dark:text-white">{{ $currentWeather['visibility'] }} km</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Visibility</p>
                            </div>
                        </div>

                        <!-- Sunrise/Sunset -->
                        @if(isset($currentWeather['sunrise']) && isset($currentWeather['sunset']))
                            <div class="flex items-center justify-center gap-8 mt-6 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-zinc-800 dark:text-white">
                                            {{ \Carbon\Carbon::createFromTimestamp($currentWeather['sunrise'])->format('g:i A') }}
                                        </p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Sunrise</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-zinc-800 dark:text-white">
                                            {{ \Carbon\Carbon::createFromTimestamp($currentWeather['sunset'])->format('g:i A') }}
                                        </p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Sunset</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </x-theme.agri-card>
                @endif

                <!-- 5-Day Forecast -->
                @if($forecast && count($forecast) > 0)
                    <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                        <h3 class="text-lg font-medium text-zinc-800 dark:text-white mb-4">5-Day Forecast</h3>
                        <div class="grid gap-3">
                            @foreach($forecast as $day)
                                <div class="flex items-center justify-between p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 text-center">
                                            <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $day['day'] }}</p>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                {{ \Carbon\Carbon::parse($day['date'])->format('M j') }}
                                            </p>
                                        </div>
                                        <div class="w-10 h-10 bg-white dark:bg-zinc-800 rounded-lg flex items-center justify-center">
                                            @php
                                                $dayIcon = $this->getWeatherIcon($day['icon']);
                                            @endphp
                                            @if($dayIcon === 'sun')
                                                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                            @elseif($dayIcon === 'cloud-rain')
                                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400 capitalize">{{ $day['description'] }}</p>
                                    </div>
                                    <div class="flex items-center gap-6">
                                        <div class="text-center">
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Rain</p>
                                            <p class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ $day['rain_chance'] }}%</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Humidity</p>
                                            <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $day['humidity'] }}%</p>
                                        </div>
                                        <div class="text-right min-w-[80px]">
                                            <span class="text-sm font-medium text-zinc-800 dark:text-white">{{ $day['temp_max'] }}°</span>
                                            <span class="text-sm text-zinc-400 dark:text-zinc-500"> / {{ $day['temp_min'] }}°</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-theme.agri-card>
                @endif
            </div>

            <!-- Sidebar: Farming Tips -->
            <div class="space-y-6">
                <!-- Weather-based Recommendations -->
                <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-lg font-medium text-zinc-800 dark:text-white mb-4">Farming Tips</h3>
                    @if($currentWeather)
                        <div class="space-y-3">
                            @if($currentWeather['temperature'] > 30)
                                <div class="flex items-start gap-3 p-3 bg-red-50 dark:bg-red-900/20 rounded-xl">
                                    <div class="w-8 h-8 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-red-800 dark:text-red-200">High Temperature Alert</p>
                                        <p class="text-xs text-red-600 dark:text-red-400">Increase irrigation and consider shade protection for sensitive crops.</p>
                                    </div>
                                </div>
                            @endif

                            @if($currentWeather['humidity'] > 80)
                                <div class="flex items-start gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-blue-800 dark:text-blue-200">High Humidity</p>
                                        <p class="text-xs text-blue-600 dark:text-blue-400">Watch for fungal diseases. Ensure good air circulation.</p>
                                    </div>
                                </div>
                            @endif

                            @if($currentWeather['wind_speed'] > 30)
                                <div class="flex items-start gap-3 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl">
                                    <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Strong Winds</p>
                                        <p class="text-xs text-yellow-600 dark:text-yellow-400">Secure loose structures and protect young plants.</p>
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-start gap-3 p-3 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                                <div class="w-8 h-8 bg-agri-lime/30 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-zinc-800 dark:text-white">Today's Conditions</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                        @if($currentWeather['temperature'] >= 20 && $currentWeather['temperature'] <= 28)
                                            Good conditions for most farming activities.
                                        @elseif($currentWeather['temperature'] < 20)
                                            Cool conditions - good for leafy vegetables.
                                        @else
                                            Warm conditions - best to work early morning or evening.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </x-theme.agri-card>

                <!-- Quick Actions -->
                <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-lg font-medium text-zinc-800 dark:text-white mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="{{ route('tasks.create') }}" wire:navigate class="flex items-center gap-3 p-3 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-800 transition-colors">
                            <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="text-sm font-medium text-zinc-800 dark:text-white">Schedule Task</span>
                        </a>
                        <a href="{{ route('farms.index') }}" wire:navigate class="flex items-center gap-3 p-3 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-800 transition-colors">
                            <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                            <span class="text-sm font-medium text-zinc-800 dark:text-white">Update Farm Location</span>
                        </a>
                    </div>
                </x-theme.agri-card>
            </div>
        </div>
    @endif
</div>
