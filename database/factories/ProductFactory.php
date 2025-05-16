<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(50000, 300000),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'author_id' => Author::inRandomOrder()->first()?->id ?? Author::factory(),
            'publisher_id' => Publisher::inRandomOrder()->first()?->id ?? Publisher::factory(),
        ];
    }
}
