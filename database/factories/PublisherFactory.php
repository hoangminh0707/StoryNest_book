<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PublisherFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'NXB ' . $this->faker->company(),
            'nationality' => $this->faker->country(),
            'address' => $this->faker->address(),
        ];
    }
}

