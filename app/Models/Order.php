<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'guest_email', 'total_price', 'status'
    ];

    // Quan hệ 1 - N với OrderItem
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

