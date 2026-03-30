<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Session;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    //
    public function index(){
        $products = Product::all();
        return view('productsmanagement', ['products'=>$products, 'activePage'=>'Products','titlePage'=>'Products']);
    }

    public function addEditProduct($product_id){
        if($product_id == 'new'){
            $product = new Product();
        }
        else{
            $product = Product::find($product_id);
        }
        return view('product-form', ['product'=>$product, 'activePage'=>'Product', 'titlePage'=>'Product']);
    }

    public function save(Request $request){
         if(empty($request->input('product_id'))){
            $c = new Product;
         }
         else{
            $c = Product::find($request->input('product_id'));
         }
         if(!empty($request->input('sku'))){
            $c->sku = $request->input('sku');
         }
         else{
            $c->sku = Str::random(5);
         }
         $c->name = $request->input('name');
         $c->description = $request->input('description');
         $c->price = $request->input('price');
         $c->stock_quantity = $request->input('stock_quantity');
         $c->unit = $request->input('unit');
        try{
            $c->save();
            Session::flash('alert-success', 'Product saved successfully!');
         }
         catch(\Exception $e){
            Session::flash('alert-danger', "Error has orrcured: Please check. ".$e->getMessage());
         }
        return redirect('/admin/products');
    }

    public function deleteProduct(Request $request){
        $product = Product::find($request->product_id);
        if($product->delete()){
            Session::flash('alert-success', 'Product deleted successfully!');
        }
        else{
            Session::flash('alert-danger', "Error has orrcured: Please check. ".$e->getMessage());
        }
        return redirect('/admin/products');
    }

     public function viewProduct($product_id){
        $product = Product::find($product_id);
        return view('productdetails', ['product'=>$product]);
        }


// End of the Class
}
