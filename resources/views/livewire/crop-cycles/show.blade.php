<div>
    <div class="mb-8">
        <a href="{{ route('crop-cycles.index') }}" wire:navigate class="inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Crop Cycles
        </a>

        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-light text-zinc-800 dark:text-white">{{ $cropCycle->name ?? 'Crop Cycle' }}</h1>
                    @php
                        $statusColors = [
                            'planning' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                            'active' => 'bg-agri-lime text-zinc-800',
                            'harvested' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$cropCycle->status] ?? 'bg-zinc-100 text-zinc-600' }}">
                        {{ ucfirst($cropCycle->status) }}
                    </span>
                </div>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    {{ $cropCycle->crop->name ?? 'Unknown Crop' }} • {{ $cropCycle->farm->name ?? 'Unknown Farm' }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('crop-cycles.edit', $cropCycle) }}" wire:navigate class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 text-sm font-medium rounded-full hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                @if($cropCycle->status === 'active')
                    <button
                        wire:click="markAsHarvested"
                        wire:confirm="Mark this crop cycle as harvested?"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-agri-lime text-zinc-800 text-sm font-medium rounded-full hover:bg-agri-lime-light transition-colors"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Mark Harvested
                    </button>
                @endif
                <button
                    wire:click="deleteCropCycle"
                    wire:confirm="Are you sure you want to delete this crop cycle? This action cannot be undone."
                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 text-sm font-medium rounded-full hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Progress Card -->
    @if($cropCycle->status === 'active' && $cropCycle->planting_date && $cropCycle->expected_harvest_date)
        <div class="bg-gradient-to-r from-agri-green to-agri-green-dark rounded-2xl p-6 mb-8 text-white">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-medium mb-1">Growth Progress</h2>
                    <p class="text-white/70 text-sm">
                        @if($daysRemaining > 0)
                            {{ $daysRemaining }} days until expected harvest
                        @else
                            Ready for harvest!
                        @endif
                    </p>
                </div>
                <div class="text-right">
                    <span class="text-3xl font-light">{{ $progress }}%</span>
                </div>
            </div>
            <div class="mt-4 h-3 bg-white/20 rounded-full overflow-hidden">
                <div class="h-full bg-agri-lime rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
            </div>
            <div class="flex justify-between mt-2 text-xs text-white/70">
                <span>Planted: {{ $cropCycle->planting_date->format('M d, Y') }}</span>
                <span>Expected: {{ $cropCycle->expected_harvest_date->format('M d, Y') }}</span>
            </div>
        </div>
    @endif

    <!-- Stats Grid -->
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 mb-8">
        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-agri-bg-alt dark:bg-zinc-700 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-light text-zinc-800 dark:text-white">{{ $cropCycle->area ? number_format($cropCycle->area, 1) . ' ' . $cropCycle->area_unit : '-' }}</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Area Planted</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-agri-bg-alt dark:bg-zinc-700 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-light text-zinc-800 dark:text-white">{{ $cropCycle->expected_yield ? number_format($cropCycle->expected_yield, 1) . ' ' . $cropCycle->yield_unit : '-' }}</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Expected Yield</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-agri-bg-alt dark:bg-zinc-700 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-light text-zinc-800 dark:text-white">{{ $cropCycle->actual_yield ? number_format($cropCycle->actual_yield, 1) . ' ' . $cropCycle->yield_unit : '-' }}</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Actual Yield</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-agri-bg-alt dark:bg-zinc-700 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-light text-zinc-800 dark:text-white">{{ $cropCycle->actual_harvest_date?->format('M d') ?? '-' }}</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Harvested On</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Crop Details -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-6">Crop Information</h2>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Crop Name</p>
                        <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $cropCycle->crop->name ?? 'Unknown' }}</p>
                    </div>
                    <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Field/Section</p>
                        <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $cropCycle->field_section ?? 'Not specified' }}</p>
                    </div>
                    <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Planting Date</p>
                        <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $cropCycle->planting_date?->format('M d, Y') ?? 'Not set' }}</p>
                    </div>
                    <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Expected Harvest</p>
                        <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $cropCycle->expected_harvest_date?->format('M d, Y') ?? 'Not set' }}</p>
                    </div>
                </div>
            </div>

            <!-- Seed Information -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-6">Seed Information</h2>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Seed Source</p>
                        <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $cropCycle->seed_source ?? 'Not specified' }}</p>
                    </div>
                    <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Seed Variety</p>
                        <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $cropCycle->seed_variety ?? 'Not specified' }}</p>
                    </div>
                    <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Seed Quantity</p>
                        <p class="text-sm font-medium text-zinc-800 dark:text-white">
                            {{ $cropCycle->seed_quantity ? number_format($cropCycle->seed_quantity, 1) . ' ' . $cropCycle->seed_unit : 'Not specified' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if($cropCycle->notes)
                <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                    <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-4">Notes</h2>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">{{ $cropCycle->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Farm Info -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-4">Farm</h2>
                <a href="{{ route('farms.show', $cropCycle->farm) }}" wire:navigate class="flex items-center gap-3 p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-700 transition-colors">
                    <div class="w-12 h-12 bg-gradient-to-br from-agri-green to-agri-green-dark rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $cropCycle->farm->name ?? 'Unknown' }}</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $cropCycle->farm->city ?? '' }}</p>
                    </div>
                </a>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-4">Quick Actions</h2>
                <div class="space-y-2">
                    <a href="#" class="flex items-center gap-3 p-3 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-700 transition-colors">
                        <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">Add Task</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-700 transition-colors">
                        <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">Record Expense</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-700 transition-colors">
                        <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">Report Pest Issue</span>
                    </a>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-4">Timeline</h2>
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <div class="w-3 h-3 bg-agri-lime rounded-full"></div>
                            <div class="w-0.5 h-full bg-zinc-200 dark:bg-zinc-700"></div>
                        </div>
                        <div class="pb-4">
                            <p class="text-sm font-medium text-zinc-800 dark:text-white">Planted</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $cropCycle->planting_date?->format('M d, Y') ?? 'Not set' }}</p>
                        </div>
                    </div>
                    @if($cropCycle->status === 'active')
                        <div class="flex gap-3">
                            <div class="flex flex-col items-center">
                                <div class="w-3 h-3 bg-agri-lime/50 rounded-full animate-pulse"></div>
                                <div class="w-0.5 h-full bg-zinc-200 dark:bg-zinc-700"></div>
                            </div>
                            <div class="pb-4">
                                <p class="text-sm font-medium text-zinc-800 dark:text-white">Growing</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">In progress</p>
                            </div>
                        </div>
                    @endif
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <div class="w-3 h-3 {{ $cropCycle->status === 'harvested' ? 'bg-green-500' : 'bg-zinc-300 dark:bg-zinc-600' }} rounded-full"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-zinc-800 dark:text-white">Harvest</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                {{ $cropCycle->actual_harvest_date?->format('M d, Y') ?? ($cropCycle->expected_harvest_date?->format('M d, Y') . ' (expected)') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

