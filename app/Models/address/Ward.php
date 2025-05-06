<?php

namespace App\Models\address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    public function district() {
        return $this->belongsTo(District::class);
    }
    
}
