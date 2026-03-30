<?php

namespace App\Livewire\Finances;

use App\Models\CropCycle;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
#[Title('Edit Expense')]
class ExpenseEdit extends Component
{
    use WithFileUploads;

    public Expense $expense;

    #[Validate('required|in:labor,seeds,fertilizers,pesticides,equipment,fuel,transport,utilities,maintenance,rent,other')]
    public string $category = 'labor';

    #[Validate('nullable|string|max:100')]
    public ?string $subcategory = '';

    #[Validate('required|string|max:500')]
    public string $description = '';

    #[Validate('required|numeric|min:0.01')]
    public float $amount = 0;

    #[Validate('required|date')]
    public string $expenseDate = '';

    #[Validate('nullable|string|max:100')]
    public ?string $paymentMethod = 'cash';

    #[Validate('nullable|string|max:255')]
    public ?string $vendor = '';

    #[Validate('nullable|exists:farms,id')]
    public ?int $farmId = null;

    #[Validate('nullable|exists:crop_cycles,id')]
    public ?int $cropCycleId = null;

    #[Validate('nullable|image|max:2048')]
    public $receipt = null;

    public function mount(Expense $expense): void
    {
        $this->authorize('update', $expense);

        $this->expense = $expense;
        $this->category = $expense->category;
        $this->subcategory = $expense->subcategory;
        $this->description = $expense->description;
        $this->amount = $expense->amount;
        $this->expenseDate = $expense->expense_date->format('Y-m-d');
        $this->paymentMethod = $expense->payment_method;
        $this->vendor = $expense->vendor;
        $this->farmId = $expense->farm_id;
        $this->cropCycleId = $expense->crop_cycle_id;
    }

    public function updatedFarmId(): void
    {
        $this->cropCycleId = null;
    }

    public function save(): void
    {
        $this->authorize('update', $this->expense);
        $this->validate();

        $receiptPath = $this->expense->receipt_path;
        if ($this->receipt) {
            $receiptPath = $this->receipt->store('receipts', 'public');
        }

        $this->expense->update([
            'category' => $this->category,
            'subcategory' => $this->subcategory,
            'description' => $this->description,
            'amount' => $this->amount,
            'expense_date' => $this->expenseDate,
            'payment_method' => $this->paymentMethod,
            'vendor' => $this->vendor,
            'farm_id' => $this->farmId,
            'crop_cycle_id' => $this->cropCycleId,
            'receipt_path' => $receiptPath,
        ]);

        session()->flash('success', 'Expense updated successfully!');
        $this->redirect(route('finances.index'), navigate: true);
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->expense);
        $this->expense->delete();

        session()->flash('success', 'Expense deleted.');
        $this->redirect(route('finances.index'), navigate: true);
    }

    public function render()
    {
        $user = Auth::user();
        $farms = $user->farms()->pluck('name', 'id');
        $cropCycles = $this->farmId
            ? CropCycle::where('farm_id', $this->farmId)->pluck('name', 'id')
            : collect();

        return view('livewire.finances.expense-edit', [
            'farms' => $farms,
            'cropCycles' => $cropCycles,
        ]);
    }
}
