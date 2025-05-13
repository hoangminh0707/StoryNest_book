<?php

namespace Database\Seeders;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        for ($i = 0; $i < 20; $i++) {
            Product::create([
                'name' => $faker->sentence(3),
                'description' => $faker->paragraph(4),
                'price' => $faker->numberBetween(50000, 200000),
                'category_id' => rand(1, 5),
                'author_id' => rand(1, 10),
                'publisher_id' => rand(1, 5),
            ]);
        }
    }
}

