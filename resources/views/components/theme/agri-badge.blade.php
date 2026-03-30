{{--
    AgriAI Badge Component

    Usage:
    <x-theme.agri-badge>Default</x-theme.agri-badge>
    <x-theme.agri-badge variant="lime">Lime badge</x-theme.agri-badge>
    <x-theme.agri-badge variant="dark">Dark badge</x-theme.agri-badge>
--}}

@props([
    'variant' => 'default',
    'size' => 'md',
])

@php
    $baseClasses = 'inline-flex items-center font-medium rounded-full';

    $variants = [
        'default' => 'bg-agri-bg-alt text-agri-olive-dark dark:bg-agri-bg-alt dark:text-agri-olive',
        'lime' => 'bg-agri-lime text-zinc-800',
        'dark' => 'bg-zinc-800 text-white dark:bg-zinc-700',
        'outline' => 'bg-transparent border border-zinc-200 text-zinc-600 dark:border-zinc-700 dark:text-zinc-400',
        'success' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
        'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
        'error' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
    ];

    $sizes = [
        'sm' => 'px-2 py-0.5 text-xs',
        'md' => 'px-3 py-1 text-sm',
        'lg' => 'px-4 py-1.5 text-sm',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['default']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>

