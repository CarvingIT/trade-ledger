<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    //
    public function unit(){
        return $this->belongsTo(Unit::class, 'related_unit_id');
    }
}
