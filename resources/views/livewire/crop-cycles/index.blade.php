<div>
    <x-theme.agri-page-header
        title="Crop Cycles"
        description="Track your crops from planting to harvest"
    >
        <x-slot:actions>
            <x-theme.agri-button :href="route('crop-cycles.create')" variant="primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Crop Cycle
            </x-theme.agri-button>
        </x-slot:actions>
    </x-theme.agri-page-header>

    <!-- Filters -->
    <div class="mb-6 flex flex-col sm:flex-row gap-4">
        <div class="relative flex-1 max-w-md">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search crop cycles..."
                class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
            >
        </div>

        <select
            wire:model.live="farmId"
            class="px-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
        >
            <option value="">All Farms</option>
            @foreach($farms as $farm)
                <option value="{{ $farm->id }}">{{ $farm->name }}</option>
            @endforeach
        </select>

        <select
            wire:model.live="status"
            class="px-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
        >
            <option value="">All Statuses</option>
            @foreach($statuses as $statusOption)
                <option value="{{ $statusOption }}">{{ ucfirst($statusOption) }}</option>
            @endforeach
        </select>
    </div>

    <!-- Crop Cycles List -->
    @if($cropCycles->count() > 0)
        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-700">
                            <th class="text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider px-6 py-4">Crop</th>
                            <th class="text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider px-6 py-4">Farm</th>
                            <th class="text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider px-6 py-4">Planted</th>
                            <th class="text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider px-6 py-4">Expected Harvest</th>
                            <th class="text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider px-6 py-4">Status</th>
                            <th class="text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider px-6 py-4">Progress</th>
                            <th class="text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($cropCycles as $cycle)
                            @php
                                $progress = 0;
                                if ($cycle->planting_date && $cycle->expected_harvest_date) {
                                    $totalDays = $cycle->planting_date->diffInDays($cycle->expected_harvest_date);
                                    $daysPassed = $cycle->planting_date->diffInDays(now());
                                    $progress = $totalDays > 0 ? min(100, round(($daysPassed / $totalDays) * 100)) : 0;
                                }
                            @endphp
                            <tr class="hover:bg-agri-bg dark:hover:bg-zinc-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-agri-bg-alt dark:bg-zinc-700 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $cycle->crop->name ?? 'Unknown' }}</p>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $cycle->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-zinc-600 dark:text-zinc-300">{{ $cycle->farm->name ?? 'Unknown' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-zinc-600 dark:text-zinc-300">{{ $cycle->planting_date?->format('M d, Y') ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-zinc-600 dark:text-zinc-300">{{ $cycle->expected_harvest_date?->format('M d, Y') ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'planning' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                            'active' => 'bg-agri-lime text-zinc-800',
                                            'harvested' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$cycle->status] ?? 'bg-zinc-100 text-zinc-600' }}">
                                        {{ ucfirst($cycle->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($cycle->status === 'active')
                                        <div class="w-24">
                                            <div class="flex items-center gap-2">
                                                <div class="flex-1 h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden">
                                                    <div class="h-full bg-agri-lime rounded-full transition-all" style="width: {{ $progress }}%"></div>
                                                </div>
                                                <span class="text-xs text-zinc-500">{{ $progress }}%</span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-xs text-zinc-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('crop-cycles.show', $cycle) }}" wire:navigate class="text-sm text-agri-olive hover:text-agri-olive-dark dark:text-agri-lime">
                                        View →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $cropCycles->links() }}
        </div>
    @else
        <!-- Empty State -->
        <x-theme.agri-empty
            title="No crop cycles yet"
            description="Start tracking your crops by adding your first crop cycle."
            action-text="Add Your First Crop Cycle"
            :action-href="route('crop-cycles.create')"
        >
            <x-slot:icon>
                <svg class="w-10 h-10 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </x-slot:icon>
        </x-theme.agri-empty>
    @endif
</div>

