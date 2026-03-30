<?php

namespace App\Livewire\Finances;

use App\Models\CropCycle;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Edit Income')]
class IncomeEdit extends Component
{
    public Income $income;

    #[Validate('required|in:crop_sales,livestock,services,subsidies,rental,other')]
    public string $category = 'crop_sales';

    #[Validate('nullable|string|max:100')]
    public ?string $subcategory = '';

    #[Validate('required|string|max:500')]
    public string $description = '';

    #[Validate('required|numeric|min:0.01')]
    public float $amount = 0;

    #[Validate('required|date')]
    public string $incomeDate = '';

    #[Validate('nullable|string|max:255')]
    public ?string $buyer = '';

    #[Validate('nullable|numeric|min:0')]
    public ?float $quantity = null;

    #[Validate('nullable|string|max:50')]
    public ?string $quantityUnit = 'kg';

    #[Validate('nullable|numeric|min:0')]
    public ?float $unitPrice = null;

    #[Validate('nullable|string|max:100')]
    public ?string $paymentMethod = 'cash';

    #[Validate('nullable|in:pending,partial,paid')]
    public ?string $paymentStatus = 'paid';

    #[Validate('nullable|exists:farms,id')]
    public ?int $farmId = null;

    #[Validate('nullable|exists:crop_cycles,id')]
    public ?int $cropCycleId = null;

    public function mount(Income $income): void
    {
        $this->authorize('update', $income);

        $this->income = $income;
        $this->category = $income->category;
        $this->subcategory = $income->subcategory;
        $this->description = $income->description;
        $this->amount = $income->amount;
        $this->incomeDate = $income->income_date->format('Y-m-d');
        $this->buyer = $income->buyer;
        $this->quantity = $income->quantity;
        $this->quantityUnit = $income->quantity_unit ?? 'kg';
        $this->unitPrice = $income->unit_price;
        $this->paymentMethod = $income->payment_method;
        $this->paymentStatus = $income->payment_status;
        $this->farmId = $income->farm_id;
        $this->cropCycleId = $income->crop_cycle_id;
    }

    public function updatedFarmId(): void
    {
        $this->cropCycleId = null;
    }

    public function save(): void
    {
        $this->authorize('update', $this->income);
        $this->validate();

        $this->income->update([
            'category' => $this->category,
            'subcategory' => $this->subcategory,
            'description' => $this->description,
            'amount' => $this->amount,
            'income_date' => $this->incomeDate,
            'buyer' => $this->buyer,
            'quantity' => $this->quantity,
            'quantity_unit' => $this->quantityUnit,
            'unit_price' => $this->unitPrice,
            'payment_method' => $this->paymentMethod,
            'payment_status' => $this->paymentStatus,
            'farm_id' => $this->farmId,
            'crop_cycle_id' => $this->cropCycleId,
        ]);

        session()->flash('success', 'Income updated successfully!');
        $this->redirect(route('finances.index'), navigate: true);
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->income);
        $this->income->delete();

        session()->flash('success', 'Income deleted.');
        $this->redirect(route('finances.index'), navigate: true);
    }

    public function render()
    {
        $user = Auth::user();
        $farms = $user->farms()->pluck('name', 'id');
        $cropCycles = $this->farmId
            ? CropCycle::where('farm_id', $this->farmId)->pluck('name', 'id')
            : collect();

        return view('livewire.finances.income-edit', [
            'farms' => $farms,
            'cropCycles' => $cropCycles,
        ]);
    }
}
