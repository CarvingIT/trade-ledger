<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OwnerEntity;
use App\Models\Entity;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Session;

class UserController extends Controller
{
    //
    public function index(){
        $users = User::all();    
        return view('usermanagement', ['users'=>$users, 'activePage'=>'Users','titlePage'=>'Users']);
    }

    public function addEditUser($user_id){
        if($user_id == 'new'){
            $user = new User();
        }
        else{
            $user = User::find($user_id);
        }
        $entities = Entity::all();
        $owner_entities = OwnerEntity::where('user_id', $user_id)->get();
        return view('user-form', ['user'=>$user, 'entities'=>$entities, 'owner_entities'=>$owner_entities, 'activePage'=>'User', 'titlePage'=>'User']);
    }

    public function save(Request $request){
        if(empty($request->input('user_id'))){
           $u = new User;
        }
        else{
           $u = User::find($request->input('user_id'));
        }

        $u->name = $request->input('firstname');
        $u->email = $request->input('email');
        $u->remember_token = Str::random(10);
        if(!empty($request->input('password'))){
            $u->password = Hash::make($request->input('password'));
            if(!empty($request->input('password'))){
                $u->email_verified_at = time();
            }
        }
        $referer = '/admin/users';
        try{
        $u->save();

        if(!empty($request->entity_id)){
            $owner_entities = OwnerEntity::where('user_id',$u->id)
                                ->delete();
            foreach($request->entity_id as $entity_id){
                $entity = new OwnerEntity();
                $entity->user_id = $u->id;
                $entity->entity_id = $entity_id;
                $entity->save();
            }
        }
        Session::flash('alert-success','User details saved successfully');
        }
        catch(\Exception $e){
        Session::flash('alert-danger','There is some error please try again'.$e->getMessage());
        }
        return redirect('/admin/users');
    }    

    public function deleteUser(Request $request){
       $u = User::find($request->user_id);
        if(!empty($u)){
            if($u->delete()){
                Session::flash('alert-success','User deleted successfully');
                return redirect('/admin/users');
            }
        } 
    }

     public function viewUser(Request $request){
        $user = User::where('id',$request->user_id)
       // ->with('entity')
        ->first();
        $entities = Entity::orderBy('name')->get();
        $user_id = $request->user_id;
        $owner_entities = OwnerEntity::where('user_id', $user_id)->get();
        return view('userdetails', ['user'=>$user, 'entities'=>$entities, 'owner_entities'=>$owner_entities, 'activePage'=>'Users','titlePage'=>'Users']);
        }


// End of the Class
}
