<?php

namespace App\Livewire\Concerns;

use App\Models\Presenter;
use Livewire\Attributes\Computed;

trait DSVPresenters
{
    #[Computed]
    public function presenterName(): ?string
    {
        return Presenter::where('username', $this->presenter_search)
            ->value('name') ?? '';
    }
}
