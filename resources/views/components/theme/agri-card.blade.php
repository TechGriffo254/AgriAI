{{--
    AgriAI Card Component

    Usage:
    <x-theme.agri-card>Content here</x-theme.agri-card>
    <x-theme.agri-card variant="highlight">Highlighted content</x-theme.agri-card>
    <x-theme.agri-card variant="dark">Dark card</x-theme.agri-card>
--}}

@props([
    'variant' => 'default',
    'padding' => 'md',
    'hover' => false,
])

@php
    $baseClasses = 'rounded-2xl transition-all duration-300';

    $variants = [
        'default' => 'bg-agri-bg dark:bg-zinc-800',
        'white' => 'bg-white dark:bg-zinc-800',
        'highlight' => 'bg-agri-bg-alt dark:bg-agri-bg-alt',
        'dark' => 'bg-zinc-800 text-white',
        'accent' => 'bg-agri-lime text-zinc-800',
    ];

    $paddings = [
        'sm' => 'p-4',
        'md' => 'p-6',
        'lg' => 'p-8',
        'xl' => 'p-10',
    ];

    $hoverClass = $hover ? 'hover:bg-agri-bg-alt dark:hover:bg-zinc-700 hover:shadow-md cursor-pointer' : '';

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['default']) . ' ' . ($paddings[$padding] ?? $paddings['md']) . ' ' . $hoverClass;
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>

