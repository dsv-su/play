@php
    // Read cookie
    $raw = request()->cookie('presentation_order', '[]');
    $orderFromCookie = json_decode($raw, true);
    //$orderFromCookie = ["home.studypresentations", "home.newpresentations"];
    // Allowed components default order
    $defaultOrder = [
        'home.newpresentations',
        'home.mypresentations',
        'home.studypresentations',
        'home.next-ilearn'
        ];

    // Sanitize: keep only allowed values
    $order = collect(is_array($orderFromCookie) ? $orderFromCookie : [])
        ->filter(fn ($c) => in_array($c, $defaultOrder, true))
        ->values()
        ->all();

    // Ensure all defaults appear (append any missing ones, preserving cookie order first)
    $order = array_values(array_unique(array_merge($order, $defaultOrder)));
@endphp

<div class="max-w-screen-xl mx-auto px-4 py-6 sm:px-6 lg:px-8 md:pt-8 md:pb-8 space-y-8">
    @include('home.partials.flashmessage-section')
    <livewire:search.index />

    @foreach ($order as $component)
        @livewire($component)
        {{-- Unique keys: @livewire($component, [], key($component)) --}}
    @endforeach


    <!-- Tooltips -->
    @include('home.partials.tooltips')
</div>


