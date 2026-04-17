@push('js')
<link rel="stylesheet" href="/css/all.min.css" />
<link rel="stylesheet" href="/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="/css/jquery-ui.css" />
<script src="/js/jquery.min.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/jquery-ui.js"></script>

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
                        $('select[name="product_id[]"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });

var line_div=$('<div id="line_item"></div>');
var sopra=$('#line_item_new');
var quantity='';
for(i = 1; i <= 1000; i++) {
    //quantity += '<option value="'+i+'-'+count+'">'+i+'</option>';
    quantity += '<option value="'+i+'">'+i+'</option>';
}

$( sopra ).append( '<hr /><br /><span style="color:#F1541E;">Please choose products and quantity</span><div id="first'+count+'"><div class="px-4 py-5 bg-white sm:p-6 text-gray-900"><div class="grid grid-cols-6 gap-6"><div class="col-span-2" md:col-span-2"><label class="block font-medium text-sm" for="product">Products</label><select class="form-input rounded-md shadow-sm mt-1 block w-full" id="product_id'+count+'" name="product_id[]"></select></div><div class="col-span-2" md:col-span-2"><label class="block font-medium text-sm" for="qty">Qty</label><select class="form-input rounded-md shadow-sm mt-1 block w-full" id="quantity'+count+'" name="quantity[]"><option value="">Select Qty</option>'+quantity+'</select></div></div></div></div>');
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

</script>

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
    			<div class="mt-6 text-gray-500">
				<form name="save-invoice" action="/admin/saveinvoice" method="post">
				<input type="hidden" name="invoice_id" value="{{ $invoice->id }}" />	
				@csrf	
<div class="overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 bg-white sm:p-6 text-gray-900">
       <div class="grid grid-cols-6 gap-6">
        <!-- Title -->
        <div class="col-span-8 md:col-span-4">
             <label class="block font-medium text-sm" for="title">Title<span style="color:#F1541E;">*</span></label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="title" name="title" type="text" value="{{ $invoice->title }}" required>
        </div>
        
        <!-- Client's Company -->
        <div class="col-span-4">
             <label class="block font-medium text-sm" for="entity_id">Client Entity<span style="color:#F1541E;">*</span></label>
             <select class="form-input rounded-md shadow-sm mt-1 block w-full" id="entity_id" name="entity_id" required>
        @foreach($entities as $c)
        <option value="{{ $c->id }}" @if($c->id == $invoice->entity_id) selected @endif>{{ $c->name }}</option>
        @endforeach
        </select>
        </div>
        <!-- Description -->
        <div class="col-span-8">
             <label class="block font-medium text-sm" for="description">Description</label>
             <textarea class="form-input rounded-md shadow-sm mt-1 block w-full" id="description" name="description" type="text">{{ $invoice->description }}</textarea>
        </div>
        
        <!-- Total Amount -->
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="total_amount" style="color:red; font-size:15px;">Total Amount: {{ $invoice->total_amount }}</label>
        </div>
                @foreach($line_items as $line_item)
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="item_name">Product Name: {{ $line_item->item_name }}</label>
             <label class="block font-medium text-sm" for="rate">Rate: Rs. {{ $line_item->rate }} / {{ $line_item->product->unit_detail->name }}</label>
             <label class="block font-medium text-sm" for="quantity">Quantity: {{ $line_item->quantity }}</label>
             <label class="block font-medium text-sm" for="amount">Amount: {{ $line_item->amount }}</label>
        </div>
                @endforeach
       </div>
    </div>
        
<div id="line_item">
</div>
        <div id="line_item_new">
        </div>
        <div class="clear">&nbsp;</div>
<!--button type="button" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 duration-150 m-1" wire:loading.attr="disabled" onclick="newLineItem(); ">Add New Line Item</button-->
<button type="button" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:shadow-outline-gray m-1" style="background:#000;"  onclick="newLineItem();">Add New Line Item</button>


@if(Auth::user()->hasRole('admin'))
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
     <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled">
    Save
     </button>
     <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled" onclick="window.history.back();">
    Cancel
     </button>
   </div>
@endif
                            </div>
				</form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
