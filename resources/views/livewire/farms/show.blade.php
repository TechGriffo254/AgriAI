<div>
    <div class="mb-8">
        <a href="{{ route('farms.index') }}" wire:navigate class="inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Farms
        </a>

        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-light text-zinc-800 dark:text-white">{{ $farm->name }}</h1>
                    @if($farm->is_active)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-agri-lime text-zinc-800">
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-zinc-200 text-zinc-600">
                            Inactive
                        </span>
                    @endif
                </div>
                @if($farm->city || $farm->country)
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 flex items-center gap-1 mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ collect([$farm->address, $farm->city, $farm->state, $farm->country])->filter()->implode(', ') }}
                    </p>
                @endif
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('farms.edit', $farm) }}" wire:navigate class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 text-sm font-medium rounded-full hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <button
                    wire:click="deleteFarm"
                    wire:confirm="Are you sure you want to delete this farm? This action cannot be undone."
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

    <!-- Stats Grid -->
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-5 mb-8">
        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-agri-bg-alt dark:bg-zinc-700 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-light text-zinc-800 dark:text-white">{{ $farm->size ? number_format($farm->size, 1) : '-' }}</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $farm->size_unit ?? 'Size' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-agri-bg-alt dark:bg-zinc-700 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-light text-zinc-800 dark:text-white">{{ $stats['active_crop_cycles'] }}</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Active Crops</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-agri-bg-alt dark:bg-zinc-700 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-light text-zinc-800 dark:text-white">{{ $stats['pending_tasks'] }}</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Pending Tasks</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-red-50 dark:bg-red-900/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-light text-zinc-800 dark:text-white">{{ number_format($stats['total_expenses']) }}</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Total Expenses</p>
                </div>
            </div>
        </div>

        <div class="bg-agri-lime rounded-2xl p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/30 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-zinc-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-light text-zinc-800">{{ number_format($stats['total_income']) }}</p>
                    <p class="text-xs text-zinc-700">Total Income</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Farm Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Description -->
            @if($farm->description)
                <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                    <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-4">About this Farm</h2>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">{{ $farm->description }}</p>
                </div>
            @endif

            <!-- Farm Characteristics -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-4">Farm Characteristics</h2>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Soil Type</p>
                        <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $farm->soil_type ?: 'Not specified' }}</p>
                    </div>
                    <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Climate Zone</p>
                        <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $farm->climate_zone ?: 'Not specified' }}</p>
                    </div>
                    <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Water Source</p>
                        <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $farm->water_source ?: 'Not specified' }}</p>
                    </div>
                </div>
            </div>

            <!-- Active Crop Cycles -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-medium text-zinc-800 dark:text-white">Active Crop Cycles</h2>
                    <a href="{{ route('crop-cycles.create', $farm) }}" wire:navigate class="text-sm text-agri-olive hover:text-agri-olive-dark dark:text-agri-lime">Add Crop →</a>
                </div>

                @if($activeCropCycles->count() > 0)
                    <div class="space-y-3">
                        @foreach($activeCropCycles as $cycle)
                            <div class="flex items-center justify-between p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-agri-lime/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $cycle->crop->name ?? 'Unknown Crop' }}</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Planted: {{ $cycle->planting_date?->format('M d, Y') ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-agri-lime text-zinc-800">
                                    {{ ucfirst($cycle->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-8">No active crop cycles. Start by adding a crop!</p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Farm Image -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                <div class="aspect-video bg-gradient-to-br from-agri-green to-agri-green-dark relative">
                    @if($farm->image_path)
                        <img src="{{ Storage::url($farm->image_path) }}" alt="{{ $farm->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    @endif
                </div>
                @if($farm->latitude && $farm->longitude)
                    <div class="p-4">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Coordinates</p>
                        <p class="text-sm font-mono text-zinc-800 dark:text-white">{{ $farm->latitude }}, {{ $farm->longitude }}</p>
                    </div>
                @endif
            </div>

            <!-- Recent Tasks -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-medium text-zinc-800 dark:text-white">Recent Tasks</h2>
                    <a href="#" class="text-sm text-agri-olive hover:text-agri-olive-dark dark:text-agri-lime">View All →</a>
                </div>

                @if($recentTasks->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentTasks as $task)
                            <div class="flex items-start gap-3 p-3 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                                <div class="w-2 h-2 mt-1.5 rounded-full {{ $task->priority === 'high' ? 'bg-red-500' : ($task->priority === 'medium' ? 'bg-yellow-500' : 'bg-green-500') }}"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-zinc-800 dark:text-white truncate">{{ $task->title }}</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $task->due_date?->format('M d') ?? 'No due date' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-4">No pending tasks</p>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-4">Quick Actions</h2>
                <div class="space-y-2">
                    <a href="{{ route('crop-cycles.create', $farm) }}" wire:navigate class="flex items-center gap-3 p-3 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-700 transition-colors">
                        <x-theme.agri-icon-box variant="light" size="sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </x-theme.agri-icon-box>
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">Add Crop Cycle</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-700 transition-colors">
                        <x-theme.agri-icon-box variant="light" size="sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </x-theme.agri-icon-box>
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">Add Task</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-700 transition-colors">
                        <x-theme.agri-icon-box variant="light" size="sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </x-theme.agri-icon-box>
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">Record Expense</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-700 transition-colors">
                        <x-theme.agri-icon-box variant="light" size="sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                            </svg>
                        </x-theme.agri-icon-box>
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">Check Weather</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

