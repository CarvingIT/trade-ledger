@push('js')
<link rel="stylesheet" href="/css/all.min.css" />
<link rel="stylesheet" href="/css/jquery-ui.css" />
<link rel="stylesheet" href="/css/jquery.dataTables.min.css" />
<script src="/js/jquery.min.js"></script>
<script src="/js/jquery-ui.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/Purchase.js"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Purchases') }}
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
                <a class="m-5" title="New Purchase" href="/admin/purchase-form/new"><span class="fas fa-plus"></span></a>
                @endif
                &nbsp;
				<!--a class="m-5" title="Export" href="/admin/export/purchases"><span class="fas fa-file-export"></span></a-->
			</div>

    			<div class="mt-6 text-gray-900">
            <form name="purchases_export" action="/admin/purchases" method="GET" id="downloadPurchases">
                <div class="col-span-4 md:col-span-2">
             <label class="block font-medium text-sm" for="datepicker">Start Date </label>
                <input class="form-input rounded-md shadow-sm mt-1 block" id="datepicker" name="start_date" type="text" value="@if(!empty($_GET)){{ $_GET['start_date'] }}@endif" placeholder="YYYY-MM-DD" onChange="this.form.submit();">
        </div>
    <br />
        <div class="col-span-4 md:col-span-2">
             <label class="block font-medium text-sm" for="datepicker1">End Date </label>
                <input class="form-input rounded-md shadow-sm mt-1 block" id="datepicker1" name="end_date" type="text" value="@if(!empty($_GET)){{ $_GET['end_date'] }}@endif" placeholder="YYYY-MM-DD" onChange="this.form.submit();">
            </div>
            </form>
            <br />
            @if(!empty($_GET) && !empty($_GET['start_date']) && !empty($_GET['end_date']))
                <a class="m-5" title="Export Purchases" href="/admin/export/purchases_by_date?start_date={{ $_GET['start_date'] }}&end_date={{  $_GET['end_date'] }}">Export Purchases: <span class="fas fa-file-export"></span></a>
            @endif

            <div id="clear">&nbsp;</div>
			<div class="table-responsive">
                    <table id="purchases" class="display">
                        <thead class="text-primary">
                            <tr>
                            <th>Title</th>
			                <th>Owner Entity</th>
			                <th>Entity (Vendor)</th>
			                <th>Description</th>
			                <th>Total Amount</th>
			                <th>Created at</th>
			                <th>Updated at</th>
                            <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
			@foreach ($purchases as $c)
        		<tr>
			<td>{{ $c->title }}</td>
			<td>{{ $c->owner_entity->name }}</td>
			<td>{{ $c->entity->name }}</td>
			<td>{{ \Illuminate\Support\Str::limit($c->description, 30, $end='...') }}</td>
			<td>{{ $c->total_amount }}</td>
			<td>{{ $c->created_at }}</td>
			<td>{{ $c->updated_at }}</td>
			<td>
				<a href="/admin/purchase/{{ $c->id }}" title="View Details"><span class="fas fa-eye" style="padding:5%;"></span></a>
				@if(Auth::user()->hasRole('admin'))
				<a href="/admin/purchase-form/{{ $c->id }}" title="Edit"><span class="fas fa-pencil-alt" style="padding:5%;"></span></a>
				<button id="opener" class="delete_purchase" data-purchase-id="{{ $c->id }}" title="Delete"><span class="fas fa-trash-alt"></span></button>
				@endif

	    <div id="deletedialog" style="display:none;" class="bg-grey">
                <form name="deletepurchase" method="post" action="/admin/purchase/delete">
                @csrf
                <input type="hidden" id="delete_purchase_id" name="purchase_id" value="{{ $c->id }}" />
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
