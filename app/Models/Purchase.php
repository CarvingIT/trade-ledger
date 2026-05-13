<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    //
    public function owner_entity(){
        return $this->belongsTo(Entity::class,'owner_entity_id');    
    }    

    public function entity(){
        return $this->belongsTo(Entity::class, 'entity_id');
    }

}
