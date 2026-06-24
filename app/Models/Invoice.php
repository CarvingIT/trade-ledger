<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    //
        use SoftDeletes;
    public function entity(){
        return $this->belongsTo(Entity::class, 'entity_id')->withTrashed();
    }
    public function owner_entity(){
        return $this->belongsTo(Entity::class, 'owner_entity_id')->withTrashed();
    }


}
