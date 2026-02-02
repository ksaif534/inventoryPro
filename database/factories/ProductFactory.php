<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'sku' => 'PRD-' . fake()->unique()->numerify('#######'),
            'description' => fake()->sentence(),
            'category_id' => Category::factory(),
            'cost_price' => fake()->randomFloat(2, 10, 100),
            'selling_price' => fake()->randomFloat(2, 15, 150),
            'quantity' => fake()->numberBetween(0, 500),
            'low_stock_threshold' => fake()->numberBetween(5, 50),
            'is_active' => true,
        ];
    }
}
