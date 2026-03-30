@props([
    'title',
    'description',
    'icon' => null,
])

<div class="flex w-full flex-col text-center mb-2">
    @if($icon)
        <div class="flex justify-center mb-4">
            <div class="w-14 h-14 bg-agri-bg dark:bg-zinc-700 rounded-2xl flex items-center justify-center">
                {!! $icon !!}
            </div>
        </div>
    @endif
    <h1 class="text-2xl font-semibold text-zinc-800 dark:text-white mb-2">{{ $title }}</h1>
    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $description }}</p>
</div>
