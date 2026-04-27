<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
	@if(empty($user->id))
            {{ __('New Person') }}
	@else
            {{ __('Edit Person') }}
	@endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
	        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    			<div class="mt-6 text-gray-500">
				<form name="save-user" action="/admin/saveuser" method="post">
				<input type="hidden" name="user_id" value="{{ $user->id }}" />	
				<input type="hidden" name="referer" value="@php if(!empty($_SERVER['HTTP_REFERER'])){echo $_SERVER['HTTP_REFERER'];} @endphp">
				@csrf	
<div class="overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 bg-white sm:p-6 text-gray-900">
	<!-- Checkbox whether to send email to client or not -->
        <div class="col-span-4" md:col-span-4">
             <input id="send_email" name="send_email" type="checkbox" value="1">
             <label class=" font-medium text-sm" for="send_email">Send a Welcome Email to the Client</label>
        </div>
	<br />
       <div class="grid grid-cols-6 gap-6">

        <!-- User Name -->
        <div class="col-span-3">
             <label class="block font-medium text-sm" for="name">Name</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="firstname" name="firstname" type="text" value="{{ $user->name }}" >
        </div>
        <!-- Email -->
        <div class="col-span-8 md:col-span-4">
             <label class="block font-medium text-sm" for="email">Email</label> 
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="email" name="email" type="text" value="{{ $user->email }}" required>
        </div>
	<!-- Password -->
        <div class="col-span-8 md:col-span-4">
             <label class="block font-medium text-sm" for="password">Password</label> 
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="password" name="password" type="text" value="" @if(empty($user->password)) required @endif>
        </div>
	<!-- Person's Company -->
        @php
            $owner_entities_array = [];
            foreach($owner_entities as $entity){
                $owner_entities_array[] = $entity->entity_id;
            }
        @endphp
        <div class="col-span-4">
            @if(empty($owner_entities_array))
            <input type="hidden" name="select_option" value="">
            @endif
             <label class="block font-medium text-sm" for="entity_id">Entities</label>
             <select class="form-input rounded-md shadow-sm mt-1 block w-full" id="entity_id" name="entity_id[]" multiple onChange="this.form.submit();">
		@foreach($entities as $c)
		<option value="{{ $c->id }}" @if(in_array($c->id,$owner_entities_array)) selected @endif>{{ $c->name }}</option>
		@endforeach
		</select>
        </div>
        <div class="col-span-8">
             <label class="block font-medium text-sm" for="address">My Entities</label>
        @if(!empty($owner_entities_array))
            <ul>
            @foreach($owner_entities as $entity)
                <li>{{ $entity->entity->name }}</li>
            @endforeach
            </ul>
        @else
            <p style="color:#ef4b0e;">Please choose your entities.  If you have a single entity then it will be considered as a primary entity.</p>
        @endif
        </div>
<!--
        <div class="col-span-8">
             <label class="block font-medium text-sm" for="address">Address</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="address" name="address" type="text" value="{{ $user->address }}" >
        </div>
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="city">City</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="city" name="city" type="text" value="{{ $user->city }}" >
        </div>
        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="state_or_province">State or Province</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="state_or_province" name="state_or_province" type="text" value="{{ $user->state_or_province }}" >
        </div>

        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="country">Country</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="country" name="country" type="text" value="{{ $user->country }}" >
        </div>

        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="postal_code">Postal code</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="postal_code" name="postal_code" type="text" value="{{ $user->postal_code }}" >
        </div>

        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="work_telephone_number">Work Telephone Number</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="work_telephone_number" name="work_telephone_number" type="text" value="{{ $user->work_telephone_number }}" >
        </div>

        <div class="col-span-8 md:col-span-2">
             <label class="block font-medium text-sm" for="mobile_telephone_number">Mobile Telephone Number</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="mobile_telephone_number" name="mobile_telephone_number" type="text" value="{{ $user->mobile_telephone_number }}" >
        </div>

        <div class="col-span-8">
             <label class="block font-medium text-sm" for="notes_on_this_user">Notes on this person</label>
             <textarea class="form-input rounded-md shadow-sm mt-1 block w-full" id="notes_on_this_person" name="notes_on_this_person" type="text">{{ $user->notes_on_this_person }}</textarea>
        </div>
-->
       </div>
    </div>
<div class="clear">&nbsp;</div>

@if(Auth::user()->hasRole('admin'))
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
     <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled">
    Save
     </button>
&nbsp;&nbsp;
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
