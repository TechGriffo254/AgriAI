<div>
    <x-theme.agri-page-header
        title="Market Prices"
        description="Track commodity prices across markets"
    >
        <x-slot:actions>
            <x-theme.agri-button :href="route('market.create')" variant="primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Price
            </x-theme.agri-button>
        </x-slot:actions>
    </x-theme.agri-page-header>

    <!-- Top Commodities Cards -->
    @if($topCommodities->count() > 0)
        <div class="grid gap-4 md:grid-cols-3 lg:grid-cols-6 mb-6">
            @foreach($topCommodities as $top)
                <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                    <div class="text-center">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">{{ $top->commodity }}</p>
                        <p class="text-xl font-bold text-zinc-800 dark:text-white mt-1">
                            KES {{ number_format($top->price, 0) }}
                        </p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">per {{ $top->unit }}</p>
                        @if($top->price_change_percent)
                            <p class="text-xs mt-1 {{ $top->price_change_percent >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $top->price_change_percent >= 0 ? '+' : '' }}{{ number_format($top->price_change_percent, 1) }}%
                            </p>
                        @endif
                    </div>
                </x-theme.agri-card>
            @endforeach
        </div>
    @endif

    <!-- Filters -->
    <div class="mb-6 grid gap-4 md:grid-cols-4">
        <div class="md:col-span-2 relative">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search commodities, markets..."
                class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime"
            >
        </div>
        <select
            wire:model.live="commodity"
            class="w-full px-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime"
        >
            <option value="">All Commodities</option>
            @foreach($commodities as $c)
                <option value="{{ $c }}">{{ $c }}</option>
            @endforeach
        </select>
        <select
            wire:model.live="location"
            class="w-full px-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime"
        >
            <option value="">All Locations</option>
            @foreach($locations as $loc)
                <option value="{{ $loc }}">{{ $loc }}</option>
            @endforeach
        </select>
    </div>

    <!-- Prices Table -->
    @if($prices->count() > 0)
        <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700 overflow-hidden p-0">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-agri-bg dark:bg-zinc-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase cursor-pointer hover:text-zinc-700" wire:click="sortBy('commodity')">
                                <div class="flex items-center gap-1">
                                    Commodity
                                    @if($sortBy === 'commodity')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDir === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Market</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Location</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase cursor-pointer hover:text-zinc-700" wire:click="sortBy('price')">
                                <div class="flex items-center justify-end gap-1">
                                    Price
                                    @if($sortBy === 'price')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDir === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Range</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase cursor-pointer hover:text-zinc-700" wire:click="sortBy('price_date')">
                                <div class="flex items-center gap-1">
                                    Date
                                    @if($sortBy === 'price_date')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDir === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($prices as $price)
                            <tr wire:key="price-{{ $price->id }}" class="hover:bg-agri-bg/50 dark:hover:bg-zinc-800/50">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $price->commodity }}</p>
                                        @if($price->variety)
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $price->variety }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $price->market_name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $price->location ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <p class="text-sm font-medium text-zinc-800 dark:text-white">
                                        KES {{ number_format($price->price, 0) }}/{{ $price->unit }}
                                    </p>
                                    @if($price->price_change_percent)
                                        <p class="text-xs {{ $price->price_change_percent >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $price->price_change_percent >= 0 ? '+' : '' }}{{ number_format($price->price_change_percent, 1) }}%
                                        </p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center text-xs text-zinc-500 dark:text-zinc-400">
                                    @if($price->price_min && $price->price_max)
                                        {{ number_format($price->price_min, 0) }} - {{ number_format($price->price_max, 0) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $price->price_date->format('M j, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('market.show', $price) }}" wire:navigate class="p-2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <button
                                            wire:click="delete({{ $price->id }})"
                                            wire:confirm="Delete this price entry?"
                                            class="p-2 text-zinc-400 hover:text-red-500"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-theme.agri-card>
        <div class="mt-4">
            {{ $prices->links() }}
        </div>
    @else
        <x-theme.agri-empty
            title="No market prices yet"
            description="Start tracking commodity prices"
            action-text="Add Price"
            :action-href="route('market.create')"
        >
            <x-slot:icon>
                <svg class="w-10 h-10 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </x-slot:icon>
        </x-theme.agri-empty>
    @endif
</div>
