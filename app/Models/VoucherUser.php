<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherUser extends Model
{
    use HasFactory;

    // Các cột có thể được điền vào
    protected $fillable = [
        'voucher_id', 'user_id', 'used_at', 'is_used'
    ];

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
     * Lấy thông tin khi voucher được sử dụng
     */
    public function getUsedAtAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('d-m-Y H:i:s') : null;
    }

    /**
     * Thiết lập thời gian sử dụng voucher
     */
    public function setUsedAtAttribute($value)
    {
        $this->attributes['used_at'] = $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }

    /**
     * Lấy trạng thái sử dụng voucher
     */
    public function getIsUsedAttribute($value)
    {
        return $value ? 'Đã sử dụng' : 'Chưa sử dụng';
    }
}
