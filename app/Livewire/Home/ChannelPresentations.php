<?php

namespace App\Livewire\Home;

use App\Models\Channel;
use Livewire\Component;

class ChannelPresentations extends Component
{
    public Channel $channel;

    public $channelVideos;

    public int $totalCount = 0;

    public function mount(int $channelId): void
    {
        $this->channel = Channel::findOrFail($channelId);
        $query = $this->channel->presentations()->where('visibility', true)->where('state', true);
        $this->totalCount = $query->count();
        $raw = $query->latest('creation')->limit(10)
            ->with(['video_course:id,video_id,course_id', 'video_course.course:id,name,designation'])
            ->get();
        // Homepage channels are global. Any active, published presentation in
        // the channel is shown consistently, regardless of the viewer's role.
        $this->channelVideos = $raw;
    }

    public function render()
    {
        return view('livewire.home.channel-presentations');
    }
}
