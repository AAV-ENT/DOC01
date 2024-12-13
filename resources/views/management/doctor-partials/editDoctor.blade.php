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
                    <form method="POST" action="{{ route('doctor.update', ['id' => $doctor->id]) }}" class="p-6">
                        @csrf
                        @method('PUT')
                        
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Editeaza locatia') }}
                        </h2>
            
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Modifica datele locatiei.') }}
                        </p>
            
                        <div class="mt-6">
                            <div class="mb-4">
                                <x-input-label for="name" value="{{ __('Nume doctor') }}" class="sr-only" />
            
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-3/4"
                                    placeholder="{{ __('Nume doctor') }}" value="{{ $doctor->name }}" />
            
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
            
                            <div class="mb-4">
                                <x-input-label for="doctor_type" value="{{ __("Specializare") }}" />
                                <select id="doctor_type" name="doctor_type" type="text"
                                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-3/4"
                                    placeholder="{{ __('Selecteaza specializarea') }}">
                                    <option disabled selected>{{ __("Selectează tipul de medic sau specialist") }}</option>
                                    <option value="{{ $doctor->doctor_type }}" selected>{{ $doctor->doctor_type }}</option>
                                    <optgroup label="Medicină Generală și Medicină de Familie">
                                        <option value="Medic de familie">Medic de familie</option>
                                        <option value="Medic generalist">Medic generalist</option>
                                    </optgroup>
            
                                    <optgroup label="Specialități Clinice">
                                        <option value="Medic Medicină Internă">Medic Medicină Internă</option>
                                        <option value="Cardiolog">Cardiolog</option>
                                        <option value="Gastroenterolog">Gastroenterolog</option>
                                        <option value="Nefrolog">Nefrolog</option>
                                        <option value="Pneumolog">Pneumolog</option>
                                        <option value="Reumatolog">Reumatolog</option>
                                        <option value="Endocrinolog">Endocrinolog</option>
                                        <option value="Oncolog">Oncolog</option>
                                        <option value="Dermatolog">Dermatolog</option>
                                        <option value="Neurolog">Neurolog</option>
                                        <option value="Psihiatru">Psihiatru</option>
                                        <option value="Alergolog">Alergolog</option>
                                        <option value="Infecționist">Infecționist</option>
                                        <option value="Diabetolog">Diabetolog</option>
                                        <option value="Hematolog">Hematolog</option>
                                    </optgroup>
            
                                    <optgroup label="Specialități Chirurgicale">
                                        <option value="Chirurg General">Chirurg General</option>
                                        <option value="Ortoped">Ortoped</option>
                                        <option value="Neurochirurg">Neurochirurg</option>
                                        <option value="Chirurg Cardiovascular">Chirurg Cardiovascular</option>
                                        <option value="Chirurg Plastician">Chirurg Plastician</option>
                                        <option value="Chirurg Pediatric">Chirurg Pediatric</option>
                                        <option value="Chirurg Vascular">Chirurg Vascular</option>
                                    </optgroup>
            
                                    <optgroup label="Specialități Obstetricale și Ginecologice">
                                        <option value="Obstetrician-Ginecolog">Obstetrician-Ginecolog</option>
                                    </optgroup>
            
                                    <optgroup label="Specialități Pediatrice">
                                        <option value="Pediatru">Pediatru</option>
                                        <option value="Neonatolog">Neonatolog</option>
                                    </optgroup>
            
                                    <optgroup label="Medicină Dentară și Stomatologie">
                                        <option value="Medic Dentist">Medic Dentist</option>
                                        <option value="Ortodont">Ortodont</option>
                                        <option value="Chirurg Oral">Chirurg Oral</option>
                                        <option value="Endodont">Endodont</option>
                                        <option value="Parodontolog">Parodontolog</option>
                                    </optgroup>
            
                                    <optgroup label="Specialități de Recuperare și Reabilitare">
                                        <option value="Kinetoterapeut">Kinetoterapeut</option>
                                        <option value="Fizioterapeut">Fizioterapeut</option>
                                        <option value="Terapeut Ocupațional">Terapeut Ocupațional</option>
                                    </optgroup>
            
                                    <optgroup label="Specialități de Diagnostic">
                                        <option value="Radiolog">Radiolog</option>
                                        <option value="Imagist">Imagist</option>
                                        <option value="Anatomopatolog">Anatomopatolog</option>
                                        <option value="Laborant">Laborant</option>
                                    </optgroup>
            
                                    <optgroup label="Specialități Anestezice și de Terapie Intensivă">
                                        <option value="Anestezist">Anestezist</option>
                                        <option value="Specialist Terapie Intensivă">Specialist Terapie Intensivă</option>
                                    </optgroup>
            
                                    <optgroup label="Medicină Alternativă și Complementară">
                                        <option value="Naturopat">Naturopat</option>
                                        <option value="Homeopat">Homeopat</option>
                                        <option value="Acupuncturist">Acupuncturist</option>
                                    </optgroup>
                                </select>
                                <x-input-error :messages="$errors->get('doctor_type')" class="mt-2" />
                            </div>
            
                            <div class="mb-4">
                                <x-input-label value="{{ __('Selectează servicii') }}" />
            
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
            
                                <select id="services" name="services[]" multiple
                                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-3/4">
                                    @foreach($user->services as $service)
                                        <option value="{{ $service->id }}"
                                            {{ in_array($service->id, $selectedServices) ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
        
            
            
                                <!-- Include Tom Select -->
                                <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
                                <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
            
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        new TomSelect("#services", {
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
            
                            <div class="mb-4">
                                <x-input-label for="location_id" value="{{ __('Locatia desfasurarii serviciului') }}"
                                    class="sr-only" />
            
                                <select id="location_id" name="location_id" type="text"
                                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-3/4"
                                    placeholder="{{ __('Locatia desfasurarii serviciuluil') }}">
                                    <option disabled selected>{{ _("Locatia desfasurarii serviciului") }}</option>
                                    @foreach ($location as $loc)
                                        @if ($loc->id == $doctor->location_id)
                                            <option selected value="{{ $loc->id }}">{{ $loc->name }} | {{ $loc->address }}</option>
                                        @else
                                            <option value="{{ $loc->id }}">{{ $loc->name }} | {{ $loc->address }}</option>
                                        @endif
                                    @endforeach
                                </select>
            
                                <x-input-error :messages="$errors->get('location_id')" class="mt-2" />
                            </div>
            
                            <div>
                                <div>
                                    <input type="checkbox" name="otherProgram" id="otherProgram" value="1" class="mr-2" @if ($selectedLocation->startingTime == $doctor->startingTime && $selectedLocation->endingTime == $doctor->endingTime)
                                        checked
                                    @endif>
                                    <label for="otherProgram">{{ __("Medicul are alt program față de programul locației?") }}</label>
                                </div><br>

                                <div id="scheduleContainer" class="
                                    hidden
                                ">
                                    @if(session('error-location'))
                                        <p class="text-sm text-red-600 dark:text-red-400 space-y-1">{{ session('error-location') }}</p>
                                    @endif
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
    
                                    // Decode JSON strings into arrays
                                    $startingTime = json_decode($doctor->startingTime, true) ?? [];
                                    $endingTime = json_decode($doctor->endingTime, true) ?? [];
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
                                    document.addEventListener('DOMContentLoaded', function () {
                                        const otherProgramCheckbox = document.getElementById('otherProgram');
                                        const scheduleContainer = document.getElementById('scheduleContainer');

                                        const doctorStartTime = '{{ $doctor->startingTime }}'
                                        const doctorEndTime   = '{{ $doctor->endingTime }}'
                                        const locationStartTime = '{{ $selectedLocation->startingTime }}'
                                        const locationEndTime   = '{{ $selectedLocation->endingTime }}'

                                        if(doctorStartTime === locationStartTime && doctorEndTime === locationEndTime) {
                                            otherProgramCheckbox.checked = false
                                            scheduleContainer.classList.add('hidden');
                                        } else {
                                            otherProgramCheckbox.checked = true
                                            scheduleContainer.classList.remove('hidden');
                                        }

                                        if(otherProgramCheckbox.checked) {
                                            scheduleContainer.classList.remove('hidden');
                                        }
            
                                        otherProgramCheckbox.addEventListener('change', function () {
                                            if (this.checked) {
                                                scheduleContainer.classList.remove('hidden');
                                            } else {
                                                scheduleContainer.classList.add('hidden');
                                            }
                                        });
        
                                        const form = document.querySelector('form');
                                        form.addEventListener('submit', function (e) {
                                            const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                            const startingTimes = [];
                                            const endingTimes = [];
        
                                            days.forEach(day => {
                                                const isWorkingDay = document.querySelector(`#workingDay_${day}`).checked;
                                                const startTime = document.querySelector(`#startingTime_${day}`).value;
                                                const endTime = document.querySelector(`#endingTime_${day}`).value;
        
                                                if (isWorkingDay) {
                                                    startingTimes.push(startTime);
                                                    endingTimes.push(endTime);
                                                } else {
                                                    startingTimes.push('-');
                                                    endingTimes.push('-');
                                                }
                                            });
        
                                            // Add these arrays to hidden inputs
                                            const startingInput = document.createElement('input');
                                            startingInput.type = 'hidden';
                                            startingInput.name = 'startingTime';
                                            startingInput.value = startingTimes.join(',');
        
                                            const endingInput = document.createElement('input');
                                            endingInput.type = 'hidden';
                                            endingInput.name = 'endingTime';
                                            endingInput.value = endingTimes.join(',');
        
                                            form.appendChild(startingInput);
                                            form.appendChild(endingInput);
                                        });
                                    });
            
                                </script>
                            </div>
                            
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-primary-button class="ms-3">
                                {{ __('Salveaza noile informatii') }}
                            </x-primary-button>
                        </div>
                        
                    </form>
                    <div class="flex justify-end mt-4 pr-6">
                        @include('management.doctor-partials.deleteDoctor')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
