<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MarketPrice>
 */
class MarketPriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $commodities = [
            'Maize' => ['White', 'Yellow', null],
            'Beans' => ['Red', 'Black', 'Pinto', null],
            'Wheat' => ['Hard', 'Soft', null],
            'Rice' => ['Basmati', 'Pishori', null],
            'Potatoes' => ['Irish', 'Sweet', null],
            'Tomatoes' => ['Roma', 'Cherry', null],
            'Onions' => ['Red', 'White', null],
            'Cabbage' => ['Green', 'Red', null],
            'Carrots' => [null],
            'Bananas' => ['Cooking', 'Sweet', null],
            'Milk' => ['Fresh', 'Pasteurized', null],
            'Eggs' => ['Large', 'Medium', null],
        ];

        $markets = [
            'Wakulima Market' => 'Nairobi',
            'Gikomba Market' => 'Nairobi',
            'Kongowea Market' => 'Mombasa',
            'Kibuye Market' => 'Kisumu',
            'Nakuru Municipal Market' => 'Nakuru',
            'Eldoret Open Air Market' => 'Eldoret',
            'Meru Town Market' => 'Meru',
            'Nyeri Municipal Market' => 'Nyeri',
        ];

        $units = ['kg', 'bag', 'crate', 'bunch', 'piece', 'litre'];
        $grades = ['Grade A', 'Grade B', 'Grade C', null];

        $commodity = fake()->randomElement(array_keys($commodities));
        $variety = fake()->randomElement($commodities[$commodity]);
        $market = fake()->randomElement(array_keys($markets));
        $location = $markets[$market];

        $basePrice = fake()->randomFloat(2, 20, 500);
        $priceChange = fake()->randomFloat(2, -50, 50);
        $priceChangePercent = ($basePrice > 0) ? ($priceChange / $basePrice) * 100 : 0;

        return [
            'commodity' => $commodity,
            'variety' => $variety,
            'market_name' => $market,
            'location' => $location,
            'country' => 'Kenya',
            'price' => $basePrice,
            'currency' => 'KES',
            'unit' => fake()->randomElement($units),
            'price_min' => $basePrice * 0.9,
            'price_max' => $basePrice * 1.1,
            'price_change' => $priceChange,
            'price_change_percent' => round($priceChangePercent, 2),
            'price_date' => fake()->dateTimeBetween('-30 days', 'now'),
            'data_source' => fake()->randomElement(['NAFIS', 'Local Survey', 'Manual Entry', 'Kenya Agricultural Market Information System']),
            'quality_grade' => fake()->randomElement($grades),
        ];
    }

    /**
     * Create historical price data for a commodity.
     */
    public function forCommodity(string $commodity, string $market): static
    {
        return $this->state(fn (array $attributes) => [
            'commodity' => $commodity,
            'market_name' => $market,
        ]);
    }

    /**
     * Create recent price entry.
     */
    public function recent(): static
    {
        return $this->state(fn (array $attributes) => [
            'price_date' => fake()->dateTimeBetween('-7 days', 'now'),
        ]);
    }
}
