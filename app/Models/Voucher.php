<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description', 
        'type',
        'value',
        'expires_at',
        'max_usage',
        'usage_count', 
        'is_active',
        'condition_type', 
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Quan hệ: 1 voucher có nhiều điều kiện áp dụng (sản phẩm/danh mục)
     */
    public function conditions()
    {
        return $this->hasMany(VoucherCondition::class);
    }

    /**
     * Danh sách sản phẩm được áp dụng
     */
    // public function applicableProducts()
    // {
    //     return $this->conditions()
    //         ->where('condition_type', 'product')
    //         ->with('product');
    // }

    /**
     * Danh sách danh mục được áp dụng
     */
    // public function applicableCategories()
    // {
    //     return $this->conditions()
    //         ->where('condition_type', 'category')
    //         ->with('category');
    // }

    /**
     * Kiểm tra voucher còn hiệu lực không
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Kiểm tra có thể sử dụng voucher không
     */
    public function isUsable(): bool
    {
        return $this->is_active && !$this->isExpired();
    }

    /**
     * Trả về tên loại giảm giá (percent / fixed)
     */
    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'percent' ? 'Phần trăm (%)' : 'Giảm tiền cố định';
    }

    /**
     * Format lại ngày hết hạn (hiển thị)
     */
    public function getFormattedExpiresAtAttribute(): string
    {
        return $this->expires_at ? $this->expires_at->format('d/m/Y H:i') : 'Không giới hạn';
    }
}
