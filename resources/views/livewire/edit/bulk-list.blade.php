<div>
    @foreach($videos as $key => $video)
        <!-- Row Card -->
        <div class="bg-white dark:bg-neutral-900 border border-gray-200 dark:border-neutral-800 rounded-lg shadow-sm hover:shadow-md transition">
            <!-- Flex Row -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between p-4 gap-3">
                <!-- Left side: Icons -->
                <div class="flex items-center gap-2 shrink-0">
                    <div class="flex items-center bg-gray-600 border border-gray-600 rounded px-1 py-0.5">
                        @include('home.partials.permission-buttons')
                    </div>
                </div>
                <!-- Right side: Title + duration + presenters -->
                <div class="flex flex-col md:flex-row md:items-center md:gap-4 flex-1 min-w-0">
                    <!-- Title -->
                    <a target="_blank" rel="noopener noreferrer"
                       href="{{ route('player.show', ['video' => $video]) }}"
                       class="font-medium hover:text-blue-600 text-gray-800 dark:text-neutral-100 truncate"
                       title="{{ $video->title }}">
                        {{ $video->title }}
                    </a>
                    <!-- Duration -->
                    <span class="inline-flex w-fit flex-none shrink-0 items-center px-2 py-0.5 text-xs
                                    font-medium text-white bg-gray-500 border border-gray-500 rounded shadow whitespace-nowrap">
                              {{ $video->duration }}
                            </span>
                    <div class="flex items-center">
                        @include('home.partials.courses')
                    </div>
                    <!-- Presenters -->
                    <div class="flex items-center">
                        @include('home.partials.presenters')
                    </div>
                    <!-- Tags -->
                    <div class="flex items-center">
                        @include('livewire.search.partials.tag-table')
                    </div>
                </div>
                <span class="text-xs">
                            {{$video->getCreationDate()}}
                        </span>
                <div class="flex items-center gap-4">
                    @include('livewire.search.partials.bulk-edit-table')
                </div>
            </div>
        </div>
        <!-- /Row Card -->
    @endforeach
</div>
