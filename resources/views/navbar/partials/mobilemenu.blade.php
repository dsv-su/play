<div x-show="mobileMenuOpen" class="md:hidden">
    <ul class="px-2 pt-2 pb-3 space-y-1">
        <!-- Mobile Dropdown for "Navigation" -->
        <li>
            <button @click="activeMobileMenu = activeMobileMenu === 'getting-started' ? '' : 'getting-started'" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-neutral-700 hover:bg-neutral-100 dark:text-white">
                {{__("Navigation")}}
                <svg :class="{ 'rotate-180': activeMobileMenu === 'getting-started' }" class="inline-block h-4 w-4 ml-2 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="activeMobileMenu === 'getting-started'" class="pl-4 space-y-1" x-transition>
                <a href="{{route('my.presentations')}}" @click="mobileMenuOpen = false; activeMobileMenu = ''" class="block px-3 py-2 rounded-md text-base font-medium text-neutral-700 hover:bg-neutral-100 dark:text-white">
                    {{__("My Presentations")}}
                </a>
                {{--}}<a href="#_" @click="mobileMenuOpen = false; activeMobileMenu = ''" class="block px-3 py-2 rounded-md text-base font-medium text-neutral-700 hover:bg-neutral-100 dark:text-white">
                    Course
                </a>
                <a href="#_" @click="mobileMenuOpen = false; activeMobileMenu = ''" class="block px-3 py-2 rounded-md text-base font-medium text-neutral-700 hover:bg-neutral-100 dark:text-white">
                    Channel
                </a>{{--}}
            </div>
        </li>
        <!-- Mobile Dropdown for "Manage" -->
        @can('manage-content')
        <li>
            <button @click="activeMobileMenu = activeMobileMenu === 'learn-more' ? '' : 'learn-more'" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-neutral-700 hover:bg-neutral-100 dark:text-white">
                Manage
                <svg :class="{ 'rotate-180': activeMobileMenu === 'learn-more' }" class="inline-block h-4 w-4 ml-2 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="activeMobileMenu === 'learn-more'" class="pl-4 space-y-1" x-transition>
                {{--}}<a href="#_" @click="mobileMenuOpen = false; activeMobileMenu = ''" class="block px-3 py-2 rounded-md text-base font-medium text-neutral-700 hover:bg-neutral-100 dark:text-white">
                    Presentation
                </a>
                <a href="#_" @click="mobileMenuOpen = false; activeMobileMenu = ''" class="block px-3 py-2 rounded-md text-base font-medium text-neutral-700 hover:bg-neutral-100 dark:text-white">
                    Course
                </a>{{--}}
                <a href="{{route('presentation.upload')}}" @click="mobileMenuOpen = false; activeMobileMenu = ''" class="block px-3 py-2 rounded-md text-base font-medium text-neutral-700 hover:bg-neutral-100 dark:text-white">
                    Manual Upload
                </a>
                {{--}}<a href="#_" @click="mobileMenuOpen = false; activeMobileMenu = ''" class="block px-3 py-2 rounded-md text-base font-medium text-neutral-700 hover:bg-neutral-100 dark:text-white">
                    Settings
                </a>
                <a href="#_" @click="mobileMenuOpen = false; activeMobileMenu = ''" class="block px-3 py-2 rounded-md text-base font-medium text-neutral-700 hover:bg-neutral-100 dark:text-white">
                    Help
                </a>
                <a href="#_" @click="mobileMenuOpen = false; activeMobileMenu = ''" class="block px-3 py-2 rounded-md text-base font-medium text-neutral-700 hover:bg-neutral-100 dark:text-white">
                    Status
                </a>{{--}}
            </div>
        </li>
        @endcan
        <li>
            <a href="{{route('admin.recorders')}}" class="inline-flex items-center justify-center px-3 h-10 py-2 font-medium transition-colors rounded-md hover:text-neutral-900 dark:hover:text-gray-200">
                {{__("Recorders")}}
            </a>
        </li>
        <!-- Admin -->
        @can('admin-content')
        <li>
            <a href="#_" class="block px-3 py-2 rounded-md text-base font-medium text-neutral-700 hover:bg-neutral-100 dark:text-white">
                Admin
            </a>
        </li>
        @endcan
    </ul>
</div>
