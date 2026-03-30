{{--
    AgriAI Empty State Component

    Usage:
    <x-theme.agri-empty
        title="No farms yet"
        description="Get started by adding your first farm"
        action-text="Add Your First Farm"
        action-href="/farms/create"
    >
        <x-slot:icon>
            <svg>...</svg>
        </x-slot:icon>
    </x-theme.agri-empty>
--}}

@props([
    'title' => 'Nothing here yet',
    'description' => '',
    'actionText' => null,
    'actionHref' => '#',
])

<div {{ $attributes->merge(['class' => 'text-center py-16 bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700']) }}>
    <div class="w-20 h-20 bg-agri-bg-alt dark:bg-zinc-700 rounded-full flex items-center justify-center mx-auto mb-6">
        @if(isset($icon))
            {{ $icon }}
        @else
            <svg class="w-10 h-10 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
        @endif
    </div>
    <h3 class="text-lg font-medium text-zinc-800 dark:text-white mb-2">{{ $title }}</h3>
    @if($description)
        <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-6 max-w-sm mx-auto">{{ $description }}</p>
    @endif
    @if($actionText)
        <x-theme.agri-button :href="$actionHref" variant="primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            {{ $actionText }}
        </x-theme.agri-button>
    @endif
    {{ $slot }}
</div>

