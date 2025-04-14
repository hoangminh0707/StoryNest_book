<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'name',
        'provider',
        'default_fee',
        'description',
        'image',
        'is_active',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'shipping_method_id');
    }
}
