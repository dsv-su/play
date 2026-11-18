@php
    $hoursLate = $video->updated_at->diffInHours(now(), false);
    $isEdited = $video->origin === 'edited';
    $progress = max(0, min(100, (float) $video->progress - ($isEdited ? 20 : 0)));
    $statusClass = $hoursLate >= 6 ? 'pending-status-error' : ($hoursLate >= 2 ? 'pending-status-warning' : '');
    $label = match (true) {
        $hoursLate >= 12 => __('Error. Processing may have stalled.'),
        $hoursLate >= 6 => __('There may be a queue delay or a processing issue.'),
        $hoursLate >= 4 => __('Your presentation may still be waiting in the queue or taking longer to process. Please check back later for an update.'),
        $hoursLate >= 2 => __('Processing can take longer for large presentations or when the queue is busy. Please check back later for an update.'),
        default => null,
    };
@endphp
@if($video->progress !== null)
    <div class="pending-card-status {{ $statusClass }}">
        <div class="pending-progress-heading">
            <span>{{ __('Processing') }}</span>
            <span class="pending-progress-value">{{ $progress }}%</span>
        </div>
        <div class="pending-progress-track" role="progressbar"
             aria-label="{{ __('Processing progress') }}"
             aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
            <div class="pending-progress-fill" style="width: {{ $progress }}%"></div>
        </div>
        @if($label)
            <p class="pending-progress-note">{{ $label }}</p>
            <p class="pending-progress-note">{{ __('Last updated: :time', ['time' => $video->updated_at->diffForHumans()]) }}</p>
        @endif
        @if(!$isEdited && $label && $hoursLate >= 6)
            @include('pending.partials.handlers')
        @endif
    </div>
@endif
