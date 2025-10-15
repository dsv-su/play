<div class="w-full mb-2 p-2 sm:p-3 md:p-4
            dark:bg-gray-800 dark:border-gray-700">
@php
    if (!function_exists('badge')) {
        function badge($text, $color = 'blue') {
            return '<span class="bg-'.$color.'-100 text-'.$color.'-800 text-normal font-medium me-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-'.$color.'-400 border border-'.$color.'-400">' . $text . '</span>';
        }
    }

    $labels = [
        'upload' => isset($video) ? badge(__("New: ")) . 'Upload Presentation' : badge(__("New Upload")),
        'edit'   => isset($video) ? badge(__("Edit: "), 'green') . $video->title : __("Edit"),
    ];
@endphp

<!-- Title + Info -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 md:gap-3">
        <!-- Title -->
        <h2 class="text-lg sm:text-xl text-gray-900 dark:text-white flex-1 min-w-0">
            <span class="break-words">{!! $labels[$type] ?? __("Presentation") !!}</span>
            {{--}}<small class="text-gray-500 dark:text-gray-400 ml-1 hidden sm:inline">[ {{$video->id ?? ''}} ]</small>{{--}}
        </h2>

        <!-- Info -->
        @if(in_array($type, ['edit']))
        <div class="w-full md:w-1/3 bg-blue-50 border border-gray-200 rounded-lg p-2 sm:p-3 dark:bg-blue-500">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 sm:gap-3">
                <!-- Duration -->
                <div class="flex flex-col gap-y-1 min-w-0">
                    <label for="duration" class="font-sans text-xs sm:text-sm font-medium text-gray-900 dark:text-white">
                        {{ __("Duration:") }}
                    </label>
                    <div class="flex items-center">
                        <span class="px-1.5 py-0 text-[0.8125rem]/5 font-medium text-white bg-gray-800
                                    border border-gray-800 rounded shadow-md inline-flex items-center gap-1 truncate">
                            {{$video->duration}}
                        </span>
                    </div>
                </div>

                <!-- Origin -->
                <div class="flex flex-col gap-y-1 min-w-0">
                    <label for="title_sv" class="font-sans text-xs sm:text-sm font-medium text-gray-900 dark:text-white">
                        {{ __("Origin:") }}
                        <button id="origin-button" data-modal-toggle="origin-modal" type="button" aria-label="{{ __('More info about origin') }}">
                            <svg class="w-4 h-4 inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </button>
                    </label>
                    <div class="flex items-center">
                        <span class="px-1.5 py-0 text-[0.8125rem]/5 font-medium text-gray-900
                                    border border-gray-800 rounded shadow-md inline-flex items-center gap-1 truncate">
                            @switch($video->origin)
                                @case('mediasite') {{ __("Mediasite") }} @break
                                @case('cattura')   {{ __("DSV") }} @break
                                @case('manual')    {{ __("Uploaded") }} @break
                                @default           {{ __("Unknown") }}
                            @endswitch
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

