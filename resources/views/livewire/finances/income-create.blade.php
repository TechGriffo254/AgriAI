<div>
    <x-theme.agri-page-header
        title="Add Income"
        description="Record a new income"
        :back-href="route('finances.index')"
        back-label="Back to Finances"
    />

    <form wire:submit="save" class="space-y-6 max-w-2xl">
        <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
            <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-6">Income Details</h2>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="category" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="category"
                        wire:model="category"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime"
                    >
                        <option value="crop_sales">Crop Sales</option>
                        <option value="livestock">Livestock</option>
                        <option value="services">Services</option>
                        <option value="subsidies">Subsidies</option>
                        <option value="rental">Rental</option>
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
                        placeholder="e.g., Maize, Tomatoes"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime"
                    >
                    @error('subcategory') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="description"
                        wire:model="description"
                        rows="2"
                        placeholder="What was sold or earned?"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime resize-none"
                    ></textarea>
                    @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="buyer" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Buyer / Customer
                    </label>
                    <input
                        type="text"
                        id="buyer"
                        wire:model="buyer"
                        placeholder="Who paid you?"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime"
                    >
                    @error('buyer') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="incomeDate" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Date <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="date"
                        id="incomeDate"
                        wire:model="incomeDate"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime"
                    >
                    @error('incomeDate') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </x-theme.agri-card>

        <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
            <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-6">Quantity & Pricing</h2>

            <div class="grid gap-6 md:grid-cols-3">
                <div>
                    <label for="quantity" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Quantity
                    </label>
                    <input
                        type="number"
                        id="quantity"
                        wire:model.live="quantity"
                        step="0.01"
                        min="0"
                        placeholder="0"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime"
                    >
                    @error('quantity') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="quantityUnit" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Unit
                    </label>
                    <select
                        id="quantityUnit"
                        wire:model="quantityUnit"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime"
                    >
                        <option value="kg">Kilograms (kg)</option>
                        <option value="bags">Bags</option>
                        <option value="crates">Crates</option>
                        <option value="pieces">Pieces</option>
                        <option value="liters">Liters</option>
                        <option value="units">Units</option>
                    </select>
                    @error('quantityUnit') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="unitPrice" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Unit Price (KES)
                    </label>
                    <input
                        type="number"
                        id="unitPrice"
                        wire:model.live="unitPrice"
                        step="0.01"
                        min="0"
                        placeholder="0.00"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime"
                    >
                    @error('unitPrice') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-3">
                    <label for="amount" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Total Amount (KES) <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        id="amount"
                        wire:model="amount"
                        step="0.01"
                        min="0"
                        placeholder="0.00"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime"
                    >
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Auto-calculated if quantity and unit price are provided</p>
                    @error('amount') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </x-theme.agri-card>

        <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
            <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-6">Payment & Farm</h2>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="paymentMethod" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Payment Method
                    </label>
                    <select
                        id="paymentMethod"
                        wire:model="paymentMethod"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime"
                    >
                        <option value="cash">Cash</option>
                        <option value="mpesa">M-Pesa</option>
                        <option value="bank">Bank Transfer</option>
                        <option value="credit">Credit</option>
                        <option value="other">Other</option>
                    </select>
                    @error('paymentMethod') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="paymentStatus" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Payment Status
                    </label>
                    <select
                        id="paymentStatus"
                        wire:model="paymentStatus"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime"
                    >
                        <option value="paid">Paid</option>
                        <option value="partial">Partial</option>
                        <option value="pending">Pending</option>
                    </select>
                    @error('paymentStatus') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="farmId" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Farm
                    </label>
                    <select
                        id="farmId"
                        wire:model.live="farmId"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime"
                    >
                        <option value="">General (not farm-specific)</option>
                        @foreach($farms as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('farmId') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                @if($farmId && $cropCycles->count() > 0)
                    <div>
                        <label for="cropCycleId" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Crop Cycle
                        </label>
                        <select
                            id="cropCycleId"
                            wire:model="cropCycleId"
                            class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime"
                        >
                            <option value="">Not linked to cycle</option>
                            @foreach($cropCycles as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('cropCycleId') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                @endif
            </div>
        </x-theme.agri-card>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3">
            <x-theme.agri-button :href="route('finances.index')" variant="ghost">
                Cancel
            </x-theme.agri-button>
            <x-theme.agri-button type="submit" variant="primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Save Income
            </x-theme.agri-button>
        </div>
    </form>
</div>
