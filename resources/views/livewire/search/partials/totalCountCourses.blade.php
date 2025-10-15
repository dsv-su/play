<div class="ml-4 mt-4 flex items-center gap-2">
    <div class="shrink-0 flex items-center gap-1
              bg-blue-800 hover:bg-blue-900 text-white
              text-xl sm:text-base font-semibold
              px-2 sm:px-2.5 py-0.5 rounded border border-blue-900
              dark:bg-blue-950 dark:text-white dark:border-blue-800">
        {{$totalCount}}
    </div>
    <div class="text-xl dark:text-white">
        @if($totalCount == 1)
            {{__("Course")}}
        @else
            {{ __("Courses") }}
        @endif
    </div>
</div>


