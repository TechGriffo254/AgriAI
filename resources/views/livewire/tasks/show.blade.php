<div>
    @php
        $isOverdue = $task->due_date && $task->due_date->isPast() && $task->status !== 'completed';
        $priorityColors = [
            'urgent' => 'bg-red-500',
            'high' => 'bg-orange-500',
            'medium' => 'bg-yellow-500',
            'low' => 'bg-green-500',
        ];
        $statusColors = [
            'pending' => 'bg-zinc-200 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300',
            'in_progress' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
            'completed' => 'bg-agri-lime text-zinc-800',
            'cancelled' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
        ];
        $categoryLabels = [
            'planting' => '🌱 Planting',
            'watering' => '💧 Watering',
            'fertilizing' => '🧪 Fertilizing',
            'harvesting' => '🌾 Harvesting',
            'pest_control' => '🐛 Pest Control',
            'maintenance' => '🔧 Maintenance',
            'other' => '📋 Other',
        ];
    @endphp

    <x-theme.agri-page-header
        :title="$task->title"
        :back-href="route('tasks.index')"
        back-label="Back to Tasks"
    >
        <x-slot:badge>
            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$task->status] ?? $statusColors['pending'] }}">
                {{ str_replace('_', ' ', ucfirst($task->status)) }}
            </span>
        </x-slot:badge>
        <x-slot:actions>
            <x-theme.agri-button :href="route('tasks.edit', $task)" variant="outline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </x-theme.agri-button>
        </x-slot:actions>
    </x-theme.agri-page-header>

    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Task Details Card -->
            <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                <!-- Quick Status Toggle -->
                <div class="flex items-center justify-between mb-6 pb-6 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center gap-4">
                        <button
                            wire:click="toggleComplete"
                            class="w-10 h-10 rounded-full border-2 flex items-center justify-center transition-colors {{ $task->status === 'completed' ? 'bg-agri-lime border-agri-lime' : 'border-zinc-300 dark:border-zinc-600 hover:border-agri-lime' }}"
                        >
                            @if($task->status === 'completed')
                                <svg class="w-6 h-6 text-zinc-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            @endif
                        </button>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Mark as</p>
                            <p class="font-medium text-zinc-800 dark:text-white">
                                {{ $task->status === 'completed' ? 'Incomplete' : 'Complete' }}
                            </p>
                        </div>
                    </div>

                    <!-- Status Dropdown -->
                    <div class="flex items-center gap-2">
                        <select
                            wire:change="updateStatus($event.target.value)"
                            class="px-3 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-agri-lime"
                        >
                            <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>🔄 In Progress</option>
                            <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>✅ Completed</option>
                            <option value="cancelled" {{ $task->status === 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                        </select>
                    </div>
                </div>

                <!-- Description -->
                @if($task->description)
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-2">Description</h3>
                        <p class="text-zinc-800 dark:text-white whitespace-pre-wrap">{{ $task->description }}</p>
                    </div>
                @endif

                <!-- Meta Info Grid -->
                <div class="grid gap-4 sm:grid-cols-2">
                    <!-- Category -->
                    <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Category</p>
                        <p class="text-sm font-medium text-zinc-800 dark:text-white">
                            {{ $categoryLabels[$task->category] ?? ucfirst($task->category) }}
                        </p>
                    </div>

                    <!-- Priority -->
                    <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Priority</p>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full {{ $priorityColors[$task->priority] ?? 'bg-zinc-400' }}"></span>
                            <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ ucfirst($task->priority) }}</p>
                        </div>
                    </div>

                    <!-- Due Date -->
                    <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl {{ $isOverdue ? 'ring-2 ring-red-500' : '' }}">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Due Date</p>
                        @if($task->due_date)
                            <p class="text-sm font-medium {{ $isOverdue ? 'text-red-600 dark:text-red-400' : 'text-zinc-800 dark:text-white' }}">
                                {{ $task->due_date->format('M j, Y') }}
                                @if($task->due_time)
                                    at {{ $task->due_time }}
                                @endif
                            </p>
                            @if($isOverdue)
                                <p class="text-xs text-red-600 dark:text-red-400 mt-1">Overdue by {{ $task->due_date->diffForHumans() }}</p>
                            @elseif($task->due_date->isFuture())
                                <p class="text-xs text-zinc-500 mt-1">{{ $task->due_date->diffForHumans() }}</p>
                            @endif
                        @else
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">No due date set</p>
                        @endif
                    </div>

                    <!-- Created -->
                    <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Created</p>
                        <p class="text-sm font-medium text-zinc-800 dark:text-white">
                            {{ $task->created_at->format('M j, Y') }}
                        </p>
                        <p class="text-xs text-zinc-500 mt-1">{{ $task->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                @if($task->completed_at)
                    <div class="mt-4 p-4 bg-agri-lime/20 rounded-xl">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm font-medium text-agri-olive-dark">
                                Completed on {{ $task->completed_at->format('M j, Y \a\t g:i A') }}
                            </p>
                        </div>
                    </div>
                @endif
            </x-theme.agri-card>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Related Farm -->
            @if($task->farm)
                <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-4">Related Farm</h3>
                    <a href="{{ route('farms.show', $task->farm) }}" wire:navigate class="flex items-center gap-3 p-3 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-800 transition-colors">
                        <div class="w-10 h-10 bg-gradient-to-br from-agri-green to-agri-green-dark rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $task->farm->name }}</p>
                            @if($task->farm->city || $task->farm->country)
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ collect([$task->farm->city, $task->farm->country])->filter()->implode(', ') }}
                                </p>
                            @endif
                        </div>
                    </a>
                </x-theme.agri-card>
            @endif

            <!-- Related Crop Cycle -->
            @if($task->cropCycle)
                <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-4">Related Crop Cycle</h3>
                    <a href="{{ route('crop-cycles.show', $task->cropCycle) }}" wire:navigate class="flex items-center gap-3 p-3 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-800 transition-colors">
                        <div class="w-10 h-10 bg-gradient-to-br from-agri-lime to-agri-lime-dark rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-zinc-800/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $task->cropCycle->name }}</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                {{ ucfirst($task->cropCycle->status) }}
                            </p>
                        </div>
                    </a>
                </x-theme.agri-card>
            @endif

            <!-- Reminder Info -->
            @if($task->reminder_enabled)
                <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-4">Reminder</h3>
                    <div class="flex items-center gap-3 p-3 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-zinc-800 dark:text-white">
                                @if($task->reminder_minutes_before >= 1440)
                                    {{ $task->reminder_minutes_before / 1440 }} day(s) before
                                @elseif($task->reminder_minutes_before >= 60)
                                    {{ $task->reminder_minutes_before / 60 }} hour(s) before
                                @else
                                    {{ $task->reminder_minutes_before }} minutes before
                                @endif
                            </p>
                            @if($task->reminder_sent_at)
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                    Sent {{ $task->reminder_sent_at->diffForHumans() }}
                                </p>
                            @else
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Not sent yet</p>
                            @endif
                        </div>
                    </div>
                </x-theme.agri-card>
            @endif

            <!-- Actions -->
            <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-4">Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('tasks.edit', $task) }}" wire:navigate class="flex items-center gap-3 p-3 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-800 transition-colors">
                        <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="text-sm font-medium text-zinc-800 dark:text-white">Edit Task</span>
                    </a>
                    <button
                        wire:click="delete"
                        wire:confirm="Are you sure you want to delete this task?"
                        class="w-full flex items-center gap-3 p-3 bg-red-50 dark:bg-red-900/20 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors text-left"
                    >
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span class="text-sm font-medium text-red-600 dark:text-red-400">Delete Task</span>
                    </button>
                </div>
            </x-theme.agri-card>
        </div>
    </div>
</div>
