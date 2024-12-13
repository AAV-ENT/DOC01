<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Servicii') }}
            </h2>
        
            {{-- <a href="#"><button class="text-white bg-green-600 px-4 py-2 rounded-md font-semibold" data-target="#ModalAddService" data-toggle="modal">Adauga serviciu</button></a> --}}
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-end gap-2">
                        @include('management.services-partials.newService')
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
                    
                    @foreach ($location as $loc)
                        @php
                            $i = 0;
                        @endphp
                            <div class="flex items-center gap-5">
                                <h4 class="text-lg">{{ $loc->name }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $loc->address }}</p>
                            </div>
                            @foreach ($user->services as $service)
                                @if(in_array($loc->id, json_decode($service->location_id)))
                                    @php
                                        $i++;
                                    @endphp
                                    <div class="mb-5 mt-2 bg-gray-100 dark:bg-gray-700 rounded-md py-3 px-8">
                                        <div class="flex justify-between items-center">
                                            <p class="text-xl font-bold">{{ $service->name }}</p>
                                            <div class="flex gap-4">
                                               <a href="{{ route('services.edit', ['id' => $service->id]) }}"><button class="border-[2px] border-orange-500 px-3 py-1 rounded-md hover:bg-orange-500 duration-100 ease-in">{{ __('Edit') }}</button></a>
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Pret') }}: {{ $service->price }} {{ __('RON') }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Durata') }}: {{ $service->duration }} {{ __('min') }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Descriere') }}: <br> <pre class="text-sm text-gray-600 dark:text-gray-400">{{ $service->description }}</pre></p>
                                    </div>
                                @endif
                            @endforeach
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
