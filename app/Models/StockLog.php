<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variant_id',
        'admin_id',
        'change_quantity',
        'note',
        'stock_before',
        'stock_after',
    ];

    // Quan hệ với Product (Sản phẩm)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Quan hệ với Variant (Biến thể sản phẩm)
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    // Quan hệ với User (Quản trị viên)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}