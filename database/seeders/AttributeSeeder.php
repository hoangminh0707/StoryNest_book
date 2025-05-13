<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        $attributes = ['Kích thước', 'Ngôn ngữ', 'Loại bìa'];

        foreach ($attributes as $attr) {
            Attribute::create(['name' => $attr]);
        }
    }
}
