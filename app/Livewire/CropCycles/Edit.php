<?php

namespace App\Livewire\CropCycles;

use App\Models\Crop;
use App\Models\CropCycle;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Edit Crop Cycle')]
class Edit extends Component
{
    use AuthorizesRequests;

    public CropCycle $cropCycle;

    #[Validate('required|exists:crops,id')]
    public string $cropId = '';

    #[Validate('nullable|string|max:255')]
    public string $name = '';

    #[Validate('nullable|string|max:255')]
    public string $fieldSection = '';

    #[Validate('nullable|numeric|min:0')]
    public ?float $area = null;

    #[Validate('nullable|in:acres,hectares,square_meters')]
    public string $areaUnit = 'acres';

    #[Validate('required|date')]
    public string $plantingDate = '';

    #[Validate('nullable|date')]
    public ?string $expectedHarvestDate = null;

    #[Validate('nullable|date')]
    public ?string $actualHarvestDate = null;

    #[Validate('required|in:planning,active,harvested,cancelled')]
    public string $status = 'active';

    #[Validate('nullable|string|max:255')]
    public string $seedSource = '';

    #[Validate('nullable|string|max:255')]
    public string $seedVariety = '';

    #[Validate('nullable|numeric|min:0')]
    public ?float $seedQuantity = null;

    #[Validate('nullable|string|max:50')]
    public string $seedUnit = 'kg';

    #[Validate('nullable|numeric|min:0')]
    public ?float $expectedYield = null;

    #[Validate('nullable|numeric|min:0')]
    public ?float $actualYield = null;

    #[Validate('nullable|string|max:50')]
    public string $yieldUnit = 'kg';

    #[Validate('nullable|string|max:2000')]
    public string $notes = '';

    public function mount(CropCycle $cropCycle): void
    {
        $this->authorize('update', $cropCycle);

        $this->cropCycle = $cropCycle;
        $this->cropId = (string) $cropCycle->crop_id;
        $this->name = $cropCycle->name ?? '';
        $this->fieldSection = $cropCycle->field_section ?? '';
        $this->area = $cropCycle->area;
        $this->areaUnit = $cropCycle->area_unit ?? 'acres';
        $this->plantingDate = $cropCycle->planting_date?->format('Y-m-d') ?? '';
        $this->expectedHarvestDate = $cropCycle->expected_harvest_date?->format('Y-m-d');
        $this->actualHarvestDate = $cropCycle->actual_harvest_date?->format('Y-m-d');
        $this->status = $cropCycle->status ?? 'active';
        $this->seedSource = $cropCycle->seed_source ?? '';
        $this->seedVariety = $cropCycle->seed_variety ?? '';
        $this->seedQuantity = $cropCycle->seed_quantity;
        $this->seedUnit = $cropCycle->seed_unit ?? 'kg';
        $this->expectedYield = $cropCycle->expected_yield;
        $this->actualYield = $cropCycle->actual_yield;
        $this->yieldUnit = $cropCycle->yield_unit ?? 'kg';
        $this->notes = $cropCycle->notes ?? '';
    }

    public function save(): void
    {
        $this->validate();

        $this->cropCycle->update([
            'crop_id' => $this->cropId,
            'name' => $this->name ?: null,
            'field_section' => $this->fieldSection ?: null,
            'area' => $this->area,
            'area_unit' => $this->areaUnit,
            'planting_date' => $this->plantingDate,
            'expected_harvest_date' => $this->expectedHarvestDate,
            'actual_harvest_date' => $this->actualHarvestDate,
            'status' => $this->status,
            'seed_source' => $this->seedSource ?: null,
            'seed_variety' => $this->seedVariety ?: null,
            'seed_quantity' => $this->seedQuantity,
            'seed_unit' => $this->seedUnit ?: null,
            'expected_yield' => $this->expectedYield,
            'actual_yield' => $this->actualYield,
            'yield_unit' => $this->yieldUnit ?: null,
            'notes' => $this->notes ?: null,
        ]);

        session()->flash('success', 'Crop cycle updated successfully!');

        $this->redirect(route('crop-cycles.show', $this->cropCycle), navigate: true);
    }

    public function render()
    {
        return view('livewire.crop-cycles.edit', [
            'crops' => Crop::where('is_active', true)->orderBy('name')->get(),
        ]);
    }
}
