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
            {{ __('Settings Details') }}
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
                                <!--a title="Edit entity" href="/admin/setting-form/{{$setting->id}}"><span class="fas fa-pencil-alt m-1 fa-2x"></span></a-->
                                @endif
                        </div>

    			<div class="mt-6 text-gray-500">
	
				<form name="save-setting" action="/admin/savesetting" method="post">
				<input type="hidden" name="setting_id" value="{{ $setting->id }}" />	
				@csrf	
<div class="overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 bg-white sm:p-6 text-gray-900">
       <div class="grid grid-cols-6 gap-6">
        <!-- Settings Owner Entity -->
        <div class="col-span-8 md:col-span-4">
             <label class="block font-medium text-sm" for="name">Owner Entity</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="owner_entity" name="owner_entity" type="text" value="{{ $setting->owner_entity->name }}" readonly style="background:#eee;">
        </div>

        <!-- Name -->
        <div class="col-span-8">
             <label class="block font-medium text-sm" for="setting">Name of the setting <span style="color:#F1541E;">*</span></label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="name" name="name" type="text" value="{{ $setting->name }}" required readonly style="background:#eee;">
        </div>

        <!-- Value -->
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="value">Value</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="value" name="value" type="text" value="{{ $setting->value }}"  readonly style="background:#eee;">
        </div>

        <!-- Description -->
        <div class="col-span-8">
             <label class="block font-medium text-sm" for="description">Description</label>
             <textarea class="form-input rounded-md shadow-sm mt-1 block w-full" id="description" name="description" type="text" readonly style="background:#eee;">{{ $setting->description }}</textarea readonly style="background:#eee;">
        </div>

       </div>
    </div>
                            </div>
				</form>
    <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled" onclick="window.history.back();">
    Back
     </button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
