{{--
    AgriAI Theme Configuration

    This file documents the design tokens and color palette used throughout the application.
    Import this partial where you need access to theme-aware utility classes.

    Brand Colors:
    - Lime (Primary):    bg-agri-lime      (#c5d82d) - Main brand accent
    - Lime Light:        bg-agri-lime-light (#d5e83d) - Hover states
    - Lime Dark:         bg-agri-lime-dark  (#b5c82d) - Active states
    - Olive:             text-agri-olive    (#8b9a2d) - Accent text
    - Olive Dark:        text-agri-olive-dark (#6b7a24) - Muted accent text
    - Green:             bg-agri-green      (#4a6d2a) - Nature/field elements
    - Green Dark:        bg-agri-green-dark (#2d4a1a) - Dark nature elements

    Background Colors:
    - Main Background:   bg-agri-bg         (#f8f8f6) - Page background
    - Alt Background:    bg-agri-bg-alt     (#f0f4d4) - Highlighted sections
    - Card Background:   bg-agri-bg-card    (#ffffff) - Card surfaces

    Typography:
    - Font Family: Inter (sans-serif)
    - Headings: font-light to font-medium (300-500)
    - Body: font-normal (400)
    - Accent text style: italic

    Border Radius:
    - Small: rounded-lg (0.5rem)
    - Medium: rounded-xl (0.75rem)
    - Large: rounded-2xl (1rem)
    - Extra Large: rounded-3xl (1.5rem)
    - Pill: rounded-full

    Component Patterns:
    - Buttons: rounded-full with px-6 py-3 padding
    - Cards: rounded-2xl or rounded-3xl with p-6 or p-8 padding
    - Icons in containers: rounded-xl or rounded-2xl
    - Logo grid: 2x2 grid of rounded-sm squares
--}}

{{-- AgriAI Logo Component --}}
@props(['size' => 'md'])

@php
    $sizes = [
        'xs' => 'w-1.5 h-1.5 gap-0.5',
        'sm' => 'w-2 h-2 gap-0.5',
        'md' => 'w-2.5 h-2.5 gap-0.5',
        'lg' => 'w-3 h-3 gap-1',
        'xl' => 'w-4 h-4 gap-1',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $squareSize = explode(' ', $sizeClass)[0] . ' ' . explode(' ', $sizeClass)[1];
    $gapSize = explode(' ', $sizeClass)[2] ?? 'gap-0.5';
@endphp

<div {{ $attributes->merge(['class' => "grid grid-cols-2 {$gapSize}"]) }}>
    <div class="{{ $squareSize }} bg-agri-lime rounded-sm"></div>
    <div class="{{ $squareSize }} bg-agri-lime rounded-sm"></div>
    <div class="{{ $squareSize }} bg-agri-lime rounded-sm"></div>
    <div class="{{ $squareSize }} bg-agri-lime rounded-sm"></div>
</div>

