<?php

namespace App\Livewire\CropCycles;

use App\Models\Crop;
use App\Models\CropCycle;
use App\Models\Farm;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.app')] // layout to be used
#[Title('Add Crop Cycle')] //  title of the page
class Create extends Component
{
    #[Validate('required|exists:farms,id')]
    public string $farmId = '';

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

    #[Validate('nullable|date|after:planting_date')]
    public ?string $expectedHarvestDate = null;

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

    #[Validate('nullable|string|max:50')]
    public string $yieldUnit = 'kg';

    #[Validate('nullable|string|max:2000')]
    public string $notes = '';

    public ?Farm $preselectedFarm = null;

    public function mount(?Farm $farm = null): void
    {
        if ($farm && $farm->exists) {
            $this->authorize('view', $farm);
            $this->farmId = (string) $farm->id;
            $this->preselectedFarm = $farm;
        }

        $this->plantingDate = now()->format('Y-m-d');
    }

    public function updatedCropId(): void
    {
        if ($this->cropId) {
            $crop = Crop::find($this->cropId);
            if ($crop && $crop->days_to_maturity && $this->plantingDate) {
                $this->expectedHarvestDate = now()->parse($this->plantingDate)
                    ->addDays($crop->days_to_maturity)
                    ->format('Y-m-d');
            }
        }
    }

    public function save(): void
    {
        $this->validate();

        $farm = Farm::findOrFail($this->farmId);
        $this->authorize('update', $farm);

        $crop = Crop::find($this->cropId);
        $name = $this->name ?: ($crop ? $crop->name.' - '.now()->format('M Y') : 'Crop Cycle');

        $cropCycle = CropCycle::create([
            'farm_id' => $this->farmId,
            'crop_id' => $this->cropId,
            'name' => $name,
            'field_section' => $this->fieldSection ?: null,
            'area' => $this->area,
            'area_unit' => $this->areaUnit,
            'planting_date' => $this->plantingDate,
            'expected_harvest_date' => $this->expectedHarvestDate,
            'status' => 'active',
            'seed_source' => $this->seedSource ?: null,
            'seed_variety' => $this->seedVariety ?: null,
            'seed_quantity' => $this->seedQuantity,
            'seed_unit' => $this->seedUnit ?: null,
            'expected_yield' => $this->expectedYield,
            'yield_unit' => $this->yieldUnit ?: null,
            'notes' => $this->notes ?: null,
        ]);
        session()->flash('success', 'Crop cycle created successfully!');
        $this->redirect(route('crop-cycles.show', $cropCycle), navigate: true);
    }

    public function render()
    {
        $user = Auth::user();

        return view('livewire.crop-cycles.create', [
            'farms' => $user->farms()->where('is_active', true)->get(),
            'crops' => Crop::where('is_active', true)->orderBy('name')->get(),
        ]);
    }
}
