<?php

namespace App\Livewire\Farms;

use App\Models\Farm;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
#[Title('Add New Farm')]
class Create extends Component
{
    use WithFileUploads;

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
    public ?string $country = 'Kenya';

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

    public function save(): void
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('farms', 'public');
        }

        $farm = Auth::user()->farms()->create([
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
            'is_active' => true,
        ]);

        session()->flash('success', 'Farm created successfully!');

        $this->redirect(route('farms.show', $farm), navigate: true);
    }

    public function render()
    {
        return view('livewire.farms.create');
    }
}
