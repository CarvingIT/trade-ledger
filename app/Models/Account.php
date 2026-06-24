<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    //
    use SoftDeletes;
    public $timestamps = false;

    public function owner_entity(){
        return $this->belongsTo(Entity::class,'owner_entity_id')->withTrashed();
    }
}
