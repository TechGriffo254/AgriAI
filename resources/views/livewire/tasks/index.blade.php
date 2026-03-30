<div>
    <x-theme.agri-page-header
        title="Tasks"
        description="Manage your farm tasks and activities"
    >
        <x-slot:actions>
            <x-theme.agri-button :href="route('tasks.create')" variant="primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Task
            </x-theme.agri-button>
        </x-slot:actions>
    </x-theme.agri-page-header>

    <!-- Status Tabs -->
    <div class="mb-6 flex flex-wrap gap-2">
        <button
            wire:click="$set('status', '')"
            class="px-4 py-2 text-sm font-medium rounded-full transition-colors {{ $status === '' ? 'bg-agri-lime text-zinc-800' : 'bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}"
        >
            All <span class="ml-1 text-xs">({{ $taskCounts['all'] }})</span>
        </button>
        <button
            wire:click="$set('status', 'pending')"
            class="px-4 py-2 text-sm font-medium rounded-full transition-colors {{ $status === 'pending' ? 'bg-agri-lime text-zinc-800' : 'bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}"
        >
            Pending <span class="ml-1 text-xs">({{ $taskCounts['pending'] }})</span>
        </button>
        <button
            wire:click="$set('status', 'in_progress')"
            class="px-4 py-2 text-sm font-medium rounded-full transition-colors {{ $status === 'in_progress' ? 'bg-agri-lime text-zinc-800' : 'bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}"
        >
            In Progress <span class="ml-1 text-xs">({{ $taskCounts['in_progress'] }})</span>
        </button>
        <button
            wire:click="$set('status', 'completed')"
            class="px-4 py-2 text-sm font-medium rounded-full transition-colors {{ $status === 'completed' ? 'bg-agri-lime text-zinc-800' : 'bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}"
        >
            Completed <span class="ml-1 text-xs">({{ $taskCounts['completed'] }})</span>
        </button>
        @if($taskCounts['overdue'] > 0)
            <span class="px-4 py-2 text-sm font-medium rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                Overdue <span class="ml-1 text-xs">({{ $taskCounts['overdue'] }})</span>
            </span>
        @endif
    </div>

    <!-- Filters -->
    <div class="mb-6 grid gap-4 md:grid-cols-4">
        <div class="relative">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search tasks..."
                class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
            >
        </div>

        <select
            wire:model.live="priority"
            class="w-full px-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
        >
            <option value="">All Priorities</option>
            <option value="urgent">Urgent</option>
            <option value="high">High</option>
            <option value="medium">Medium</option>
            <option value="low">Low</option>
        </select>

        <select
            wire:model.live="category"
            class="w-full px-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
        >
            <option value="">All Categories</option>
            <option value="planting">Planting</option>
            <option value="watering">Watering</option>
            <option value="fertilizing">Fertilizing</option>
            <option value="harvesting">Harvesting</option>
            <option value="pest_control">Pest Control</option>
            <option value="maintenance">Maintenance</option>
            <option value="other">Other</option>
        </select>

        <select
            wire:model.live="farmId"
            class="w-full px-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
        >
            <option value="">All Farms</option>
            @foreach($farms as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Tasks List -->
    @if($tasks->count() > 0)
        <div class="space-y-3">
            @foreach($tasks as $task)
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
                    $categoryIcons = [
                        'planting' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />',
                        'watering' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />',
                        'fertilizing' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />',
                        'harvesting' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />',
                        'pest_control' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />',
                        'maintenance' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />',
                        'other' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />',
                    ];
                @endphp
                <div wire:key="task-{{ $task->id }}" class="group bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 hover:border-agri-lime dark:hover:border-agri-lime transition-all duration-300 {{ $isOverdue ? 'border-l-4 border-l-red-500' : '' }}">
                    <div class="p-4 sm:p-5 flex items-start gap-4">
                        <!-- Checkbox -->
                        <button
                            wire:click="toggleComplete({{ $task->id }})"
                            class="mt-1 shrink-0 w-6 h-6 rounded-full border-2 flex items-center justify-center transition-colors {{ $task->status === 'completed' ? 'bg-agri-lime border-agri-lime' : 'border-zinc-300 dark:border-zinc-600 hover:border-agri-lime' }}"
                        >
                            @if($task->status === 'completed')
                                <svg class="w-4 h-4 text-zinc-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            @endif
                        </button>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('tasks.show', $task) }}" wire:navigate class="text-base font-medium text-zinc-800 dark:text-white hover:text-agri-olive dark:hover:text-agri-lime {{ $task->status === 'completed' ? 'line-through text-zinc-500' : '' }}">
                                        {{ $task->title }}
                                    </a>
                                    <div class="flex flex-wrap items-center gap-2 mt-2">
                                        <!-- Priority Indicator -->
                                        <span class="inline-flex items-center gap-1 text-xs text-zinc-500 dark:text-zinc-400">
                                            <span class="w-2 h-2 rounded-full {{ $priorityColors[$task->priority] ?? 'bg-zinc-400' }}"></span>
                                            {{ ucfirst($task->priority) }}
                                        </span>

                                        <!-- Category -->
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                {!! $categoryIcons[$task->category] ?? $categoryIcons['other'] !!}
                                            </svg>
                                            {{ str_replace('_', ' ', ucfirst($task->category)) }}
                                        </span>

                                        <!-- Status Badge -->
                                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$task->status] ?? $statusColors['pending'] }}">
                                            {{ str_replace('_', ' ', ucfirst($task->status)) }}
                                        </span>

                                        <!-- Farm -->
                                        @if($task->farm)
                                            <span class="inline-flex items-center gap-1 text-xs text-zinc-500 dark:text-zinc-400">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $task->farm->name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Due Date -->
                                <div class="shrink-0 text-right">
                                    @if($task->due_date)
                                        <div class="text-sm {{ $isOverdue ? 'text-red-600 dark:text-red-400 font-medium' : 'text-zinc-600 dark:text-zinc-400' }}">
                                            @if($task->due_date->isToday())
                                                Today
                                            @elseif($task->due_date->isTomorrow())
                                                Tomorrow
                                            @elseif($task->due_date->isYesterday())
                                                Yesterday
                                            @else
                                                {{ $task->due_date->format('M j') }}
                                            @endif
                                        </div>
                                        @if($task->due_time)
                                            <div class="text-xs text-zinc-500 dark:text-zinc-500">{{ $task->due_time }}</div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('tasks.edit', $task) }}" wire:navigate class="p-2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <button
                                wire:click="deleteTask({{ $task->id }})"
                                wire:confirm="Are you sure you want to delete this task?"
                                class="p-2 text-zinc-400 hover:text-red-500 transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $tasks->links() }}
        </div>
    @else
        <x-theme.agri-empty
            title="No tasks found"
            description="Create your first task to start managing your farm activities"
            action-text="Add Your First Task"
            :action-href="route('tasks.create')"
        >
            <x-slot:icon>
                <svg class="w-10 h-10 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </x-slot:icon>
        </x-theme.agri-empty>
    @endif
</div>
