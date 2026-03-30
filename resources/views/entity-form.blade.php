@push('js')
<link rel="stylesheet" href="/css/all.min.css" />
<link rel="stylesheet" href="/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="/css/jquery-ui.css" />
<script src="/js/jquery.min.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/jquery-ui.js"></script>

<script type="text/javascript">
$( function() {
    $( "#datepicker" ).datepicker();
    $( "#datepicker1" ).datepicker();
    $( "#datepicker2" ).datepicker();
    $( "#datepicker3" ).datepicker();
  } );
</script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
	@if(empty($company->id))
            {{ __('New Entity') }}
	@else
            {{ __('Edit Entity') }}
	@endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
	        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    			<div class="mt-6 text-gray-500">
				<form name="save-entity" action="/admin/saveentity" method="post">
				<input type="hidden" name="entity_id" value="{{ $entity->id }}" />	
				@csrf	
<div class="overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 bg-white sm:p-6 text-gray-900">
       <div class="grid grid-cols-6 gap-6">
        <!-- Company Name -->
        <div class="col-span-8 md:col-span-4">
             <label class="block font-medium text-sm" for="name">Name of the company <span style="color:#F1541E;">*</span></label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="name" name="name" type="text" value="{{ $entity->name }}" required>
        </div>
	
        <!-- Email -->
        <div class="col-span-4" md:col-span-4">
             <label class="block font-medium text-sm" for="email">Email</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="email" name="email" type="text" value="{{ $entity->email }}" >
        </div>
        <!-- Phone -->
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="phone">Phone</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="phone" name="phone" type="text" value="{{ $entity->phone }}" >
        </div>
	
	<!-- Other Info -->
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="other_info">Other Info</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="other_info" name="other_info" type="text" value="{{ $entity->other_info }}">
        </div>


        <!-- Description -->
        <div class="col-span-8">
             <label class="block font-medium text-sm" for="description">Description</label>
             <textarea class="form-input rounded-md shadow-sm mt-1 block w-full" id="description" name="description" type="text">{{ $entity->description }}</textarea>
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
