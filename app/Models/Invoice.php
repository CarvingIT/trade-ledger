<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    public function entity(){
        return $this->belongsTo(Entity::class, 'entity_id');
    }
    public function owner_entity(){
        return $this->belongsTo(Entity::class, 'owner_entity_id');
    }


}
