<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
                @php 
                    $colPlacement = 1; 
                    $startHour = 9;
                    $endHour = 21;    
                    $col = 0;
                    $row = 0;
                @endphp
                <div class="grid grid-cols-3 grid-rows-{{abs($endHour - $startHour) / 3}} mb-5 px-3">
                    @for ($i = $startHour; $i < $endHour; $i++)
                        @php 
                            $col++;
                            $row++;
                            $hourFormat = abs($endHour - $startHour) / 3;
                        @endphp
                        
                        <div class="grid grid-rows-4 col-span-1 row-span-1 row-start-{{$row}} col-start-{{$colPlacement}} border-l-[1px] border-gray-700 @if($endHour - $hourFormat <= $i) border-r-[1px] @endif ">
                            @for ($j = 0; $j <= 3; $j++)
                            <div class="pt-5 border-gray-700 border-t-[1px] @if($col % $hourFormat == 0 && $j == 3) border-b-[1px] @endif ">
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
        </div>
    </div>
</x-app-layout>
