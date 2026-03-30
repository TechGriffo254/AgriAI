{{--
    AgriAI Icon Container Component

    Usage:
    <x-theme.agri-icon-box>
        <svg>...</svg>
    </x-theme.agri-icon-box>
    <x-theme.agri-icon-box variant="lime" size="lg">
        <svg>...</svg>
    </x-theme.agri-icon-box>
--}}

@props([
    'variant' => 'default',
    'size' => 'md',
])

@php
    $baseClasses = 'flex items-center justify-center rounded-2xl transition-all duration-200';

    $variants = [
        'default' => 'bg-white shadow-sm dark:bg-zinc-700',
        'lime' => 'bg-agri-lime',
        'light' => 'bg-agri-bg-alt dark:bg-zinc-700',
        'dark' => 'bg-zinc-800 text-white',
        'outline' => 'border border-zinc-200 dark:border-zinc-700',
    ];

    $sizes = [
        'sm' => 'w-10 h-10',
        'md' => 'w-14 h-14',
        'lg' => 'w-16 h-16',
        'xl' => 'w-20 h-20',
    ];

    $iconSizes = [
        'sm' => '[&>svg]:w-5 [&>svg]:h-5',
        'md' => '[&>svg]:w-7 [&>svg]:h-7',
        'lg' => '[&>svg]:w-8 [&>svg]:h-8',
        'xl' => '[&>svg]:w-10 [&>svg]:h-10',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['default']) . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($iconSizes[$size] ?? $iconSizes['md']);
@endphp

<div {{ $attributes->merge(['class' => $classes . ' text-agri-olive [&>svg]:text-agri-olive']) }}>
    {{ $slot }}
</div>

