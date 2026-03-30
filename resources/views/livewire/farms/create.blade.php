<div>
    <div class="mb-8">
        <a href="{{ route('farms.index') }}" wire:navigate class="inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Farms
        </a>
        <h1 class="text-2xl font-light text-zinc-800 dark:text-white">Add New Farm</h1>
        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Create a new farm property to start tracking</p>
    </div>

    <form wire:submit="save" class="space-y-8">
        <!-- Basic Information -->
        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-6">Basic Information</h2>

            <div class="grid gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Farm Name *</label>
                    <input
                        type="text"
                        id="name"
                        wire:model="name"
                        placeholder="e.g., Green Valley Farm"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Description</label>
                    <textarea
                        id="description"
                        wire:model="description"
                        rows="3"
                        placeholder="Brief description of your farm..."
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent resize-none"
                    ></textarea>
                    @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="size" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Farm Size</label>
                    <div class="flex gap-2">
                        <input
                            type="number"
                            id="size"
                            wire:model="size"
                            step="0.1"
                            placeholder="0.0"
                            class="flex-1 px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                        >
                        <select
                            wire:model="sizeUnit"
                            class="px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                        >
                            <option value="acres">Acres</option>
                            <option value="hectares">Hectares</option>
                            <option value="square_meters">Sq. Meters</option>
                        </select>
                    </div>
                    @error('size') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Farm Image</label>
                    <input
                        type="file"
                        id="image"
                        wire:model="image"
                        accept="image/*"
                        class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-agri-lime file:text-zinc-800 hover:file:bg-agri-lime-light"
                    >
                    @error('image') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Location -->
        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-6">Location</h2>

            <div class="grid gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Address</label>
                    <input
                        type="text"
                        id="address"
                        wire:model="address"
                        placeholder="Street address"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('address') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">City</label>
                    <input
                        type="text"
                        id="city"
                        wire:model="city"
                        placeholder="e.g., Nairobi"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('city') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="state" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">County/State</label>
                    <input
                        type="text"
                        id="state"
                        wire:model="state"
                        placeholder="e.g., Nairobi County"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('state') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="country" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Country</label>
                    <input
                        type="text"
                        id="country"
                        wire:model="country"
                        placeholder="e.g., Kenya"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('country') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- GPS Coordinates with Auto-detect -->
                <div class="md:col-span-2">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">GPS Coordinates</label>
                        <button
                            type="button"
                            x-data="{ loading: false, error: null }"
                            @click="
                                loading = true;
                                error = null;
                                if (navigator.geolocation) {
                                    navigator.geolocation.getCurrentPosition(
                                        (position) => {
                                            $wire.set('latitude', position.coords.latitude);
                                            $wire.set('longitude', position.coords.longitude);
                                            loading = false;
                                        },
                                        (err) => {
                                            loading = false;
                                            if (err.code === 1) {
                                                error = 'Location access denied. Please enable location permissions.';
                                            } else if (err.code === 2) {
                                                error = 'Location unavailable. Please try again.';
                                            } else {
                                                error = 'Could not get location. Please enter manually.';
                                            }
                                            alert(error);
                                        },
                                        { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                                    );
                                } else {
                                    loading = false;
                                    alert('Geolocation is not supported by your browser.');
                                }
                            "
                            class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-agri-olive hover:text-agri-olive-dark dark:text-agri-lime dark:hover:text-agri-lime-light bg-agri-lime/10 hover:bg-agri-lime/20 rounded-lg transition-colors"
                            :disabled="loading"
                        >
                            <template x-if="!loading">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </template>
                            <template x-if="loading">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </template>
                            <span x-text="loading ? 'Detecting...' : 'Use My Location'"></span>
                        </button>
                    </div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-3">
                        Click "Use My Location" to auto-fill coordinates, or enter manually below.
                    </p>
                </div>

                <div>
                    <label for="latitude" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Latitude</label>
                    <input
                        type="number"
                        id="latitude"
                        wire:model="latitude"
                        step="any"
                        placeholder="-1.2921"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('latitude') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="longitude" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Longitude</label>
                    <input
                        type="number"
                        id="longitude"
                        wire:model="longitude"
                        step="any"
                        placeholder="36.8219"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('longitude') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Location Status Indicator -->
                @if($latitude && $longitude)
                    <div class="md:col-span-2">
                        <div class="flex items-center gap-2 p-3 bg-agri-lime/10 rounded-xl">
                            <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm text-agri-olive-dark dark:text-agri-lime">
                                Location set: {{ number_format($latitude, 6) }}, {{ number_format($longitude, 6) }}
                            </span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Farm Characteristics -->
        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-6">Farm Characteristics</h2>

            <div class="grid gap-6 md:grid-cols-3">
                <div>
                    <label for="soilType" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Soil Type</label>
                    <select
                        id="soilType"
                        wire:model="soilType"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                        <option value="">Select soil type</option>
                        <option value="Clay">Clay</option>
                        <option value="Sandy">Sandy</option>
                        <option value="Loam">Loam</option>
                        <option value="Silt">Silt</option>
                        <option value="Peat">Peat</option>
                        <option value="Chalky">Chalky</option>
                        <option value="Mixed">Mixed</option>
                    </select>
                    @error('soilType') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="climateZone" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Climate Zone</label>
                    <select
                        id="climateZone"
                        wire:model="climateZone"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                        <option value="">Select climate zone</option>
                        <option value="Tropical">Tropical</option>
                        <option value="Subtropical">Subtropical</option>
                        <option value="Arid">Arid</option>
                        <option value="Semi-Arid">Semi-Arid</option>
                        <option value="Temperate">Temperate</option>
                        <option value="Highland">Highland</option>
                    </select>
                    @error('climateZone') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="waterSource" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Water Source</label>
                    <select
                        id="waterSource"
                        wire:model="waterSource"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                        <option value="">Select water source</option>
                        <option value="River">River</option>
                        <option value="Borehole">Borehole</option>
                        <option value="Rain-fed">Rain-fed</option>
                        <option value="Dam">Dam</option>
                        <option value="Canal">Canal</option>
                        <option value="Municipal">Municipal</option>
                        <option value="Mixed">Mixed</option>
                    </select>
                    @error('waterSource') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('farms.index') }}" wire:navigate class="px-6 py-2.5 text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-zinc-200 transition-colors">
                Cancel
            </a>
            <button
                type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-agri-lime text-zinc-800 text-sm font-medium rounded-full hover:bg-agri-lime-light transition-colors disabled:opacity-50"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove wire:target="save">Create Farm</span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Creating...
                </span>
            </button>
        </div>
    </form>
</div>

