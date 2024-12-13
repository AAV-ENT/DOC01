<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Locatii') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('updateLocation', ['id' => $location->id]) }}" class="p-6">
                        @csrf
                        @method('PUT')
                        
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Editeaza locatia') }}
                        </h2>
            
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Modifica datele locatiei.') }}
                        </p>
            
                        <div class="mt-6">
                            <div>
                                <x-input-label for="name" value="{{ __('Denumeste noua locatie') }}" class="sr-only" />
            
                                <x-text-input
                                    id="name"
                                    name="name"
                                    type="text"
                                    class="mt-1 block w-3/4"
                                    value="{{ old('name', $location->name) }}"
                                    placeholder="{{ __('Introdu numele locatiei') }}"
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
                                    value="{{ old('name', $location->address) }}"
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
                                        @if($county->id == $location->city)
                                            <option selected value="{{ $county->county_code }}">{{ $county->county_name }}</option>
                                        @else
                                            <option value="{{ $county->county_code }}">{{ $county->county_name }}</option>
                                        @endif
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
                                    @php
                                        foreach($cities as $city) {
                                            if($location->state == $city->id) {
                                                echo "<option selected value='" . $city->id . "'>" . $city->location_name . "</option>";
                                            }
                                        }
                                    @endphp
                                </select>
                
                                <x-input-error :messages="$errors->get('state')" class="mt-2" />
                        </div>
                        
                        
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
                        
                            <p>Seteaza programul locatiei</p>
                            @if(session('error-location'))
                                <p class="text-sm text-red-600 dark:text-red-400 space-y-1">{{ session('error-location') }}</p>
                            @endif
                            @php
                            // Decode JSON strings into arrays
                            $startingTime = json_decode($location->startingTime, true) ?? [];
                            $endingTime = json_decode($location->endingTime, true) ?? [];
                            @endphp
                            
                            @foreach ($days as $dayEn => $dayRo)
                                <div class="grid grid-cols-5 gap-4 mb-4">
                                    <p>{{ $dayRo }}</p>
                                    <div class="flex items-center gap-2 col-span-2">
                                        <label for="startingTime_{{ $dayEn }}">Început</label>
                                        <select name="startingTime_{{ $dayEn }}" id="startingTime_{{ $dayEn }}" 
                                            class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                            <option value="" selected>Selectează ora</option>
                                            @foreach ($startingTime as $day)
                                                @if ($day['day'] === $dayEn && $day['start_time'] != "Selecteaza ora")
                                                    <option selected value="{{ $day['start_time'] }}">{{ $day['start_time'] }}</option>
                                                @endif
                                            @endforeach
                                            {!! generateTimeOptions() !!}
                                        </select>
                                    </div>
                                    <div class="flex items-center gap-2 col-span-2">
                                        <label for="endingTime_{{ $dayEn }}">Sfârșit</label>
                                        <select name="endingTime_{{ $dayEn }}" id="endingTime_{{ $dayEn }}" 
                                            class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                            <option value="" selected>Selectează ora</option>
                                            @foreach ($endingTime as $day)
                                                @if ($day['day'] === $dayEn && $day['end_time'] != "Selecteaza ora")
                                                    <option selected value="{{ $day['end_time'] }}">{{ $day['end_time'] }}</option>
                                                @endif
                                            @endforeach
                                            {!! generateTimeOptions() !!}
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
            
                        
                        <script>

                            window.onload = function() {

                                const locationId = {{ $location->city }}
                                const stateId = document.getElementById("state");

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
                            <x-primary-button class="ms-3">
                                {{ __('Modifica locatia') }}
                            </x-primary-button>
                        </div>
                        
                    </form>
                    <div class="flex justify-end mt-4">
                        @include('management.location-partials.deleteLocation')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
