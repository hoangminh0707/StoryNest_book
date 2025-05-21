<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publisher;
use Faker\Factory as Faker;

class PublisherSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('vi_VN');

        $nationalities = ['Việt Nam', 'Pháp', 'Mỹ', 'Nhật Bản', 'Hàn Quốc', 'Anh', 'Đức', 'Trung Quốc'];

        for ($i = 1; $i <= 10; $i++) {
            Publisher::create([
                'name' => 'NXB ' . $faker->company,
                'nationality' => $faker->randomElement($nationalities),
                'address' => $faker->address,
            ]);
        }
    }
}
