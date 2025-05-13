<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bio',
        'birthdate',
    ];

    // Mối quan hệ 1-N với Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
