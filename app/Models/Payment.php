<?php

namespace App\Models;   
use App\Models\PaymentDetail; 
use App\Models\Order;  

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(PaymentDetail::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
