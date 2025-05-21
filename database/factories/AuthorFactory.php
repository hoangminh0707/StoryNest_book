<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'bio' => $this->faker->paragraph(3),
            'birthdate' => $this->faker->date('Y-m-d', '2000-01-01'),
        ];
    }
}
