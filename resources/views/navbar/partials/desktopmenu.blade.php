<ul class="hidden md:flex items-center justify-center flex-1 p-1 space-x-1 list-none space-x-1 text-neutral-700 group dark:text-white">
    <li>
        <button
            type="button"
            aria-controls="navigation-dropdown-getting-started"
            :aria-expanded="navigationMenuOpen && navigationMenu === 'getting-started'"
            :class="{ 'bg-neutral-100 dark:bg-white/10': navigationMenu=='getting-started', 'hover:bg-neutral-100 dark:hover:bg-white/10': navigationMenu!='getting-started' }"
            @click="$event.detail === 0 ? navigationMenuToggle($el, 'getting-started') : navigationMenuOpenFor($el, 'getting-started')"
            @keydown.arrow-down.prevent="navigationMenuOpenFor($el, 'getting-started', true)"
            @mouseover="navigationMenuOpenFor($el, 'getting-started')"
            @mouseleave="navigationMenuLeave()"
            class="inline-flex items-center justify-center h-10 px-4 py-2 font-medium transition-colors rounded-md hover:text-neutral-900 dark:hover:text-gray-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2 dark:focus-visible:ring-blue-400 dark:focus-visible:ring-offset-gray-800">
            <span>{{__("Navigation")}}</span>
            <svg :class="{ '-rotate-180': navigationMenuOpen && navigationMenu=='getting-started' }"
                 class="relative top-[1px] ml-1 h-3 w-3 ease-out duration-300"
                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </button>
    </li>
    @can('manage-content')
    <li>
        <button
            type="button"
            aria-controls="navigation-dropdown-learn-more"
            :aria-expanded="navigationMenuOpen && navigationMenu === 'learn-more'"
            :class="{ 'bg-neutral-100 dark:bg-white/10': navigationMenu=='learn-more', 'hover:bg-neutral-100 dark:hover:bg-white/10': navigationMenu!='learn-more' }"
            @click="$event.detail === 0 ? navigationMenuToggle($el, 'learn-more') : navigationMenuOpenFor($el, 'learn-more')"
            @keydown.arrow-down.prevent="navigationMenuOpenFor($el, 'learn-more', true)"
            @mouseover="navigationMenuOpenFor($el, 'learn-more')"
            @mouseleave="navigationMenuLeave()"
            class="inline-flex items-center justify-center h-10 px-4 py-2 font-medium transition-colors rounded-md hover:text-neutral-900 dark:hover:text-gray-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2 dark:focus-visible:ring-blue-400 dark:focus-visible:ring-offset-gray-800">
            <span>{{__("Manage")}}</span>
            <svg :class="{ '-rotate-180': navigationMenuOpen && navigationMenu=='learn-more' }"
                 class="relative top-[1px] ml-1 h-3 w-3 ease-out duration-300"
                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </button>
    </li>
    @endcan
    <li>
        <a href="{{route('admin.recorders')}}" class="inline-flex items-center justify-center h-10 px-4 py-2 font-medium transition-colors rounded-md hover:text-neutral-900 dark:hover:text-gray-200">
            {{__("Recorders")}}
        </a>
    </li>
    @can('admin-content')
    <li>
        <a href="{{route('admin.settings')}}" class="inline-flex items-center justify-center h-10 px-4 py-2 font-medium transition-colors rounded-md hover:text-neutral-900 dark:hover:text-gray-200">
            {{__("Admin")}}
        </a>
    </li>
    @endcan
</ul>
