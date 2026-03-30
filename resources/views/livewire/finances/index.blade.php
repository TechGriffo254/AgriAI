<div>
    <x-theme.agri-page-header
        title="Finances"
        description="Track your farm expenses and income"
    >
        <x-slot:actions>
            <x-theme.agri-button :href="route('finances.expense.create')" variant="outline">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Expense
            </x-theme.agri-button>
            <x-theme.agri-button :href="route('finances.income.create')" variant="primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Income
            </x-theme.agri-button>
        </x-slot:actions>
    </x-theme.agri-page-header>

    <!-- Stats Cards -->
    <div class="grid gap-4 md:grid-cols-3 mb-6">
        <x-theme.agri-stat
            :value="'KES ' . number_format($totalIncome, 0)"
            label="Total Income"
            layout="inline"
            variant="default"
        >
            <x-slot:icon>
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8l-8 8-8-8" />
                </svg>
            </x-slot:icon>
        </x-theme.agri-stat>

        <x-theme.agri-stat
            :value="'KES ' . number_format($totalExpenses, 0)"
            label="Total Expenses"
            layout="inline"
            variant="default"
        >
            <x-slot:icon>
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 20V4m-8 8l8-8 8 8" />
                </svg>
            </x-slot:icon>
        </x-theme.agri-stat>

        <x-theme.agri-stat
            :value="'KES ' . number_format($netProfit, 0)"
            label="Net Profit"
            layout="inline"
            :variant="$netProfit >= 0 ? 'accent' : 'default'"
            :class="$netProfit < 0 ? 'border-l-4 border-l-red-500' : ''"
        >
            <x-slot:icon>
                <svg class="w-6 h-6 {{ $netProfit >= 0 ? 'text-zinc-800' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </x-slot:icon>
        </x-theme.agri-stat>
    </div>

    <!-- Date Range Filter -->
    <div class="mb-6 flex flex-wrap items-center gap-4">
        <div class="flex items-center gap-2">
            <label class="text-sm text-zinc-600 dark:text-zinc-400">From:</label>
            <input
                type="date"
                wire:model.live="dateFrom"
                class="px-3 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime"
            >
        </div>
        <div class="flex items-center gap-2">
            <label class="text-sm text-zinc-600 dark:text-zinc-400">To:</label>
            <input
                type="date"
                wire:model.live="dateTo"
                class="px-3 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime"
            >
        </div>
    </div>

    <!-- Tabs -->
    <div class="mb-6 border-b border-zinc-200 dark:border-zinc-700">
        <nav class="flex gap-6">
            <button
                wire:click="setTab('overview')"
                class="pb-3 text-sm font-medium transition-colors {{ $activeTab === 'overview' ? 'text-agri-olive border-b-2 border-agri-lime' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300' }}"
            >
                Overview
            </button>
            <button
                wire:click="setTab('expenses')"
                class="pb-3 text-sm font-medium transition-colors {{ $activeTab === 'expenses' ? 'text-agri-olive border-b-2 border-agri-lime' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300' }}"
            >
                Expenses
            </button>
            <button
                wire:click="setTab('income')"
                class="pb-3 text-sm font-medium transition-colors {{ $activeTab === 'income' ? 'text-agri-olive border-b-2 border-agri-lime' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300' }}"
            >
                Income
            </button>
        </nav>
    </div>

    <!-- Overview Tab -->
    @if($activeTab === 'overview')
        <div class="grid gap-6 lg:grid-cols-2">
            <!-- Expenses by Category -->
            <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                <h3 class="text-lg font-medium text-zinc-800 dark:text-white mb-4">Expenses by Category</h3>
                @if($expensesByCategory->count() > 0)
                    <div class="space-y-3">
                        @foreach($expensesByCategory as $cat)
                            @php
                                $percentage = $totalExpenses > 0 ? ($cat->total / $totalExpenses) * 100 : 0;
                            @endphp
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-zinc-600 dark:text-zinc-400 capitalize">{{ str_replace('_', ' ', $cat->category) }}</span>
                                    <span class="text-sm font-medium text-zinc-800 dark:text-white">KES {{ number_format($cat->total, 0) }}</span>
                                </div>
                                <div class="h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-red-500 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-8">No expenses recorded in this period</p>
                @endif
            </x-theme.agri-card>

            <!-- Income by Category -->
            <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                <h3 class="text-lg font-medium text-zinc-800 dark:text-white mb-4">Income by Category</h3>
                @if($incomesByCategory->count() > 0)
                    <div class="space-y-3">
                        @foreach($incomesByCategory as $cat)
                            @php
                                $percentage = $totalIncome > 0 ? ($cat->total / $totalIncome) * 100 : 0;
                            @endphp
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-zinc-600 dark:text-zinc-400 capitalize">{{ str_replace('_', ' ', $cat->category) }}</span>
                                    <span class="text-sm font-medium text-zinc-800 dark:text-white">KES {{ number_format($cat->total, 0) }}</span>
                                </div>
                                <div class="h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-green-500 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-8">No income recorded in this period</p>
                @endif
            </x-theme.agri-card>
        </div>
    @endif

    <!-- Expenses Tab -->
    @if($activeTab === 'expenses')
        <!-- Search & Filters -->
        <div class="mb-6 grid gap-4 md:grid-cols-3">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search expenses..."
                    class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime"
                >
            </div>
            <select
                wire:model.live="category"
                class="w-full px-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime"
            >
                <option value="">All Categories</option>
                <option value="labor">Labor</option>
                <option value="seeds">Seeds</option>
                <option value="fertilizers">Fertilizers</option>
                <option value="pesticides">Pesticides</option>
                <option value="equipment">Equipment</option>
                <option value="fuel">Fuel</option>
                <option value="transport">Transport</option>
                <option value="utilities">Utilities</option>
                <option value="maintenance">Maintenance</option>
                <option value="rent">Rent</option>
                <option value="other">Other</option>
            </select>
            <select
                wire:model.live="farmId"
                class="w-full px-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime"
            >
                <option value="">All Farms</option>
                @foreach($farms as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Expenses List -->
        @if($expenses->count() > 0)
            <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700 overflow-hidden p-0">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-agri-bg dark:bg-zinc-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Farm</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Amount</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($expenses as $expense)
                                <tr wire:key="expense-{{ $expense->id }}" class="hover:bg-agri-bg/50 dark:hover:bg-zinc-800/50">
                                    <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                        {{ $expense->expense_date->format('M j, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $expense->description }}</p>
                                        @if($expense->vendor)
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $expense->vendor }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400 capitalize">
                                        {{ str_replace('_', ' ', $expense->category) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                        {{ $expense->farm?->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-red-600 dark:text-red-400 text-right">
                                        -KES {{ number_format($expense->amount, 0) }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('finances.expense.edit', $expense) }}" wire:navigate class="p-2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <button
                                                wire:click="deleteExpense({{ $expense->id }})"
                                                wire:confirm="Are you sure you want to delete this expense?"
                                                class="p-2 text-zinc-400 hover:text-red-500"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-theme.agri-card>
            <div class="mt-4">
                {{ $expenses->links() }}
            </div>
        @else
            <x-theme.agri-empty
                title="No expenses recorded"
                description="Start tracking your farm expenses"
                action-text="Add Expense"
                :action-href="route('finances.expense.create')"
            >
                <x-slot:icon>
                    <svg class="w-10 h-10 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z" />
                    </svg>
                </x-slot:icon>
            </x-theme.agri-empty>
        @endif
    @endif

    <!-- Income Tab -->
    @if($activeTab === 'income')
        <!-- Search & Filters -->
        <div class="mb-6 grid gap-4 md:grid-cols-3">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search income..."
                    class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime"
                >
            </div>
            <select
                wire:model.live="category"
                class="w-full px-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime"
            >
                <option value="">All Categories</option>
                <option value="crop_sales">Crop Sales</option>
                <option value="livestock">Livestock</option>
                <option value="services">Services</option>
                <option value="subsidies">Subsidies</option>
                <option value="rental">Rental</option>
                <option value="other">Other</option>
            </select>
            <select
                wire:model.live="farmId"
                class="w-full px-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime"
            >
                <option value="">All Farms</option>
                @foreach($farms as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Income List -->
        @if($incomes->count() > 0)
            <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700 overflow-hidden p-0">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-agri-bg dark:bg-zinc-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Buyer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Amount</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($incomes as $income)
                                <tr wire:key="income-{{ $income->id }}" class="hover:bg-agri-bg/50 dark:hover:bg-zinc-800/50">
                                    <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                        {{ $income->income_date->format('M j, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $income->description }}</p>
                                        @if($income->quantity)
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ number_format($income->quantity, 1) }} {{ $income->quantity_unit }} @ KES {{ number_format($income->unit_price, 0) }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400 capitalize">
                                        {{ str_replace('_', ' ', $income->category) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                        {{ $income->buyer ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClasses = [
                                                'paid' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                                'partial' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                'pending' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300',
                                            ];
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClasses[$income->payment_status] ?? $statusClasses['pending'] }}">
                                            {{ ucfirst($income->payment_status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-green-600 dark:text-green-400 text-right">
                                        +KES {{ number_format($income->amount, 0) }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('finances.income.edit', $income) }}" wire:navigate class="p-2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <button
                                                wire:click="deleteIncome({{ $income->id }})"
                                                wire:confirm="Are you sure you want to delete this income?"
                                                class="p-2 text-zinc-400 hover:text-red-500"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-theme.agri-card>
            <div class="mt-4">
                {{ $incomes->links() }}
            </div>
        @else
            <x-theme.agri-empty
                title="No income recorded"
                description="Start tracking your farm income"
                action-text="Add Income"
                :action-href="route('finances.income.create')"
            >
                <x-slot:icon>
                    <svg class="w-10 h-10 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </x-slot:icon>
            </x-theme.agri-empty>
        @endif
    @endif
</div>
