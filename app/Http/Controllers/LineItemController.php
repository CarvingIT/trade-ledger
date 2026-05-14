<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LineItem;
use App\Models\Invoice;
use App\Models\Product;
use Session;

class LineItemController extends Controller
{
    //
    public function editLineItem($line_item_id){
        $lineitem = LineItem::find($line_item_id);
        return view('line-item-form', ['lineitem'=>$lineitem, 'activePage'=>'Line Item', 'titlePage'=>'Line Item']);
    }

    public function saveLineItem(Request $request){
        $lineitem = LineItem::find($request->lineitem_id);
        $lineitem->quantity = $request->quantity;
        $lineitem->rate = $request->rate;
        $lineitem->amount = $request->amount;
        $lineitem->save();
        
        $invoice = Invoice::find($request->invoice_id);
        $invoice_line_items = LineItem::where('invoice_id',$request->invoice_id)->get(); 
        $total_amount = 0;
        foreach($invoice_line_items as $item){
            $total_amount += $item->amount; 
        }
        $invoice->total_amount = $total_amount;
        $invoice->save();
        try{
            Session::flash('alert-success', 'Line item updates done successfully!');
         }
         catch(\Exception $e){
            Session::flash('alert-danger', "Error has orrcured: Please check. ".$e->getMessage());
         }
        return redirect('/admin/invoice-form/'.$request->invoice_id);
    }

    public function deleteLineItem(Request $request){
        $lineitem = LineItem::find($request->lineitem_id);
        $invoice_id = $lineitem->invoice_id;
        $invoice = Invoice::find($invoice_id);
        $total_amount = 0;
        if(!empty($lineitem->id)){
            $lineitem->delete();
            $invoice_line_items = LineItem::where('invoice_id',$invoice_id)->get(); 
            foreach($invoice_line_items as $item){
                $total_amount += $item->amount; 
            }
            $invoice->total_amount = $total_amount;
            $invoice->save();
            Session::flash('alert-success', 'Line item deleted successfully!');
        }
        return redirect('/admin/invoice-form/'.$invoice_id);
    }

// End of the Class
}
