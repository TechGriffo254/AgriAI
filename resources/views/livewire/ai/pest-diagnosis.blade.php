<div wire:poll.5s="checkStatus">
    <x-theme.agri-page-header
        title="Pest & Disease Diagnosis"
        description="Upload plant images for AI-powered diagnosis"
    >
        <x-slot:actions>
            <x-theme.agri-button :href="route('ai.assistant')" variant="outline">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                AI Chat
            </x-theme.agri-button>
        </x-slot:actions>
    </x-theme.agri-page-header>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
            <p class="text-sm text-green-700 dark:text-green-400">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
            <p class="text-sm text-red-700 dark:text-red-400">{{ session('error') }}</p>
        </div>
    @endif

    @if(session('info'))
        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl">
            <p class="text-sm text-blue-700 dark:text-blue-400">{{ session('info') }}</p>
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Upload Form -->
        <div class="lg:col-span-2">
            <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-6">Upload Plant Image</h2>

                <form wire:submit="submitDiagnosis" class="space-y-6">
                    <!-- Image Upload -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Plant Image <span class="text-red-500">*</span>
                        </label>
                        <div
                            class="border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-xl p-8 text-center hover:border-agri-lime transition-colors"
                            x-data="{ dragging: false }"
                            @dragover.prevent="dragging = true"
                            @dragleave.prevent="dragging = false"
                            @drop.prevent="dragging = false; $refs.fileInput.files = $event.dataTransfer.files; $refs.fileInput.dispatchEvent(new Event('change'))"
                            :class="{ 'border-agri-lime bg-agri-lime/5': dragging }"
                        >
                            @if($image)
                                <div class="space-y-4">
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="max-h-64 mx-auto rounded-lg">
                                    <button type="button" wire:click="$set('image', null)" class="text-sm text-red-600 hover:text-red-700">
                                        Remove image
                                    </button>
                                </div>
                            @else
                                <div class="space-y-4">
                                    <svg class="w-12 h-12 mx-auto text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <div>
                                        <label for="image" class="cursor-pointer text-agri-olive hover:text-agri-olive-dark font-medium">
                                            Click to upload
                                        </label>
                                        <span class="text-zinc-500"> or drag and drop</span>
                                    </div>
                                    <p class="text-xs text-zinc-400">PNG, JPG up to 10MB</p>
                                </div>
                            @endif
                            <input
                                type="file"
                                id="image"
                                wire:model="image"
                                accept="image/*"
                                class="hidden"
                                x-ref="fileInput"
                            >
                        </div>
                        @error('image') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Symptoms -->
                    <div>
                        <label for="symptoms" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Describe the Symptoms <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            id="symptoms"
                            wire:model="symptoms"
                            rows="4"
                            placeholder="Describe what you observe: leaf color changes, spots, wilting, pest presence, etc."
                            class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime resize-none"
                        ></textarea>
                        @error('symptoms') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <!-- Crop Name -->
                        <div>
                            <label for="cropName" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Crop/Plant Name
                            </label>
                            <input
                                type="text"
                                id="cropName"
                                wire:model="cropName"
                                placeholder="e.g., Tomato, Maize, Cabbage"
                                class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime"
                            >
                            @error('cropName') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Farm -->
                        <div>
                            <label for="farmId" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Farm (Optional)
                            </label>
                            <select
                                id="farmId"
                                wire:model="farmId"
                                class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime"
                            >
                                <option value="">Select farm</option>
                                @foreach($farms as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <x-theme.agri-button type="submit" variant="primary" :disabled="$isProcessing">
                            @if($isProcessing)
                                <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Analyzing...
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                                Analyze Image
                            @endif
                        </x-theme.agri-button>
                    </div>
                </form>
            </x-theme.agri-card>

            <!-- Current Diagnosis Result -->
            @if($currentDiagnosis && $currentDiagnosis->status === 'completed')
                <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700 mt-6">
                    <div class="flex items-start justify-between mb-6">
                        <h2 class="text-lg font-medium text-zinc-800 dark:text-white">Diagnosis Result</h2>
                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $currentDiagnosis->severity === 'severe' ? 'bg-red-100 text-red-700' : ($currentDiagnosis->severity === 'moderate' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                            {{ ucfirst($currentDiagnosis->severity ?? 'Unknown') }} Severity
                        </span>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            @if($currentDiagnosis->image_path)
                                <img src="{{ Storage::url($currentDiagnosis->image_path) }}" alt="Analyzed plant" class="w-full h-48 object-cover rounded-xl">
                            @endif
                        </div>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Identified Issue</p>
                                <p class="text-lg font-medium text-zinc-800 dark:text-white">{{ $currentDiagnosis->identified_issue ?? 'Unknown' }}</p>
                                @if($currentDiagnosis->scientific_name)
                                    <p class="text-sm text-zinc-500 italic">{{ $currentDiagnosis->scientific_name }}</p>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Confidence</p>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden">
                                        <div class="h-full bg-agri-lime rounded-full" style="width: {{ ($currentDiagnosis->confidence_score ?? 0) * 100 }}%"></div>
                                    </div>
                                    <span class="text-sm font-medium text-zinc-800 dark:text-white">{{ number_format(($currentDiagnosis->confidence_score ?? 0) * 100) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($currentDiagnosis->description)
                        <div class="mt-6 p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                            <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $currentDiagnosis->description }}</p>
                        </div>
                    @endif

                    @if($currentDiagnosis->treatment_options && count($currentDiagnosis->treatment_options) > 0)
                        <div class="mt-6">
                            <h3 class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-3">Treatment Options</h3>
                            <ul class="space-y-2">
                                @foreach($currentDiagnosis->treatment_options as $treatment)
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-agri-olive shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $treatment }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($currentDiagnosis->prevention_measures && count($currentDiagnosis->prevention_measures) > 0)
                        <div class="mt-6">
                            <h3 class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-3">Prevention Measures</h3>
                            <ul class="space-y-2">
                                @foreach($currentDiagnosis->prevention_measures as $measure)
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $measure }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </x-theme.agri-card>
            @elseif($currentDiagnosis && $currentDiagnosis->status === 'processing')
                <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700 mt-6">
                    <div class="flex flex-col items-center justify-center py-12">
                        <svg class="w-12 h-12 text-agri-olive animate-spin mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <h3 class="text-lg font-medium text-zinc-800 dark:text-white mb-2">Analyzing Image...</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Our AI is examining your plant image</p>
                    </div>
                </x-theme.agri-card>
            @endif
        </div>

        <!-- Recent Diagnoses -->
        <div>
            <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                <h3 class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-4">Recent Diagnoses</h3>
                <div class="space-y-3">
                    @forelse($diagnoses as $diagnosis)
                        <button
                            wire:click="viewDiagnosis({{ $diagnosis->id }})"
                            class="w-full text-left p-3 rounded-xl transition-colors {{ $currentDiagnosisId === $diagnosis->id ? 'bg-agri-lime/20 border border-agri-lime' : 'bg-agri-bg dark:bg-zinc-900 hover:bg-agri-bg-alt' }}"
                        >
                            <div class="flex items-center gap-3">
                                @if($diagnosis->image_path)
                                    <img src="{{ Storage::url($diagnosis->image_path) }}" alt="" class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 bg-zinc-200 dark:bg-zinc-700 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-zinc-800 dark:text-white truncate">
                                        {{ $diagnosis->identified_issue ?? $diagnosis->crop_name ?? 'Pending...' }}
                                    </p>
                                    <p class="text-xs text-zinc-500">{{ $diagnosis->created_at->diffForHumans() }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full {{ $diagnosis->status === 'completed' ? 'bg-green-100 text-green-700' : ($diagnosis->status === 'processing' ? 'bg-yellow-100 text-yellow-700' : 'bg-zinc-100 text-zinc-700') }}">
                                    {{ ucfirst($diagnosis->status) }}
                                </span>
                            </div>
                        </button>
                    @empty
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-8">No diagnoses yet</p>
                    @endforelse
                </div>
            </x-theme.agri-card>
        </div>
    </div>
</div>
