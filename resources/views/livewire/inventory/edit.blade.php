<div>
    <x-theme.agri-page-header
        title="Edit Inventory Item"
        :back-href="route('inventory.show', $inventory)"
        back-label="Back to Item"
    />

    <form wire:submit="save" class="space-y-6">
        <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
            <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-6">Item Details</h2>

            <div class="grid gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Item Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        wire:model="name"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="category"
                        wire:model="category"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                        <option value="seeds">Seeds</option>
                        <option value="fertilizers">Fertilizers</option>
                        <option value="pesticides">Pesticides</option>
                        <option value="tools">Tools</option>
                        <option value="equipment">Equipment</option>
                        <option value="fuel">Fuel</option>
                        <option value="feed">Feed</option>
                        <option value="other">Other</option>
                    </select>
                    @error('category') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="subcategory" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Subcategory
                    </label>
                    <input
                        type="text"
                        id="subcategory"
                        wire:model="subcategory"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('subcategory') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Description
                    </label>
                    <textarea
                        id="description"
                        wire:model="description"
                        rows="2"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent resize-none"
                    ></textarea>
                    @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="sku" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        SKU / Item Code
                    </label>
                    <input
                        type="text"
                        id="sku"
                        wire:model="sku"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('sku') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="farmId" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Farm
                    </label>
                    <select
                        id="farmId"
                        wire:model="farmId"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                        <option value="">General (not farm-specific)</option>
                        @foreach($farms as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('farmId') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input
                            type="checkbox"
                            wire:model="isActive"
                            class="w-5 h-5 rounded border-zinc-300 text-agri-lime focus:ring-agri-lime"
                        >
                        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Item is active</span>
                    </label>
                </div>
            </div>
        </x-theme.agri-card>

        <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
            <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-6">Stock & Pricing</h2>

            <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl mb-6">
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    <strong>Current Stock:</strong> {{ number_format($inventory->quantity, 1) }} {{ $inventory->unit }}
                    <span class="text-zinc-400">|</span>
                    <a href="{{ route('inventory.show', $inventory) }}" wire:navigate class="text-agri-olive hover:text-agri-olive-dark dark:text-agri-lime">
                        Adjust stock from item details page →
                    </a>
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                <div>
                    <label for="unit" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Unit <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="unit"
                        wire:model="unit"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                        <option value="kg">Kilograms (kg)</option>
                        <option value="g">Grams (g)</option>
                        <option value="l">Liters (L)</option>
                        <option value="ml">Milliliters (ml)</option>
                        <option value="pieces">Pieces</option>
                        <option value="bags">Bags</option>
                        <option value="boxes">Boxes</option>
                        <option value="units">Units</option>
                    </select>
                    @error('unit') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="reorderLevel" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Reorder Level
                    </label>
                    <input
                        type="number"
                        id="reorderLevel"
                        wire:model="reorderLevel"
                        step="0.01"
                        min="0"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('reorderLevel') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="unitCost" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Unit Cost (KES)
                    </label>
                    <input
                        type="number"
                        id="unitCost"
                        wire:model="unitCost"
                        step="0.01"
                        min="0"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('unitCost') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="storageLocation" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Storage Location
                    </label>
                    <input
                        type="text"
                        id="storageLocation"
                        wire:model="storageLocation"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('storageLocation') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="expiryDate" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Expiry Date
                    </label>
                    <input
                        type="date"
                        id="expiryDate"
                        wire:model="expiryDate"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('expiryDate') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="supplier" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Supplier
                    </label>
                    <input
                        type="text"
                        id="supplier"
                        wire:model="supplier"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('supplier') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Image
                    </label>
                    @if($inventory->image_path && !$image)
                        <div class="mb-2 flex items-center gap-2">
                            <img src="{{ Storage::url($inventory->image_path) }}" alt="Current" class="w-12 h-12 object-cover rounded-lg">
                            <span class="text-xs text-zinc-500">Current image</span>
                        </div>
                    @endif
                    <input
                        type="file"
                        id="image"
                        wire:model="image"
                        accept="image/*"
                        class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-agri-lime file:text-zinc-800"
                    >
                    @error('image') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </x-theme.agri-card>

        <!-- Actions -->
        <div class="flex items-center justify-between">
            <button
                type="button"
                wire:click="delete"
                wire:confirm="Are you sure you want to delete this item?"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete Item
            </button>

            <div class="flex items-center gap-3">
                <x-theme.agri-button :href="route('inventory.show', $inventory)" variant="ghost">
                    Cancel
                </x-theme.agri-button>
                <x-theme.agri-button type="submit" variant="primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Save Changes
                </x-theme.agri-button>
            </div>
        </div>
    </form>
</div>
