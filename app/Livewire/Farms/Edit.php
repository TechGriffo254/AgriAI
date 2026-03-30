<?php

namespace App\Livewire\Farms;

use App\Models\Farm;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
#[Title('Edit Farm')]
class Edit extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public Farm $farm;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('nullable|string|max:1000')]
    public ?string $description = '';

    #[Validate('nullable|numeric|between:-90,90')]
    public ?float $latitude = null;

    #[Validate('nullable|numeric|between:-180,180')]
    public ?float $longitude = null;

    #[Validate('nullable|string|max:500')]
    public ?string $address = '';

    #[Validate('nullable|string|max:100')]
    public ?string $city = '';

    #[Validate('nullable|string|max:100')]
    public ?string $state = '';

    #[Validate('nullable|string|max:100')]
    public ?string $country = '';

    #[Validate('nullable|numeric|min:0')]
    public ?float $size = null;

    #[Validate('nullable|in:acres,hectares,square_meters')]
    public ?string $sizeUnit = 'acres';

    #[Validate('nullable|string|max:100')]
    public ?string $soilType = '';

    #[Validate('nullable|string|max:100')]
    public ?string $climateZone = '';

    #[Validate('nullable|string|max:100')]
    public ?string $waterSource = '';

    #[Validate('nullable|image|max:2048')]
    public $image = null;

    #[Validate('boolean')]
    public bool $isActive = true;

    public function mount(Farm $farm): void
    {
        $this->authorize('update', $farm);

        $this->farm = $farm;
        $this->name = $farm->name;
        $this->description = $farm->description ?? '';
        $this->latitude = $farm->latitude;
        $this->longitude = $farm->longitude;
        $this->address = $farm->address ?? '';
        $this->city = $farm->city ?? '';
        $this->state = $farm->state ?? '';
        $this->country = $farm->country ?? '';
        $this->size = $farm->size;
        $this->sizeUnit = $farm->size_unit ?? 'acres';
        $this->soilType = $farm->soil_type ?? '';
        $this->climateZone = $farm->climate_zone ?? '';
        $this->waterSource = $farm->water_source ?? '';
        $this->isActive = $farm->is_active;
    }

    public function save(): void
    {
        $this->validate();

        $imagePath = $this->farm->image_path;
        if ($this->image) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $this->image->store('farms', 'public');
        }

        $this->farm->update([
            'name' => $this->name,
            'description' => $this->description,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'size' => $this->size,
            'size_unit' => $this->sizeUnit,
            'soil_type' => $this->soilType,
            'climate_zone' => $this->climateZone,
            'water_source' => $this->waterSource,
            'image_path' => $imagePath,
            'is_active' => $this->isActive,
        ]);

        session()->flash('success', 'Farm updated successfully!');

        $this->redirect(route('farms.show', $this->farm), navigate: true);
    }

    public function render()
    {
        return view('livewire.farms.edit');
    }
}
