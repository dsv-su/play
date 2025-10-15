<?php

namespace App\Livewire\Concerns;

use Livewire\Attributes\Computed;

trait DSVPresenters
{
    #[Computed]
    public function presenterName(): ?string
    {
        return \App\Models\Presenter::where('username', $this->presenter_search)
            ->value('name') ?? '';
    }

}
