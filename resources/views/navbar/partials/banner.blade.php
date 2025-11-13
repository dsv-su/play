<div x-data="{
        bannerVisible: false,
        bannerVisibleAfter: 300,
    }"
     x-show="bannerVisible"
     x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="-translate-y-10"
     x-transition:enter-end="translate-y-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="translate-y-0"
     x-transition:leave-end="-translate-y-10"
     x-init="
        setTimeout(()=>{ bannerVisible = true }, bannerVisibleAfter);
    "
     class="absolute top-full left-0 w-full h-auto py-2 duration-300 ease-out bg-susecondary shadow-sm sm:py-0 sm:h-10" x-cloak>
    <div class="relative flex items-center justify-center w-full h-full px-3 mx-auto max-w-7xl">
        <a href="#" class="flex flex-col sm:flex-row sm:items-center text-xs leading-6 text-black opacity-80 hover:opacity-100 text-center">
        <span class="flex items-center justify-center">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" ...></svg>
            <strong class="font-semibold ml-1">{{__("Message")}}</strong>
            <span class="hidden w-px h-4 mx-3 rounded-full sm:block bg-neutral-200"></span>
        </span>
            <span class="block pt-1 pb-2 leading-none sm:pt-0 sm:pb-0">
            {{__("Click here to learn more")}}
        </span>
        </a>

        <!-- Close button in top-right of banner -->
        <button
            @click="bannerVisible=false;"
            class="absolute right-3 flex items-center justify-center w-6 h-6 p-1.5 text-black rounded-full hover:bg-neutral-100"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>
</div>
