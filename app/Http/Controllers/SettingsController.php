<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Session;

class SettingsController extends Controller
{
    //
    public function index(){
        $settings = Setting::all();
        return view('settingsmanagement', ['settings'=>$settings, 'activePage'=>'Settings','titlePage'=>'Settings']);
    }

    public function addEditSetting($setting_id){
        if($setting_id == 'new'){
            $setting = new Setting();
        }
        else{
            $setting = Setting::find($setting_id);
        }
        return view('setting-form', ['setting'=>$setting, 'activePage'=>'Setting', 'titlePage'=>'Setting']);
    }

    public function save(Request $request){
         if(empty($request->input('setting_id'))){
            $c = new Setting;
         }
         else{
            $c = Setting::find($request->input('setting_id'));
         }
         if(!empty($request->input('sku'))){
            $c->sku = $request->input('sku');
         }
         else{
            $c->sku = Str::uuid();
         }
         $c->name = $request->input('name');
         $c->description = $request->input('description');
         $c->price = $request->input('price');
         $c->stock_quantity = $request->input('stock_quantity');
         $c->unit = $request->input('unit');
        try{
            $c->save();
            Session::flash('alert-success', 'Setting saved successfully!');
         }
         catch(\Exception $e){
            Session::flash('alert-danger', "Error has orrcured: Please check. ".$e->getMessage());
         }
        return redirect('/admin/settings');
    }

    public function deleteSetting(Request $request){
        $setting = Setting::find($request->setting_id);
        if($setting->delete()){
            Session::flash('alert-success', 'Setting deleted successfully!');
        }
        else{
            Session::flash('alert-danger', "Error has orrcured: Please check. ".$e->getMessage());
        }
        return redirect('/admin/settings');
    }

     public function viewSetting($setting_id){
        $setting = Setting::find($setting_id);
        return view('productdetails', ['setting'=>$setting]);
     }



// End of the Class
}
