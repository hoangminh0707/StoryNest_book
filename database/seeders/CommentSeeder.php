<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        $users = User::all();
        $products = Product::all();

        if ($users->count() === 0 || $products->count() === 0) {
            $this->command->warn('Không có user hoặc sản phẩm để tạo comment.');
            return;
        }

        foreach (range(1, 30) as $i) {
            Comment::create([
                'user_id' => $users->random()->id,
                'commentable_id' => $products->random()->id,
                'commentable_type' => Product::class,
                'content' => $faker->sentence(12),
                'is_approved' => rand(0, 1),
            ]);
        }
    }
}
