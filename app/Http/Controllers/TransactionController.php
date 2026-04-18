<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Entity;
use App\Models\OwnerEntity;
use App\Models\Invoice;
use App\Models\Account;
use Session;

class TransactionController extends Controller
{
    //
    public function index(){
        $transactions = Transaction::all();
        return view('transactionsmanagement', ['transactions'=>$transactions, 'activePage'=>'Transactions','titlePage'=>'Transactions']);
    }

    public function addEditTransaction($transaction_id){
        if($transaction_id == 'new'){
            $transaction = new Transaction();
        }
        else{
            $transaction = Transaction::find($transaction_id);
        }
        $invoices = Invoice::all();
        $accounts = Account::all();
        $entities = Entity::all();
        return view('transaction-form', ['transaction'=>$transaction, 'invoices'=>$invoices, 'accounts'=>$accounts, 'entities'=>$entities, 'activePage'=>'Transaction', 'titlePage'=>'Transaction']);
    }

    public function save(Request $request){
         if(empty($request->input('transaction_id'))){
            $c = new Transaction;
         }
         else{
            $c = Transaction::find($request->input('transaction_id'));
         }
         $c->type = $request->input('type');
         $c->entity_id = $request->input('entity_id');
         $c->description = $request->input('description');
         $c->account_id = $request->input('account_id');
         $c->invoice_id = $request->input('invoice_id');
         $c->total_amount = $request->input('total_amount');
         $c->status = $request->input('status');
        
         $user_id = auth()->user()->id;
         $owner_entity = OwnerEntity::where('user_id', $user_id)
                        ->where('primary_entity','1')
                        ->first();
         $c->owner_entity_id = $owner_entity->entity_id;
        try{
            $c->save();
            Session::flash('alert-success', 'Transaction saved successfully!');
         }
         catch(\Exception $e){
            Session::flash('alert-danger', "Error has orrcured: Please check. ".$e->getMessage());
         }
        return redirect('/admin/transactions');
    }

    public function deleteTransaction(Request $request){
        $transaction = Transaction::find($request->transaction_id);
        if($transaction->delete()){
            Session::flash('alert-success', 'Transaction deleted successfully!');
        }
        else{
            Session::flash('alert-danger', "Error has orrcured: Please check. ".$e->getMessage());
        }
        return redirect('/admin/transactions');
    }

     public function viewTransaction($transaction_id){
        $transaction = Transaction::find($transaction_id);
        $invoices = Invoice::all();
        $accounts = Account::all();
        $entities = Entity::all();
        return view('transactiondetails', ['transaction'=>$transaction, 'invoices'=>$invoices, 'accounts'=>$accounts, 'entities'=>$entities]);
     }


//Class ends
}
