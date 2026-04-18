<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //
    public $timestamps = false;

    public function owner_entity(){
        return $this->belongsTo(Entity::class,'owner_entity_id');
    }
}
