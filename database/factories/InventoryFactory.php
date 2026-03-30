<?php

namespace Database\Factories;

use App\Models\Farm;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['seeds', 'fertilizers', 'pesticides', 'tools', 'equipment', 'fuel', 'feed', 'other'];
        $category = fake()->randomElement($categories);

        $items = [
            'seeds' => ['Maize Seeds', 'Tomato Seeds', 'Bean Seeds', 'Wheat Seeds', 'Cabbage Seeds'],
            'fertilizers' => ['DAP Fertilizer', 'NPK 17-17-17', 'Urea', 'CAN Fertilizer', 'Organic Compost'],
            'pesticides' => ['Insecticide Spray', 'Fungicide', 'Herbicide', 'Rodenticide', 'Nematicide'],
            'tools' => ['Hoe', 'Spade', 'Rake', 'Pruning Shears', 'Wheelbarrow'],
            'equipment' => ['Water Pump', 'Sprayer', 'Tractor Attachment', 'Drip Irrigation Kit'],
            'fuel' => ['Diesel', 'Petrol', 'Kerosene'],
            'feed' => ['Chicken Feed', 'Cattle Feed', 'Pig Feed'],
            'other' => ['Twine', 'Sacks', 'Tarpaulin', 'Shade Net'],
        ];

        $units = [
            'seeds' => 'kg',
            'fertilizers' => 'bags',
            'pesticides' => 'l',
            'tools' => 'pieces',
            'equipment' => 'units',
            'fuel' => 'l',
            'feed' => 'bags',
            'other' => 'pieces',
        ];

        $quantity = fake()->randomFloat(1, 5, 100);
        $reorderLevel = fake()->randomFloat(1, 1, 20);

        return [
            'user_id' => User::factory(),
            'farm_id' => fake()->boolean(70) ? Farm::factory() : null,
            'name' => fake()->randomElement($items[$category]),
            'category' => $category,
            'subcategory' => fake()->optional()->word(),
            'description' => fake()->optional()->sentence(),
            'sku' => strtoupper(fake()->bothify('???-###')),
            'quantity' => $quantity,
            'unit' => $units[$category],
            'unit_cost' => fake()->randomFloat(2, 50, 5000),
            'currency' => 'KES',
            'reorder_level' => $reorderLevel,
            'storage_location' => fake()->optional()->randomElement(['Warehouse A', 'Warehouse B', 'Shed 1', 'Shed 2', 'Store Room']),
            'expiry_date' => fake()->optional()->dateTimeBetween('now', '+2 years'),
            'supplier' => fake()->optional()->company(),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the item is low on stock.
     */
    public function lowStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => fake()->randomFloat(1, 1, 5),
            'reorder_level' => fake()->randomFloat(1, 10, 20),
        ]);
    }

    /**
     * Indicate that the item is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
