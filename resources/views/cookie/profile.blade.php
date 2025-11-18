@extends('layouts.app')
@section('content')
    @include('dsvheader')
    @include('navbar.navbar')
    <div class="max-w-screen-xl mx-auto px-4 py-6 sm:px-6 lg:px-8 md:pb-8 space-y-4">
        <section class="bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
            <div class="relative z-1 bg-white dark:bg-neutral-800">
                <!-- Heading -->
                <div class="p-4 pb-0">
                    <div class="pb-2 flex flex-wrap justify-between items-center gap-2 border-b border-dashed border-gray-200 dark:border-neutral-700">
                        <h2 class="font-medium text-sm text-gray-800 dark:text-neutral-200">
                            Profile settings
                        </h2>
                    </div>
                </div>
                <!-- End Heading -->
                <!-- Body -->
                <div class="p-4">
                    <!-- Profile -->
                    <div class="flex items-center gap-x-3">
                        <div class="grow">
                            <h3 class="font-medium text-lg text-gray-800 dark:text-neutral-200">
                                {{ app()->make('play_user') }}
                            </h3>
                        </div>
                    </div>
                    <!-- End Profile -->
                    <!-- Grid List -->
                    <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-2">
                        <!-- Item -->
                        <div class="flex flex-col gap-y-1">
                            <span class="text-[13px] text-gray-500 dark:text-neutral-500">
                                {{__("Published presentations")}}:
                            </span>
                            <div class="flex items-center gap-x-1.5">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16.881V7.119a1 1 0 0 1 1.636-.772l5.927 4.881a1 1 0 0 1 0 1.544l-5.927 4.88A1 1 0 0 1 8 16.882Z"/>
                                </svg>
                                <span class="font-medium text-sm text-gray-800 dark:text-neutral-200">
                                    N/A
                                </span>
                            </div>
                        </div>
                        <!-- End Item -->
                        <!-- Item -->
                        <div class="flex flex-col gap-y-1">
                            <span class="text-[13px] text-gray-500 dark:text-neutral-500">
                                N/A
                            </span>
                            <div class="flex items-center gap-x-1.5">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16.881V7.119a1 1 0 0 1 1.636-.772l5.927 4.881a1 1 0 0 1 0 1.544l-5.927 4.88A1 1 0 0 1 8 16.882Z"/>
                                </svg> <span class="font-medium text-sm text-gray-800 dark:text-neutral-200">
                                    N/A
                                </span>
                            </div>
                        </div>
                        <!-- End Item -->
                        <!-- Item -->
                        <div class="flex flex-col gap-y-1">
                            <span class="text-[13px] text-gray-500 dark:text-neutral-500">
                                {{__("Group")}}
                            </span> <div class="flex items-center gap-x-1.5">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16.881V7.119a1 1 0 0 1 1.636-.772l5.927 4.881a1 1 0 0 1 0 1.544l-5.927 4.88A1 1 0 0 1 8 16.882Z"/>
                                </svg> <span class="font-medium text-sm text-gray-800 dark:text-neutral-200">
                                    {{ app()->make('play_role') }}
                                </span>
                            </div>
                        </div>
                        <!-- End Item -->
                        <!-- Item -->
                        <div class="flex flex-col gap-y-1">
                            <span class="text-[13px] text-gray-500 dark:text-neutral-500">
                                N/A
                            </span>
                            <div class="flex items-center gap-x-1.5">

                                <span class="font-medium text-sm text-gray-800 dark:text-neutral-200">
                                    N/A
                                </span>
                            </div>
                        </div>
                        <!-- End Item -->
                    </div>
                    <!-- End Grid List -->
                    <!-- Order of presentation sections -->
                    <div class="pt-5 mt-5 border-t border-gray-200 dark:border-neutral-700">
                        <!-- Heading -->
                        <div class="p-4 pb-0">
                            <h2 class="font-medium text-sm text-gray-800 dark:text-neutral-200">
                                {{ __("Order of presentations sections") }}
                            </h2>
                            
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="flex flex-col">
                                @include('cookie.presentation-order')
                            </div>
                        </div>
                    </div>
                    <!-- End Card -->
                </div>
                <!-- End Body -->
            </div>
        </section>
    </div>
    @include('layouts.darktoggler')
@endsection
