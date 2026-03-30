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
#[Title('Add Income')]
class IncomeCreate extends Component
{
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

    public function mount(): void
    {
        $this->incomeDate = now()->format('Y-m-d');
    }

    public function updatedFarmId(): void
    {
        $this->cropCycleId = null;
    }

    public function updatedQuantity(): void
    {
        $this->calculateAmount();
    }

    public function updatedUnitPrice(): void
    {
        $this->calculateAmount();
    }

    protected function calculateAmount(): void
    {
        if ($this->quantity && $this->unitPrice) {
            $this->amount = $this->quantity * $this->unitPrice;
        }
    }

    public function save(): void
    {
        $this->validate();

        $user = Auth::user();

        // Verify farm ownership
        if ($this->farmId) {
            $farm = $user->farms()->find($this->farmId);
            if (! $farm) {
                $this->addError('farmId', 'Invalid farm selected.');

                return;
            }
        }

        Income::create([
            'user_id' => $user->id,
            'farm_id' => $this->farmId,
            'crop_cycle_id' => $this->cropCycleId,
            'category' => $this->category,
            'subcategory' => $this->subcategory,
            'description' => $this->description,
            'amount' => $this->amount,
            'currency' => 'KES',
            'income_date' => $this->incomeDate,
            'buyer' => $this->buyer,
            'quantity' => $this->quantity,
            'quantity_unit' => $this->quantityUnit,
            'unit_price' => $this->unitPrice,
            'payment_method' => $this->paymentMethod,
            'payment_status' => $this->paymentStatus,
        ]);

        session()->flash('success', 'Income recorded successfully!');

        $this->redirect(route('finances.index'), navigate: true);
    }

    public function render()
    {
        $user = Auth::user();
        $farms = $user->farms()->pluck('name', 'id');
        $cropCycles = $this->farmId
            ? CropCycle::where('farm_id', $this->farmId)->pluck('name', 'id')
            : collect();

        return view('livewire.finances.income-create', [
            'farms' => $farms,
            'cropCycles' => $cropCycles,
        ]);
    }
}
