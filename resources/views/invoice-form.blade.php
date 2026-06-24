@push('js')
<link rel="stylesheet" href="/css/all.min.css" />
<link rel="stylesheet" href="/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="/css/jquery-ui.css" />
<script src="/js/jquery.min.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/jquery-ui.js"></script>
<script src="/js/Invoice.js"></script>

<script type="text/javascript">
var count=0;
function newLineItem(){
                $.ajax({
                    url: '/admin/get_products/ajax',
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $.each(data, function(key, value){
                        //$('.product-select').append('<option value="'+ key +'">'+ value +'</option>');
                        $('select[name="product_id[]"]').append('<option value="'+ key +'-'+count+'">'+ value +'</option>');
                        });
                    }
                });

var line_div=$('<div id="line_item"></div>');
var sopra=$('#line_item_new');
var quantity='';
for(i = 1; i <= 1000; i++) {
    quantity += '<option value="'+i+'-'+count+'">'+i+'</option>';
    //quantity += '<option value="'+i+'">'+i+'</option>';
}

const mobileQuery = window.matchMedia("(max-width: 768px)");
//alert(mobileQuery.matches);
if (mobileQuery.matches) {
//Mobile view so all the input fields display in two rows.
$( sopra ).append( '<hr /><br /><span style="color:#F1541E;">Please choose a product and a quantity. The amount will be displayed only after choosing the quantity and the product.</span><div id="first'+count+'"><div class="px-4 py-5 bg-white sm:p-6 text-gray-900"><div class="grid grid-cols-3 gap-3"><div class="col-span-2" md:col-span-2"><label class="block font-medium text-sm" for="product">Products</label><select class="form-input rounded-md shadow-sm mt-1 block w-full" onChange="getRate(this.value);" id="product_id'+count+'" name="product_id[]"><option value="">Choose Product</option></select></div><div class="col-span-1" md:col-span-1"><label class="block font-medium text-sm" for="rate">Rate</label><input class="form-input rounded-md shadow-sm mt-1 block w-full" type="text" name="rate[]" id="rate-'+count+'" value="" onChange="RecalculateAmount(this.id);"></div><div class="col-span-1 md:col-span-1"><label class="block font-medium text-sm" for="qty">Qty</label><select class="form-input rounded-md shadow-sm mt-1 block w-full" id="quantity'+count+'" name="quantity[]" onChange="calculateAmount(this.value);">'+quantity+'</select></div><div class="col-span-2" md:col-span-2"><label class="block font-medium text-sm" for="amount">Amount</label><input class="form-input rounded-md shadow-sm mt-1 block w-full" type="text" name="amount[]" id="amount'+count+'" value=""></div></div></div></div>');
} else{
//Desktop view so all the input fields display in one row.
$( sopra ).append( '<hr /><br /><span style="color:#F1541E;">Please choose a product and a quantity. The amount will be displayed only after choosing the quantity and the product.</span><div id="first'+count+'"><div class="px-4 py-5 bg-white sm:p-6 text-gray-900"><div class="grid grid-cols-6 gap-6"><div class="col-span-2" md:col-span-2"><label class="block font-medium text-sm" for="product">Products</label><select class="form-input rounded-md shadow-sm mt-1 block w-full" onChange="getRate(this.value);" id="product_id'+count+'" name="product_id[]"><option value="">Choose Product</option></select></div><div class="col-span-1" md:col-span-1"><label class="block font-medium text-sm" for="rate">Rate</label><input class="form-input rounded-md shadow-sm mt-1 block w-full" type="text" name="rate[]" id="rate-'+count+'" value="" onChange="RecalculateAmount(this.id);"></div><div class="col-span-1 md:col-span-1"><label class="block font-medium text-sm" for="qty">Qty</label><select class="form-input rounded-md shadow-sm mt-1 block w-full" id="quantity'+count+'" name="quantity[]" onChange="calculateAmount(this.value);">'+quantity+'</select></div><div class="col-span-2" md:col-span-2"><label class="block font-medium text-sm" for="amount">Amount</label><input class="form-input rounded-md shadow-sm mt-1 block w-full" type="text" name="amount[]" id="amount'+count+'" value=""></div></div></div></div>');
}
count++;
}

$("#line_items").DataTable(
        {
        stateSave:true,
        "scrollX": true,
        columnDefs: [
                        { width: '20%', targets: 0 },
                        { width: '10%', targets: 1 },
                        { width: '15%', targets: 2 },
                        { width: '13%', targets: 3 },
                ],
                "lengthMenu": [ 100, 500, 1000 ],
                "pageLength": 100,
                fixedColumns: true,
        initComplete: function () {
        $('div.dataTables_filter input', this.api().table().container()).attr('id', 'mySearchInput');
        $('div.dataTables_filter input', this.api().table().container()).attr('name', 'search_field');
    }
        }
    );

function RecalculateAmount(rateId){
        //alert(rateId);
        var rate = document.getElementById(rateId).value;
        var item_rate = rateId.split("-");
        var r_cnt = item_rate[1];
        var cnt = r_cnt;
        //alert(rate);

        var quantityId = document.getElementById('quantity'+cnt).value;
        var item_type = quantityId.split("-");
        var quantity = item_type[0];
        var q_cnt = item_type[1];
        //alert(quantity);

        var amount = quantity * rate;
        document.getElementById('amount'+cnt).value = amount;
    }

function calculateAmount(quantityId){
        var item_qty = quantityId.split("-");
        var quantity = item_qty[0];
        var q_cnt = item_qty[1];
        //alert(quantityId);
        //alert(quantity);
        //alert(q_cnt);
        var cnt = q_cnt;
        //alert(cnt);
        var rate = document.getElementById('rate-'+cnt).value;
        //alert("SKK");
        //alert(rate);
        var amount = quantity * rate;
        document.getElementById('amount'+cnt).value = amount;
    }

 function getRate(productId){
        var item_type = productId.split("-");
        var product_id = item_type[0];
        var p_cnt = item_type[1];
        //alert(productId);
        //alert(product_id);
        //alert(p_cnt);

        var cnt = p_cnt-1;

        $.ajax({
                    url: '/admin/get_product_rate/ajax/'+product_id,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //alert(data.rate);
                        $('#rate-'+cnt).val(data.rate);
                        RecalculateAmount('rate-'+cnt);
                    }
              });
    }

$(document).ready(function(){
    $('.toggle-div').on('click', function(event){
        // Prevent the browser from navigating to the anchor's href
        event.preventDefault();

         // Get the ID of the div to show from the anchor's href attribute
        var targetDivId = $(this).attr('href'); // e.g., "#div1"

        //Modal
        $(targetDivId).show();

        // When the user clicks on <closeBtn> (x), close the modal
        $(".close").click(function(){
            $(targetDivId).hide();
        })
        $(".close-div").click(function(){
            $(targetDivId).hide();
        })

        // Prevent clicks inside the modal content from closing the modal
        $('.modal').on('click', function(e) {
            e.stopPropagation();
        });

    });

});


</script>

<style>
/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 5%; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  /*background-color: #fefefe;*/
  background-color: #ffffff;
  margin: auto;
  padding: 20px;
  /*border: 1px solid #fb700d;*/
  width: 60%;
}
/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  margin-left:95%;
}
.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>

@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
	@if(empty($invoice->id))
            {{ __('New Invoice') }}
	@else
            {{ __('Edit Invoice') }}
	@endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
	        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div class="text-right">
                <a href="#myModal" class="toggle-div inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:shadow-outline-gray m-1" id="toggleBtn" style="background:#000;">Add New Product</a>
            </div>
                        <div id="myModal" class="modal">
                          <!-- Modal content -->
                          <div class="modal-content">
                            <span class="close" id="closeBtn">&times;</span>
              <div class="mt-6 text-gray-500">
                <h3>Please fill in your information to access this resource.</h3>
                      <form name="add-product" action="/admin/saveproduct" method="post">
                      @csrf
                        <input type="hidden" name="referer" value="{{ url()->current() }}">
                        <div class="col-span-8 md:col-span-2">
                         <label class="block font-medium text-sm" for="sku">SKU<span style="color:#F1541E;">*</span></label>
                         <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="sku" name="sku" type="text" value="" >
                        </div>
        <br />
        <div class="col-span-8 md:col-span-4">
             <label class="block font-medium text-sm" for="name">Name of the product <span style="color:#F1541E;">*</span></label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="name" name="name" type="text" value="" required>
        </div>
        <br />
        <div class="col-span-4" md:col-span-4">
             <label class="block font-medium text-sm" for="price">Unit Price (in Rs.) <span style="color:#F1541E;">*</span></label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="price" name="price" type="text" value="" required>
        </div>
        <br />
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="unit">Unit <span style="color:#F1541E;">*</span></label>
             <select class="form-input rounded-md shadow-sm mt-1 block w-full" id="unit" name="unit">
                <option value=''>Choose Related Unit</option>
        @foreach($units as $c)
        <option value="{{ $c->id }}">{{ $c->name }}</option>
        @endforeach
        </select>
        </div>
        <br />
        <div class="col-span-8">
             <label class="block font-medium text-sm" for="description">Description</label>
             <textarea class="form-input rounded-md shadow-sm mt-1 block w-full" id="description" name="description" type="text"></textarea>
        </div>
               </div>
            <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
     <button type="submit" class="button-round inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1 refresh_page" wire:loading.attr="disabled">
            Add Product 
     </button>
     <button type="button" class="button-round inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1 close-div" wire:loading.attr="disabled">
    Cancel
     </button>
            </div>
            </form>
            </div><!-- modal-content -->
            </div><!-- myModal -->
        <!-- The Modal ends -->

    			<div class="mt-6 text-gray-500">
				<form name="save-invoice" action="/admin/saveinvoice" method="post">
				<input type="hidden" name="invoice_id" value="{{ $invoice->id }}" />	
				@csrf	
<div class="overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 bg-white sm:p-6 text-gray-900">

             @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                   @if(Session::has('alert-' . $msg))
                    <div class="mt-6 text-gray-900 leading-7 font-semibold ">
                                <span @if($msg == 'danger') style="color:red"  @else style="color:green" @endif>{{ Session::get('alert-' . $msg) }}</span>
                    </div>
                   @endif
             @endforeach
        <div class="clear">&nbsp;</div>
        <div class="grid grid-cols-6 gap-6">
        <!-- Client's Company -->
        <div class="col-span-4 md:col-span-4">
             <label class="block font-medium text-sm" for="entity_id">Client Entity<span style="color:#F1541E;">*</span></label>
             <select class="form-input rounded-md shadow-sm mt-1 block w-full" id="entity_id" name="entity_id" required>
        @foreach($entities as $c)
            @php if(auth()->user()->get_current_entity($c->id) == 1) continue;  @endphp
        <option value="{{ $c->id }}" @if($c->id == $invoice->entity_id) selected @endif>{{ $c->name }}</option>
        @endforeach
        </select>
        </div>
        <!-- Invoice Date -->
        <div class="col-span-4 md:col-span-4">
            @php
                $month = date('m');
                $day = date('d');
                $year = date('Y');
                $today = $year.'-'.$month.'-'.$day;
            @endphp
             <label class="block font-medium text-sm" for="invoice_date">Invoice Date<span style="color:#F1541E;">*</span></label>
            @if(!preg_match('/new/',url()->current()))
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="invoice_date" name="invoice_date" type="date" value="{{ $invoice->invoice_date }}" required>
            @else
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="invoice_date" name="invoice_date" type="date" value="{{ $today }}" required>
            @endif
        </div>
        <!-- Invoice special discount -->
        <div class="col-span-4 md:col-span-4">
             <label class="block font-medium text-sm" for="discount">Special Discount (Optional)</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="discount" name="discount" type="text" value="{{ $invoice->discount }}" placeholder="2% or Rs. 200">
        </div>

        <!-- Description -->
        <!--
        <div class="col-span-8">
             <label class="block font-medium text-sm" for="description">Description</label>
             <textarea class="form-input rounded-md shadow-sm mt-1 block w-full" id="description" name="description" type="text">{{ $invoice->description }}</textarea>
        </div>
        -->
       <div class="clear">&nbsp;</div> 
        <!-- Total Amount -->
        <div class="col-span-8 md:col-span-2">
            @if(!empty($invoice->entity_id))
                @php
                    $total_amount = $invoice->total_amount;
                    $owner_entity_details = \App\Models\Entity::find($invoice->owner_entity_id);
                    $total_amount_including_tax = $invoice->total_amount;
                    if(!empty($owner_entity_details->GSTIN_number) && !empty($tax_number)){
                    $total_amount_including_tax = $total_amount + ($total_amount * (int)$tax_number/100);
                    }
                @endphp
            @endif
            @if(!empty($invoice->total_amount))
             <label class="block font-medium text-sm" for="total_amount" style="color:red; font-size:15px;">Total Amount (in Rs.): {{ number_format($invoice->total_amount,2) }} @if(!empty($owner_entity_details->GSTIN_number) && !empty($tax_number)) <br />{{ $invoice->tax_name }}: {{ $invoice->tax_value }}<br /> Total Amount including tax (in Rs.): {{ number_format($total_amount_including_tax,2) }} @endif
</label>
            @endif
        </div>

       </div>
    </div>
        
<div id="line_item">
</div>
        <div id="line_item_new">
        </div>
        <div class="clear">&nbsp;</div>
<!--button type="button" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 duration-150 m-1" wire:loading.attr="disabled" onclick="newLineItem(); ">Add New Line Item</button-->
<button type="button" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:shadow-outline-gray m-1" style="background:#000;"  onclick="newLineItem();">Add New Line Item</button>


{{--@if(Auth::user()->hasRole('admin'))--}}
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
     <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled">
    Save
     </button>
&nbsp;
     <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled" onclick="window.history.back();">
    Cancel
     </button>
   </div>
{{--@endif--}}
                            </div>
				</form>
</div>
        <div class="clear">&nbsp;</div>
        <div class="col-span-8 md:col-span-2">
                @foreach($line_items as $line_item)
                <div class="text-right">
                <a href="/admin/line-item-form/{{ $line_item->id }}" title="Edit"><span class="fas fa-pencil-alt"></span></a>
                <button id="opener" class="delete_lineitem" data-lineitem-id="{{ $line_item->id }}" title="Delete"><span class="fas fa-trash-alt"></span></button>
                </div>
        <div id="deletedialog" style="display:none;" class="bg-grey">
                <form name="deletelineitem" method="post" action="/admin/lineitem/delete">
                @csrf
                <input type="hidden" id="delete_lineitem_id" name="lineitem_id" value="{{ $line_item->id }}" />
            This action can not be undone.
            <div class="flex items-center justify-end px-4 py-3 sm:px-6">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled">Delete</button>
                <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1 do-not-delete" wire:loading.attr="disabled" id="cancel-delete">Cancel</button>
            </div>
                </form>
         </div>
                
        <div class="col-span-1 md:col-span-1">
             <label class="block font-medium text-sm" for="item_name">Product Name: {{ $line_item->item_name }}</label>
             <label class="block font-medium text-sm" for="rate">Rate: Rs. {{ $line_item->rate }} / {{ $line_item->product->unit_detail->name }}</label>
             <label class="block font-medium text-sm" for="quantity">Quantity: {{ $line_item->quantity }}</label>
             <label class="block font-medium text-sm" for="amount">Amount (in Rs.): {{ $line_item->amount }}</label>
        </div>
                @endforeach
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
