<div>
    @if(count($channelVideos) > 0)
        @include('home.partials.carousel', [
            'videos' => $channelVideos,
            'heading' => $channel->name,
            'libraryUrl' => route('channels.show', $channel),
        ])
    @endif
</div>
