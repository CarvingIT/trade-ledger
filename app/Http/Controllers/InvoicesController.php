<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Entity;
use App\Models\OwnerEntity;
use App\Models\Product;
use App\Models\LineItem;
use Session;

class InvoicesController extends Controller
{
    //
    public function index(){
        $invoices = Invoice::all();
        return view('invoicesmanagement', ['invoices'=>$invoices, 'activePage'=>'Invoices','titlePage'=>'Invoices']);
    }

    public function addEditInvoice($invoice_id){
        if($invoice_id == 'new'){
            $invoice = new Invoice();
        }
        else{
            $invoice = Invoice::find($invoice_id);
        }
        $entities = Entity::all();
        $products = Product::all();
        $line_items = LineItem::where('invoice_id',$invoice_id)->get(); 

        return view('invoice-form', ['invoice'=>$invoice, 'entities'=>$entities, 'products'=>$products, 'line_items'=>$line_items, 'activePage'=>'Invoice', 'titlePage'=>'Invoice']);
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
         if(empty($request->input('invoice_id'))){
            $c = new Invoice;
         }
         else{
            $c = Invoice::find($request->input('invoice_id'));
         }
         $c->title = $request->input('title');
         $c->description = $request->input('description');
         $c->entity_id = $request->input('entity_id'); //Client entity id
         $user_id = auth()->user()->id;
         $owner_entity = OwnerEntity::where('user_id', $user_id)
                        ->where('primary_entity','1')
                        ->first();
         $c->owner_entity_id = $owner_entity->entity_id;
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
                    $line_item->invoice_id = $c->id;
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
            Session::flash('alert-success', 'Sale-Invoice saved successfully!');
         }
         catch(\Exception $e){
            Session::flash('alert-danger', "Error has orrcured: Please check. ".$e->getMessage());
         }
        return redirect('/admin/invoices');
    }


     public function deleteInvoice(Request $request){
        $invoice = Invoice::find($request->invoice_id);
        if($invoice->delete()){
            Session::flash('alert-success', 'Invoice deleted successfully!');
        }
        else{
            Session::flash('alert-danger', "Error has orrcured: Please check. ".$e->getMessage());
        }
        return redirect('/admin/invoices');
    }

     public function viewInvoice($invoice_id){
        $invoice = Invoice::find($invoice_id);
        $line_items = LineItem::where('invoice_id',$invoice_id)->get(); 
        return view('invoicedetails', ['invoice'=>$invoice,'line_items'=>$line_items]);
        }



// End of the Class
}
