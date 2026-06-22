<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Entity;
use App\Models\OwnerEntity;
use App\Models\Product;
use App\Models\LineItem;
use App\Models\Setting;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade\Pdf;
use Session;
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;


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
        $units = Unit::all();

        if(!empty($invoice->tax_value) && $invoice->tax_name=='GST'){
            $tax_number = str_replace('%', '', $invoice->tax_value);
        }
        else{
            $tax_number = 0;
        }

        return view('invoice-form', ['invoice'=>$invoice, 'entities'=>$entities, 'products'=>$products, 'line_items'=>$line_items, 'tax_number'=>$tax_number, 'units'=>$units, 'activePage'=>'Invoice', 'titlePage'=>'Invoice']);
    }

    public function save(Request $request){
/*
print_r($request->product_id);
echo "<br />";
print_r($request->rate);
echo "<br />";
print_r($request->quantity);
$product_items = $request->product_id;
$product_rates = $request->rate;
echo "<br />";
foreach($request->quantity as $prod=>$qty){
    echo $product_items[$prod]." Rate: ".$product_rates[$prod]." ".$qty."<br />";
    $product_id = $product_items[$prod];
    $product_details = explode("-",$product_id);
    echo $product_id = $product_details[0]."<br />";
                    $product = Product::find($product_id);
                    echo "Name: ".$product->name."<br/>";
                    $qty_details = explode("-",$qty);
                    $qty = $qty_details[0];
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

         //$c->title = $request->input('title');
         //$c->description = $request->input('description');
         $c->entity_id = $request->input('entity_id');                       //Client entity id
         $c->invoice_date = $request->input('invoice_date');
         $user_id = auth()->user()->id;
         $owner_entity = OwnerEntity::where('user_id', $user_id)
                        ->where('primary_entity','1')                       //Primary meaning Current entity.
                        ->first();
        if(empty($owner_entity->id)){
            Session::flash('alert-danger', "Invoice creation failed. Please check if your current business is chosen on the dashboard. Then create the invoice.");
            return redirect('/admin/invoices');
        }
         //Here these lines are necessary
         $tax_details = Setting::where('owner_entity_id', $owner_entity->entity_id)
                        ->where('name','GST')
                        ->first();
         if(!empty($tax_details->value)){
            $tax_number = str_replace('%', '', $tax_details->value);
        	$c->tax_name = $tax_details->name;
        	$c->tax_value = $tax_details->value;
         }
         else{
            $tax_number = 0;
         }

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
         $product_rates = $request->rate;
         if(!empty($request->product_id) && !empty($request->quantity)){
                foreach($request->quantity as $prod=>$qty){
                    $qty_details = explode("-",$qty);
                    $qty = $qty_details[0];

                    $line_item = new LineItem();

                    $product_id = $product_items[$prod]; //it comes here like 4-0, 4 is the product id and 0 is div id
                    $product_details = explode("-",$product_id);//so explode is there
                    $product_id = $product_details[0];

                    $prod_rate = $product_rates[$prod]; //Rate dynamically set in the Invoice form

                    $product = Product::find($product_id);
                    $line_item->product_id = $product_id;
                    $line_item->invoice_id = $c->id;
                    $line_item->item_name = $product->name;
                    $line_item->quantity = $qty;
                    $line_item->rate = $prod_rate;
                    $line_item->amount = $prod_rate*$qty;
                    $total_amount += $prod_rate*$qty;
                    $line_item->save();
                }
         }     
         $c->discount = $request->discount;
        $discount_amount = 0;
        //Check if discount is in % or Rs
        if(isset($request->discount)){
            if(preg_match("/%/",$request->discount)){
                $discount = preg_replace("/%/","",$request->discount);
                $discount_amount = ($total_amount*$discount)/100;     
            }
            else if(preg_match("/Rs/i",$request->discount)){
                $discount_amount = preg_replace("/[A-Za-z.-\/-]/i","",$request->discount);
//echo $request->discount." preg".$discount_amount; exit;
            }
            else{
//echo $request->discount; exit;
                $discount_amount = preg_replace("/[A-Za-z.-\/-]/i","",$request->discount);
            }
        }
        $c->total_amount = $total_amount-$discount_amount;
         
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
        if(!empty($invoice->tax_value) && $invoice->tax_name=='GST'){
        $tax_number = str_replace('%', '', $invoice->tax_value);
        }
        else{
        $tax_number = '';
        }
        $total_amount = $invoice->total_amount;

        //Check if the Owner Entity has GSTIN number  
        $owner_entity_details = Entity::find($invoice->owner_entity_id); 
        $total_amount_including_tax = $total_amount;
        if(!empty($owner_entity_details->GSTIN_number) && !empty($tax_number)){
        $total_amount_including_tax = $total_amount + ($total_amount * (int)$tax_number/100);
        }
        return view('invoicedetails', ['invoice'=>$invoice, 'line_items'=>$line_items, 'total_amount_including_tax'=>$total_amount_including_tax]);
        }
    
    public function downloadInvoicePDF($id){
        $invoice = Invoice::findOrFail($id);
        $line_items = LineItem::where('invoice_id',$id)->get();

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
        if(!empty($invoice->tax_value) && $invoice->tax_name=='GST'){
        $tax_number = str_replace('%', '', $invoice->tax_value);
        }
        else{
        $tax_number = '';
        }

        $total_amount = $invoice->total_amount;

        //Check if the Owner Entity has GSTIN number 
        $owner_entity_details = Entity::find($invoice->owner_entity_id);
        $total_amount_including_tax = $total_amount;
        if(!empty($owner_entity_details->GSTIN_number) && !empty($tax_number)){
        $total_amount_including_tax = $total_amount + ($total_amount * (int)$tax_number/100);
        }

        $data = ['invoice' => $invoice,'line_items'=>$line_items,'total_amount_including_tax'=>$total_amount_including_tax];

        // Load the view and pass the data
        $pdf = Pdf::loadView('invoices.pdf', $data);

        // Download the PDF file
        return $pdf->download('invoice-' . $invoice->id . '.pdf');
        }

        public function getInvoiceAmount($invoice_id){
            $invoice = Invoice::find($invoice_id);
            $line_items = LineItem::where('invoice_id',$invoice_id)->get(); 

            /*
            $user_id = auth()->user()->id;
            $owner_entity = OwnerEntity::where('user_id', $user_id)
                        ->where('primary_entity','1')
                        ->first();
            $tax_details = Setting::where('owner_entity_id', $owner_entity->entity_id)
                        ->where('name','GST')
                        ->first();
            */
            if(!empty($invoice->tax_value) && $invoice->tax_name=='GST'){
                $tax_number = str_replace('%', '', $invoice->tax_value);
            }
            else{
                $tax_number = '';
            }

            $total_amount = $invoice->total_amount;

        //Check if the Owner Entity has GSTIN number 
            $owner_entity_details = Entity::find($invoice->owner_entity_id);
            $total_amount_including_tax = $total_amount;
            if(!empty($owner_entity_details->GSTIN_number) && !empty($tax_number)){
                $total_amount_including_tax = $total_amount + ($total_amount * (int)$tax_number/100);
            }
            return  json_encode(['tax_name'=>$invoice->tax_name, 'tax_value'=>$invoice->tax_value, 'total_amount'=>$total_amount, 'total_amount_including_tax'=>$total_amount_including_tax]);
        }
            
        public function getInvoices($entity_id){
            $invoices = Invoice::where('entity_id',$entity_id)
                        ->get();
            $invoices_array = [];
            foreach($invoices as $inv){
                $invoices_array[$inv->id]=$inv->total_amount;
            }
            return json_encode($invoices_array);
        }

        public function exportInvoicesByDate(Request $request){
            $start_date = $request->start_date;
            $end_date = $request->end_date; 
            
            if(strtotime($start_date) > strtotime($end_date)){
            Session::flash('alert-danger', "Start Date should be before or less than the End Date");
                return redirect('/admin/invoices');
            }

            //$start_date = date('Y-m-d h:m:s', strtotime($request->input('start_date')));
            //$end_date = date('Y-m-d h:m:s', strtotime($request->input('end_date')));
            $start_date = date('Y-m-d', strtotime($request->input('start_date')));
            $end_date = date('Y-m-d', strtotime($request->input('end_date')));

            #$invoices = Invoice::whereBetween('created_at', [$start_date, $end_date])
            #            ->get();
            $invoices = Invoice::whereBetween('invoice_date', [$start_date, $end_date])
                        ->get();

            $export_invoices = [];
            foreach($invoices as $inv){
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

                $export_invoices[] = [$inv->id, $inv->invoice_date, $inv->owner_entity->name, $inv->entity->name, $inv->total_amount, $total_amount_including_tax, $inv->tax_name, $inv->tax_value, $inv->description];
            }

            $file_name = 'Invoices_'.time().'.xlsx';
            return Excel::download(new InvoicesExport($export_invoices), $file_name);
        }

// End of the Class
}
