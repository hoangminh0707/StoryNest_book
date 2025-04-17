<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'address_line',
        'ward',
        'district',
        'city',
        'is_default',
    ];

    // Một địa chỉ thuộc về 1 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Địa chỉ đầy đủ dạng chuỗi
    public function fullAddress()
    {
        return "{$this->address_line}, {$this->ward}, {$this->district}, {$this->city}";
    }
}
