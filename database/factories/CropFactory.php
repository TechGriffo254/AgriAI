<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Crop>
 */
class CropFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $crops = [
            ['name' => 'Maize', 'category' => 'Cereals', 'days_to_maturity' => 120],
            ['name' => 'Wheat', 'category' => 'Cereals', 'days_to_maturity' => 110],
            ['name' => 'Rice', 'category' => 'Cereals', 'days_to_maturity' => 130],
            ['name' => 'Beans', 'category' => 'Legumes', 'days_to_maturity' => 90],
            ['name' => 'Tomatoes', 'category' => 'Vegetables', 'days_to_maturity' => 75],
            ['name' => 'Potatoes', 'category' => 'Tubers', 'days_to_maturity' => 100],
            ['name' => 'Cabbage', 'category' => 'Vegetables', 'days_to_maturity' => 80],
            ['name' => 'Onions', 'category' => 'Vegetables', 'days_to_maturity' => 120],
            ['name' => 'Carrots', 'category' => 'Vegetables', 'days_to_maturity' => 75],
            ['name' => 'Kale', 'category' => 'Vegetables', 'days_to_maturity' => 60],
            ['name' => 'Sunflower', 'category' => 'Oilseeds', 'days_to_maturity' => 110],
            ['name' => 'Sorghum', 'category' => 'Cereals', 'days_to_maturity' => 100],
            ['name' => 'Millet', 'category' => 'Cereals', 'days_to_maturity' => 90],
            ['name' => 'Sweet Potatoes', 'category' => 'Tubers', 'days_to_maturity' => 95],
            ['name' => 'Peas', 'category' => 'Legumes', 'days_to_maturity' => 70],
            ['name' => 'Cucumbers', 'category' => 'Vegetables', 'days_to_maturity' => 65],
            ['name' => 'Spinach', 'category' => 'Vegetables', 'days_to_maturity' => 50],
            ['name' => 'Pumpkins', 'category' => 'Vegetables', 'days_to_maturity' => 100],
            ['name' => 'Cassava', 'category' => 'Tubers', 'days_to_maturity' => 150],
            ['name' => 'Groundnuts', 'category' => 'Legumes', 'days_to_maturity' => 120],
            ['name' => 'Sugarcane', 'category' => 'Cash Crops', 'days_to_maturity' => 365],
            ['name' => 'Coffee', 'category' => 'Cash Crops', 'days_to_maturity' => 730],
            ['name' => 'Tea', 'category' => 'Cash Crops', 'days_to_maturity' => 1095],

        ];

        $crop = fake()->randomElement($crops);

        return [
            'name' => $crop['name'],
            'category' => $crop['category'],
            'days_to_maturity' => $crop['days_to_maturity'],
            'planting_season' => fake()->randomElement(['Long Rains', 'Short Rains', 'All Year']),
            'harvest_season' => fake()->randomElement(['Dry Season', 'Rainy Season', 'All Year']),
            'optimal_temp_min' => fake()->randomFloat(1, 15, 20),
            'optimal_temp_max' => fake()->randomFloat(1, 25, 35),
            'water_requirement' => fake()->randomFloat(1, 400, 800),
            'soil_type_preference' => fake()->randomElement(['Loam', 'Sandy Loam', 'Clay', 'Sandy']),
            'ph_min' => fake()->randomFloat(1, 5.5, 6.5),
            'ph_max' => fake()->randomFloat(1, 7.0, 8.0),
            'is_active' => true,
        ];
    }
}
