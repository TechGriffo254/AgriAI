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
#[Title('Add Expense')]
class ExpenseCreate extends Component
{
    use WithFileUploads;

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

    public function mount(): void
    {
        $this->expenseDate = now()->format('Y-m-d');
    }

    public function updatedFarmId(): void
    {
        $this->cropCycleId = null;
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

        $receiptPath = null;
        if ($this->receipt) {
            $receiptPath = $this->receipt->store('receipts', 'public');
        }

        Expense::create([
            'user_id' => $user->id,
            'farm_id' => $this->farmId,
            'crop_cycle_id' => $this->cropCycleId,
            'category' => $this->category,
            'subcategory' => $this->subcategory,
            'description' => $this->description,
            'amount' => $this->amount,
            'currency' => 'KES',
            'expense_date' => $this->expenseDate,
            'payment_method' => $this->paymentMethod,
            'vendor' => $this->vendor,
            'receipt_path' => $receiptPath,
        ]);

        session()->flash('success', 'Expense recorded successfully!');

        $this->redirect(route('finances.index'), navigate: true);
    }

    public function render()
    {
        $user = Auth::user();
        $farms = $user->farms()->pluck('name', 'id');
        $cropCycles = $this->farmId
            ? CropCycle::where('farm_id', $this->farmId)->pluck('name', 'id')
            : collect();

        return view('livewire.finances.expense-create', [
            'farms' => $farms,
            'cropCycles' => $cropCycles,
        ]);
    }
}
