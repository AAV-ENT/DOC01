<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Servicii') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('services.update', ['id' => $services->id]) }}" class="p-6">
                        @csrf
                        @method('PUT')
                        
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Editeaza serviciul') }}
                        </h2>
            
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Modifica datele serviciul, precum, pret, nume, descriere, durata, locatia.') }}
                        </p>
            
                        <div class="mt-6">
                            <div>
                                <x-input-label for="name" :value="__('Nume serviciu')" />
            
                                <x-text-input
                                    id="name"
                                    name="name"
                                    type="text"
                                    class="mt-1 block w-3/4"
                                    value="{{ old('name', $services->name) }}"
                                    placeholder="{{ __('Nume serviciu') }}"
                                />
                
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="my-4">
                                <x-input-label for="price" value="{{ __('Pretul serviciului') }}" class="sr-only" />
            
                                <x-text-input
                                    id="price"
                                    name="price"
                                    type="text"
                                    class="mt-1 block w-3/4"
                                    value="{{ old('price', $services->price) }}"
                                    placeholder="{{ __('Pretul serviciului') }}"
                                />
                
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                            <div class="my-4">
                                <x-input-label for="duration" value="{{ __('Durata serviciului') }}" class="sr-only" />
            
                                <x-text-input
                                    id="duration"
                                    name="duration"
                                    type="text"
                                    class="mt-1 block w-3/4"
                                    value="{{ old('duration', $services->duration) }}"
                                    placeholder="{{ __('Durata serviciului') }}"
                                />
                
                                <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                            </div>
                            <div class="my-4">
                                <x-input-label for="description" value="{{ __('Descrierea serviciului (optional)') }}" class="sr-only" />
            
                                <x-textarea  
                                    id="description"
                                    name="description"
                                    type="text"
                                    class="mt-1 block w-3/4"
                                    placeholder="{{ __('Descrierea serviciului (optional)') }}"                    
                                >{{ old('description', $services->description) }}</x-textarea>
                
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label value="{{ __('Selectează locatiile') }}" />
            
                                <style>
                                    .ts-control {
                                        background: rgb(17 24 39) !important;
                                        color: white !important;
            
                                        border-color: rgb(55 65 81) !important;
                                    }
            
                                    .ts-dropdown {
                                        background: rgb(17 24 39) !important;
                                        color: white !important;
            
                                        border-color: rgb(55 65 81) !important;
                                    }
            
                                    .ts-control input {
                                        color: white !important;
                                    }
            
                                </style>
            
                                <select id="location_id" name="location_id[]" multiple
                                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-3/4 text-lg">
                                    @foreach($user->location as $location)
                                        <option value="{{ $location->id }}"
                                            {{ in_array($location->id, json_decode($services->location_id) ?? []) ? 'selected' : '' }}>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
        
            
            
                                <!-- Include Tom Select -->
                                <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
                                <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
            
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        new TomSelect("#location_id", {
                                            plugins: ['checkbox_options'], // Enables checkboxes
                                            maxItems: null, // Unlimited selection
                                            hideSelected: true, // Hides selected options
                                            closeAfterSelect: false, // Dropdown remains open
                                            render: {
                                                option: function (data, escape) {
                                                    return `
                                <div class="flex items-center gap-2">
                                    <span>${escape(data.text)}</span>
                                </div>`;
                                                }
                                            }
                                        });
                                    });
            
                                </script>
                            </div>


                            {{-- <div class="mb-4">
                                <x-input-label for="location_id" value="{{ __('Locatia desfasurarii serviciului') }}" class="sr-only" />
            
                                <select 
                                    id="location_id"
                                    name="location_id"
                                    type="text"
                                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-3/4"
                                    placeholder="{{ __('Locatia desfasurarii serviciuluil') }}"
                                >
                                    <option disabled selected>{{ _("Locatia desfasurarii serviciului") }}</option>
                                    @foreach ($location as $loc)
                                        @if ($loc->id == $services->location_id)
                                            <option selected value="{{ $loc->id }}">{{ $loc->name }} | {{ $loc->address }}</option>
                                        @else
                                            <option value="{{ $loc->id }}">{{ $loc->name }} | {{ $loc->address }}</option>
                                        @endif
                                    @endforeach
                                </select>
                
                                <x-input-error :messages="$errors->get('location_id')" class="mt-2" />
                            </div> --}}
                        </div>
            
                        <div class="mt-6 flex justify-end">
                            
                            <x-primary-button class="ms-3">
                                {{ __('Modifica serviciul') }}
                            </x-primary-button>
                        </div>
                        
                    </form>

                    <div class="flex justify-end mt-4 pr-6">
                        @include('management.services-partials.deleteService')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
