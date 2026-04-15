<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnerEntity extends Model
{
    //
    public function entity(){
        return $this->belongsTo(Entity::class, 'entity_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
