<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;
use Session;

class CurrencyController extends Controller
{
    //
    public function index(){
        $currencies = Currency::all();
        return view('currenciesmanagement', ['currencies'=>$currencies, 'activePage'=>'Currency','titlePage'=>'Currency']);
    }

    public function addEditCurrency($currency_id){
        if($currency_id == 'new'){
            $currency = new Currency();
        }
        else{
            $currency = Currency::find($currency_id);
        }
        return view('currency-form', ['currency'=>$currency, 'activePage'=>'Currency', 'titlePage'=>'Currency']);
    }

    public function save(Request $request){
         if(empty($request->input('currency_id'))){
            $c = new Currency;
         }
         else{
            $c = Currency::find($request->input('currency_id'));
         }
         $c->name = $request->input('name');
         $c->symbol = $request->input('symbol');
        try{
            $c->save();
            Session::flash('alert-success', 'Currency saved successfully!');
         }
         catch(\Exception $e){
            Session::flash('alert-danger', "Error has orrcured: Please check. ".$e->getMessage());
         }
        return redirect('/admin/currencies');
    }

    public function deleteCurrency(Request $request){
        $currency = Currency::find($request->currency_id);
        if($currency->delete()){
            Session::flash('alert-success', 'Currency deleted successfully!');
        }
        else{
            Session::flash('alert-danger', "Error has orrcured: Please check. ".$e->getMessage());
        }
        return redirect('/admin/currencies');
    }

    public function viewCurrency($currency_id){
        $currency = Currency::find($currency_id);
        return view('currencydetails', ['currency'=>$currency]);
     }

// End of Class
}
