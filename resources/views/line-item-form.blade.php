@push('js')
<link rel="stylesheet" href="/css/all.min.css" />
<link rel="stylesheet" href="/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="/css/jquery-ui.css" />
<script src="/js/jquery.min.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/jquery-ui.js"></script>
<script>
    function calculateAmount(){
        var quantity = document.getElementById('quantity').value;
        var rate = document.getElementById('rate').value;
        var amount = quantity * rate;
        document.getElementById('amount').value = amount;
    }
</script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
	@if(empty($unit->id))
            {{ __('New Line item') }}
	@else
            {{ __('Edit Line item') }}
	@endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
	        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    			<div class="mt-6 text-gray-500">
				<form name="save-lineitem" action="/admin/savelineitem" method="post">
				<input type="hidden" name="lineitem_id" value="{{ $lineitem->id }}" />	
				<input type="hidden" name="invoice_id" value="{{ $lineitem->invoice_id }}" />	
				@csrf	
<div class="overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 bg-white sm:p-6 text-gray-900">
       <div class="grid grid-cols-6 gap-6">
        <!-- Line Item Name -->
        <div class="col-span-8 md:col-span-4">
             <label class="block font-medium text-sm" for="name">Product Name<span style="color:#F1541E;">*</span></label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="item_name" name="item_name" type="text" value="{{ $lineitem->item_name }}" required>
        </div>
	
        <!-- Quantity -->
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="quantity">Quantity</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="quantity" name="quantity" type="number" value="{{ $lineitem->quantity }}" onChange="calculateAmount();">
        </div>
	
        <!-- Rate -->
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="rate">Rate (per {{ $lineitem->product->unit_detail->name }})</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="rate" name="rate" type="text" value="{{ $lineitem->rate }}" onChange="calculateAmount();">
        </div>

        <!-- Amount -->
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="rate">Amount</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="amount" name="amount" type="text" value="{{ $lineitem->amount }}">
        </div>

       </div>
    </div>
<div class="clear">&nbsp;</div>

@if(Auth::user()->hasRole('admin'))
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
     <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled">
    Save
     </button>
    &nbsp;
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
