@push('js')
<link rel="stylesheet" href="/css/all.min.css" />
<link rel="stylesheet" href="/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="/css/jquery-ui.css" />
<script src="/js/jquery.min.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/jquery-ui.js"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
	@if(empty($unit->id))
            {{ __('New Unit') }}
	@else
            {{ __('Edit Unit') }}
	@endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
	        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    			<div class="mt-6 text-gray-500">
				<form name="save-unit" action="/admin/saveunit" method="post">
				<input type="hidden" name="unit_id" value="{{ $unit->id }}" />	
				@csrf	
<div class="overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 bg-white sm:p-6 text-gray-900">
       <div class="grid grid-cols-6 gap-6">
        <!-- Unit Name -->
        <div class="col-span-8 md:col-span-4">
             <label class="block font-medium text-sm" for="name">Name of the unit <span style="color:#F1541E;">*</span></label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="name" name="name" type="text" value="{{ $unit->name }}" required>
        </div>
	
        <!-- Unit Id -->
        <div class="col-span-4" md:col-span-4">
             <label class="block font-medium text-sm" for="related_unit_id">Related Unit ID</label>
             <select class="form-input rounded-md shadow-sm mt-1 block w-full" id="related_unit_id" name="related_unit_id">
                <option value=''>Choose Related Unit</option>
        @foreach($units as $c)
        <option value="{{ $c->id }}" @if($c->id == $unit->id) selected @endif>{{ $c->name }}</option>
        @endforeach
        </select>
        </div>

        <!-- Unit Quantity -->
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="related_unit_quantity">Unit Quantity</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="related_unit_quantity" name="related_unit_quantity" type="text" value="{{ $unit->related_unit_quantity }}">
        </div>
	
        <!-- Description -->
        <div class="col-span-8">
             <label class="block font-medium text-sm" for="description">Description</label>
             <textarea class="form-input rounded-md shadow-sm mt-1 block w-full" id="description" name="description" type="text">{{ $unit->description }}</textarea>
        </div>

       </div>
    </div>

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
