<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Doctori') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-end">
                    @include('management.doctor-partials.newDoctor')
                </div>
            </div>
        </div>
    </div>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @foreach ($location as $loc)
                        @php
                            $i = 0;
                        @endphp
                            <div class="flex items-center gap-5">
                                <h4 class="text-lg">{{ $loc->name }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $loc->address }}</p>
                            </div>
                            <div class="grid md:grid-cols-2 grid-cols-1 gap-10 my-2">
                            @foreach ($user->doctor as $doctor)
                                @if ($doctor->location_id == $loc->id)
                                    @php
                                        $i++;
                                    @endphp
                                    
                                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $doctor->name }}</h3>
                                                    <p class="text-black dark:text-white">{{ $doctor->doctor_type }}</p>
                                                </div>
                                                <div>
                                                    <a href="{{ route('doctor.edit', ['id' => $doctor->id]) }}"><button class="border-[2px] border-orange-500 mt-3 px-3 py-1 rounded-md hover:bg-orange-500 duration-100 ease-in">{{ __('Edit') }}</button></a>
                                                </div>
                                            </div>
                                            {{-- <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ __('Servicii:') }}</p>
                                            <ul class="list-disc list-inside text-sm text-gray-700 dark:text-gray-300">
                                                @forelse($doctor->services as $service)
                                                    <li>{{ $service->name }}</li>
                                                @empty
                                                    <li class="text-gray-500 italic">{{ __('Niciun serviciu adăugat') }}</li>
                                                @endforelse
                                            </ul> --}}
                                        </div>
                                    
                                @endif
                            @endforeach
                        </div>
                            @php
                                if($i == 0) {
                                    echo '<div class="mb-5 mt-2 bg-gray-100 dark:bg-gray-700 rounded-md py-3 px-8">';
                                        echo '<p class="font-bold">Locatia nu are servicii adaugate</p>';
                                    echo '</div>';
                                }
                            @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
