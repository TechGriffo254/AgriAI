<?php

namespace App\Livewire\Market;

use App\Models\MarketPrice;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Market Price Details')]
class Show extends Component
{
    public MarketPrice $marketPrice;

    public function mount(MarketPrice $marketPrice): void
    {
        $this->marketPrice = $marketPrice;
    }

    public function delete(): void
    {
        $this->marketPrice->delete();
        session()->flash('success', 'Market price deleted successfully!');
        $this->redirect(route('market.index'), navigate: true);
    }

    public function render()
    {
        // Get price history for this commodity
        $priceHistory = MarketPrice::query()
            ->where('commodity', $this->marketPrice->commodity)
            ->where('market_name', $this->marketPrice->market_name)
            ->orderBy('price_date', 'asc')
            ->limit(30)
            ->get();

        // Calculate statistics
        $avgPrice = $priceHistory->avg('price');
        $minPrice = $priceHistory->min('price');
        $maxPrice = $priceHistory->max('price');
        $priceCount = $priceHistory->count();

        // Get related prices from other markets
        $otherMarkets = MarketPrice::query()
            ->where('commodity', $this->marketPrice->commodity)
            ->where('market_name', '!=', $this->marketPrice->market_name)
            ->where('price_date', '>=', now()->subDays(7))
            ->orderBy('price_date', 'desc')
            ->limit(5)
            ->get();

        // Prepare chart data
        $chartData = $priceHistory->map(function ($price) {
            return [
                'date' => $price->price_date->format('M j'),
                'price' => $price->price,
            ];
        })->values()->toArray();

        return view('livewire.market.show', [
            'priceHistory' => $priceHistory,
            'avgPrice' => $avgPrice,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'priceCount' => $priceCount,
            'otherMarkets' => $otherMarkets,
            'chartData' => $chartData,
        ]);
    }
}
