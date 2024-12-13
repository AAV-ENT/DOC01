<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Locatii') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-end gap-2">
                        @include('management.location-partials.newLocation')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
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

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const alert = document.querySelector('.alert');
                            if (alert) {
                                setTimeout(() => {
                                    alert.remove();
                                }, 3000); // Remove after 3 seconds
                            }
                        });
                    </script>
                    
                    @forelse($user->location as $location)
                        <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $location->name }}</h3>
                                <div class="flex items-center gap-4"> 
                                    <a href="{{ route('editLocation', ['id' => $location->id]) }}"><button class="border-[2px] border-orange-500 px-3 py-1 rounded-md hover:bg-orange-500 duration-100 ease-in">Editeaza</button></a>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ __('Adresa:') }} {{ $location->address }} <br> {{ __('Oras: ') }} @php
                                
                                foreach($counties as $county) {
                                    if($location->city == $county->id) {
                                        echo $county->county_name;
                                    }
                                }

                                echo ', ';

                                foreach($cities as $city) {
                                    if($location->state == $city->id) {
                                        echo $city->location_name;
                                    }
                                }

                            @endphp</p>

                            @php
                                // Decode JSON strings into arrays
                                $startingTime = json_decode($location->startingTime, true);
                                $endingTime = json_decode($location->endingTime, true);

                                // Check if decoding failed and fallback to empty arrays
                                if (!is_array($startingTime)) {
                                    $startingTime = [];
                                }
                                if (!is_array($endingTime)) {
                                    $endingTime = [];
                                }

                                // Use array_filter for each day's schedule
                                $mondaySchedule = array_filter($startingTime, fn($daySchedule) => $daySchedule['day'] === 'Monday');
                                $tuesdaySchedule = array_filter($startingTime, fn($daySchedule) => $daySchedule['day'] === 'Tuesday');
                                $wednesdaySchedule = array_filter($startingTime, fn($daySchedule) => $daySchedule['day'] === 'Wednesday');
                                $thursdaySchedule = array_filter($startingTime, fn($daySchedule) => $daySchedule['day'] === 'Thursday');
                                $fridaySchedule = array_filter($startingTime, fn($daySchedule) => $daySchedule['day'] === 'Friday');
                                $saturdaySchedule = array_filter($startingTime, fn($daySchedule) => $daySchedule['day'] === 'Saturday');
                                $sundaySchedule = array_filter($startingTime, fn($daySchedule) => $daySchedule['day'] === 'Sunday');

                                // Extract starting times
                                // Extract ending times
                                $startTimeMonday = reset($mondaySchedule)['start_time'] ?? "-";
                                $startTimeMonday = ($startTimeMonday === "Selecteaza ora") ? "" : $startTimeMonday;

                                $startTimeTuesday = reset($tuesdaySchedule)['start_time'] ?? "-";
                                $startTimeTuesday = ($startTimeTuesday === "Selecteaza ora") ? "" : $startTimeTuesday;

                                $startTimeWednesday = reset($wednesdaySchedule)['start_time'] ?? "-";
                                $startTimeWednesday = ($startTimeWednesday === "Selecteaza ora") ? "" : $startTimeWednesday;

                                $startTimeThursday = reset($thursdaySchedule)['start_time'] ?? "-";
                                $startTimeThursday = ($startTimeThursday === "Selecteaza ora") ? "" : $startTimeThursday;

                                $startTimeFriday = reset($fridaySchedule)['start_time'] ?? "-";
                                $startTimeFriday = ($startTimeFriday === "Selecteaza ora") ? "" : $startTimeFriday;

                                $startTimeSaturday = reset($saturdaySchedule)['start_time'] ?? "-";
                                $startTimeSaturday = ($startTimeSaturday === "Selecteaza ora") ? "" : $startTimeSaturday;

                                $startTimeSunday = reset($sundaySchedule)['start_time'] ?? "-";
                                $startTimeSunday = ($startTimeSunday === "Selecteaza ora") ? "" : $startTimeSunday;



                                // Repeat the process for ending times
                                $mondaySchedule = array_filter($endingTime, fn($daySchedule) => $daySchedule['day'] === 'Monday');
                                $tuesdaySchedule = array_filter($endingTime, fn($daySchedule) => $daySchedule['day'] === 'Tuesday');
                                $wednesdaySchedule = array_filter($endingTime, fn($daySchedule) => $daySchedule['day'] === 'Wednesday');
                                $thursdaySchedule = array_filter($endingTime, fn($daySchedule) => $daySchedule['day'] === 'Thursday');
                                $fridaySchedule = array_filter($endingTime, fn($daySchedule) => $daySchedule['day'] === 'Friday');
                                $saturdaySchedule = array_filter($endingTime, fn($daySchedule) => $daySchedule['day'] === 'Saturday');
                                $sundaySchedule = array_filter($endingTime, fn($daySchedule) => $daySchedule['day'] === 'Sunday');

                                // Extract ending times
                                // Extract ending times
                                $endingTimeMonday = reset($mondaySchedule)['end_time'] ?? "-";
                                $endingTimeMonday = ($endingTimeMonday === "Selecteaza ora") ? "" : $endingTimeMonday;

                                $endingTimeTuesday = reset($tuesdaySchedule)['end_time'] ?? "-";
                                $endingTimeTuesday = ($endingTimeTuesday === "Selecteaza ora") ? "" : $endingTimeTuesday;

                                $endingTimeWednesday = reset($wednesdaySchedule)['end_time'] ?? "-";
                                $endingTimeWednesday = ($endingTimeWednesday === "Selecteaza ora") ? "" : $endingTimeWednesday;

                                $endingTimeThursday = reset($thursdaySchedule)['end_time'] ?? "-";
                                $endingTimeThursday = ($endingTimeThursday === "Selecteaza ora") ? "" : $endingTimeThursday;

                                $endingTimeFriday = reset($fridaySchedule)['end_time'] ?? "-";
                                $endingTimeFriday = ($endingTimeFriday === "Selecteaza ora") ? "" : $endingTimeFriday;

                                $endingTimeSaturday = reset($saturdaySchedule)['end_time'] ?? "-";
                                $endingTimeSaturday = ($endingTimeSaturday === "Selecteaza ora") ? "" : $endingTimeSaturday;

                                $endingTimeSunday = reset($sundaySchedule)['end_time'] ?? "-";
                                $endingTimeSunday = ($endingTimeSunday === "Selecteaza ora") ? "" : $endingTimeSunday;

                                @endphp

                                <!-- Display the schedules -->
                                <p class="text-sm text-gray-600 mt-4 dark:text-gray-400">{{ __('Ore functionare: ') }}</p>
                                <div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                                        <p class="mr-3">{{__("Luni")}}</p>
                                        <p>{{ $startTimeMonday }}</p>
                                        <p> - </p>
                                        <p>{{ $endingTimeMonday }}</p>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                                        <p class="mr-3">{{__("Marti")}}</p>
                                        <p>{{ $startTimeTuesday }}</p>
                                        <p> - </p>
                                        <p>{{ $endingTimeTuesday }}</p>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                                        <p class="mr-3">{{__("Miercuri")}}</p>
                                        <p>{{ $startTimeWednesday }}</p>
                                        <p> - </p>
                                        <p>{{ $endingTimeWednesday }}</p>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                                        <p class="mr-3">{{__("Joi")}}</p>
                                        <p>{{ $startTimeThursday }}</p>
                                        <p> - </p>
                                        <p>{{ $endingTimeThursday }}</p>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                                        <p class="mr-3">{{__("Vineri")}}</p>
                                        <p>{{ $startTimeFriday }}</p>
                                        <p> - </p>
                                        <p>{{ $endingTimeFriday }}</p>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                                        <p class="mr-3">{{__("Sambata")}}</p>
                                        <p>{{ $startTimeSaturday }}</p>
                                        <p> - </p>
                                        <p>{{ $endingTimeSaturday }}</p>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                                        <p class="mr-3">{{__("Duminica")}}</p>
                                        <p>{{ $startTimeSunday }}</p>
                                        <p> - </p>
                                        <p>{{ $endingTimeSunday }}</p>
                                    </div>
</div>

                        </div>
                    @empty
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ __('Nu aveti nici o locatie adaugata') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
