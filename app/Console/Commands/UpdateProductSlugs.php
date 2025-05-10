<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Str;

class UpdateProductSlugs extends Command
{

    // lệnh update Slug php artisan products:update-slugs
    protected $signature = 'products:update-slugs';
    protected $description = 'Cập nhật slug cho tất cả sản phẩm dựa trên tên';

    public function handle()
    {
        $products = Product::all();
        foreach ($products as $product) {
            $baseSlug = Str::slug($product->name);
            $slug = $baseSlug;
            $i = 1;

            // Đảm bảo slug là duy nhất
            while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $baseSlug . '-' . $i++;
            }

            $product->slug = $slug;
            $product->save();

            $this->info("Đã cập nhật: {$product->name} → $slug");
        }

        $this->info('✅ Đã cập nhật tất cả slug!');
    }
}