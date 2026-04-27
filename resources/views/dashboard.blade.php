<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    <div class="clear">&nbsp;</div>
                    @php
                        $owner_entities_array = [];
                        $owner_entities=\App\Models\OwnerEntity::where('user_id',auth()->user()->id)->get();
                        foreach($owner_entities as $ent){
                            $owner_entities_array[] =  $ent->entity_id;
                        }
                        //print_r($owner_entities);
                    @endphp

            <div class="overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6 text-gray-900">
                    <div class="grid grid-cols-6 gap-6">

                    <form name="save-current-entity" action="/admin/save_current_entity" method="post">
                    @csrf
                    <div class="col-span-3">
                        <label class="block font-medium " for="address">Choose your current Entity</label>
                             @if(!empty($owner_entities_array))
                                 @foreach($owner_entities as $entity)
                                     <input type="radio" value="{{ $entity->entity_id }}" name="entity_id" @if($entity->primary_entity == 1) checked @endif> {{ $entity->entity->name }} <br />
                                 @endforeach
                             @else
                                 <p style="color:#ef4b0e;">Please choose your entities then select primary entity. If you have a single entity then it will be considered as a current entity.</p>
                             @endif
                    </div>
                    <div class="col-span-3">
                        <div class="flex items-center justify-end px-4 py-3 text-left sm:px-6">
     <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled">
    Save
     </button>
                    </form>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
