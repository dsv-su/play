@if($new ?? false)
<span class="presentation-card-age">
  {{ $video->created_at->diffForHumans() }}
</span>
@endif
