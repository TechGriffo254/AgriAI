{{--
    AgriAI Page Header Component

    Usage:
    <x-theme.agri-page-header
        title="My Farms"
        description="Manage your farm properties"
        back-href="/dashboard"
        back-label="Back to Dashboard"
    >
        <x-slot:actions>
            <x-theme.agri-button href="/farms/create">Add Farm</x-theme.agri-button>
        </x-slot:actions>
    </x-theme.agri-page-header>
--}}

@props([
    'title' => '',
    'description' => null,
    'backHref' => null,
    'backLabel' => 'Back',
])

<div class="mb-8">
    @if($backHref)
        <a href="{{ $backHref }}" wire:navigate class="inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            {{ $backLabel }}
        </a>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-light text-zinc-800 dark:text-white">{{ $title }}</h1>
                @if(isset($badge))
                    {{ $badge }}
                @endif
            </div>
            @if($description)
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">{{ $description }}</p>
            @endif
        </div>
        @if(isset($actions))
            <div class="flex items-center gap-2">
                {{ $actions }}
            </div>
        @endif
    </div>
</div>

