<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([

            AuthorSeeder::class,
            CategorySeeder::class,
            PublisherSeeder::class,
            ProductSeeder::class,
            ProductVariantSeeder::class,
            AttributeSeeder::class,
            AttributeValueSeeder::class,
            ProductVariantAttributeSeeder::class,
            CommentSeeder::class,
        ]);
    }
    
}
