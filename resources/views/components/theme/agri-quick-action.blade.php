{{--
    AgriAI Quick Action Item Component

    Usage:
    <x-theme.agri-quick-action href="/path" icon="plus">
        Add Crop Cycle
    </x-theme.agri-quick-action>
--}}

@props([
    'href' => '#',
    'navigate' => true,
])

<a
    href="{{ $href }}"
    @if($navigate) wire:navigate @endif
    {{ $attributes->merge(['class' => 'flex items-center gap-3 p-3 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-700 transition-colors']) }}
>
    @if(isset($icon))
        <x-theme.agri-icon-box variant="light" size="sm">
            {{ $icon }}
        </x-theme.agri-icon-box>
    @endif
    <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $slot }}</span>
</a>

