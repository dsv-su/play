@php
    // Read cookie
    $raw = request()->cookie('presentation_order', '[]');
    $orderFromCookie = json_decode($raw, true);
    //$orderFromCookie = ["home.studypresentations", "home.newpresentations"];
    $order = \App\Support\HomePresentationOrder::sanitize($orderFromCookie);
    $channels = \App\Models\Channel::query()->where('show_on_homepage', true)->get()->keyBy(fn ($channel) => $channel->component_key);
@endphp

<div class="max-w-screen-xl mx-auto px-4 py-6 sm:px-6 lg:px-8 md:pt-8 md:pb-8 space-y-8">
    @include('home.partials.flashmessage-section')
    <livewire:search.index />

    @foreach ($order as $component)
        @if(str_starts_with($component, 'channel.'))
            @if($channels->has($component))
                <livewire:home.channel-presentations :channel-id="$channels[$component]->id" :key="$component" />
            @endif
        @else
            @livewire($component)
        @endif
        {{-- Unique keys: @livewire($component, [], key($component)) --}}
    @endforeach


    <!-- Tooltips -->
    @include('home.partials.tooltips')
</div>

