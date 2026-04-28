@push('js')
<link rel="stylesheet" href="/css/all.min.css" />
<link rel="stylesheet" href="/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="/css/jquery-ui.css" />
<script src="/js/jquery.min.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/jquery-ui.js"></script>
<script src="/js/Purchase.js"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Purchase Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
		@foreach (['danger', 'warning', 'success', 'info'] as $msg)
                   @if(Session::has('alert-' . $msg))
                        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                                <div class="mt-6 text-gray-900 leading-7 font-semibold ">
                                        <span>{{ Session::get('alert-' . $msg) }}</span>
                                </div>
                        </div>
                   @endif
               @endforeach
	        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
			<div class="text-right">
				@if(Auth::user()->hasRole('admin'))
                               <a title="Edit Purchase" href="/admin/purchase-form/{{$purchase->id}}"><span class="fas fa-pencil-alt m-1 fa-2x"></span></a>
                               <a class="m-5" title="Export" href="/admin/purchase/{{ $purchase->id }}/download" target="_blank"><span class="fas fa-file-export fa-2x"></span></a> 
                                @endif
                        </div>

    			<div class="mt-6 text-gray-500">
	
				<form name="save-entity" action="/admin/savepurchase" method="post">
				<input type="hidden" name="purchase_id" value="{{ $purchase->id }}" />	
				@csrf	
<div class="overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 bg-white sm:p-6 text-gray-900">
       <div class="grid grid-cols-6 gap-6">
        <!-- Company Name -->
        <div class="col-span-8">
             <label class="block font-medium text-sm" for="purchase">Title <span style="color:#F1541E;">*</span></label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="title" name="title" type="text" value="{{ $purchase->title }}" required readonly style="background:#eee;">
        </div>

        <!-- Owner Entity -->
        <div class="col-span-4" md:col-span-4">
             <label class="block font-medium text-sm" for="owner entity">Owner Entity</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="owner_entity" name="owner_entity" type="text" value="{{ $purchase->owner_entity->name }}"  readonly style="background:#eee;">
        </div>

        <!-- Client Entity -->
        <div class="col-span-4" md:col-span-4">
             <label class="block font-medium text-sm" for="client_entity">Client Entity</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="client_entity" name="client_entity" type="text" value="{{ $purchase->entity->name }}"  readonly style="background:#eee;">
        </div>

        <!-- Price -->
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="total_amount">Total Amount of Items (in Rs.)</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="total_amount" name="total_amount" type="text" value="{{ $purchase->total_amount }}"  readonly style="background:#eee;">
        </div>

        <!-- Tax -->
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="tax">Tax</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="tax" name="tax" type="text" value="{{ @$purchase->tax_name }} - {{ @$purchase->tax_value }}"  readonly style="background:#eee;">
        </div>
	
        <!-- Total Amount with Tax -->
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="total_amount">Total Amount including Tax (in Rs.)</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="total_amount_including_tax" name="total_amount_including_tax" type="text" value="{{ $total_amount_including_tax }}"  readonly style="background:#eee;">
        </div>

        <!-- Description -->
        <div class="col-span-8">
             <label class="block font-medium text-sm" for="description">Description</label>
             <textarea class="form-input rounded-md shadow-sm mt-1 block w-full" id="description" name="description" type="text" readonly style="background:#eee;">{{ $purchase->description }}</textarea readonly style="background:#eee;">
        </div>

       </div>
    </div>
          </div>
				</form>
         <div class="mt-6 text-gray-900">
           <div class="table-responsive">
              <table id="line_items" class="display">
                <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Rate</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                @foreach($line_items as $line_item)
                <tr>
                    <td>{{ $line_item->item_name }}</td>
                    <td>Rs. {{ $line_item->rate }} / {{ $line_item->product->unit_detail->name }}</td>
                    <td>{{ $line_item->quantity }}</td>
                    <td>{{ $line_item->amount }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
         </div>
       </div>

                     </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
