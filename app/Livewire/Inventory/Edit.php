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
#[Title('Edit Inventory Item')]
class Edit extends Component
{
    use WithFileUploads;

    public Inventory $inventory;

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

    #[Validate('boolean')]
    public bool $isActive = true;

    #[Validate('nullable|image|max:2048')]
    public $image = null;

    public function mount(Inventory $inventory): void
    {
        $this->authorize('update', $inventory);

        $this->inventory = $inventory;
        $this->name = $inventory->name;
        $this->category = $inventory->category;
        $this->subcategory = $inventory->subcategory;
        $this->description = $inventory->description;
        $this->sku = $inventory->sku;
        $this->unit = $inventory->unit;
        $this->unitCost = $inventory->unit_cost;
        $this->reorderLevel = $inventory->reorder_level;
        $this->storageLocation = $inventory->storage_location;
        $this->expiryDate = $inventory->expiry_date?->format('Y-m-d');
        $this->supplier = $inventory->supplier;
        $this->farmId = $inventory->farm_id;
        $this->isActive = $inventory->is_active;
    }

    public function save(): void
    {
        $this->authorize('update', $this->inventory);
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

        $imagePath = $this->inventory->image_path;
        if ($this->image) {
            $imagePath = $this->image->store('inventory', 'public');
        }

        $this->inventory->update([
            'farm_id' => $this->farmId,
            'name' => $this->name,
            'category' => $this->category,
            'subcategory' => $this->subcategory,
            'description' => $this->description,
            'sku' => $this->sku,
            'unit' => $this->unit,
            'unit_cost' => $this->unitCost,
            'reorder_level' => $this->reorderLevel,
            'storage_location' => $this->storageLocation,
            'expiry_date' => $this->expiryDate,
            'supplier' => $this->supplier,
            'image_path' => $imagePath,
            'is_active' => $this->isActive,
        ]);

        session()->flash('success', 'Inventory item updated successfully!');

        $this->redirect(route('inventory.show', $this->inventory), navigate: true);
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
        $farms = Auth::user()->farms()->pluck('name', 'id');

        return view('livewire.inventory.edit', [
            'farms' => $farms,
        ]);
    }
}
