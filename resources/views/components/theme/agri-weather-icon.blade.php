{{--
    AgriAI Weather Icon Component

    Usage:
    <x-theme.agri-weather-icon code="01d" />
    <x-theme.agri-weather-icon code="10d" size="lg" />
--}}

@props([
    'code' => '01d',
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'w-6 h-6',
        'md' => 'w-10 h-10',
        'lg' => 'w-16 h-16',
        'xl' => 'w-24 h-24',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $iconCode = substr($code, 0, 2);
    $isNight = str_ends_with($code, 'n');
@endphp

<div {{ $attributes->merge(['class' => $sizeClass . ' flex items-center justify-center']) }}>
    @switch($iconCode)
        @case('01')
            {{-- Clear sky --}}
            @if($isNight)
                <svg class="w-full h-full text-indigo-300" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                </svg>
            @else
                <svg class="w-full h-full text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="5"/>
                    <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
                </svg>
            @endif
            @break
        @case('02')
            {{-- Few clouds --}}
            <svg class="w-full h-full text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2a5 5 0 0 0-5 5 5 5 0 0 0 .09.92A4.5 4.5 0 0 0 4 12.5 4.5 4.5 0 0 0 8.5 17h10a3.5 3.5 0 0 0 .5-6.97A5 5 0 0 0 12 2z" class="text-zinc-300 dark:text-zinc-500"/>
                <circle cx="17" cy="7" r="4" class="text-yellow-400"/>
            </svg>
            @break
        @case('03')
        @case('04')
            {{-- Clouds --}}
            <svg class="w-full h-full text-zinc-400 dark:text-zinc-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/>
            </svg>
            @break
        @case('09')
        @case('10')
            {{-- Rain --}}
            <svg class="w-full h-full text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z" class="text-zinc-400 dark:text-zinc-500"/>
                <path d="M8 19v2M12 19v2M16 19v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            @break
        @case('11')
            {{-- Thunderstorm --}}
            <svg class="w-full h-full text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z" class="text-zinc-500"/>
                <path d="M13 11l-2 4h3l-2 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            </svg>
            @break
        @case('13')
            {{-- Snow --}}
            <svg class="w-full h-full text-blue-200" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z" class="text-zinc-400"/>
                <circle cx="8" cy="19" r="1"/>
                <circle cx="12" cy="21" r="1"/>
                <circle cx="16" cy="19" r="1"/>
            </svg>
            @break
        @case('50')
            {{-- Mist --}}
            <svg class="w-full h-full text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path d="M5 8h14M3 12h18M5 16h14"/>
            </svg>
            @break
        @default
            <svg class="w-full h-full text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="5"/>
            </svg>
    @endswitch
</div>

