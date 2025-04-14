<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Product extends Model
{ 
    use HasFactory;
    
    protected $fillable = ['name', 'description', 'price','author_id'];

        public function images()
        {
        return $this->hasMany(ProductImage::class);
        }

            public function author()
            {
            return $this->belongsTo(Author::class);
            }

            public function category()
            {
            return $this->belongsTo(Categories::class);
            }

            public function publisher()
            {
                return $this->belongsTo(Publisher::class);
            }

    }
    

