<?php

namespace App\Livewire\Inventory;

use App\Models\Inventory;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Inventory Details')]
class Show extends Component
{
    public Inventory $inventory;

    public bool $showAdjustModal = false;

    #[Validate('required|in:add,remove,adjust')]
    public string $adjustType = 'add';

    #[Validate('required|numeric|min:0.01')]
    public float $adjustQuantity = 0;

    #[Validate('nullable|string|max:500')]
    public ?string $adjustNotes = '';

    public function mount(Inventory $inventory): void
    {
        $this->authorize('view', $inventory);

        $this->inventory = $inventory->load(['farm', 'transactions' => function ($query) {
            $query->latest()->limit(10);
        }]);
    }

    public function openAdjustModal(): void
    {
        $this->showAdjustModal = true;
        $this->adjustType = 'add';
        $this->adjustQuantity = 0;
        $this->adjustNotes = '';
    }

    public function closeAdjustModal(): void
    {
        $this->showAdjustModal = false;
        $this->resetValidation();
    }

    public function adjustStock(): void
    {
        $this->authorize('update', $this->inventory);

        $this->validate();

        $quantityBefore = $this->inventory->quantity;

        if ($this->adjustType === 'add') {
            $quantityAfter = $quantityBefore + $this->adjustQuantity;
            $transactionType = 'stock_in';
        } elseif ($this->adjustType === 'remove') {
            if ($this->adjustQuantity > $quantityBefore) {
                $this->addError('adjustQuantity', 'Cannot remove more than available stock.');

                return;
            }
            $quantityAfter = $quantityBefore - $this->adjustQuantity;
            $transactionType = 'stock_out';
        } else {
            $quantityAfter = $this->adjustQuantity;
            $transactionType = 'adjustment';
        }

        // Create transaction record
        InventoryTransaction::create([
            'inventory_id' => $this->inventory->id,
            'user_id' => Auth::id(),
            'type' => $transactionType,
            'quantity' => $this->adjustType === 'adjust' ? abs($quantityAfter - $quantityBefore) : $this->adjustQuantity,
            'quantity_before' => $quantityBefore,
            'quantity_after' => $quantityAfter,
            'unit_cost' => $this->inventory->unit_cost,
            'total_cost' => $this->adjustQuantity * ($this->inventory->unit_cost ?? 0),
            'notes' => $this->adjustNotes,
            'transaction_date' => now(),
        ]);

        // Update inventory quantity
        $this->inventory->update(['quantity' => $quantityAfter]);

        $this->inventory->refresh();
        $this->closeAdjustModal();

        session()->flash('success', 'Stock adjusted successfully!');
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->inventory);

        $this->inventory->delete();

        session()->flash('success', 'Inventory item deleted successfully.');

        $this->redirect(route('inventory.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.inventory.show');
    }
}
