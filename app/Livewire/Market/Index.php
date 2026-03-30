<?php

namespace App\Livewire\Market;

use App\Models\MarketPrice;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('Market Prices')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $commodity = '';

    public string $location = '';

    public string $sortBy = 'price_date';

    public string $sortDir = 'desc';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }
    }

    public function delete(MarketPrice $price): void
    {
        $price->delete();
    }

    public function render()
    {
        $prices = MarketPrice::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('commodity', 'like', "%{$this->search}%")
                        ->orWhere('variety', 'like', "%{$this->search}%")
                        ->orWhere('market_name', 'like', "%{$this->search}%");
                });
            })
            ->when($this->commodity, fn ($query) => $query->where('commodity', $this->commodity))
            ->when($this->location, fn ($query) => $query->where('location', $this->location))
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate(15);

        // Get unique commodities and locations for filters
        $commodities = MarketPrice::distinct()->pluck('commodity')->filter();
        $locations = MarketPrice::distinct()->pluck('location')->filter();

        // Get latest prices for top commodities
        $topCommodities = MarketPrice::query()
            ->selectRaw('commodity, MAX(price_date) as latest_date')
            ->groupBy('commodity')
            ->orderByDesc('latest_date')
            ->limit(6)
            ->get()
            ->map(function ($item) {
                return MarketPrice::where('commodity', $item->commodity)
                    ->where('price_date', $item->latest_date)
                    ->first();
            })
            ->filter();

        return view('livewire.market.index', [
            'prices' => $prices,
            'commodities' => $commodities,
            'locations' => $locations,
            'topCommodities' => $topCommodities,
        ]);
    }
}
