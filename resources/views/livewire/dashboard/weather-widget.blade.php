<div class="bg-gradient-to-br from-agri-green to-agri-green-dark rounded-2xl p-6 text-white" wire:init="fetchWeather">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-medium">Weather</h2>
        <a href="{{ route('weather.index') }}" wire:navigate class="text-sm text-white/70 hover:text-white">View Forecast</a>
    </div>

    @if($loading)
        <div class="flex items-center justify-between animate-pulse">
            <div>
                <div class="h-8 w-16 bg-white/20 rounded mb-2"></div>
                <div class="h-4 w-24 bg-white/20 rounded"></div>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-2xl"></div>
        </div>
    @elseif($farm && $weather)
        <div class="flex items-center justify-between">
            <div>
                <p class="text-4xl font-light">{{ $weather['temperature'] }}°C</p>
                <p class="text-sm text-white/70 mt-1">{{ $farm->city ?? $farm->name }}</p>
                <p class="text-xs text-white/60 mt-0.5">{{ $weather['description'] }}</p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                @if($weather['icon'] === 'sun')
                    <svg class="w-10 h-10 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                @elseif($weather['icon'] === 'cloud-sun')
                    <svg class="w-10 h-10 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                    </svg>
                @elseif($weather['icon'] === 'cloud')
                    <svg class="w-10 h-10 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                    </svg>
                @elseif($weather['icon'] === 'cloud-rain')
                    <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 18v2m-4-1v2m-4-1v2" />
                    </svg>
                @elseif($weather['icon'] === 'cloud-lightning')
                    <svg class="w-10 h-10 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                @else
                    <svg class="w-10 h-10 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                @endif
            </div>
        </div>
        <div class="flex items-center gap-4 mt-4 pt-4 border-t border-white/20">
            <div class="flex items-center gap-1.5">
                <svg class="w-4 h-4 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                </svg>
                <span class="text-xs text-white/70">{{ $weather['humidity'] }}%</span>
            </div>
            <div class="flex items-center gap-1.5">
                <svg class="w-4 h-4 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
                <span class="text-xs text-white/70">{{ $weather['wind_speed'] }} km/h</span>
            </div>
        </div>
    @elseif($farm)
        <p class="text-sm text-white/70">Set farm coordinates to see weather</p>
        <a href="{{ route('farms.edit', $farm) }}" wire:navigate class="inline-flex items-center gap-1 mt-2 text-sm text-agri-lime hover:text-agri-lime-light">
            Update farm location
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    @else
        <p class="text-sm text-white/70">Add a farm to see weather</p>
        <a href="{{ route('farms.create') }}" wire:navigate class="inline-flex items-center gap-1 mt-2 text-sm text-agri-lime hover:text-agri-lime-light">
            Add your first farm
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    @endif
</div>
