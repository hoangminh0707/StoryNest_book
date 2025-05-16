<?php

namespace Database\Factories;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeValueFactory extends Factory
{
    public function definition(): array
    {
        return [
            'attribute_id' => Attribute::inRandomOrder()->first()?->id ?? Attribute::factory(),
            'value' => $this->faker->randomElement(['Nhỏ', 'Vừa', 'Lớn', 'Đỏ', 'Xanh', 'Bìa cứng', 'Bìa mềm']),
        ];
    }
}

