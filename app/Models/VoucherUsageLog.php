<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherUsageLog extends Model
{
    use HasFactory;

    // Các cột có thể được điền vào
    protected $fillable = ['voucher_id', 'user_id', 'order_id', 'discount_value'];

    /**
     * Quan hệ với bảng Voucher
     */
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    /**
     * Quan hệ với bảng User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ với bảng Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
