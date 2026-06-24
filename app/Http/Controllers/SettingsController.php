<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\OwnerEntity;
use App\Models\Entity;
use Session;

class SettingsController extends Controller
{
    //
    public function index(){
        //$settings = Setting::all();
        $owner_entity_id = auth()->user()->getCurrentChosenEntity();
        $settings = Setting::has('owner_entity')
                    ->where('owner_entity_id',$owner_entity_id)
                    ->get(); //Displays records whose owner entity is available
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
         $c->name = $request->input('name');
         $c->description = $request->input('description');
         $c->value = $request->input('value');
         $user_id = auth()->user()->id;
         $owner_entity = OwnerEntity::where('user_id', $user_id)
                        ->where('primary_entity','1')
                        ->first();
         $c->owner_entity_id = $owner_entity->entity_id;
        // Check if the entity has GSTIN number when GST needs to be set as a setting. //
         $entity_details = Entity::find($owner_entity->entity_id);
         if(preg_match("/GST/i", $request->input('name')) && empty($entity_details->GSTIN_number)){
            Session::flash('alert-danger', 'GSTIN number needs to be set first then GST value. Please set the GSTIN number for this entity, '.$entity_details->name.' on entity edit page.');
            return redirect('/admin/settings');
         }   
        try{
            $c->save();
            Session::flash('alert-success', 'Setting saved successfully!');
         }
         catch(\Exception $e){
            Session::flash('alert-danger', "Please check again. Your current organization which is the Owner Entity in this table has already set the ".$request->input('name'));
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
        return view('settingsdetails', ['setting'=>$setting]);
     }



// End of the Class
}
