<section class="space-y-6">
    <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500" x-data="" x-on:click.prevent="$dispatch('open-modal', 'new-doctor')">{{ __('Adauga programare') }}</button>

    <x-modal name="new-doctor" focusable>
        <form method="post" action="{{ route('appointment.store') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Creaza o programare.') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Introdu informatii despre pacient si serviciul dorit, pentru a vizualiza datile cand se pot crea programari') }}
            </p>

            <div class="mt-6">
                <div class="mb-4">
                    <x-input-label for="name" value="{{ __('Nume pacient') }}" class="sr-only" />

                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-3/4"
                        placeholder="{{ __('Nume pacient') }}" />

                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="phone" value="{{ __('Telefon pacient') }}" class="sr-only" />

                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-3/4"
                        placeholder="{{ __('Telefon pacient') }}" />

                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="email" value="{{ __('Email pacient') }}" class="sr-only" />

                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-3/4"
                        placeholder="{{ __('Email pacient') }}" />

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                {{-- <div class="mb-4">
                    <x-input-label for="ssn" value="{{ __('CNP') }}" class="sr-only" />

                    <x-text-input id="ssn" name="ssn" type="text" class="mt-1 block w-3/4"
                        placeholder="{{ __('CNP') }}" />

                    <x-input-error :messages="$errors->get('ssn')" class="mt-2" />
                </div> --}}

                <div class="mb-4">
                    <x-input-label for="service_id" value="{{ __("Servicii") }}" />
                    <select id="service_id" name="service_id" type="text"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-3/4"
                        placeholder="{{ __('Selecteaza serviciul') }}">
                        <option disabled selected>{{ __("Selectează serviciul") }}</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach

                    </select>
                    <x-input-error :messages="$errors->get('service_id')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="appointment_type" value="{{ __("Specializare") }}" />
                    <select disabled id="appointment_type" name="appointment_type" type="text"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-3/4"
                        placeholder="{{ __('Selecteaza tipul programarii') }}">
                        <option value="0" disabled selected>{{ __("Selectează tipul programarii") }}</option>
                        <option value="T">Trimitere</option>
                        <option value="U">Urgente</option>
                        <option value="N">Normal</option>
                    </select>
                    <x-input-error :messages="$errors->get('appointment_type')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="location_id" value="{{ __('Locatia desfasurarii serviciului') }}"
                        class="sr-only" />

                    <select disabled id="location_id" name="location_id" type="text"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-3/4"
                        placeholder="{{ __('Selecteaza intai serviciul si tipul programarii') }}">
                        <option disabled selected>{{ _("Selecteaza intai serviciul si tipul programarii") }}</option>
                    </select>

                    <x-input-error :messages="$errors->get('location_id')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="doctor_id" value="{{ __("Doctor") }}" />
                    <select disabled id="doctor_id" name="doctor_id" type="text"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-3/4"
                        placeholder="{{ __('Selecteaza intai locatia') }}">
                        <option disabled selected>{{ __('Selecteaza intai locatia') }}</option>
                    </select>
                    <x-input-error :messages="$errors->get('doctor_id')" class="mt-2" />
                </div>

                <div class="relative">
                    
                    <x-input-label for="date" value="{{ __('Selectează intai informatiile anterioare') }}" class="sr-only" />

                    <input type="text" name="date" disabled id="date-selector-create" placeholder="{{ __('Selectează intai informatiile anterioare') }}"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-3/4">

                    <x-input-error :messages="$errors->get('date')" class="mt-2" />
                    
                </div>

                <div class="mb-4">
                    <x-input-label for="time" value="{{ __("Intervalul orar") }}" />
                    <select disabled id="time" name="time" type="text"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-3/4"
                        placeholder="{{ __('Selecteaza intai data') }}">
                        <option disabled selected>{{ __('Selecteaza intai data') }}</option>
                    </select>
                    <x-input-error :messages="$errors->get('time')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Creaza programare') }}
                </x-primary-button>
            </div>

            <script src="{{ asset('js/createAppointmentSteps.js') }}"></script>
        </form>
    </x-modal>
</section>
