<?php

namespace App\Livewire\Inventory;

use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
#[Title('Add Inventory Item')]
class Create extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|in:seeds,fertilizers,pesticides,tools,equipment,fuel,feed,other')]
    public string $category = 'seeds';

    #[Validate('nullable|string|max:100')]
    public ?string $subcategory = '';

    #[Validate('nullable|string|max:1000')]
    public ?string $description = '';

    #[Validate('nullable|string|max:100')]
    public ?string $sku = '';

    #[Validate('required|numeric|min:0')]
    public float $quantity = 0;

    #[Validate('required|string|max:50')]
    public string $unit = 'kg';

    #[Validate('nullable|numeric|min:0')]
    public ?float $unitCost = null;

    #[Validate('nullable|numeric|min:0')]
    public ?float $reorderLevel = null;

    #[Validate('nullable|string|max:255')]
    public ?string $storageLocation = '';

    #[Validate('nullable|date')]
    public ?string $expiryDate = null;

    #[Validate('nullable|string|max:255')]
    public ?string $supplier = '';

    #[Validate('nullable|exists:farms,id')]
    public ?int $farmId = null;

    #[Validate('nullable|image|max:2048')]
    public $image = null;

    public function save(): void
    {
        $this->validate();

        $user = Auth::user();

        // Verify farm ownership if provided
        if ($this->farmId) {
            $farm = $user->farms()->find($this->farmId);
            if (! $farm) {
                $this->addError('farmId', 'Invalid farm selected.');

                return;
            }
        }

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('inventory', 'public');
        }

        $inventory = Inventory::create([
            'user_id' => $user->id,
            'farm_id' => $this->farmId,
            'name' => $this->name,
            'category' => $this->category,
            'subcategory' => $this->subcategory,
            'description' => $this->description,
            'sku' => $this->sku,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'unit_cost' => $this->unitCost,
            'currency' => 'KES',
            'reorder_level' => $this->reorderLevel,
            'storage_location' => $this->storageLocation,
            'expiry_date' => $this->expiryDate,
            'supplier' => $this->supplier,
            'image_path' => $imagePath,
            'is_active' => true,
        ]);

        session()->flash('success', 'Inventory item added successfully!');

        $this->redirect(route('inventory.show', $inventory), navigate: true);
    }

    public function render()
    {
        $farms = Auth::user()->farms()->pluck('name', 'id');

        return view('livewire.inventory.create', [
            'farms' => $farms,
        ]);
    }
}
