<?php

namespace App\Livewire\Inventory;

use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('Inventory')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $category = '';

    public string $farmId = '';

    public bool $lowStockOnly = false;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function updatedFarmId(): void
    {
        $this->resetPage();
    }

    public function updatedLowStockOnly(): void
    {
        $this->resetPage();
    }

    public function deleteItem(Inventory $inventory): void
    {
        $this->authorize('delete', $inventory);

        $inventory->delete();

        $this->dispatch('inventory-deleted');
    }

    public function render()
    {
        $user = Auth::user();

        $items = Inventory::where('user_id', $user->id)
            ->with('farm')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('sku', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                });
            })
            ->when($this->category, fn ($query) => $query->where('category', $this->category))
            ->when($this->farmId, fn ($query) => $query->where('farm_id', $this->farmId))
            ->when($this->lowStockOnly, fn ($query) => $query->whereColumn('quantity', '<=', 'reorder_level'))
            ->orderBy('name')
            ->paginate(12);

        $farms = $user->farms()->pluck('name', 'id');

        $categories = Inventory::where('user_id', $user->id)
            ->distinct()
            ->pluck('category')
            ->filter();

        $stats = [
            'total_items' => Inventory::where('user_id', $user->id)->count(),
            'low_stock' => Inventory::where('user_id', $user->id)
                ->whereColumn('quantity', '<=', 'reorder_level')
                ->count(),
            'total_value' => Inventory::where('user_id', $user->id)
                ->selectRaw('SUM(quantity * unit_cost) as total')
                ->value('total') ?? 0,
        ];

        return view('livewire.inventory.index', [
            'items' => $items,
            'farms' => $farms,
            'categories' => $categories,
            'stats' => $stats,
        ]);
    }
}
