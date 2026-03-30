<?php

namespace App\Livewire\Finances;

use App\Models\Expense;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('Finances')]
class Index extends Component
{
    use WithPagination;

    public string $activeTab = 'overview';

    public string $search = '';

    public string $category = '';

    public string $farmId = '';

    public string $dateFrom = '';

    public string $dateTo = '';

    public function mount(): void
    {
        $this->dateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = now()->format('Y-m-d');
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function deleteExpense(Expense $expense): void
    {
        $this->authorize('delete', $expense);
        $expense->delete();
    }

    public function deleteIncome(Income $income): void
    {
        $this->authorize('delete', $income);
        $income->delete();
    }

    public function render()
    {
        $user = Auth::user();

        // Get date range
        $fromDate = $this->dateFrom ?: now()->startOfMonth();
        $toDate = $this->dateTo ?: now();

        // Calculate stats
        $totalExpenses = Expense::where('user_id', $user->id)
            ->whereBetween('expense_date', [$fromDate, $toDate])
            ->sum('amount');

        $totalIncome = Income::where('user_id', $user->id)
            ->whereBetween('income_date', [$fromDate, $toDate])
            ->sum('amount');

        $netProfit = $totalIncome - $totalExpenses;

        // Get expenses with filters
        $expenses = Expense::where('user_id', $user->id)
            ->with(['farm', 'cropCycle'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('description', 'like', "%{$this->search}%")
                        ->orWhere('vendor', 'like', "%{$this->search}%");
                });
            })
            ->when($this->category, fn ($query) => $query->where('category', $this->category))
            ->when($this->farmId, fn ($query) => $query->where('farm_id', $this->farmId))
            ->when($this->dateFrom, fn ($query) => $query->whereDate('expense_date', '>=', $this->dateFrom))
            ->when($this->dateTo, fn ($query) => $query->whereDate('expense_date', '<=', $this->dateTo))
            ->orderBy('expense_date', 'desc')
            ->paginate(10, pageName: 'expensesPage');

        // Get income with filters
        $incomes = Income::where('user_id', $user->id)
            ->with(['farm', 'cropCycle'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('description', 'like', "%{$this->search}%")
                        ->orWhere('buyer', 'like', "%{$this->search}%");
                });
            })
            ->when($this->category, fn ($query) => $query->where('category', $this->category))
            ->when($this->farmId, fn ($query) => $query->where('farm_id', $this->farmId))
            ->when($this->dateFrom, fn ($query) => $query->whereDate('income_date', '>=', $this->dateFrom))
            ->when($this->dateTo, fn ($query) => $query->whereDate('income_date', '<=', $this->dateTo))
            ->orderBy('income_date', 'desc')
            ->paginate(10, pageName: 'incomesPage');

        // Get expense categories breakdown
        $expensesByCategory = Expense::where('user_id', $user->id)
            ->whereBetween('expense_date', [$fromDate, $toDate])
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        // Get income categories breakdown
        $incomesByCategory = Income::where('user_id', $user->id)
            ->whereBetween('income_date', [$fromDate, $toDate])
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $farms = $user->farms()->pluck('name', 'id');

        return view('livewire.finances.index', [
            'expenses' => $expenses,
            'incomes' => $incomes,
            'totalExpenses' => $totalExpenses,
            'totalIncome' => $totalIncome,
            'netProfit' => $netProfit,
            'expensesByCategory' => $expensesByCategory,
            'incomesByCategory' => $incomesByCategory,
            'farms' => $farms,
        ]);
    }
}
