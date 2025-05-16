<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BookFullSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed theo thứ tự để đảm bảo khóa ngoại đúng
        $this->call([
            CategorySeeder::class,
            AuthorSeeder::class,
            PublisherSeeder::class,
            ProductSeeder::class,
            AttributeSeeder::class,
            AttributeValueSeeder::class,
            ProductVariantSeeder::class,
            // Nếu chưa attach ở ProductVariantSeeder, mới dùng dòng dưới
            // ProductVariantAttributeSeeder::class,
        ]);
    }
}
