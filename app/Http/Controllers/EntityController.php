<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entity;
use Session;

class EntityController extends Controller
{
    //
     public function index(){
        $entities = Entity::all();
        return view('entitymanagement', ['entities'=>$entities, 'activePage'=>'Entities','titlePage'=>'Entities']);
    }

    public function addEditEntity($entity_id){
        if($entity_id == 'new'){
            $entity = new Entity();
        }
        else{
            $entity = Entity::find($entity_id);
        }
        return view('entity-form', ['entity'=>$entity, 'activePage'=>'Entity', 'titlePage'=>'Entity']);
    }
    
    public function save(Request $request){
         if(empty($request->input('entity_id'))){
            $c = new Entity;
         }
         else{
            $c = Entity::find($request->input('entity_id'));
         }
         $c->name = $request->input('name');
         $c->phone = $request->input('phone');
         $c->email = $request->input('email');
         $c->description = $request->input('description');
         $c->other_info = $request->input('other_info');
        try{
            $c->save();
            Session::flash('alert-success', 'Entity saved successfully!');
         }
         catch(\Exception $e){
            Session::flash('alert-danger', "Error has orrcured: Please check. ".$e->getMessage());
         }
        return redirect('/admin/entities');
    }

    public function deleteEntity(Request $request){
        $entity = Entity::find($request->entity_id);
        if($entity->delete()){
            Session::flash('alert-success', 'Entity deleted successfully!');
        }
        else{
            Session::flash('alert-danger', "Error has orrcured: Please check. ".$e->getMessage());
        }
        return redirect('/admin/entities');
    }

    public function viewEntity($entity_id){
        $entity = Entity::find($entity_id);
        return view('entitydetails', ['entity'=>$entity]);
        }


}
