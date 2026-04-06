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
            {{ __('Currency Details') }}
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
                                <a title="Edit entity" href="/admin/currency-form/{{$currency->id}}"><span class="fas fa-pencil-alt m-1 fa-2x"></span></a>
                                @endif
                        </div>

    			<div class="mt-6 text-gray-500">
	
				<form name="save-entity" action="/admin/savecurrency" method="post">
				<input type="hidden" name="currency_id" value="{{ $currency->id }}" />	
				@csrf	
<div class="overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 bg-white sm:p-6 text-gray-900">
       <div class="grid grid-cols-6 gap-6">
        <!-- Company Name -->
        <div class="col-span-8">
             <label class="block font-medium text-sm" for="currency">Name of the currency <span style="color:#F1541E;">*</span></label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="name" name="name" type="text" value="{{ $currency->name }}" required readonly style="background:#eee;">
        </div>

        <!-- Symbol -->
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="symbol">Symbol</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="symbol" name="symbol" type="text" value="{{ $currency->symbol }}"  readonly style="background:#eee;">
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
