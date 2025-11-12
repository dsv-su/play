<div x-ref="navigationDropdown" x-show="navigationMenuOpen"
     x-transition:enter="transition ease-out duration-100"
     x-transition:enter-start="opacity-0 scale-90"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-100"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-90"
     @mouseover="navigationMenuClearCloseTimeout()" @mouseleave="navigationMenuLeave()"
     class="absolute top-0 pt-3 -translate-x-1/2 translate-y-11 hidden md:block" x-cloak>
    <div class="flex justify-center w-auto h-auto overflow-hidden bg-white border rounded-md shadow-sm border-neutral-200/70">
        <!-- Dropdown content for "Navigation" -->
        <div x-show="navigationMenu == 'getting-started'" class="flex items-stretch justify-center w-full max-w-2xl p-6 gap-x-3">
            {{--}}
            <div class="flex-shrink-0 w-48 rounded pt-28 pb-7 bg-gradient-to-br from-neutral-800 to-black">
                <div class="relative px-7 space-y-1.5 text-white">
                    <svg class="block w-auto h-9" viewBox="0 0 180 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M67.683 89.217h44.634l30.9 53.218H36.783l30.9-53.218Z" fill="currentColor"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M77.478 120.522h21.913v46.956H77.478v-46.956Zm-34.434-29.74 45.59-78.26 46.757 78.26H43.044Z" fill="currentColor"/>
                    </svg>
                    <span class="block font-bold">Playback</span>
                    <span class="block text-sm opacity-60">Play at DSV</span>
                </div>
            </div>
            {{--}}
            <div class="w-72">
                <a href="{{route('my.presentations')}}" @click="navigationMenuClose()"
                   class="block px-3.5 py-3 text-sm rounded
                          hover:bg-neutral-100 dark:hover:bg-white/10
                          transition-colors duration-150">
                    <span class="block mb-1 font-medium text-gray-900 dark:text-gray-600">
                        {{ __("My Presentations") }}
                    </span>

                    @if(in_array(app()->make('play_auth'), ['Administrator', 'Staff']))
                        <span class="block font-light leading-5 text-gray-600 dark:text-gray-600">
                            {{__('Here you can navigate among presentations from your teaching activities sorted after course.')}}
                        </span>
                    @elseif(app()->make('play_auth') == 'Student')
                        <span class="block font-light leading-5 text-gray-600 dark:text-gray-600">
                            {{__('Here you can navigate among presentations from your registed course sorted after course.')}}
                        </span>
                    @endif

                </a>
                {{--}}<a href="#_" @click="navigationMenuClose()" class="block px-3.5 py-3 text-sm rounded hover:bg-neutral-100">
                    <span class="block mb-1 font-medium text-black">Course</span>
                    <span class="block leading-5 opacity-50">Here you can navigate among presentations from your teaching activities by course.</span>
                </a>{{--}}
                {{--}}<a href="#_" @click="navigationMenuClose()" class="block px-3.5 py-3 text-sm rounded hover:bg-neutral-100">
                    <span class="block mb-1 font-medium text-black">Chanel</span>
                    <span class="block leading-5 opacity-50">Here you can navigate among presentations from your teaching activities by chanel.</span>
                </a>{{--}}
            </div>
        </div>
        <!-- Dropdown content for "Manage" -->
        <div x-show="navigationMenu == 'learn-more'" class="flex items-stretch justify-center w-full p-6">
            <div class="w-72">
                {{--}}<a href="#_" @click="navigationMenuClose()" class="block px-3.5 py-3 text-sm rounded hover:bg-neutral-100">
                    <span class="block mb-1 font-medium text-black">Manage Presentations</span>
                    <span class="block font-light leading-5 opacity-50">Here you can manage your presentations.</span>
                </a>
                <a href="#_" @click="navigationMenuClose()" class="block px-3.5 py-3 text-sm rounded hover:bg-neutral-100">
                    <span class="block mb-1 font-medium text-black">Manage Courses</span>
                    <span class="block font-light leading-5 opacity-50">Here you can manage your courses.</span>
                </a>{{--}}
                <a href="{{route('presentation.upload')}}" @click="navigationMenuClose()" class="block px-3.5 py-3 text-sm rounded hover:bg-neutral-100">
                    <span class="block mb-1 font-medium text-black">{{__('Manual Upload')}}</span>
                    <span class="block leading-5 opacity-50">{{__('Upload a presentation and associate it with a course.')}}</span>
                </a>
            </div>
            {{--}}<div class="w-72">
                <a href="#_" @click="navigationMenuClose()" class="block px-3.5 py-3 text-sm rounded hover:bg-neutral-100">
                    <span class="block mb-1 font-medium text-black">Manage a channel</span>
                    <span class="block font-light leading-5 opacity-50">Here you can manage a channel</span>
                </a>
                <a href="#_" @click="navigationMenuClose()" class="block px-3.5 py-3 text-sm rounded hover:bg-neutral-100">
                    <span class="block mb-1 font-medium text-black">Help</span>
                    <span class="block leading-5 opacity-50">Get Help for the most used cases.</span>
                </a>
                <a href="#_" @click="navigationMenuClose()" class="block px-3.5 py-3 text-sm rounded hover:bg-neutral-100">
                    <span class="block mb-1 font-medium text-black">Delete</span>
                    <span class="block leading-5 opacity-50">Settings.</span>
                </a>
            </div>{{--}}
        </div>
    </div>
</div>
