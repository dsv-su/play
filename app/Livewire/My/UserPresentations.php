<?php

namespace App\Livewire\My;

use App\Livewire\PresentationLibraryResults;
use App\Models\Channel;
use App\Models\ChannelVideoAssignment;
use App\Models\Video;
use App\Services\MyPresentation\PresentationLibrary;
use App\Services\VideoSearch\VideoFilters;
use Illuminate\Database\Eloquent\Builder;

class UserPresentations extends PresentationLibraryResults
{
    public function addToChannel(string $videoId, int $channelId): void
    {
        $username = $this->currentUsername();
        abort_if($username === '', 403);
        $channel = Channel::query()->where('created_by', $username)->findOrFail($channelId);
        $video = $this->addableVideosQuery()->findOrFail($videoId);

        ChannelVideoAssignment::firstOrCreate([
            'channel_id' => $channel->id,
            'video_id' => $video->id,
        ], ['assigned_by' => $username]);

        session()->flash('message', __('Presentation added to channel.'));
        session()->flash('success', true);
    }

    private function currentUsername(): string
    {
        return app()->bound('play_username') ? (string) app('play_username') : '';
    }

    private function addableVideosQuery(): Builder
    {
        return Video::query()->where('visibility', true)->where('unlisted', false)
            ->when(! app()->bound('play_role') || app('play_role') !== 'Administrator', function ($query) {
                $username = $this->currentUsername();
                $query->where(function ($query) use ($username) {
                    $query->whereHas('presenters', fn ($presenters) => $presenters->where('username', $username))
                        ->orWhereHas('individualPermissions', fn ($permissions) => $permissions
                            ->where('username', $username)->whereIn('permission', ['edit', 'delete']));
                });
            });
    }

    public function render()
    {
        $view = parent::render();
        $videos = $view->getData()['courseVideos']->getCollection();
        if ($videos->isNotEmpty()) {
            $videos->load(['channels' => fn ($query) => $query->orderBy('name')]);
        }
        $channels = $this->currentUsername() !== ''
            ? Channel::query()->where('created_by', $this->currentUsername())->orderBy('name')->get()
            : collect();

        return $view->with([
            'customChannels' => $channels,
            'channelAddableVideoIds' => $channels->isNotEmpty()
                ? $this->addableVideosQuery()->whereKey($view->getData()['courseVideos']->getCollection()->pluck('id'))->pluck('videos.id')->flip()
                : collect(),
        ]);
    }

    protected function libraryQuery(PresentationLibrary $library, VideoFilters $filters): Builder
    {
        return $library->query($filters);
    }

    protected function resultsView(): string
    {
        return 'livewire.my.my-presentations';
    }
}
