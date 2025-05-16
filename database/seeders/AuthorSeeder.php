<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        for ($i = 0; $i < 10; $i++) {
            Author::create([
                'name' => $faker->name,
                'bio' => $faker->paragraph(3),
                'birthdate' => $faker->date(),
            ]);
        }
    }
}

