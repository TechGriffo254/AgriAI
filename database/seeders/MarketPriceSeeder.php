<?php

namespace Database\Seeders;

use App\Models\MarketPrice;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MarketPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create random market prices
        MarketPrice::factory(50)->create();

        // Create historical price series for specific commodities to show trends
        $this->createPriceSeries('Maize', 'Wakulima Market', 'Nairobi', 'White', 45, 'kg');
        $this->createPriceSeries('Beans', 'Gikomba Market', 'Nairobi', 'Red', 120, 'kg');
        $this->createPriceSeries('Tomatoes', 'Kongowea Market', 'Mombasa', 'Roma', 80, 'kg');
        $this->createPriceSeries('Rice', 'Kibuye Market', 'Kisumu', 'Pishori', 180, 'kg');
        $this->createPriceSeries('Potatoes', 'Nakuru Municipal Market', 'Nakuru', 'Irish', 35, 'kg');
    }

    /**
     * Create a historical price series for a commodity.
     */
    private function createPriceSeries(
        string $commodity,
        string $market,
        string $location,
        string $variety,
        float $basePrice,
        string $unit
    ): void {
        $previousPrice = null;

        // Create prices for last 30 days
        for ($i = 30; $i >= 0; $i--) {
            // Add some variation to price (±10%)
            $variance = $basePrice * (rand(-100, 100) / 1000);
            $price = $basePrice + $variance;

            // Calculate change from previous
            $priceChange = null;
            $priceChangePercent = null;

            if ($previousPrice !== null) {
                $priceChange = $price - $previousPrice;
                $priceChangePercent = ($previousPrice > 0)
                    ? (($price - $previousPrice) / $previousPrice) * 100
                    : 0;
            }

            MarketPrice::create([
                'commodity' => $commodity,
                'variety' => $variety,
                'market_name' => $market,
                'location' => $location,
                'country' => 'Kenya',
                'price' => round($price, 2),
                'currency' => 'KES',
                'unit' => $unit,
                'price_min' => round($price * 0.9, 2),
                'price_max' => round($price * 1.1, 2),
                'price_change' => $priceChange ? round($priceChange, 2) : null,
                'price_change_percent' => $priceChangePercent ? round($priceChangePercent, 2) : null,
                'price_date' => Carbon::now()->subDays($i)->format('Y-m-d'),
                'data_source' => 'Seeder',
                'quality_grade' => 'Grade A',
            ]);

            $previousPrice = $price;
        }
    }
}
