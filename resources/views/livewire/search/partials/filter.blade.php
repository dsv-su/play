<div class="w-full min-w-0">
    <div class="flex min-w-0 flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-start">
        @foreach($activeFilters as $filter => $isActive)
            @if($isActive)
                @include('livewire.search.partials.' . $filter)
            @endif
        @endforeach
    </div>
</div>
