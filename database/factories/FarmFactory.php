<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Farm>
 */
class FarmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kenyanCities = ['Nairobi', 'Nakuru', 'Kisumu', 'Eldoret', 'Mombasa', 'Machakos', 'Nyeri', 'Kiambu', 'Thika', 'Naivasha'];
        $kenyanCounties = ['Nairobi County', 'Nakuru County', 'Kisumu County', 'Uasin Gishu County', 'Mombasa County', 'Machakos County', 'Nyeri County', 'Kiambu County', 'Murang\'a County', 'Narok County'];
        $soilTypes = ['Clay', 'Sandy', 'Loam', 'Silt', 'Peat', 'Chalky', 'Mixed'];
        $climateZones = ['Tropical', 'Subtropical', 'Arid', 'Semi-Arid', 'Temperate', 'Highland'];
        $waterSources = ['River', 'Borehole', 'Rain-fed', 'Dam', 'Canal', 'Municipal', 'Mixed'];
        $farmNames = ['Green Valley', 'Sunrise', 'Happy Harvest', 'Golden Fields', 'Fertile Plains', 'Fresh Start', 'Highland', 'Riverside', 'Sunshine', 'Abundant'];
        $farmSuffixes = ['Farm', 'Estate', 'Gardens', 'Ranch', 'Acres', 'Plantation'];

        return [
            'user_id' => User::factory(),
            'name' => fake()->randomElement($farmNames) . ' ' . fake()->randomElement($farmSuffixes),
            'description' => fake()->optional(0.7)->paragraph(),
            'latitude' => fake()->latitude(-4.5, 4.5),
            'longitude' => fake()->longitude(33.5, 42),
            'address' => fake()->optional(0.6)->streetAddress(),
            'city' => fake()->randomElement($kenyanCities),
            'state' => fake()->randomElement($kenyanCounties),
            'country' => 'Kenya',
            'size' => fake()->randomFloat(1, 0.5, 500),
            'size_unit' => fake()->randomElement(['acres', 'hectares']),
            'soil_type' => fake()->randomElement($soilTypes),
            'climate_zone' => fake()->randomElement($climateZones),
            'water_source' => fake()->randomElement($waterSources),
            'is_active' => fake()->boolean(90),
            'metadata' => null,
        ];
    }

    /**
     * Indicate that the farm is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the farm is large (>100 acres).
     */
    public function large(): static
    {
        return $this->state(fn (array $attributes) => [
            'size' => fake()->randomFloat(1, 100, 1000),
            'size_unit' => 'acres',
        ]);
    }

    /**
     * Indicate that the farm is small (<10 acres).
     */
    public function small(): static
    {
        return $this->state(fn (array $attributes) => [
            'size' => fake()->randomFloat(1, 0.5, 10),
            'size_unit' => 'acres',
        ]);
    }
}
