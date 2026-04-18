<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\OwnerEntity;
use Session;

class AccountController extends Controller
{
    //
    public function index(){
        $accounts = Account::all();
        return view('accountsmanagement', ['accounts'=>$accounts, 'activePage'=>'Accounts','titlePage'=>'Accounts']);
    }

    public function addEditAccount($account_id){
        if($account_id == 'new'){
            $account = new Account();
        }
        else{
            $account = Account::find($account_id);
        }
        return view('account-form', ['account'=>$account, 'activePage'=>'Account', 'titlePage'=>'Account']);
    }

    public function save(Request $request){
         if(empty($request->input('account_id'))){
            $c = new Account;
         }
         else{
            $c = Account::find($request->input('account_id'));
         }
         $c->name = $request->input('name');
         $c->description = $request->input('description');
         $user_id = auth()->user()->id;
         $owner_entity = OwnerEntity::where('user_id', $user_id)
                        ->where('primary_entity','1')
                        ->first();
         $c->owner_entity_id = $owner_entity->entity_id;
        try{
            $c->save();
            Session::flash('alert-success', 'Account saved successfully!');
         }
         catch(\Exception $e){
            Session::flash('alert-danger', "Error has orrcured: Please check. ".$e->getMessage());
         }
        return redirect('/admin/accounts');
    }

    public function deleteAccount(Request $request){
        $account = Account::find($request->account_id);
        if($account->delete()){
            Session::flash('alert-success', 'Account deleted successfully!');
        }
        else{
            Session::flash('alert-danger', "Error has orrcured: Please check. ".$e->getMessage());
        }
        return redirect('/admin/accounts');
    }

     public function viewAccount($account_id){
        $account = Account::find($account_id);
        return view('accountdetails', ['account'=>$account]);
     }

//Class ends
}
