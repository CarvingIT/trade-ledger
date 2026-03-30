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
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
	        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
			<div class="text-right">
			@if(Auth::user()->hasRole('admin'))
                          <a title="Edit Person" href="/admin/user-form/{{$user->id}}"><span class="fas fa-pencil-alt m-1 fa-2x"></span></a>
                        @endif
			</div>
    			<div class="mt-6 text-gray-500">
				<form name="save-user" action="/admin/saveuser" method="post">
				<input type="hidden" name="user_id" value="{{ $user->id }}" />	
				<input type="hidden" name="referer" value="@php if(!empty($_SERVER['HTTP_REFERER'])){echo $_SERVER['HTTP_REFERER'];} @endphp">
				@csrf	
<div class="overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 bg-white sm:p-6 text-gray-900">
       <div class="grid grid-cols-6 gap-6">
        <!-- User Name -->
        <div class="col-span-3">
             <label class="block font-medium text-sm" for="name">Name</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="name" name="name" type="text" value="{{ $user->name }}" readonly style="background:#eee;">
        </div>
        <!-- Email -->
        <div class="col-span-8 md:col-span-4">
             <label class="block font-medium text-sm" for="email">Email</label> 
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="email" name="email" type="text" value="{{ $user->email }}" required readonly style="background:#eee;">
        </div>
	<!-- Password -->
        <div class="col-span-8 md:col-span-4">
             <label class="block font-medium text-sm" for="password">Password</label> 
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="password" name="password" type="text" value="" readonly style="background:#eee;">
        </div>
        <!--
        <div class="col-span-8">
             <label class="block font-medium text-sm" for="address">Address</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="address" name="address" type="text" value="{{ $user->address }}"  readonly style="background:#eee;">
        </div>
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="city">City</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="city" name="city" type="text" value="{{ $user->city }}"  readonly style="background:#eee;">
        </div>
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="state_or_province">State or Province</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="state_or_province" name="state_or_province" type="text" value="{{ $user->state_or_province }}"  readonly style="background:#eee;">
        </div>
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="country">Country</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="country" name="country" type="text" value="{{ $user->country }}"  readonly style="background:#eee;">
        </div>
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="postal_code">Postal code</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="postal_code" name="postal_code" type="text" value="{{ $user->postal_code }}"  readonly style="background:#eee;">
        </div>
        -->
	<!-- Person's Company -->
        <div class="col-span-4">
             <label class="block font-medium text-sm" for="entity_id">Entity</label>
             <select class="form-input rounded-md shadow-sm mt-1 block w-full" id="entity_id" name="entity_id" readonly style="background:#eee;">
		@foreach($entities as $c)
		<option value="{{ $c->id }}" @if($c->id == $user->entity_id) selected @endif>{{ $c->name }}</option>
		@endforeach
		</select>
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
