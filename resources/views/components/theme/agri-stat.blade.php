{{--
    AgriAI Stat Card Component

    Usage:
    <x-theme.agri-stat value="32%" label="Yield Increase" />
    <x-theme.agri-stat value="10K+" label="Active Farmers" variant="accent" />
    <x-theme.agri-stat value="50" label="Total Farms" layout="inline">
        <x-slot:icon>
            <svg>...</svg>
        </x-slot:icon>
    </x-theme.agri-stat>
--}}

@props([
    'value' => '',
    'label' => '',
    'variant' => 'default',
    'layout' => 'centered',
    'border' => true,
])

@php
    $variants = [
        'default' => 'bg-white dark:bg-zinc-800',
        'accent' => 'bg-agri-lime',
        'dark' => 'bg-zinc-800 text-white',
        'alt' => 'bg-agri-bg-alt dark:bg-zinc-700',
    ];

    $textColor = $variant === 'dark' ? 'text-white' : ($variant === 'accent' ? 'text-zinc-800' : 'text-zinc-800 dark:text-white');
    $labelColor = $variant === 'dark' ? 'text-zinc-400' : ($variant === 'accent' ? 'text-zinc-700' : 'text-zinc-500 dark:text-zinc-400');
    $borderClass = $border && $variant === 'default' ? 'border border-zinc-200 dark:border-zinc-700' : '';
@endphp

@if($layout === 'inline')
    <div {{ $attributes->merge(['class' => 'rounded-2xl p-5 ' . ($variants[$variant] ?? $variants['default']) . ' ' . $borderClass]) }}>
        <div class="flex items-center gap-3">
            @if(isset($icon))
                <div class="w-10 h-10 {{ $variant === 'accent' ? 'bg-white/30' : 'bg-agri-bg-alt dark:bg-zinc-700' }} rounded-xl flex items-center justify-center">
                    {{ $icon }}
                </div>
            @endif
            <div>
                <p class="text-xl font-light {{ $textColor }}">{{ $value }}</p>
                <p class="text-xs {{ $labelColor }}">{{ $label }}</p>
            </div>
        </div>
    </div>
@else
    <div {{ $attributes->merge(['class' => 'text-center p-8 rounded-3xl ' . ($variants[$variant] ?? $variants['default']) . ' ' . $borderClass]) }}>
        <div class="text-4xl lg:text-5xl font-light {{ $textColor }} mb-2">{{ $value }}</div>
        <div class="text-sm {{ $labelColor }}">{{ $label }}</div>

        @if(isset($icon))
            <div class="mt-3 w-8 h-8 bg-agri-lime rounded-full flex items-center justify-center mx-auto">
                {{ $icon }}
            </div>
        @endif
    </div>
@endif

