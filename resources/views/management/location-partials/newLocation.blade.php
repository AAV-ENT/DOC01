<section class="space-y-6">
    <x-primary-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'new-location')"
    >{{ __('Adauga locatie noua') }}</x-primary-button>

    <x-modal name="new-location" focusable>
        <form method="post" action="{{ route('storeLocation') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Adauga o locatie noua') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('O locatie reprezinta un punct de lucru intr-un oras. In cazul in care aveti mai multe puncte de lucru, repeta actiunea pentru fiecare.') }}
            </p>

            <div class="mt-6">
                <div>
                    <x-input-label for="name" value="{{ __('Denumeste noua locatie') }}" class="sr-only" />

                    <x-text-input
                        id="name"
                        name="name"
                        type="text"
                        class="mt-1 block w-3/4"
                        placeholder="{{ __('Denumeste noua locatie') }}"
                    />
    
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="my-4">
                    <x-input-label for="address" value="{{ __('Adresa locatiei') }}" class="sr-only" />

                    <x-text-input
                        id="address"
                        name="address"
                        type="text"
                        class="mt-1 block w-3/4"
                        placeholder="{{ __('Adresa locatiei') }}"
                    />
    
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="city" value="{{ __('Selecteaza judetul') }}" class="sr-only" />

                    <select 
                        id="city"
                        name="city"
                        type="text"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-3/4"
                        placeholder="{{ __('Selecteaza judetul') }}"
                    >
                        <option disabled selected>{{ _("Selecteaza judetul") }}</option>
                        @foreach ($counties as $county)
                            <option value="{{ $county->county_code }}">{{ $county->county_name }}</option>
                        @endforeach
                    </select>
    
                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="state" value="{{ __('Selecteaza localitate') }}" class="sr-only" />

                    <select 
                        id="state"
                        name="state"
                        type="text"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-3/4"
                        placeholder="{{ __('Selecteaza localitate') }}"
                    >
                        <option disabled selected>{{ _("Selecteaza localitate") }}</option>
                    </select>
    
                    <x-input-error :messages="$errors->get('state')" class="mt-2" />
                </div>

                <div>
  
                    @php
                        function generateTimeOptions() {
                            $options = '';
                            $startTime = strtotime('00:00');
                            $endTime = strtotime('23:45');
    
                            while ($startTime <= $endTime) {
                                $time = date('H:i', $startTime);
                                $options .= "<option value='{$time}'>{$time}</option>";
                                $startTime = strtotime('+15 minutes', $startTime);
                            }
    
                            return $options;
                        }
                    @endphp
                    
                    <div id="scheduleContainer" class="mt-4">
                        @php
                            $days = [
                                'Monday' => 'Luni',
                                'Tuesday' => 'Marți',
                                'Wednesday' => 'Miercuri',
                                'Thursday' => 'Joi',
                                'Friday' => 'Vineri',
                                'Saturday' => 'Sâmbătă',
                                'Sunday' => 'Duminică'
                            ];
                        @endphp
                    
                        <p>Seteaza programul locatiei</p>
                        @if(session('error-location'))
                            <p class="text-sm text-red-600 dark:text-red-400 space-y-1">{{ session('error-location') }}</p>
                        @endif
                        @foreach ($days as $dayEn => $dayRo)
                            <div class="grid grid-cols-5 gap-4 mb-4">
                                <p>{{ $dayRo }}</p>
                                <div class="flex items-center gap-2 col-span-2">
                                    <label for="startingTime_{{ $dayEn }}">Început</label>
                                    <select name="startingTime_{{ $dayEn }}" id="startingTime_{{ $dayEn }}" 
                                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option selected>Selecteaza ora</option>
                                        {!! generateTimeOptions() !!}
                                    </select>
                                </div>
                                <div class="flex items-center gap-2 col-span-2">
                                    <label for="endingTime_{{ $dayEn }}">Sfârșit</label>
                                    <select name="endingTime_{{ $dayEn }}" id="endingTime_{{ $dayEn }}" 
                                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option selected>Selecteaza ora</option>
                                        {!! generateTimeOptions() !!}
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- <div class="mb-4">
                    <x-input-label for="startingTime" value="{{ __('Ora deschidere') }}" class="sr-only" />

                    <select 
                        id="startingTime"
                        name="startingTime"
                        type="text"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-3/4"
                        placeholder="{{ __('Ora deschidere') }}"
                    >
                        <option disabled selected>{{ _("Ora deschidere") }}</option>
                        @for ($hour = 0; $hour < 24; $hour++)
                            @foreach (['00', '15', '30', '45'] as $minute)
                                <option value="{{ sprintf('%02d:%s', $hour, $minute) }}">
                                    {{ sprintf('%02d:%s', $hour, $minute) }}
                                </option>
                            @endforeach 
                        @endfor
                    </select>
    
                    <x-input-error :messages="$errors->get('startingTime')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="endingTime" value="{{ __('Ora inchidere') }}" class="sr-only" />

                    <select 
                        id="endingTime"
                        name="endingTime"
                        type="text"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-3/4"
                        placeholder="{{ __('Ora inchidere') }}"
                    >
                        <option disabled selected>{{ _("Ora inchidere") }}</option>
                        @for ($hour = 0; $hour < 24; $hour++)
                            @foreach (['00', '15', '30', '45'] as $minute)
                                <option value="{{ sprintf('%02d:%s', $hour, $minute) }}">
                                    {{ sprintf('%02d:%s', $hour, $minute) }}
                                </option>
                            @endforeach 
                        @endfor
                    </select>
    
                    <x-input-error :messages="$errors->get('endingTime')" class="mt-2" />
                </div> --}}
            </div>

            <script>
                document.getElementById('city').addEventListener('change', function () {
                    const locationId = this.value;
                    const stateId = document.getElementById("state");

                    while (stateId.options.length > 0) {
                        stateId.remove(0);
                    }

                    const option = document.createElement('option');
                    option.value = 0;
                    option.textContent = 'Selecteaza localitatea';
                    option.selected = true
                    stateId.appendChild(option);

                    console.log(locationId);
                    

                    if(locationId != 0) {

                        fetch("http://127.0.0.1:8000/api/v1/cities?county_code[eq]=" + locationId)
                            .then(response => {
                                if (!response.ok) {
                                throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                data.data.forEach(location => {
                                    const option = document.createElement('option');
                                    option.value = location.id;
                                    option.textContent = location.name;
                                    stateId.appendChild(option);
                                });

                            })       
                            .catch(error => {
                                console.error('Error:', error);
                            });     
                    }
                })
            </script>

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
