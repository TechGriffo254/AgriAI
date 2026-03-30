<?php

namespace App\Livewire\Market;

use App\Models\MarketPrice;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Add Market Price')]
class Create extends Component
{
    #[Validate('required|string|max:100')]
    public string $commodity = '';

    #[Validate('nullable|string|max:100')]
    public ?string $variety = '';

    #[Validate('required|string|max:255')]
    public string $marketName = '';

    #[Validate('nullable|string|max:255')]
    public ?string $location = '';

    #[Validate('required|numeric|min:0')]
    public float $price = 0;

    #[Validate('nullable|numeric|min:0')]
    public ?float $priceMin = null;

    #[Validate('nullable|numeric|min:0')]
    public ?float $priceMax = null;

    #[Validate('required|string|max:10')]
    public string $unit = 'kg';

    #[Validate('required|date')]
    public string $priceDate = '';

    #[Validate('nullable|string|max:50')]
    public ?string $qualityGrade = '';

    #[Validate('nullable|string|max:100')]
    public ?string $dataSource = '';

    public function mount(): void
    {
        $this->priceDate = now()->format('Y-m-d');
    }

    public function save(): void
    {
        $this->validate();

        // Calculate price change from previous entry
        $previousPrice = MarketPrice::query()
            ->where('commodity', $this->commodity)
            ->where('market_name', $this->marketName)
            ->where('price_date', '<', $this->priceDate)
            ->orderBy('price_date', 'desc')
            ->first();

        $priceChange = null;
        $priceChangePercent = null;

        if ($previousPrice) {
            $priceChange = $this->price - $previousPrice->price;
            $priceChangePercent = $previousPrice->price > 0
                ? (($this->price - $previousPrice->price) / $previousPrice->price) * 100
                : 0;
        }

        MarketPrice::create([
            'commodity' => $this->commodity,
            'variety' => $this->variety ?: null,
            'market_name' => $this->marketName,
            'location' => $this->location ?: null,
            'country' => 'Kenya',
            'price' => $this->price,
            'currency' => 'KES',
            'unit' => $this->unit,
            'price_min' => $this->priceMin,
            'price_max' => $this->priceMax,
            'price_date' => $this->priceDate,
            'price_change' => $priceChange,
            'price_change_percent' => $priceChangePercent,
            'quality_grade' => $this->qualityGrade ?: null,
            'data_source' => $this->dataSource ?: 'manual',
        ]);

        session()->flash('success', 'Market price added successfully!');

        $this->redirect(route('market.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.market.create');
    }
}
