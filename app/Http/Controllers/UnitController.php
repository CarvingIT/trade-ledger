<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use Session;

class UnitController extends Controller
{
    //
     public function index(){
        $units = Unit::all();
        return view('unitsmanagement', ['units'=>$units, 'activePage'=>'Units','titlePage'=>'Units']);
    }

    public function addEditUnit($unit_id){
        if($unit_id == 'new'){
            $unit = new Unit();
        }
        else{
            $unit = Unit::find($unit_id);
        }
        $units = Unit::all();
        return view('unit-form', ['unit'=>$unit, 'units'=>$units, 'activePage'=>'Unit', 'titlePage'=>'Unit']);
    }

    public function save(Request $request){
         if(empty($request->input('unit_id'))){
            $c = new Unit;
         }
         else{
            $c = Unit::find($request->input('unit_id'));
         }
         $c->name = $request->input('name');
         $c->description = $request->input('description');
         $c->related_unit_id = $request->input('related_unit_id');
         $c->related_unit_quantity = $request->input('related_unit_quantity');
        try{
            $c->save();
            Session::flash('alert-success', 'Unit saved successfully!');
         }
         catch(\Exception $e){
            Session::flash('alert-danger', "Error has orrcured: Please check. ".$e->getMessage());
         }
        return redirect('/admin/units');
    }

    public function deleteUnit(Request $request){
        $unit = Unit::find($request->unit_id);
        if($unit->delete()){
            Session::flash('alert-success', 'Unit deleted successfully!');
        }
        else{
            Session::flash('alert-danger', "Error has orrcured: Please check. ".$e->getMessage());
        }
        return redirect('/admin/units');
    }

     public function viewUnit($unit_id){
        $unit = Unit::find($unit_id);
        return view('unitdetails', ['unit'=>$unit]);
     }



// End of Class
}
