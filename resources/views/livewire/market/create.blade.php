<div>
    <x-theme.agri-page-header
        title="Add Market Price"
        description="Record a new commodity price"
    >
        <x-slot:actions>
            <x-theme.agri-button :href="route('market.index')" variant="secondary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </x-theme.agri-button>
        </x-slot:actions>
    </x-theme.agri-page-header>

    <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700 max-w-3xl">
        <form wire:submit="save" class="space-y-6">
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Commodity -->
                <div>
                    <x-theme.agri-input
                        name="commodity"
                        label="Commodity"
                        placeholder="e.g., Maize, Wheat, Beans"
                        wire:model="commodity"
                        required
                    />
                    @error('commodity')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Variety -->
                <div>
                    <x-theme.agri-input
                        name="variety"
                        label="Variety"
                        placeholder="e.g., White, Yellow, Grade A"
                        wire:model="variety"
                    />
                    @error('variety')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Market Name -->
                <div>
                    <x-theme.agri-input
                        name="marketName"
                        label="Market Name"
                        placeholder="e.g., Wakulima Market"
                        wire:model="marketName"
                        required
                    />
                    @error('marketName')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <x-theme.agri-input
                        name="location"
                        label="Location"
                        placeholder="e.g., Nairobi, Mombasa"
                        wire:model="location"
                    />
                    @error('location')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <x-theme.agri-input
                        type="number"
                        name="price"
                        label="Price (KES)"
                        placeholder="0.00"
                        wire:model="price"
                        step="0.01"
                        min="0"
                        required
                    />
                    @error('price')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Unit -->
                <div>
                    <x-theme.agri-input
                        type="select"
                        name="unit"
                        label="Unit"
                        wire:model="unit"
                        required
                    >
                        <option value="kg">Per Kilogram (kg)</option>
                        <option value="ton">Per Ton</option>
                        <option value="bag">Per Bag (90kg)</option>
                        <option value="crate">Per Crate</option>
                        <option value="piece">Per Piece</option>
                        <option value="bunch">Per Bunch</option>
                        <option value="litre">Per Litre</option>
                    </x-theme.agri-input>
                    @error('unit')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price Min -->
                <div>
                    <x-theme.agri-input
                        type="number"
                        name="priceMin"
                        label="Minimum Price (KES)"
                        placeholder="Optional"
                        wire:model="priceMin"
                        step="0.01"
                        min="0"
                    />
                    @error('priceMin')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price Max -->
                <div>
                    <x-theme.agri-input
                        type="number"
                        name="priceMax"
                        label="Maximum Price (KES)"
                        placeholder="Optional"
                        wire:model="priceMax"
                        step="0.01"
                        min="0"
                    />
                    @error('priceMax')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price Date -->
                <div>
                    <x-theme.agri-input
                        type="date"
                        name="priceDate"
                        label="Price Date"
                        wire:model="priceDate"
                        required
                    />
                    @error('priceDate')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quality Grade -->
                <div>
                    <x-theme.agri-input
                        type="select"
                        name="qualityGrade"
                        label="Quality Grade"
                        wire:model="qualityGrade"
                    >
                        <option value="">Select Grade</option>
                        <option value="Grade A">Grade A (Premium)</option>
                        <option value="Grade B">Grade B (Standard)</option>
                        <option value="Grade C">Grade C (Economy)</option>
                    </x-theme.agri-input>
                    @error('qualityGrade')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Data Source -->
                <div class="md:col-span-2">
                    <x-theme.agri-input
                        name="dataSource"
                        label="Data Source"
                        placeholder="e.g., NAFIS, Local Market Survey"
                        wire:model="dataSource"
                    />
                    @error('dataSource')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                <x-theme.agri-button :href="route('market.index')" variant="secondary">
                    Cancel
                </x-theme.agri-button>
                <x-theme.agri-button type="submit" variant="primary">
                    <span wire:loading.remove wire:target="save">Save Price</span>
                    <span wire:loading wire:target="save" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Saving...
                    </span>
                </x-theme.agri-button>
            </div>
        </form>
    </x-theme.agri-card>
</div>
