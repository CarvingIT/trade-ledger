<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    public function unit_detail(){
        return $this->belongsTo(Unit::class, 'unit');
    }
}
