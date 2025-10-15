<ul class="hidden md:flex items-center justify-center flex-1 p-1 space-x-1 list-none space-x-1 text-neutral-700 group dark:text-white">
    <li>
        <button
            :class="{ 'bg-neutral-100': navigationMenu=='getting-started', 'hover:bg-neutral-100': navigationMenu!='getting-started' }"
            @mouseover="navigationMenuOpen=true; navigationMenuReposition($el); navigationMenu='getting-started'"
            @mouseleave="navigationMenuLeave()"
            class="inline-flex items-center justify-center h-10 px-4 py-2 font-medium transition-colors rounded-md hover:text-neutral-900 focus:outline-none">
            <span>{{__("Navigation")}}</span>
            <svg :class="{ '-rotate-180': navigationMenuOpen && navigationMenu=='getting-started' }"
                 class="relative top-[1px] ml-1 h-3 w-3 ease-out duration-300"
                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </button>
    </li>
    <li>
        <button
            :class="{ 'bg-neutral-100': navigationMenu=='learn-more', 'hover:bg-neutral-100': navigationMenu!='learn-more' }"
            @mouseover="navigationMenuOpen=true; navigationMenuReposition($el); navigationMenu='learn-more'"
            @mouseleave="navigationMenuLeave()"
            class="inline-flex items-center justify-center h-10 px-4 py-2 font-medium transition-colors rounded-md hover:text-neutral-900 focus:outline-none">
            <span>{{__("Manage")}}</span>
            <svg :class="{ '-rotate-180': navigationMenuOpen && navigationMenu=='learn-more' }"
                 class="relative top-[1px] ml-1 h-3 w-3 ease-out duration-300"
                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </button>
    </li>
    <li>
        <a href="#_" class="inline-flex items-center justify-center h-10 px-4 py-2 font-medium transition-colors rounded-md hover:text-neutral-900 dark:hover:text-gray-200">
            Admin
        </a>
    </li>
</ul>
