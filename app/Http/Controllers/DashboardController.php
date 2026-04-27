<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\OwnerEntity;

class DashboardController extends Controller
{
    //
    public function setCurrentEntity(Request $request){
         $user_id = auth()->user()->id;
         $entity_id = $request->entity_id;
         $owner_entities = OwnerEntity::where('user_id',$user_id)->get();

         foreach($owner_entities as $ent){
            if(!empty($request->entity_id)){
                $owner_entity = OwnerEntity::where('user_id', $user_id)
                                ->where('entity_id',$ent->entity_id)
                                ->first();
                if($owner_entity->entity_id == $entity_id){
                $owner_entity->primary_entity = 1;
                }
                else{
                $owner_entity->primary_entity = 0;
                }
                try{
                $owner_entity->save();
                Session::flash('alert-success','Current entity saved successfully');
                }
                catch(\Exception $e){
                Session::flash('alert-danger','There is some error please try again'.$e->getMessage());
                }
            }
        }
        return redirect('/dashboard');
    }

//Class ends
}
