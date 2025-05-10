<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->first()?->id ?? Product::factory(),
            'sku' => strtoupper($this->faker->unique()->bothify('BK-####')),
            'variant_name' => $this->faker->word(),
            'variant_price' => $this->faker->numberBetween(50000, 300000),
            'stock_quantity' => $this->faker->numberBetween(10, 100),
        ];
    }
}
