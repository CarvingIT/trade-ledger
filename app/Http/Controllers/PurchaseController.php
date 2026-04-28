<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Entity;
use App\Models\OwnerEntity;
use App\Models\Product;
use App\Models\LineItem;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Session;
use App\Exports\PurchasesExport;
use Maatwebsite\Excel\Facades\Excel;


class PurchaseController extends Controller
{
    //
    public function index(){
        $purchases = Purchase::all();
        return view('purchasesmanagement', ['purchases'=>$purchases, 'activePage'=>'Purchases','titlePage'=>'Purchases']);
    }

    public function addEditPurchase($purchase_id){
        if($purchase_id == 'new'){
            $purchase = new Purchase();
        }
        else{
            $purchase = Purchase::find($purchase_id);
        }
        $entities = Entity::all();
        $products = Product::all();
        $line_items = LineItem::where('purchase_id',$purchase_id)->get(); 

        if(!empty($purchase->tax_value) && $purchase->tax_name=='GST'){
            $tax_number = str_replace('%', '', $purchase->tax_value);
        }
        else{
            $tax_number = 0;
        }

        return view('purchase-form', ['purchase'=>$purchase, 'entities'=>$entities, 'products'=>$products, 'line_items'=>$line_items, 'tax_number'=>$tax_number, 'activePage'=>'Purchase', 'titlePage'=>'Purchase']);
    }

    public function save(Request $request){
/*
print_r($request->product_id);
$product_items = $request->product_id;
print_r($request->quantity);
echo "<br />";
foreach($request->quantity as $prod=>$qty){
    echo $product_items[$prod]." ".$qty."<br />";
    $product_id = $product_items[$prod];
                    $product = Product::find($product_id);
                    echo "Name: ".$product->name."<br/>";
                    echo "Quantity: ".$qty."<br />";
                    echo "Rate: ".$product->price."<br/>";
                    echo "Amount: ".$amount = $product->price*$qty."<br />";
}
exit;
*/
         if(empty($request->input('purchase_id'))){
            $c = new Purchase;
         }
         else{
            $c = Purchase::find($request->input('purchase_id'));
         }
         $c->title = $request->input('title');
         $c->description = $request->input('description');
         $c->entity_id = $request->input('entity_id');                       //Vendor entity id
         $user_id = auth()->user()->id;
         $owner_entity = OwnerEntity::where('user_id', $user_id)
                        ->where('primary_entity','1')                       //Primary meaning Current entity.
                        ->first();
         $vendor_entity = OwnerEntity::where('entity_id', $request->input('entity_id'))
                        ->where('primary_entity','1')                       //Primary meaning Current entity.
                        ->first();
         //Here these lines are necessary
         $tax_details = Setting::where('owner_entity_id', $vendor_entity->entity_id)
                        ->where('name','GST')
                        ->first();
         if(!empty($tax_details->value)){
            $tax_number = str_replace('%', '', $tax_details->value);
         }
         else{
            $tax_number = 0;
         }

        $c->owner_entity_id = $owner_entity->entity_id;
        $c->tax_name = $tax_details->name;
        $c->tax_value = $tax_details->value;
        $c->save();

         // Line Items 
            if($c->total_amount > 0){
                $total_amount = $c->total_amount;
            }
            else{
                $total_amount = 0;
            }

         $product_items = $request->product_id;
         if(!empty($request->product_id) && !empty($request->quantity)){
                foreach($request->quantity as $prod=>$qty){
                    $line_item = new LineItem();
                    $product_id = $product_items[$prod];
                    $product = Product::find($product_id);
                    $line_item->product_id = $product_id;
                    $line_item->purchase_id = $c->id;
                    $line_item->item_name = $product->name;
                    $line_item->quantity = $qty;
                    $line_item->rate = $product->price;
                    $line_item->amount = $product->price*$qty;
                    $total_amount += $product->price*$qty;
                    $line_item->save();
                }
         }     
        $c->total_amount = $total_amount;
        try{
            $c->save();
            Session::flash('alert-success', 'Purchase saved successfully!');
         }
         catch(\Exception $e){
            Session::flash('alert-danger', "Error has orrcured: Please check. ".$e->getMessage());
         }
        return redirect('/admin/purchases');
    }


     public function deletePurchase(Request $request){
        $purchase = Purchase::find($request->purchase_id);
        if($purchase->delete()){
            Session::flash('alert-success', 'Purchase deleted successfully!');
        }
        else{
            Session::flash('alert-danger', "Error has orrcured: Please check. ".$e->getMessage());
        }
        return redirect('/admin/purchases');
    }

     public function viewPurchase($purchase_id){
        $purchase = Purchase::find($purchase_id);
        $line_items = LineItem::where('purchase_id',$purchase_id)->get(); 

        //Apply GST to the Client if the owner has GSTIN Number in entities table and in Settings table GST value is there for the same entity.
        /*
        $user_id = auth()->user()->id;
        $owner_entity = OwnerEntity::where('user_id', $user_id)
                        ->where('primary_entity','1')
                        ->first();
        $tax_details = Setting::where('owner_entity_id', $owner_entity->entity_id)
                        ->where('name','GST')
                        ->first();
        */
        if(!empty($purchase->tax_value) && $purchase->tax_name=='GST'){
        $tax_number = str_replace('%', '', $purchase->tax_value);
        }
        else{
        $tax_number = '';
        }
        $total_amount = $purchase->total_amount;

        //Check if the Owner Entity has GSTIN number  
        $owner_entity_details = Entity::find($purchase->owner_entity_id); 
        $total_amount_including_tax = $total_amount;
        if(!empty($owner_entity_details->GSTIN_number) && !empty($tax_number)){
        $total_amount_including_tax = $total_amount + ($total_amount * (int)$tax_number/100);
        }
        return view('purchasedetails', ['purchase'=>$purchase, 'line_items'=>$line_items, 'total_amount_including_tax'=>$total_amount_including_tax]);
        }
    
    public function downloadPurchasePDF($id){
        $purchase = Purchase::findOrFail($id);
        $line_items = LineItem::where('purchase_id',$id)->get();

        //Apply GST to the Client if the owner has GSTIN Number in entities table and in Settings table GST value is there for the same entity.
        /*
        $user_id = auth()->user()->id;
        $owner_entity = OwnerEntity::where('user_id', $user_id)
                        ->where('primary_entity','1')
                        ->first();

        $tax_details = Setting::where('owner_entity_id', $owner_entity->entity_id)
                        ->where('name','GST')
                        ->first();
        */
        if(!empty($purchase->tax_value) && $purchase->tax_name=='GST'){
        $tax_number = str_replace('%', '', $purchase->tax_value);
        }
        else{
        $tax_number = '';
        }

        $total_amount = $purchase->total_amount;

        //Check if the Owner Entity has GSTIN number 
        $owner_entity_details = Entity::find($purchase->owner_entity_id);
        $total_amount_including_tax = $total_amount;
        if(!empty($owner_entity_details->GSTIN_number) && !empty($tax_number)){
        $total_amount_including_tax = $total_amount + ($total_amount * (int)$tax_number/100);
        }

        $data = ['purchase' => $purchase,'line_items'=>$line_items,'total_amount_including_tax'=>$total_amount_including_tax];

        // Load the view and pass the data
        $pdf = Pdf::loadView('purchases.pdf', $data);

        // Download the PDF file
        return $pdf->download('purchase-' . $purchase->id . '.pdf');
        }

        public function getPurchaseAmount($purchase_id){
            $purchase = Purchase::find($purchase_id);
            $line_items = LineItem::where('purchase_id',$purchase_id)->get(); 

            /*
            $user_id = auth()->user()->id;
            $owner_entity = OwnerEntity::where('user_id', $user_id)
                        ->where('primary_entity','1')
                        ->first();
            $tax_details = Setting::where('owner_entity_id', $owner_entity->entity_id)
                        ->where('name','GST')
                        ->first();
            */
            if(!empty($purchase->tax_value) && $purchase->tax_name=='GST'){
                $tax_number = str_replace('%', '', $purchase->tax_value);
            }
            else{
                $tax_number = '';
            }

            $total_amount = $purchase->total_amount;

        //Check if the Owner Entity has GSTIN number 
            $owner_entity_details = Entity::find($purchase->owner_entity_id);
            $total_amount_including_tax = $total_amount;
            if(!empty($owner_entity_details->GSTIN_number) && !empty($tax_number)){
                $total_amount_including_tax = $total_amount + ($total_amount * (int)$tax_number/100);
            }
            return  json_encode(['tax_name'=>$purchase->tax_name, 'tax_value'=>$purchase->tax_value, 'total_amount'=>$total_amount, 'total_amount_including_tax'=>$total_amount_including_tax]);
        }
            
        public function getPurchases($entity_id){
            $purchases = Purchase::where('entity_id',$entity_id)->get();
            $purchases_array = [];
            foreach($purchases as $inv){
                $purchases_array[$inv->id]=$inv->title;
            }
            return $purchases_array;
        }

        public function exportPurchasesByDate(Request $request){
            $start_date = $request->start_date;
            $end_date = $request->end_date; 
            $start_date = date('Y-m-d h:m:s', strtotime($request->input('start_date')));
            $end_date = date('Y-m-d h:m:s', strtotime($request->input('end_date')));


            $purchases = Purchase::whereBetween('created_at', [$start_date, $end_date])
                        ->get();


            $export_purchases = [];
            foreach($purchases as $inv){
                if(!empty($inv->tax_value) && $inv->tax_name == 'GST'){
                    $tax_number = str_replace('%', '', $inv->tax_value);
                }
                else{
                    $tax_number = '';
                }
                $total_amount = $inv->total_amount;

                //Check if the Owner Entity has GSTIN number 
                $owner_entity_details = Entity::find($inv->owner_entity_id);
                $total_amount_including_tax = $total_amount;
                if(!empty($owner_entity_details->GSTIN_number) && !empty($tax_number)){
                    $total_amount_including_tax = $total_amount + ($total_amount * (int)$tax_number/100);
                }

                $export_purchases[] = [$inv->created_at, $inv->owner_entity->name, $inv->title, $inv->entity->name, $inv->total_amount, $total_amount_including_tax, $inv->tax_name, $inv->tax_value, $inv->description];
            }

            $file_name = 'Purchases.xlsx';
            return Excel::download(new PurchasesExport($export_purchases), $file_name);
        }

// End of the Class
}
