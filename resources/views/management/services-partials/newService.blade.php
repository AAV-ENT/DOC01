<section class="space-y-6">
    <x-primary-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'new-location')"
    >{{ __('Adauga serviciu nou') }}</x-primary-button>

    <x-modal name="new-location" focusable>
        <form method="post" action="{{ route('createService') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Adauga serviciu nou') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Adauga informatii despre serviciile pe care le prestezi in locatiile tale.') }}
            </p>

            <div class="mt-6">
                <div>
                    <x-input-label for="name" value="{{ __('Nume serviciu') }}" class="sr-only" />

                    <x-text-input
                        id="name"
                        name="name"
                        type="text"
                        class="mt-1 block w-3/4"
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
                    />
    
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
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-3/4">
                        @foreach($user->location as $location)
                            <option value="{{ $location->id }}"
                                {{ in_array($location->id, $selectedLocations ?? []) ? 'selected' : '' }}>
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

            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Adauga locatie noua') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</section>
