<section class="space-y-6">
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-service-deletion')"
    >{{ __('Sterge serviciul') }}</x-danger-button>

    <x-modal name="confirm-service-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('services.destroy', ['id' => $services->id]) }}" class="p-6">
            @csrf
            @method('delete')

            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Sterge serviciul') }}
                </h2>
        
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Serviciul va fi sters permanent.') }}
                </p>
    
                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Anuleaza') }}
                    </x-secondary-button>
    
                    <x-danger-button class="ms-3">
                        {{ __('Sterge serviciul') }}
                    </x-danger-button>
                </div>
            </div>
            
        </form>
    </x-modal>
</section>
