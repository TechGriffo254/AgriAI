<div>
    @php
        $isLowStock = $inventory->reorder_level && $inventory->quantity <= $inventory->reorder_level;
    @endphp

    <x-theme.agri-page-header
        :title="$inventory->name"
        :back-href="route('inventory.index')"
        back-label="Back to Inventory"
    >
        <x-slot:badge>
            <x-theme.agri-icon-box variant="light" size="sm">
                @switch($inventory->category)
                    @case('seeds')
                        <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        @break
                    @case('fertilizers')
                        <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                        @break
                    @case('pesticides')
                        <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        @break
                    @case('tools')
                        <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        @break
                    @case('equipment')
                        <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 12a7.5 7.5 0 0015 0m-15 0a7.5 7.5 0 1115 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077l1.41-.513m14.095-5.13l1.41-.513M5.106 17.785l1.15-.964m11.49-9.642l1.149-.964M7.501 19.795l.75-1.3m7.5-12.99l.75-1.3m-6.063 16.658l.26-1.477m2.605-14.772l.26-1.477m0 17.726l-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205L6.75 2.906" />
                        </svg>
                        @break
                    @case('fuel')
                        <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                        </svg>
                        @break
                    @case('feed')
                        <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        @break
                    @default
                        <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                @endswitch
            </x-theme.agri-icon-box>
        </x-slot:badge>
        <x-slot:actions>
            <x-theme.agri-button wire:click="openAdjustModal" variant="outline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Adjust Stock
            </x-theme.agri-button>
            <x-theme.agri-button :href="route('inventory.edit', $inventory)" variant="outline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </x-theme.agri-button>
        </x-slot:actions>
    </x-theme.agri-page-header>

    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Stock Card -->
            <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700 {{ $isLowStock ? 'border-l-4 border-l-orange-500' : '' }}">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 bg-agri-bg dark:bg-zinc-700 rounded-2xl flex items-center justify-center">
                            @include('livewire.inventory.partials.category-icon', ['category' => $inventory->category, 'size' => 'lg'])
                        </div>
                        <div>
                            <p class="text-4xl font-light {{ $isLowStock ? 'text-orange-600 dark:text-orange-400' : 'text-zinc-800 dark:text-white' }}">
                                {{ number_format($inventory->quantity, 1) }}
                            </p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $inventory->unit }} in stock</p>
                            @if($isLowStock)
                                <p class="text-sm text-orange-600 dark:text-orange-400 mt-1 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    Below reorder level ({{ number_format($inventory->reorder_level, 1) }} {{ $inventory->unit }})
                                </p>
                            @endif
                        </div>
                    </div>

                    @if($inventory->unit_cost)
                        <div class="text-right">
                            <p class="text-2xl font-light text-zinc-800 dark:text-white">
                                KES {{ number_format($inventory->quantity * $inventory->unit_cost, 0) }}
                            </p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                Total Value ({{ number_format($inventory->unit_cost, 0) }}/{{ $inventory->unit }})
                            </p>
                        </div>
                    @endif
                </div>
            </x-theme.agri-card>

            <!-- Details -->
            <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                <h3 class="text-lg font-medium text-zinc-800 dark:text-white mb-6">Item Details</h3>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Category</p>
                        <p class="text-sm font-medium text-zinc-800 dark:text-white capitalize">{{ $inventory->category }}</p>
                    </div>

                    @if($inventory->subcategory)
                        <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Subcategory</p>
                            <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $inventory->subcategory }}</p>
                        </div>
                    @endif

                    @if($inventory->sku)
                        <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">SKU</p>
                            <p class="text-sm font-medium text-zinc-800 dark:text-white font-mono">{{ $inventory->sku }}</p>
                        </div>
                    @endif

                    @if($inventory->storage_location)
                        <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Storage Location</p>
                            <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $inventory->storage_location }}</p>
                        </div>
                    @endif

                    @if($inventory->supplier)
                        <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Supplier</p>
                            <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $inventory->supplier }}</p>
                        </div>
                    @endif

                    @if($inventory->expiry_date)
                        <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl {{ $inventory->expiry_date->isPast() ? 'ring-2 ring-red-500' : ($inventory->expiry_date->diffInDays() <= 30 ? 'ring-2 ring-orange-500' : '') }}">
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Expiry Date</p>
                            <p class="text-sm font-medium {{ $inventory->expiry_date->isPast() ? 'text-red-600' : 'text-zinc-800 dark:text-white' }}">
                                {{ $inventory->expiry_date->format('M j, Y') }}
                                @if($inventory->expiry_date->isPast())
                                    <span class="text-red-600">(Expired)</span>
                                @elseif($inventory->expiry_date->diffInDays() <= 30)
                                    <span class="text-orange-600">({{ $inventory->expiry_date->diffForHumans() }})</span>
                                @endif
                            </p>
                        </div>
                    @endif
                </div>

                @if($inventory->description)
                    <div class="mt-6 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-2">Description</p>
                        <p class="text-sm text-zinc-800 dark:text-white">{{ $inventory->description }}</p>
                    </div>
                @endif
            </x-theme.agri-card>

            <!-- Transaction History -->
            <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                <h3 class="text-lg font-medium text-zinc-800 dark:text-white mb-6">Recent Transactions</h3>

                @if($inventory->transactions->count() > 0)
                    <div class="space-y-3">
                        @foreach($inventory->transactions as $transaction)
                            <div class="flex items-center justify-between p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $transaction->type === 'stock_in' ? 'bg-green-100 dark:bg-green-900/30' : ($transaction->type === 'stock_out' ? 'bg-red-100 dark:bg-red-900/30' : 'bg-blue-100 dark:bg-blue-900/30') }}">
                                        @if($transaction->type === 'stock_in')
                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8l-8 8-8-8" />
                                            </svg>
                                        @elseif($transaction->type === 'stock_out')
                                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20V4m-8 8l8-8 8 8" />
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-zinc-800 dark:text-white capitalize">
                                            {{ str_replace('_', ' ', $transaction->type) }}
                                        </p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ $transaction->created_at->format('M j, Y g:i A') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium {{ $transaction->type === 'stock_in' ? 'text-green-600' : ($transaction->type === 'stock_out' ? 'text-red-600' : 'text-blue-600') }}">
                                        {{ $transaction->type === 'stock_in' ? '+' : ($transaction->type === 'stock_out' ? '-' : '±') }}{{ number_format($transaction->quantity, 1) }}
                                    </p>
                                    <p class="text-xs text-zinc-500">
                                        {{ number_format($transaction->quantity_before, 1) }} → {{ number_format($transaction->quantity_after, 1) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-8">No transactions yet</p>
                @endif
            </x-theme.agri-card>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            @if($inventory->farm)
                <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-4">Farm</h3>
                    <a href="{{ route('farms.show', $inventory->farm) }}" wire:navigate class="flex items-center gap-3 p-3 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-800 transition-colors">
                        <div class="w-10 h-10 bg-gradient-to-br from-agri-green to-agri-green-dark rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $inventory->farm->name }}</p>
                        </div>
                    </a>
                </x-theme.agri-card>
            @endif

            <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-4">Actions</h3>
                <div class="space-y-2">
                    <button wire:click="openAdjustModal" class="w-full flex items-center gap-3 p-3 bg-agri-lime/10 rounded-xl hover:bg-agri-lime/20 transition-colors text-left">
                        <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span class="text-sm font-medium text-agri-olive-dark dark:text-agri-lime">Adjust Stock</span>
                    </button>
                    <a href="{{ route('inventory.edit', $inventory) }}" wire:navigate class="flex items-center gap-3 p-3 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-800 transition-colors">
                        <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="text-sm font-medium text-zinc-800 dark:text-white">Edit Item</span>
                    </a>
                    <button
                        wire:click="delete"
                        wire:confirm="Are you sure you want to delete this item?"
                        class="w-full flex items-center gap-3 p-3 bg-red-50 dark:bg-red-900/20 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors text-left"
                    >
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span class="text-sm font-medium text-red-600 dark:text-red-400">Delete Item</span>
                    </button>
                </div>
            </x-theme.agri-card>
        </div>
    </div>

    <!-- Adjust Stock Modal -->
    @if($showAdjustModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" x-data @keydown.escape.window="$wire.closeAdjustModal()">
            <div class="w-full max-w-md bg-white dark:bg-zinc-800 rounded-2xl shadow-xl" @click.outside="$wire.closeAdjustModal()">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-lg font-medium text-zinc-800 dark:text-white">Adjust Stock</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Current: {{ number_format($inventory->quantity, 1) }} {{ $inventory->unit }}</p>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Adjustment Type</label>
                        <div class="grid grid-cols-3 gap-2">
                            <button
                                type="button"
                                wire:click="$set('adjustType', 'add')"
                                class="p-3 rounded-xl text-center transition-colors {{ $adjustType === 'add' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 ring-2 ring-green-500' : 'bg-agri-bg dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400' }}"
                            >
                                <svg class="w-5 h-5 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span class="text-xs font-medium">Add</span>
                            </button>
                            <button
                                type="button"
                                wire:click="$set('adjustType', 'remove')"
                                class="p-3 rounded-xl text-center transition-colors {{ $adjustType === 'remove' ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 ring-2 ring-red-500' : 'bg-agri-bg dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400' }}"
                            >
                                <svg class="w-5 h-5 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                                <span class="text-xs font-medium">Remove</span>
                            </button>
                            <button
                                type="button"
                                wire:click="$set('adjustType', 'adjust')"
                                class="p-3 rounded-xl text-center transition-colors {{ $adjustType === 'adjust' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 ring-2 ring-blue-500' : 'bg-agri-bg dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400' }}"
                            >
                                <svg class="w-5 h-5 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span class="text-xs font-medium">Set</span>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="adjustQuantity" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            {{ $adjustType === 'adjust' ? 'New Quantity' : 'Quantity' }}
                        </label>
                        <div class="relative">
                            <input
                                type="number"
                                id="adjustQuantity"
                                wire:model="adjustQuantity"
                                step="0.01"
                                min="0"
                                class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                            >
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-zinc-400">{{ $inventory->unit }}</span>
                        </div>
                        @error('adjustQuantity') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="adjustNotes" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Notes (Optional)</label>
                        <textarea
                            id="adjustNotes"
                            wire:model="adjustNotes"
                            rows="2"
                            placeholder="Reason for adjustment..."
                            class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent resize-none"
                        ></textarea>
                    </div>
                </div>

                <div class="p-6 bg-agri-bg dark:bg-zinc-900 rounded-b-2xl flex items-center justify-end gap-3">
                    <button
                        type="button"
                        wire:click="closeAdjustModal"
                        class="px-4 py-2 text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-zinc-200"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        wire:click="adjustStock"
                        class="px-4 py-2 bg-agri-lime text-zinc-800 text-sm font-medium rounded-xl hover:bg-agri-lime-light transition-colors"
                    >
                        Confirm Adjustment
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
