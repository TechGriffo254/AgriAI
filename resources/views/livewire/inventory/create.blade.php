<div>
    <x-theme.agri-page-header
        title="Add Inventory Item"
        description="Add a new item to your inventory"
        :back-href="route('inventory.index')"
        back-label="Back to Inventory"
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
                        placeholder="e.g., Maize Seeds (Duma 43)"
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
                        placeholder="e.g., Hybrid, Organic"
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
                        placeholder="Additional details about the item..."
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
                        placeholder="e.g., SEED-001"
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
            </div>
        </x-theme.agri-card>

        <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
            <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-6">Stock & Pricing</h2>

            <div class="grid gap-6 md:grid-cols-3">
                <div>
                    <label for="quantity" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Quantity <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        id="quantity"
                        wire:model="quantity"
                        step="0.01"
                        min="0"
                        placeholder="0"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('quantity') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

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
                        placeholder="Alert when stock falls below"
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
                        placeholder="0.00"
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
                        placeholder="e.g., Warehouse A, Shelf 3"
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
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
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
                        placeholder="e.g., Kenya Seed Company"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('supplier') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Image
                    </label>
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
        <div class="flex items-center justify-end gap-3">
            <x-theme.agri-button :href="route('inventory.index')" variant="ghost">
                Cancel
            </x-theme.agri-button>
            <x-theme.agri-button type="submit" variant="primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Add Item
            </x-theme.agri-button>
        </div>
    </form>
</div>
