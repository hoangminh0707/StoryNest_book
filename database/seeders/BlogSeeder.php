<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\User;

class BlogSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Lấy danh sách user_id có sẵn
        $userIds = User::pluck('id')->toArray();

        // Nếu chưa có user, tạo 5 user mẫu
        if (empty($userIds)) {
            User::factory()->count(5)->create();
            $userIds = User::pluck('id')->toArray();
        }

        foreach (range(1, 10) as $index) {
            DB::table('blogs')->insert([
                'user_id'    => $faker->randomElement($userIds),
                'title'      => $faker->sentence(),
                'content'    => $faker->paragraphs(3, true),
                'image' => $faker->imageUrl(640, 480, 'nature', true, 'Blog'),
                'status'     => $faker->randomElement(['published', 'draft', 'archived']),
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
