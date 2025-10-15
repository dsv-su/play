<!-- Flash Message section -->
@if(session()->has('message'))
    <div class="mx-auto w-full px-3 sm:px-4
              max-w-screen-sm sm:max-w-md md:max-w-lg lg:max-w-2xl">
        <div
            role="alert"
            aria-live="polite"
            class="text-center font-medium text-sm sm:text-base
             px-4 py-3 sm:py-4 rounded-lg border shadow-sm ring-1 ring-inset
             transition-colors duration-200
        @if (session('success'))
                bg-green-50 text-green-800 border-green-200 ring-green-100
                dark:bg-green-900/40 dark:text-green-100 dark:border-green-800 dark:ring-green-900
        @elseif (session('warning'))
                bg-amber-50 text-amber-900 border-amber-200 ring-amber-100
                dark:bg-amber-900/40 dark:text-amber-100 dark:border-amber-800 dark:ring-amber-900
        @elseif (session('error'))
                bg-red-50 text-red-800 border-red-200 ring-red-100
                dark:bg-red-900/40 dark:text-red-100 dark:border-red-800 dark:ring-red-900
        @else
                bg-blue-50 text-blue-800 border-blue-200 ring-blue-100
                dark:bg-blue-900/40 dark:text-blue-100 dark:border-blue-800 dark:ring-blue-900
        @endif">
            {{ session('message') }}
        </div>
    </div>
@endif

