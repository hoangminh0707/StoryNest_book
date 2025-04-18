<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PaymentDetail; 
use App\Models\Order;  




class Payment extends Model
{

    use HasFactory;

    protected $fillable = [
        'order_id', 
        'amount', 
        'payment_method', 
        'status'
    ];

        public function order()
        {
            return $this->belongsTo(Order::class);
        }

        public function paymentDetail()
        {
            return $this->hasOne(PaymentDetail::class);
        }

        public function details()
        {
            return $this->hasMany(PaymentDetail::class);
        }

   
}
