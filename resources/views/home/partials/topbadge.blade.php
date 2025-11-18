@if($new ?? false)
<span class="absolute top-0 start-0
  rounded-sm
  text-xs font-medium bg-gray-800 text-white
  py-1.5 px-3 dark:bg-neutral-900">
  {{ $video->created_at->diffForHumans() }}
</span>
@endif
