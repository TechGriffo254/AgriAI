{{--
    AgriAI Input Component

    Usage:
    <x-theme.agri-input name="name" label="Farm Name" wire:model="name" required />
    <x-theme.agri-input type="select" name="status" label="Status" wire:model="status" :options="$statuses" />
--}}

@props([
    'type' => 'text',
    'name' => '',
    'label' => null,
    'placeholder' => '',
    'required' => false,
    'options' => [],
    'error' => null,
])

<div>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
            {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif

    @if($type === 'select')
        <select
            id="{{ $name }}"
            {{ $attributes->merge(['class' => 'w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent']) }}
        >
            {{ $slot }}
            @foreach($options as $value => $optionLabel)
                <option value="{{ $value }}">{{ $optionLabel }}</option>
            @endforeach
        </select>
    @elseif($type === 'textarea')
        <textarea
            id="{{ $name }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => 'w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent resize-none']) }}
        ></textarea>
    @else
        <input
            type="{{ $type }}"
            id="{{ $name }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => 'w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent']) }}
        >
    @endif

    @if($error)
        <p class="mt-1 text-sm text-red-500">{{ $error }}</p>
    @endif
</div>

