<div class="relative">
    <input
        type="text"
        class="form-input"
        placeholder="Search Users..."
        wire:model="query"
        wire:keydown.escape="clear"
        wire:keydown.tab="clear"
        wire:keydown.arrow-up="decrementHighlight"
        wire:keydown.arrow-down="incrementHighlight"
        wire:keydown.enter="selectUser"
    />

    <div wire:loading class="absolute z-10 w-full bg-white rounded-t-none shadow-lg list-group">
        <div class="list-item">Searching...</div>
    </div>

    @if(!empty($query))
        <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="clear"></div>

        <div class="list-group search-results-dropdown">
            @if(!empty($users))
                @foreach($users as $displayname => $uid)
                    <div class="list-group-item">
                    <a href="#">{{ $displayname }} - {{ $uid }}</a>
                    </div>
                @endforeach
            @else
                <div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>
            @endif
        </div>
    @endif
</div>



