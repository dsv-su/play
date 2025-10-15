<div class="w-full sm:w-auto">
    <div class="flex items-stretch sm:items-center gap-2 sm:gap-3 flex-wrap sm:flex-nowrap overflow-x-auto
                sm:overflow-visible whitespace-nowrap sm:whitespace-normal [-ms-overflow-style:none] [scrollbar-width:none]"
         style="-webkit-overflow-scrolling:touch">
        @foreach($activeFilters as $filter => $isActive)
            @if($isActive)
                @include('livewire.search.partials.' . $filter)
            @endif
        @endforeach
    </div>
</div>

