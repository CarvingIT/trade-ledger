@push('js')
<link rel="stylesheet" href="/css/all.min.css" />
<link rel="stylesheet" href="/css/jquery-ui.css" />
<link rel="stylesheet" href="/css/jquery.dataTables.min.css" />
<script src="/js/jquery.min.js"></script>
<script src="/js/jquery-ui.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/Transaction.js"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transactions') }}
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
                <a class="m-5" title="New Invoice" href="/admin/transaction-form/new"><span class="fas fa-plus"></span></a>
                @endif
                &nbsp;
				<a class="m-5" title="Export" href="/admin/export/transactions"><span class="fas fa-file-export"></span></a>
			</div>
    			<div class="mt-6 text-gray-900">
			<div class="table-responsive">
                    <table id="transactions" class="display">
                        <thead class="text-primary">
                            <tr>
			                <th>Owner Entity</th>
                            <th>Account</th>
                            <th>Type</th>
			                <th>Entity (Client)</th>
			                <th>Total Amount</th>
			                <th>Status</th>
			                <th>Description</th>
                            <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
			@foreach ($transactions as $c)
        		<tr>
			<td>{{ $c->owner_entity->name }}</td>
			<td>{{ $c->account->name }}</td>
			<td>{{ $c->type }}</td>
			<td>{{ $c->entity->name }}</td>
			<td>{{ $c->total_amount }}</td>
			<td>{{ $c->status }}</td>
			<td>{{ \Illuminate\Support\Str::limit($c->description, 30, $end='...') }}</td>
			<td>
				<a href="/admin/transaction/{{ $c->id }}" title="View Details"><span class="fas fa-eye" style="padding:5%;"></span></a>
				@if(Auth::user()->hasRole('admin'))
				<a href="/admin/transaction-form/{{ $c->id }}" title="Edit"><span class="fas fa-pencil-alt" style="padding:5%;"></span></a>
				<button id="opener" class="delete_transaction" data-transaction-id="{{ $c->id }}" title="Delete"><span class="fas fa-trash-alt"></span></button>
				@endif

	    <div id="deletedialog" style="display:none;" class="bg-grey">
                <form name="deletetransaction" method="post" action="/admin/transaction/delete">
                @csrf
                <input type="hidden" id="delete_transaction_id" name="transaction_id" value="{{ $c->id }}" />
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
