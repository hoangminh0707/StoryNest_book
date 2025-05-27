<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Product::all() as $product) {
            for ($i = 0; $i < 2; $i++) {
                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'sku' => strtoupper(uniqid('SKU')),
                    'variant_name' => 'Biến thể ' . ($i + 1),
                    'variant_price' => $product->price + rand(0, 30000),
                    'stock_quantity' => rand(10, 100),
                ]);

                // Gán giá trị thuộc tính
                $values = AttributeValue::inRandomOrder()->take(3)->get();
                $variant->attributeValues()->attach($values->pluck('id'));
            }
        }
    }
}
