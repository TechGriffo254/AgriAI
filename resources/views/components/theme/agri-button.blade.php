{{--
    AgriAI Button Component

    Usage:
    <x-theme.agri-button>Click me</x-theme.agri-button>
    <x-theme.agri-button variant="secondary">Secondary</x-theme.agri-button>
    <x-theme.agri-button variant="outline">Outline</x-theme.agri-button>
    <x-theme.agri-button variant="dark" with-logo>With Logo</x-theme.agri-button>
--}}

@props([
    'variant' => 'primary',
    'size' => 'md',
    'withLogo' => false,
    'href' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2';

    $variants = [
        'primary' => 'bg-agri-lime text-zinc-800 hover:bg-agri-lime-light focus:ring-agri-lime',
        'secondary' => 'bg-zinc-200 text-zinc-700 hover:bg-zinc-300 focus:ring-zinc-400',
        'dark' => 'bg-zinc-800 text-white hover:bg-zinc-700 focus:ring-zinc-600',
        'outline' => 'bg-white border border-zinc-200 text-zinc-800 hover:border-agri-lime hover:bg-agri-bg focus:ring-agri-lime',
        'ghost' => 'bg-transparent text-zinc-600 hover:text-zinc-900 hover:bg-zinc-100 focus:ring-zinc-400',
    ];

    $sizes = [
        'sm' => 'px-4 py-2 text-sm gap-2',
        'md' => 'px-6 py-3 text-sm gap-3',
        'lg' => 'px-8 py-4 text-base gap-3',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($withLogo)
            <div class="grid grid-cols-2 gap-0.5">
                <div class="w-1.5 h-1.5 bg-agri-lime rounded-[2px]"></div>
                <div class="w-1.5 h-1.5 bg-agri-lime rounded-[2px]"></div>
                <div class="w-1.5 h-1.5 bg-agri-lime rounded-[2px]"></div>
                <div class="w-1.5 h-1.5 bg-agri-lime rounded-[2px]"></div>
            </div>
        @endif
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes, 'type' => 'button']) }}>
        @if($withLogo)
            <div class="grid grid-cols-2 gap-0.5">
                <div class="w-1.5 h-1.5 bg-agri-lime rounded-[2px]"></div>
                <div class="w-1.5 h-1.5 bg-agri-lime rounded-[2px]"></div>
                <div class="w-1.5 h-1.5 bg-agri-lime rounded-[2px]"></div>
                <div class="w-1.5 h-1.5 bg-agri-lime rounded-[2px]"></div>
            </div>
        @endif
        {{ $slot }}
    </button>
@endif

