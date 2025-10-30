@if($video->progress)
    <div class="space-y-5">
        <!-- Progress -->
        <div class="flex w-full h-3 bg-gray-200 rounded overflow-hidden dark:bg-neutral-700"
             role="progressbar"
             aria-valuenow="25"
             aria-valuemin="0"
             aria-valuemax="100">
            <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap dark:bg-blue-500 transition duration-500"
                 style="width: {{$video->progress ?? 0}}%">{{$video->progress ?? 0}}%
            </div>
        </div>
        <!-- End Progress -->
    </div>
@endif

