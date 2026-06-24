<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    public function owner_entity(){
        return $this->belongsTo(Entity::class,'owner_entity_id')->withTrashed();
    }
    public function entity(){
        return $this->belongsTo(Entity::class,'entity_id')->withTrashed();
    }
    public function account(){
        return $this->belongsTo(Account::class,'account_id')->withTrashed();
    }
}
