<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Servicii') }}
            </h2>
        
            {{-- <a href="#"><button class="text-white bg-green-600 px-4 py-2 rounded-md font-semibold" data-target="#ModalAddService" data-toggle="modal">Adauga serviciu</button></a> --}}
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="/create-appoitment">
                        @csrf
                        <div class="flex justify-between items-center">
                            <div>
                                <label for="service">{{ _('Selecteaza serviciul') }}</label><br>
                                <select id="serviceSelect" name="service" class="mt-2 text-lg bg-gray-800 outline-none pb-3 pl-3 w-[200px]">
                                    <option disalbe selected value="0">{{ _('Selecteaza serviciul') }}</option>
                                    @foreach($user->services as $service)
                                        <option value="{{ $service->id }}" data-duration="{{ $service->duration }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="citySelect" id="cityLabel" style="display:none;">Select City:</label>
                                <select id="citySelect" onchange="fetchLocations()" style="display:none;">
                                    <option value="">-- Select City --</option>
                                </select>
                            </div>
                            <div>
                                <label for="locationSelect" id="locationLabel" style="display:none;">Select Location:</label>
                                <select id="locationSelect" onchange="fetchDoctors()" style="display:none;">
                                    <option value="">-- Select Location --</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <div>
                                <label for="doctor">{{ _('Selecteaza doctorul') }}</label><br>
                                <select id="doctorSelect" name="doctor" disabled class="mt-2 text-lg bg-gray-800 outline-none pb-3 pl-3 w-[200px]">
                                    <option value="0">{{ _('Orice doctor') }}</option>
                                </select>
                            </div>
                            <div>
                                <label for="date">{{ _('Selecteaza data') }}</label><br>
                                @php
                                    $maxDateInTime = strtotime("+1 Year");
                                    $maxDate = date("Y-m-d", $maxDateInTime);
                                @endphp
                                <input type="date" disabled id="appointmentDate" name="date" onchange="fetchAvailableSlots()" min="{{ date("Y-m-d") }}" max="{{ $maxDate }}" class="mt-2 bg-gray-800 pb-3 pl-3 text-lg w-[200px]">
                            </div>
                            <div>
                                <label for="time">{{ _('Selecteaza ora') }}</label><br>
                                <select id="timeSelect" name="time" disabled class="mt-2 bg-gray-800 pb-3 pl-3 text-lg w-[200px]">
                                    <option value="">{{ _('Selecteaza ora') }}</option>
                                </select>
                            </div>
                        </div>
                    
                        <button type="submit">Book Appointment</button>
                    </form>
                    
                    <script>
                        document.getElementById('serviceSelect').addEventListener('change', function () {
                            const serviceId = this.value;
                            const doctorSelect = document.getElementById('doctorSelect')
                            const selectTime   = document.getElementById('appointmentDate')

                            if(serviceId == 0) {
                                doctorSelect.disabled = true;
                                selectTime.disabled = true;
                            } else {
                                doctorSelect.disabled = false;
                                selectTime.disabled = false;
                            }


                            while (doctorSelect.options.length > 0) {
                                doctorSelect.remove(0);
                            }

                            const option = document.createElement('option');
                            option.value = 0;
                            option.textContent = 'Orice doctor';
                            option.selected = true
                            doctorSelect.appendChild(option);

                            if(serviceId != 0) {

                                fetch("http://127.0.0.1:8000/api/v1/services/" + serviceId + "?includeDoctors=true")
                                    .then(response => {
                                        if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        data.data.doctor.forEach(doctor => {
                                            const option = document.createElement('option');
                                            option.value = doctor.id;
                                            option.textContent = doctor.name;
                                            doctorSelect.appendChild(option);
                                        });
                                        doctorSelect.disabled = false;

                                        const doctorId = 0;

                                        searchDateAvailable(doctorId)
                                        
                                    })       
                                    .catch(error => {
                                        console.error('Error:', error);
                                    });     
                            }
                        })

                        document.getElementById('doctorSelect').addEventListener('change', function () {
                            const doctorId = this.value 
                            console.log(doctorId)
                            searchDateAvailable(doctorId)
                        });

                        function fetchAvailability() {
                            const doctorId = document.getElementById('doctorSelect').value;
                            const locationId = document.getElementById('locationSelect').value;
                            const duration = getServiceDuration(); // Assume this function gets the service duration

                            fetch(`/api/v1/appointments/availability?doctorId=${doctorId}&locationId=${locationId}&duration=${duration}`)
                                .then(response => response.json())
                                .then(availableDates => {
                                    populateDatePicker(availableDates);
                                });
                        }

                        function populateDatePicker(dates) {
                            const datePicker = document.getElementById('datePicker');
                            datePicker.disabled = false;

                            // Allow only the dates provided by the API
                            datePicker.setAttribute('min', dates[0]);
                            datePicker.setAttribute('max', dates[dates.length - 1]);
                        }

                    </script>                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
