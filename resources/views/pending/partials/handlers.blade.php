@php
    $raw = $video->pending->handlers ?? [];
    $handlers = is_array($raw) ? $raw : [];
@endphp
<ul class="pending-handlers">
    @forelse($handlers as $handler)
        <li>
            <span class="pending-handler-name">{{ $handler }}</span>
            <span class="presentation-card-chip">{{ __('Pending') }}</span>
        </li>
    @empty
        <li class="pending-handlers-empty">{{ __('No handlers') }}</li>
    @endforelse
</ul>
