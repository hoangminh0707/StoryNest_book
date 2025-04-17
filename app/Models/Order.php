<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\UserAddress;
use App\Models\ShippingMethod;
use App\Models\OrderItem;


class Order extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'user_address_id',
        'voucher_id',
        'shipping_method_id',
        'total_amount',
        'discount_amount',
        'shipping_fee',
        'final_amount',
        'status',
    ];

    public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

public function userAddress()
{
    return $this->belongsTo(UserAddress::class);
}

public function shippingMethod()
{
    return $this->belongsTo(ShippingMethod::class);
}

public function payment()
{
    return $this->hasOne(Payment::class);
}


}
