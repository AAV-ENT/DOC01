<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @php
                $colPlacement = 1;
                $startHour = 9;
                $endHour = 21;
                $col = 0;
                $row = 0;
                @endphp
                <div class="grid grid-cols-3 grid-rows-{{abs($endHour - $startHour) / 3}} mb-5 px-3">
                    @for ($i = $startHour; $i < $endHour; $i++) @php $col++; $row++; $hourFormat=abs($endHour -
                        $startHour) / 3; @endphp <div
                        class="grid grid-rows-4 col-span-1 row-span-1 row-start-{{$row}} col-start-{{$colPlacement}} border-l-[1px] border-gray-700 @if($endHour - $hourFormat <= $i) border-r-[1px] @endif ">
                        @for ($j = 0; $j <= 3; $j++) <div
                            class="pt-5 border-gray-700 border-t-[1px] @if($col % $hourFormat == 0 && $j == 3) border-b-[1px] @endif ">
                            <p class="pl-3 font-bold dark:text-white text-black text-lg">
                                {{ $i }}:@if ($j * 15 == 0)00 @else{{ $j * 15 }} @endif
                            </p>
                </div>
                @endfor
            </div>
            @php
            if($col == $hourFormat) {
            $colPlacement++;
            $col = 0;
            }

            if($row == $hourFormat) {
            $row = 0;
            }
            @endphp
            @endfor

        </div>
        </div>
    </div> --}}

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border mb-4 border-green-400 text-green-700 px-4 py-3 rounded relative mt-4 alert" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
    
            @if(session('error'))
                <div class="bg-red-100 border mb-4 border-red-400 text-red-700 px-4 py-3 rounded relative mt-4 alert" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
        </div>

        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Include Flatpickr -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

            <div class="px-6">
                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
            <div class="flex justify-between items-center px-6 py-3">
                <!-- Date Selector -->
                <div class="relative">
                    <form action="{{ route('appointment.search') }}" method="post">
                        @csrf
                        <div class="gap-4">
                            <input type="text" name="date" id="date-selector" placeholder="Selectează data"
                                class="mt-1 px-3 py-2 w-44 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300">
                            <input type="text" name="phone" placeholder="Numar de telefon"
                                class="mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300">
                            <button class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Caută programare
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-4">
                    @include('management.appointment-partials.newAppointment')
                </div>
            </div>

            <script>
                // Initialize Flatpickr
                document.addEventListener('DOMContentLoaded', function () {
                    flatpickr("#date-selector", {
                        dateFormat: "d-m-Y",
                        onDayCreate: function (dObj, dStr, fp, dayElem) {
                            // Highlight specific days in December 2024
                            const highlightedDays = ["2024-12-01", "2024-12-15", "2024-12-25", "2024-12-31"];
                            const date = dayElem.dateObj.toISOString().split('T')[0];
            
                            if (highlightedDays.includes(date)) {
                                dayElem.style.backgroundColor = "#3b82f6"; // Blue background
                                dayElem.style.color = "white"; // White text
                                dayElem.style.borderRadius = "50%"; // Circle shape
                            }
                        }
                    });
                });
            </script>
           
                
                <div class="overflow-x-auto pt-5 relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Ora</th>
                                <th scope="col" class="px-6 py-3">Data</th>
                                <th scope="col" class="px-6 py-3">Nume</th>
                                <th scope="col" class="px-6 py-3">Telefon</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Serviciu</th>
                                <th scope="col" class="px-6 py-3">Doctor</th>
                                <th scope="col" class="px-6 py-3">Locație</th>
                                <th scope="col" class="px-6 py-3">Verificat</th>
                                <th scope="col" class="px-6 py-3">Mod verificare</th>
                                <th scope="col" class="px-6 py-3">Acțiuni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($appointments as $appointment)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">
                                        @php
                                            foreach ($services as $service) {
                                                if ($service['id'] == $appointment['service_id']) {
                                                    $duration = $service['duration'];
                                                    break;
                                                }
                                            }

                                            $hour = (int)(((int)$appointment['minute'] + $duration) / 60);
                                            $min = (int)(((int)$appointment['minute'] + $duration) % 60);

                                            echo $appointment['hour'] . ':' . $appointment['minute'] . '-' . (int)$appointment['hour'] + $hour . ':' . str_pad($min, 2, "0", STR_PAD_LEFT);
                                        @endphp
                                    </td>
                                    <td class="px-6 py-4">{{ $appointment['date'] }}</td>
                                    <td class="px-6 py-4">{{ $appointment['name'] }}</td>
                                    <td class="px-6 py-4">{{ $appointment['phone'] }}</td>
                                    <td class="px-6 py-4">{{ $appointment['email'] }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            foreach ($services as $service) {
                                                if ($service['id'] == $appointment['service_id']) {
                                                    echo $service['name'];
                                                    break;
                                                }
                                            }
                                        @endphp
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            foreach ($doctors as $doctor) {
                                                if ($doctor['id'] == $appointment['doctor_id']) {
                                                    echo $doctor['name'];
                                                    break;
                                                }
                                            }
                                        @endphp
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            foreach ($location as $loc) {
                                                if ($loc['id'] == $appointment['location_id']) {
                                                    echo $loc['name'];
                                                    break;
                                                }
                                            }
                                        @endphp
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($appointment['confirmed'] === 'Yes')    
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Da</span>
                                        @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">Nu</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($appointment['confirmed'] === 'Yes')
                                            {{ $appointment['confirmation_type'] }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <button class="text-blue-600 hover:underline dark:text-blue-500">Editare</button>
                                        <button class="text-red-600 hover:underline dark:text-red-500 ml-2">Ștergere</button>
                                    </td>
                                </tr>
                            @empty
                                <p class="dark:text-white font-bold mb-4 ml-3 text-lg">Nu sunt programari in aceasta zi</p>
                            @endforelse
                            
                            <!-- Additional rows can be added here -->
                        </tbody>
                        
                    </table>
                </div>                
            </div>
        </div>
    </div>
    
</x-app-layout>
