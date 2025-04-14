<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherOrder extends Model
{
    use HasFactory;

    // Các cột có thể được điền vào
    protected $fillable = ['voucher_id', 'order_id'];

    /**
     * Quan hệ với bảng Voucher
     */
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    /**
     * Quan hệ với bảng Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
