@if ($video->edit && $video->state)
    <input type="checkbox"
           x-model="selectedVideos"
           name="videos[]"
           value="{{ $video->id }}"
           aria-label="{{ __('Select :title', ['title' => $video->LangTitle]) }}"
           class="shrink-0 mt-0.5 border-gray-400 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50
                   disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-400 dark:checked:bg-blue-500 dark:checked:border-blue-500
                   dark:focus:ring-offset-gray-800"
           id="video-checkbox-{{ $courseId }}-{{ $video->id }}">
@endif
