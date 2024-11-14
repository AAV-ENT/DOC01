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
                    <form method="post" action="{{ route('createService') }}">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Nume serviciu')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="my-5">
                            <x-input-label for="price" :value="__('Preț (in RON)')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="text" name="price" required autofocus autocomplete="price" />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="duration" :value="__('Durată (in minute)')" />
                            <x-text-input id="duration" class="block mt-1 w-full" type="text" name="duration" required autofocus autocomplete="duration" />
                            <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                        </div>

                        <x-primary-button class="mt-4">
                            {{ __('Adauga serviciu') }}
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
                        @forelse($user->services as $service)
                            <div class="bg-gray-100 dark:bg-gray-900 rounded-md py-3 px-8">
                                <p class="text-xl font-bold">{{ $service->name }}</p>
                                <div class="py-4">
                                    <p>{{ __('Pret') }}: {{ $service->price }} {{ __('RON') }}</p>
                                    <p>{{ __('Durata') }}: {{ $service->duration }} {{ __('min') }}</p>
                                </div>
                                <div class="flex gap-4">
                                    <button class="bg-blue-600 px-2 py-1 rounded-md">{{ __('Edit') }}</button>
                                    <button class="bg-red-600 px-2 py-1 rounded-md">{{ __('Sterge') }}</button>
                                </div>
                            </div>
                        @empty
                            <li class="text-gray-500 italic">{{ __('Niciun serviciu adăugat') }}</li>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
