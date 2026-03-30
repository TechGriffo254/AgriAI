<div>
    <x-theme.agri-page-header
        title="Inventory"
        description="Manage your farm supplies, seeds, and equipment"
    >
        <x-slot:actions>
            <x-theme.agri-button :href="route('inventory.create')" variant="primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Item
            </x-theme.agri-button>
        </x-slot:actions>
    </x-theme.agri-page-header>

    <!-- Stats -->
    <div class="grid gap-4 md:grid-cols-3 mb-6">
        <x-theme.agri-stat
            :value="$stats['total_items']"
            label="Total Items"
            layout="inline"
        >
            <x-slot:icon>
                <svg class="w-6 h-6 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </x-slot:icon>
        </x-theme.agri-stat>

        <x-theme.agri-stat
            :value="$stats['low_stock']"
            label="Low Stock Items"
            layout="inline"
            variant="alt"
            :class="$stats['low_stock'] > 0 ? 'border-l-4 border-l-orange-500' : ''"
        >
            <x-slot:icon>
                <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </x-slot:icon>
        </x-theme.agri-stat>

        <x-theme.agri-stat
            :value="'KES ' . number_format($stats['total_value'], 0)"
            label="Total Value"
            layout="inline"
            variant="accent"
        >
            <x-slot:icon>
                <svg class="w-6 h-6 text-zinc-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </x-slot:icon>
        </x-theme.agri-stat>
    </div>

    <!-- Filters -->
    <div class="mb-6 grid gap-4 md:grid-cols-4">
        <div class="relative">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search inventory..."
                class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
            >
        </div>

        <select
            wire:model.live="category"
            class="w-full px-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
        >
            <option value="">All Categories</option>
            <option value="seeds">🌱 Seeds</option>
            <option value="fertilizers">🧪 Fertilizers</option>
            <option value="pesticides">🐛 Pesticides</option>
            <option value="tools">🔧 Tools</option>
            <option value="equipment">⚙️ Equipment</option>
            <option value="fuel">⛽ Fuel</option>
            <option value="feed">🌾 Feed</option>
            <option value="other">📦 Other</option>
        </select>

        <select
            wire:model.live="farmId"
            class="w-full px-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
        >
            <option value="">All Farms</option>
            @foreach($farms as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>

        <label class="flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl cursor-pointer">
            <input type="checkbox" wire:model.live="lowStockOnly" class="w-4 h-4 rounded border-zinc-300 text-agri-lime focus:ring-agri-lime">
            <span class="text-sm text-zinc-700 dark:text-zinc-300">Low Stock Only</span>
        </label>
    </div>

    <!-- Inventory Grid -->
    @if($items->count() > 0)
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach($items as $item)
                @php
                    $isLowStock = $item->reorder_level && $item->quantity <= $item->reorder_level;
                    $categoryIcons = [
                        'seeds' => '🌱',
                        'fertilizers' => '🧪',
                        'pesticides' => '🐛',
                        'tools' => '🔧',
                        'equipment' => '⚙️',
                        'fuel' => '⛽',
                        'feed' => '🌾',
                        'other' => '📦',
                    ];
                @endphp
                <div wire:key="item-{{ $item->id }}" class="group bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 hover:border-agri-lime dark:hover:border-agri-lime transition-all duration-300 overflow-hidden {{ $isLowStock ? 'border-l-4 border-l-orange-500' : '' }}">
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-start gap-3 flex-1 min-w-0">
                                <div class="w-12 h-12 bg-agri-bg dark:bg-zinc-700 rounded-xl flex items-center justify-center shrink-0 text-2xl">
                                    {{ $categoryIcons[$item->category] ?? '📦' }}
                                </div>
                                <div class="min-w-0">
                                    <a href="{{ route('inventory.show', $item) }}" wire:navigate class="text-base font-medium text-zinc-800 dark:text-white hover:text-agri-olive dark:hover:text-agri-lime truncate block">
                                        {{ $item->name }}
                                    </a>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 capitalize">{{ $item->category }}</p>
                                </div>
                            </div>
                            @if(!$item->is_active)
                                <span class="px-2 py-0.5 bg-zinc-200 dark:bg-zinc-700 rounded-full text-xs text-zinc-600 dark:text-zinc-400">Inactive</span>
                            @endif
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <p class="text-2xl font-light {{ $isLowStock ? 'text-orange-600 dark:text-orange-400' : 'text-zinc-800 dark:text-white' }}">
                                    {{ number_format($item->quantity, 1) }}
                                </p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $item->unit }}</p>
                            </div>
                            @if($item->unit_cost)
                                <div class="text-right">
                                    <p class="text-sm font-medium text-zinc-800 dark:text-white">
                                        KES {{ number_format($item->unit_cost, 0) }}
                                    </p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">per {{ $item->unit }}</p>
                                </div>
                            @endif
                        </div>

                        @if($isLowStock)
                            <div class="mt-3 px-3 py-2 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                                <p class="text-xs text-orange-700 dark:text-orange-400">
                                    ⚠️ Low stock - reorder level: {{ number_format($item->reorder_level, 1) }} {{ $item->unit }}
                                </p>
                            </div>
                        @endif

                        @if($item->farm)
                            <div class="mt-3 text-xs text-zinc-500 dark:text-zinc-400 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                {{ $item->farm->name }}
                            </div>
                        @endif
                    </div>

                    <div class="px-5 py-3 bg-agri-bg dark:bg-zinc-900 flex items-center justify-between">
                        <a href="{{ route('inventory.show', $item) }}" wire:navigate class="text-sm font-medium text-agri-olive hover:text-agri-olive-dark dark:text-agri-lime">
                            View Details →
                        </a>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('inventory.edit', $item) }}" wire:navigate class="p-2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <button
                                wire:click="deleteItem({{ $item->id }})"
                                wire:confirm="Are you sure you want to delete this item?"
                                class="p-2 text-zinc-400 hover:text-red-500 transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $items->links() }}
        </div>
    @else
        <x-theme.agri-empty
            title="No inventory items"
            description="Add your first inventory item to start tracking supplies"
            action-text="Add Your First Item"
            :action-href="route('inventory.create')"
        >
            <x-slot:icon>
                <svg class="w-10 h-10 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </x-slot:icon>
        </x-theme.agri-empty>
    @endif
</div>
