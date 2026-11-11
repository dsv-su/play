<?php

namespace App\Livewire\Channel;

use App\Livewire\PresentationLibraryResults;
use App\Models\Channel;
use App\Services\MyPresentation\PresentationLibrary;
use App\Services\VideoSearch\VideoFilters;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Locked;

class ChannelPresentations extends PresentationLibraryResults
{
    #[Locked]
    public Channel $channel;

    public bool $allowBulkEdit = false;

    public function mount(?Channel $channel = null): void
    {
        abort_unless($channel?->exists, 404);
        $this->channel = $channel;
        parent::mount();
    }

    protected function libraryQuery(PresentationLibrary $library, VideoFilters $filters): Builder
    {
        return $library->queryForChannel($this->channel->getKey(), $filters);
    }

    protected function resultsView(): string
    {
        return 'livewire.channel.channel-presentations';
    }
}
