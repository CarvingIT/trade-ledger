@push('js')
<link rel="stylesheet" href="/css/all.min.css" />
<link rel="stylesheet" href="/css/jquery-ui.css" />
<link rel="stylesheet" href="/css/jquery.dataTables.min.css" />
<script src="/js/jquery.min.js"></script>
<script src="/js/jquery-ui.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/Product.js"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

               @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                   @if(Session::has('alert-' . $msg))
		        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    				<div class="mt-6 text-gray-900 leading-7 font-semibold ">
                        		<span @if($msg == 'danger') style="color:red" @endif>{{ Session::get('alert-' . $msg) }}</span>
				</div>
                        </div>
                   @endif
               @endforeach

	        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
			<div class="text-right">
				@if(Auth::user()->hasRole('admin'))
                <a class="m-5" title="New Product" href="/admin/product-form/new"><span class="fas fa-plus"></span></a>
                @endif
                &nbsp;
				<a class="m-5" title="Export" href="/admin/export/products"><span class="fas fa-file-export"></span></a>
			</div>
    			<div class="mt-6 text-gray-900">
			<div class="table-responsive">
                    <table id="products" class="display">
                        <thead class="text-primary">
                            <tr>
                            <th>Name</th>
			                <th>SKU</th>
			                <th>Rate (Unit Price)</th>
			                <th>Stock Quantity</th>
			                <th>Unit</th>
			                <th>Description</th>
                            <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
			@foreach ($products as $c)
        		<tr>
			<td>{{ $c->name }}</td>
			<td>{{ $c->sku }}</td>
			<td>{{ $c->price }}</td>
			<td>{{ $c->stock_quantity }}</td>
			<td>{{ $c->unit_detail->name }}</td>
			<td>{{ \Illuminate\Support\Str::limit($c->description, 30, $end='...') }}</td>
			<td>
				<a href="/admin/product/{{ $c->id }}" title="View Details"><span class="fas fa-eye" style="padding:5%;"></span></a>
				@if(Auth::user()->hasRole('admin'))
				<a href="/admin/product-form/{{ $c->id }}" title="Edit"><span class="fas fa-pencil-alt" style="padding:5%;"></span></a>
				<button id="opener" class="delete_product" data-product-id="{{ $c->id }}" title="Delete"><span class="fas fa-trash-alt"></span></button>
				@endif

	    <div id="deletedialog" style="display:none;" class="bg-grey">
                <form name="deleteproduct" method="post" action="/admin/product/delete">
                @csrf
                <input type="hidden" id="delete_product_id" name="product_id" value="{{ $c->id }}" />
			This action can not be undone.
			<div class="flex items-center justify-end px-4 py-3 sm:px-6">
     			<button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled">Delete</button>
     			<button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1 do-not-delete" wire:loading.attr="disabled" id="cancel-delete">Cancel</button>
   			</div>
                </form>
            </div>
			</td>
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
</x-app-layout>
