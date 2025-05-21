<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FlashDeal extends Model
{
    protected $fillable = [
        'title',
        'start_time',
        'end_time',
        'usage_limit',
        'used_count',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Quan hệ với các biến thể sản phẩm trong flash deal
    public function flashSaleVariants()
    {
        return $this->hasMany(FlashSaleProductVariant::class);
    }

    /**
     * Thêm flash sale cho tất cả biến thể của sản phẩm với phần trăm giảm giá
     */
    public function addFlashSaleForProductVariants($product, float $discountPercent)
    {
        foreach ($product->variants as $variant) {
            $discountPrice = round($variant->price * (1 - $discountPercent / 100), 2);

            FlashSaleProductVariant::updateOrCreate(
                [
                    'flash_deal_id' => $this->id,
                    'product_variant_id' => $variant->id,
                ],
                [
                    'discount_price' => $discountPrice,
                ]
            );
        }
    }

    /**
     * Kiểm tra xem flash deal có đang hoạt động không (dựa vào thời gian)
     */
    public function isActive(): bool
    {
        $now = now();
        return $this->start_time <= $now && $this->end_time >= $now;
    }

    /**
     * Kiểm tra xem còn lượt sử dụng không
     */
    public function isAvailable(): bool
    {
        return $this->usage_limit == 0 || $this->used_count < $this->usage_limit;
    }

    /**
     * Tăng used_count một cách an toàn (gọi trong DB transaction)
     */
    public function incrementUsage()
    {
        // Giữ đồng bộ dữ liệu
        return DB::transaction(function () {
            $this->lockForUpdate(); // Khóa hàng hiện tại
            if ($this->isAvailable()) {
                $this->increment('used_count');
                return true;
            }
            return false;
        });
    }
}
