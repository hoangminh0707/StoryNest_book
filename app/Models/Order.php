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
        'order_code',
        'user_id',
        'full_name',
        'user_address',
        'phone',
        'voucher_id',
        'shipping_method_id',
        'total_amount',
        'discount_amount',
        'shipping_fee',
        'final_amount',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userAddress()
    {
        return $this->belongsTo(UserAddress::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }



    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

}