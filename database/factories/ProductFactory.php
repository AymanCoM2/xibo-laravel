<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Store ; 
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
            'product_name' => $this->faker->word,
            'sku' => $this->faker->unique()->numerify('SKU-#####'),
            'quantity' => $this->faker->numberBetween(1, 100),
            'store_id' => Store::inRandomOrder()->first()->id, // Get a random store_id
        ];
    }
}
