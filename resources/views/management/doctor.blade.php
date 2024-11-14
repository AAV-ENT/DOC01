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
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Form to Add a New Doctor -->
                    <form method="post" action="{{ route('storeDoctor') }}">
                        @csrf

                        <!-- Doctor Name Input -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nume doctor')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Services Selection -->
                        <div class="mb-4">
                            <x-input-label :value="__('Selectează servicii')" />
                            <div class="mt-2 grid grid-cols-2 gap-2">
                                @foreach($user->services as $service)
                                    <div class="flex items-center">
                                        <input type="checkbox" id="service-{{ $service->id }}" name="services[]" value="{{ $service->id }}" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="service-{{ $service->id }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $service->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <x-primary-button class="mt-4">
                            {{ __('Adauga doctor') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid xl:grid-cols-5 md:grid-cols-3 grid-cols-1 gap-10">
                        <!-- Display List of Doctors -->
                        @forelse($user->doctor as $doctor)
                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $doctor->name }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ __('Doctori:') }}</p>
                                <ul class="list-disc list-inside text-sm text-gray-700 dark:text-gray-300">
                                    @forelse($doctor->services as $service)
                                        <li>{{ $service->name }}</li>
                                    @empty
                                        <li class="text-gray-500 italic">{{ __('Niciun serviciu adăugat') }}</li>
                                    @endforelse
                                </ul>
                            </div>
                            @empty
                                <li class="text-gray-500 italic">{{ __('Niciun doctor adăugat') }}</li>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
