<x-layouts.app :title="__('Dashboard')">
    @php
        $user = auth()->user();
        $totalFarms = $user->farms()->count();
        $activeFarms = $user->farms()->where('is_active', true)->count();
        $pendingTasks = $user->tasks()->where('status', 'pending')->count();
        $completedTasks = $user->tasks()->where('status', 'completed')->whereMonth('updated_at', now()->month)->count();
        $totalAcres = $user->farms()->where('size_unit', 'acres')->sum('size') +
                      ($user->farms()->where('size_unit', 'hectares')->sum('size') * 2.471);
        $activeCropCycles = $user->cropCycles()->where('status', 'active')->count();
        $farms = $user->farms()->with('cropCycles')->latest()->limit(4)->get();
        $recentTasks = $user->tasks()->with('farm')->where('status', 'pending')->orderBy('due_date')->limit(5)->get();
        $upcomingTasks = $user->tasks()->with('farm')->where('status', 'pending')->where('due_date', '>=', now())->where('due_date', '<=', now()->addDays(7))->orderBy('due_date')->limit(3)->get();

        // Financial summary for current month
        $monthlyExpenses = $user->expenses()->whereMonth('expense_date', now()->month)->whereYear('expense_date', now()->year)->sum('amount');
        $monthlyIncome = $user->incomes()->whereMonth('income_date', now()->month)->whereYear('income_date', now()->year)->sum('amount');
        $netProfit = $monthlyIncome - $monthlyExpenses;
    @endphp

    <div class="space-y-6">
        <!-- Welcome Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-light text-zinc-800 dark:text-white">
                    Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, {{ explode(' ', auth()->user()->name)[0] }}
                </h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    {{ now()->format('l, F j, Y') }} · Here's your farm overview
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('ai.assistant') }}" wire:navigate class="inline-flex items-center gap-2 px-4 py-2.5 bg-zinc-800 dark:bg-zinc-700 text-white text-sm font-medium rounded-full hover:bg-zinc-700 dark:hover:bg-zinc-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    Ask AI
                </a>
                <a href="{{ route('farms.create') }}" wire:navigate class="inline-flex items-center gap-2 px-4 py-2.5 bg-agri-lime text-zinc-800 text-sm font-medium rounded-full hover:bg-agri-lime-light transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Farm
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid gap-4 grid-cols-2 lg:grid-cols-4">
            <!-- Total Farms -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Total Farms</p>
                        <p class="text-3xl font-light text-zinc-800 dark:text-white mt-1">{{ $totalFarms }}</p>
                        <p class="text-xs text-agri-olive dark:text-agri-lime mt-1">{{ $activeFarms }} active</p>
                    </div>
                    <div class="w-12 h-12 bg-agri-bg-alt dark:bg-zinc-700 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Crop Cycles -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Crop Cycles</p>
                        <p class="text-3xl font-light text-zinc-800 dark:text-white mt-1">{{ $activeCropCycles }}</p>
                        <p class="text-xs text-agri-olive dark:text-agri-lime mt-1">active now</p>
                    </div>
                    <div class="w-12 h-12 bg-agri-bg-alt dark:bg-zinc-700 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Area -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Total Area</p>
                        <p class="text-3xl font-light text-zinc-800 dark:text-white mt-1">{{ number_format($totalAcres, 1) }}</p>
                        <p class="text-xs text-agri-olive dark:text-agri-lime mt-1">acres</p>
                    </div>
                    <div class="w-12 h-12 bg-agri-bg-alt dark:bg-zinc-700 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Tasks -->
            <div class="bg-agri-lime rounded-2xl p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-zinc-700 uppercase tracking-wide">Pending Tasks</p>
                        <p class="text-3xl font-light text-zinc-800 mt-1">{{ $pendingTasks }}</p>
                        <p class="text-xs text-zinc-700 mt-1">{{ $completedTasks }} done this month</p>
                    </div>
                    <div class="w-12 h-12 bg-white/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-zinc-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Your Farms -->
                <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-medium text-zinc-800 dark:text-white">Your Farms</h2>
                        <a href="{{ route('farms.index') }}" wire:navigate class="text-sm text-agri-olive hover:text-agri-olive-dark dark:text-agri-lime flex items-center gap-1">
                            View All
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    @if($farms->count() > 0)
                        <div class="grid gap-4 sm:grid-cols-2">
                            @foreach($farms as $farm)
                                <a href="{{ route('farms.show', $farm) }}" wire:navigate class="group p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-700 transition-all border border-transparent hover:border-agri-lime/30">
                                    <div class="flex items-start gap-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-agri-green to-agri-green-dark rounded-xl flex items-center justify-center shrink-0">
                                            @if($farm->image_path)
                                                <img src="{{ Storage::url($farm->image_path) }}" alt="{{ $farm->name }}" class="w-full h-full object-cover rounded-xl">
                                            @else
                                                <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2">
                                                <p class="text-sm font-medium text-zinc-800 dark:text-white truncate">{{ $farm->name }}</p>
                                                <span class="inline-flex w-2 h-2 rounded-full {{ $farm->is_active ? 'bg-green-500' : 'bg-zinc-300' }}"></span>
                                            </div>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400 truncate">{{ collect([$farm->city, $farm->country])->filter()->implode(', ') ?: 'No location' }}</p>
                                            <div class="flex items-center gap-3 mt-2">
                                                @if($farm->size)
                                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ number_format($farm->size, 1) }} {{ $farm->size_unit }}</span>
                                                @endif
                                                @if($farm->cropCycles->where('status', 'active')->count() > 0)
                                                    <span class="text-xs text-agri-olive dark:text-agri-lime">{{ $farm->cropCycles->where('status', 'active')->count() }} active crops</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-agri-bg-alt dark:bg-zinc-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            </div>
                            <h3 class="text-lg font-medium text-zinc-800 dark:text-white mb-2">No farms yet</h3>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">Get started by adding your first farm</p>
                            <a href="{{ route('farms.create') }}" wire:navigate class="inline-flex items-center gap-2 px-5 py-2.5 bg-agri-lime text-zinc-800 text-sm font-medium rounded-full hover:bg-agri-lime-light transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Your First Farm
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Upcoming Tasks -->
                <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-medium text-zinc-800 dark:text-white">Upcoming Tasks</h2>
                        <a href="{{ route('tasks.index') }}" wire:navigate class="text-sm text-agri-olive hover:text-agri-olive-dark dark:text-agri-lime flex items-center gap-1">
                            View All
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    @if($recentTasks->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentTasks as $task)
                                <a href="{{ route('tasks.show', $task) }}" wire:navigate class="flex items-center justify-between p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-700 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center
                                            @if($task->priority === 'high') bg-red-100 dark:bg-red-900/30
                                            @elseif($task->priority === 'medium') bg-amber-100 dark:bg-amber-900/30
                                            @else bg-zinc-100 dark:bg-zinc-700 @endif">
                                            <svg class="w-5 h-5 @if($task->priority === 'high') text-red-600 @elseif($task->priority === 'medium') text-amber-600 @else text-zinc-500 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $task->title }}</p>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $task->farm?->name ?? 'No farm' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @if($task->due_date)
                                            @php
                                                $dueDate = \Carbon\Carbon::parse($task->due_date);
                                                $isOverdue = $dueDate->isPast();
                                                $isToday = $dueDate->isToday();
                                                $isTomorrow = $dueDate->isTomorrow();
                                            @endphp
                                            <p class="text-xs {{ $isOverdue ? 'text-red-500' : ($isToday ? 'text-amber-500' : 'text-zinc-500 dark:text-zinc-400') }}">
                                                @if($isOverdue) Overdue
                                                @elseif($isToday) Today
                                                @elseif($isTomorrow) Tomorrow
                                                @else {{ $dueDate->format('M j') }}
                                                @endif
                                            </p>
                                        @endif
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium capitalize
                                            @if($task->priority === 'high') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400
                                            @elseif($task->priority === 'medium') bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400
                                            @else bg-zinc-100 text-zinc-600 dark:bg-zinc-700 dark:text-zinc-400 @endif">
                                            {{ $task->priority }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-12 h-12 bg-agri-bg-alt dark:bg-zinc-700 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">All caught up! No pending tasks.</p>
                            <a href="{{ route('tasks.create') }}" wire:navigate class="inline-flex items-center gap-1 mt-3 text-sm text-agri-olive hover:text-agri-olive-dark dark:text-agri-lime">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create a task
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Financial Summary -->
                <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-medium text-zinc-800 dark:text-white">This Month</h2>
                        <a href="{{ route('finances.index') }}" wire:navigate class="text-sm text-agri-olive hover:text-agri-olive-dark dark:text-agri-lime">Details</a>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                    </svg>
                                </div>
                                <span class="text-sm text-zinc-600 dark:text-zinc-300">Income</span>
                            </div>
                            <span class="text-sm font-medium text-green-600 dark:text-green-400">KES {{ number_format($monthlyIncome, 0) }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-red-50 dark:bg-red-900/20 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                    </svg>
                                </div>
                                <span class="text-sm text-zinc-600 dark:text-zinc-300">Expenses</span>
                            </div>
                            <span class="text-sm font-medium text-red-600 dark:text-red-400">KES {{ number_format($monthlyExpenses, 0) }}</span>
                        </div>

                        <div class="pt-3 border-t border-zinc-200 dark:border-zinc-700">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-zinc-800 dark:text-white">Net Profit</span>
                                <span class="text-lg font-semibold {{ $netProfit >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $netProfit >= 0 ? '+' : '' }}KES {{ number_format($netProfit, 0) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                    <h2 class="text-lg font-medium text-zinc-800 dark:text-white mb-4">Quick Actions</h2>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('farms.create') }}" wire:navigate class="flex flex-col items-center gap-2 p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-700 transition-colors text-center">
                            <div class="w-10 h-10 bg-agri-lime rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-zinc-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-zinc-700 dark:text-zinc-300">New Farm</span>
                        </a>

                        <a href="{{ route('tasks.create') }}" wire:navigate class="flex flex-col items-center gap-2 p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-700 transition-colors text-center">
                            <div class="w-10 h-10 bg-white dark:bg-zinc-800 rounded-lg flex items-center justify-center border border-zinc-200 dark:border-zinc-700">
                                <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-zinc-700 dark:text-zinc-300">Add Task</span>
                        </a>

                        <a href="{{ route('crop-cycles.create') }}" wire:navigate class="flex flex-col items-center gap-2 p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-700 transition-colors text-center">
                            <div class="w-10 h-10 bg-white dark:bg-zinc-800 rounded-lg flex items-center justify-center border border-zinc-200 dark:border-zinc-700">
                                <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-zinc-700 dark:text-zinc-300">Crop Cycle</span>
                        </a>

                        <a href="{{ route('inventory.create') }}" wire:navigate class="flex flex-col items-center gap-2 p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl hover:bg-agri-bg-alt dark:hover:bg-zinc-700 transition-colors text-center">
                            <div class="w-10 h-10 bg-white dark:bg-zinc-800 rounded-lg flex items-center justify-center border border-zinc-200 dark:border-zinc-700">
                                <svg class="w-5 h-5 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-zinc-700 dark:text-zinc-300">Inventory</span>
                        </a>
                    </div>
                </div>

                <!-- Weather Widget -->
                <livewire:dashboard.weather-widget />

                <!-- AI Assistant Card -->
                <div class="bg-zinc-800 dark:bg-zinc-900 rounded-2xl p-6 text-white">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-agri-lime rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-zinc-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium mb-1">AI Farm Assistant</h3>
                            <p class="text-sm text-zinc-400 mb-3">Get instant answers about crops, pests, and farming best practices.</p>
                            <a href="{{ route('ai.assistant') }}" wire:navigate class="inline-flex items-center gap-2 text-sm text-agri-lime hover:text-agri-lime-light transition-colors">
                                Start Conversation
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
