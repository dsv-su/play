@if($video->hidden || !$video->state)
    <div class="presentation-card-visibility">
        <span>{{ !$video->state ? __('Processing') : ($video->unlisted ? __('Unlisted') : __('Private')) }}</span>
    </div>
@endif
<div class="presentation-card-permissions">
    @include('home.partials.permission-buttons')
</div>
