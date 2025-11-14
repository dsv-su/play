<div wire:key="table-{{ $courseId }}-{{ (int) $switchOn }}"
     class="px-4 sm:px-6 lg:px-8 lg:py-1 mx-auto">
    <!-- For select all button -->
    @php
        // Build the list of selectable IDs as STRINGS
        $ids = $group->pluck('id')
                      ->map(fn($id) => (string) $id)
                      ->values();
    @endphp

    <form id="bulk-edit-form"
          method="post"
          action="{{ route('bulk.edit') }}"
          x-data="{
        selectedVideos: [],
        allIds: @js($ids)
      }"
          wire:ignore>
        @csrf

        @include('livewire.search.partials.selectAllbutton')

        <div class="flex flex-col gap-3 mb-3">
        @foreach($group as $key => $video)
            <!-- Row Card -->
                <div class="w-full bg-white dark:bg-neutral-900 border border-gray-200 dark:border-neutral-800 rounded-lg shadow-sm hover:shadow-md transition">
                    <!-- Card Content -->
                    <div class="flex flex-col gap-3 p-3 sm:p-4 md:flex-row md:items-center md:justify-between">
                        <!-- Left: Checkbox + permissions -->
                        <div class="flex items-center gap-2 shrink-0">
                            @include('livewire.search.partials.checkbox')

                            <div class="flex items-center bg-gray-900 border border-gray-900 rounded">
                                @include('home.partials.permission-buttons')
                            </div>
                        </div>

                        <!-- Middle: Title + meta -->
                        <div class="flex-1 min-w-0 flex flex-col gap-1">
                            <!-- Title -->
                            @php
                                $titleColor =
                                    $video->hidden && $video->unlisted
                                        ? 'text-yellow-600 dark:text-yellow-300'     // Unlisted
                                        : ($video->hidden && !$video->unlisted
                                            ? 'text-red-600 dark:text-red-400'       // Private
                                            : 'text-gray-900 dark:text-neutral-100'  // Normal
                                          );
                            @endphp
                            <a target="_blank"
                               rel="noopener noreferrer"
                               href="{{ route('player.show', ['video' => $video]) }}"
                               class="w-full font-medium text-sm sm:text-base hover:text-blue-600 {{ $titleColor }} dark:text-neutral-100 truncate"
                               title="{{ $video->title }}">
                                {{ $video->title }}
                            </a>

                            <!-- Meta row: duration, course, presenters, tags -->
                            <div class="flex flex-wrap items-center gap-2 text-xs sm:text-sm">
                                <!-- Duration -->
                                <span class="inline-flex items-center px-2 py-0.5 text-[11px] sm:text-xs
                                         font-medium text-white bg-gray-500 border border-gray-500 rounded shadow whitespace-nowrap">
                                {{ $video->duration }}
                            </span>

                                <!-- Course -->
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
                        </div>

                        <!-- Right: date + edit actions -->
                        <div class="flex items-center justify-between gap-2 sm:gap-3 md:flex-col md:items-end md:justify-center text-xs sm:text-sm">
                        <span class="text-gray-500 dark:text-neutral-400 whitespace-nowrap">
                            {{ $video->getCreationDate() }}
                        </span>

                            <div class="flex flex-wrap items-center justify-end gap-2">
                                @include('livewire.search.partials.edit-tabel')
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Row Card -->
            @endforeach

            @include('partials.download-poller-script')
        </div>
    </form>

</div>


