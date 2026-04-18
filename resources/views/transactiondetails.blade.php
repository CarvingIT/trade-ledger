@push('js')
<link rel="stylesheet" href="/css/all.min.css" />
<link rel="stylesheet" href="/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="/css/jquery-ui.css" />
<script src="/js/jquery.min.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/jquery-ui.js"></script>

<script type="text/javascript">
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
            {{ __('Transaction Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
	        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    			<div class="mt-6 text-gray-500">
				<form name="save-transaction" action="/admin/savetransaction" method="post">
				<input type="hidden" name="transaction_id" value="{{ $transaction->id }}" />	
				@csrf	
<div class="overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 bg-white sm:p-6 text-gray-900">
       <div class="grid grid-cols-6 gap-6">
        <!-- Accounts -->
        <div class="col-span-4">
             <label class="block font-medium text-sm" for="entity_id">Accounts<span style="color:#F1541E;">*</span></label>
             <select class="form-input rounded-md shadow-sm mt-1 block w-full" id="account_id" name="account_id" disabled>
            <option value="">Select Account</option>
        @foreach($accounts as $c)
        <option value="{{ $c->id }}" @if($c->id == $transaction->account_id) selected @endif>{{ $c->name }}</option>
        @endforeach
        </select>
        </div>

        <!-- Type -->
        <div class="col-span-8 md:col-span-4">
             <label class="block font-medium text-sm" for="type">Type<span style="color:#F1541E;">*</span></label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="type" name="type" type="text" value="{{ $transaction->type }}" readonly>
        </div>
        
        <!-- Client's Entity/Company -->
        <div class="col-span-4">
             <label class="block font-medium text-sm" for="entity_id">Client Entity<span style="color:#F1541E;">*</span></label>
             <select class="form-input rounded-md shadow-sm mt-1 block w-full" id="entity_id" name="entity_id" onChange="getInvoices(this.value);" disabled>
            <option value="">Select Entity</option>
        @foreach($entities as $c)
        <option value="{{ $c->id }}" @if($c->id == $transaction->entity_id) selected @endif>{{ $c->name }}</option>
        @endforeach
        </select>
        </div>

        <!-- Client's Invoices -->
        <div class="col-span-4">
             <label class="block font-medium text-sm" for="entity_id">Invoices<span style="color:#F1541E;">*</span></label>
             <select class="form-input rounded-md shadow-sm mt-1 block w-full" id="invoice_id" name="invoice_id" onChange="getTotalAmount(this.value);" disabled>
            <option value="">Choose Invoice</option>
        @foreach($invoices as $c)
        <option value="{{ $c->id }}" @if($c->id == $transaction->invoice_id) selected @endif>{{ $c->title }}</option>
        @endforeach
        </select>
        </div>

        <!-- Total Amount -->
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="total_amount" style="color:red; font-size:15px;">Total Amount</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="total_amount" name="total_amount" type="text" value="{{ $transaction->total_amount }}" readonly>
            <div id="toggle_tax" style="display:none">
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="tax_name" name="tax_name" type="text" value="" readonly>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="tax_value" name="tax_value" type="text" value="" readonly>
            </div>
        </div>

        <!-- Client's Transaction Status -->
        <div class="col-span-4">
             <label class="block font-medium text-sm" for="status">Status<span style="color:#F1541E;">*</span></label>
        <input type="radio" name="status"  value="paid" @if($transaction->status=='paid') checked @endif disabled>&nbsp;{{ __('Paid') }}<br />
        <input type="radio" name="status"  value="pending" @if($transaction->status=='pending') checked @endif disabled>&nbsp;{{ __('Pending') }}
        </div>

        <!-- Description -->
        <div class="col-span-8">
             <label class="block font-medium text-sm" for="description">Description</label>
             <textarea class="form-input rounded-md shadow-sm mt-1 block w-full" id="description" name="description" type="text">{{ $transaction->description }}</textarea>
        </div>
        
       </div>
    </div>
        
                            </div>
				</form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
