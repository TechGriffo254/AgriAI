<div>
    <div class="mb-8">
        <a href="{{ route('crop-cycles.show', $cropCycle) }}" wire:navigate class="inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Crop Cycle
        </a>
        <h1 class="text-2xl font-light text-zinc-800 dark:text-white">Edit Crop Cycle</h1>
        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Update crop cycle details</p>
    </div>

    <form wire:submit="save" class="space-y-8">
        <!-- Crop & Status -->
        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-6">Crop & Status</h2>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="cropId" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Crop *</label>
                    <select
                        id="cropId"
                        wire:model="cropId"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                        @foreach($crops as $crop)
                            <option value="{{ $crop->id }}">{{ $crop->name }} @if($crop->variety)({{ $crop->variety }})@endif</option>
                        @endforeach
                    </select>
                    @error('cropId') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Status *</label>
                    <select
                        id="status"
                        wire:model="status"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                        <option value="planning">Planning</option>
                        <option value="active">Active</option>
                        <option value="harvested">Harvested</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    @error('status') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Cycle Name</label>
                    <input
                        type="text"
                        id="name"
                        wire:model="name"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="fieldSection" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Field/Section</label>
                    <input
                        type="text"
                        id="fieldSection"
                        wire:model="fieldSection"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('fieldSection') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Dates & Area -->
        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-6">Dates & Area</h2>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="plantingDate" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Planting Date *</label>
                    <input
                        type="date"
                        id="plantingDate"
                        wire:model="plantingDate"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('plantingDate') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="expectedHarvestDate" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Expected Harvest</label>
                    <input
                        type="date"
                        id="expectedHarvestDate"
                        wire:model="expectedHarvestDate"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('expectedHarvestDate') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="actualHarvestDate" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Actual Harvest Date</label>
                    <input
                        type="date"
                        id="actualHarvestDate"
                        wire:model="actualHarvestDate"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('actualHarvestDate') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="area" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Area Planted</label>
                    <div class="flex gap-2">
                        <input
                            type="number"
                            id="area"
                            wire:model="area"
                            step="0.1"
                            class="flex-1 px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                        >
                        <select
                            wire:model="areaUnit"
                            class="px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                        >
                            <option value="acres">Acres</option>
                            <option value="hectares">Hectares</option>
                            <option value="square_meters">Sq. Meters</option>
                        </select>
                    </div>
                    @error('area') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Yield -->
        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-6">Yield</h2>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="expectedYield" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Expected Yield</label>
                    <div class="flex gap-2">
                        <input
                            type="number"
                            id="expectedYield"
                            wire:model="expectedYield"
                            step="0.1"
                            class="flex-1 px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                        >
                        <select
                            wire:model="yieldUnit"
                            class="px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                        >
                            <option value="kg">Kg</option>
                            <option value="tons">Tons</option>
                            <option value="bags">Bags</option>
                            <option value="crates">Crates</option>
                        </select>
                    </div>
                    @error('expectedYield') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="actualYield" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Actual Yield</label>
                    <input
                        type="number"
                        id="actualYield"
                        wire:model="actualYield"
                        step="0.1"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('actualYield') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Seed Information -->
        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-6">Seed Information</h2>

            <div class="grid gap-6 md:grid-cols-3">
                <div>
                    <label for="seedSource" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Seed Source</label>
                    <input
                        type="text"
                        id="seedSource"
                        wire:model="seedSource"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                </div>

                <div>
                    <label for="seedVariety" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Seed Variety</label>
                    <input
                        type="text"
                        id="seedVariety"
                        wire:model="seedVariety"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                </div>

                <div>
                    <label for="seedQuantity" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Seed Quantity</label>
                    <div class="flex gap-2">
                        <input
                            type="number"
                            id="seedQuantity"
                            wire:model="seedQuantity"
                            step="0.1"
                            class="flex-1 px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                        >
                        <select
                            wire:model="seedUnit"
                            class="px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                        >
                            <option value="kg">Kg</option>
                            <option value="g">Grams</option>
                            <option value="pieces">Pieces</option>
                            <option value="packets">Packets</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes -->
        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-6">Notes</h2>
            <textarea
                wire:model="notes"
                rows="4"
                class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent resize-none"
            ></textarea>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('crop-cycles.show', $cropCycle) }}" wire:navigate class="px-6 py-2.5 text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-zinc-200 transition-colors">
                Cancel
            </a>
            <button
                type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-agri-lime text-zinc-800 text-sm font-medium rounded-full hover:bg-agri-lime-light transition-colors disabled:opacity-50"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove wire:target="save">Save Changes</span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Saving...
                </span>
            </button>
        </div>
    </form>
</div>

