<div>
    <!-- Slider -->
    <div data-hs-carousel='{
      "loadingClasses": "opacity-0",
      "dotsItemClasses": "hs-carousel-active:bg-blue-700 hs-carousel-active:border-blue-700 size-3 border border-gray-400 rounded-full cursor-pointer dark:border-neutral-600 dark:hs-carousel-active:bg-blue-500 dark:hs-carousel-active:border-blue-500",
      "slidesQty": {
              "xs": 1,
              "sm": 2,
              "md": 3,
              "lg": 4
            },
      "isDraggable": true
    }' class="relative">
        <div class="px-4 py-2">
            <a href="#"
               class="group inline-flex items-center text-blue-700 text-xl font-light tracking-wide uppercase whitespace-nowrap drop-shadow-md dark:text-white hover:text-blue-900 dark:hover:text-gray-300 transition-colors duration-200">
                {{__("Study information")}}
                <svg class="ml-2 w-6 h-6 text-current transform transition-transform duration-200 group-hover:translate-x-1"
                     aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 12H5m14 0-4 4m4-4-4-4"/>
                </svg>
            </a>
        </div>
        <!-- Transparent background -->
        <div class="hs-carousel w-full overflow-hidden bg-transparent rounded-lg">
            <div class="relative min-h-72 ">
                <div class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap opacity-0 transition-transform duration-700 hs-carousel-dragging:transition-none hs-carousel-dragging:cursor-grabbing">
                    @foreach($studyvideos as $video)
                        <div class="hs-carousel-slide px-0.5">
                            <div class="flex justify-center h-full">
                                @include('home.partials.presentation')
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Previous button -->
        <button type="button" class="hs-carousel-prev absolute top-1/2 -translate-y-1/2 start-0 -translate-x-10
                                     inline-flex justify-center items-center w-14 h-14 text-black dark:text-white">
            <span aria-hidden="true">
              <svg class="shrink-0 size-16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"></path>
              </svg>
            </span>
            <span class="sr-only">Previous</span>
        </button>

        <!-- Next button -->
        <button type="button"
                class="hs-carousel-next absolute top-1/2 -translate-y-1/2 end-0 translate-x-10
                       inline-flex justify-center items-center w-14 h-14 text-black dark:text-white">
            <span class="sr-only">Next</span>
            <span aria-hidden="true">
              <svg class="shrink-0 size-16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 18 6-6-6-6"></path>
              </svg>
            </span>
        </button>
        <div class="hs-carousel-info absolute bottom-2 left-1/2 -translate-x-1/2 translate-y-8 inline-flex justify-center px-4 bg-white rounded-lg">
            <span class="hs-carousel-info-current me-1">0</span>
            /
            <span class="hs-carousel-info-total ms-1">0</span>
        </div>
    </div>
    <!-- End Slider -->

</div>
