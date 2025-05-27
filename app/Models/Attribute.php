<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Mối quan hệ 1-N với AttributeValue
    
    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attribute');
    }

}
