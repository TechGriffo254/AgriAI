{{--
    AgriAI Section Heading Component

    Usage:
    <x-theme.agri-heading badge="Features">
        Everything you need to <x-slot:accent>grow smarter</x-slot:accent>
    </x-theme.agri-heading>
--}}

@props([
    'badge' => null,
    'centered' => true,
    'description' => null,
])

<div {{ $attributes->merge(['class' => $centered ? 'text-center' : 'text-start']) }}>
    @if($badge)
        <x-theme.agri-badge class="mb-4">{{ $badge }}</x-theme.agri-badge>
    @endif

    <h2 class="text-3xl sm:text-4xl font-light text-zinc-800 dark:text-white">
        {{ $slot }}
        @if(isset($accent))
            <span class="italic text-agri-olive">{{ $accent }}</span>
        @endif
    </h2>

    @if($description)
        <p class="text-zinc-500 dark:text-zinc-400 mt-4 max-w-2xl {{ $centered ? 'mx-auto' : '' }}">
            {{ $description }}
        </p>
    @endif
</div>

