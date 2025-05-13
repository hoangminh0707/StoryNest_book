<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_id',
        'condition_type',
        'product_id',
        'category_id',
    ];

    /**
     * Quan hệ với voucher
     */
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    /**
     * Quan hệ với sản phẩm (nếu là điều kiện theo sản phẩm)
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Quan hệ với danh mục (nếu là điều kiện theo danh mục)
     */
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }



}