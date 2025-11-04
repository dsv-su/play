@php
    $hoursLate = $video->updated_at->diffInHours(now(), false);

    if ($hoursLate >= 6) {
        $barColor = 'bg-red-600 dark:bg-red-500';
        $textColor = 'text-red-600';
    } elseif ($hoursLate >= 4) {
        $barColor = 'bg-yellow-400 dark:bg-yellow-400';
        $textColor = 'text-orange-600';
    } elseif ($hoursLate >= 2) {
        $barColor = 'bg-yellow-400 dark:bg-yellow-400';
        $textColor = 'text-yellow-500';
    } else {
        $barColor = 'bg-blue-600 dark:bg-blue-500';
        $textColor = 'text-blue-600';
    }
    [$label] = match (true) {
                $hoursLate >= 12 => [__("Queue error.")],
                $hoursLate >= 6 => [__("High load on the queue.")],
                $hoursLate >= 4 => [__("Load on the queue.")],
                $hoursLate >= 2 => [__("Last updated")],
                default => [null],
            };
@endphp
@if($video->progress && $video->origin != 'edited')
    <div class="pt-1 space-y-2">
        <!-- Progress for manual/cattura-->
        <div class="flex w-full h-3 bg-gray-200 rounded overflow-hidden dark:bg-neutral-700"
             role="progressbar"
             aria-valuenow="{{ $video->progress ?? 0 }}"
             aria-valuemin="0"
             aria-valuemax="100">
            <div class="flex flex-col justify-center rounded-full overflow-hidden
                        {{ $barColor }}
                text-xs text-white text-center whitespace-nowrap transition duration-500"
                 style="width: {{ $video->progress ?? 0 }}%">
                {{ $video->progress ?? 0 }}%
            </div>
        </div>

        @if ($label)
            <div class="{{ $textColor }} text-xs">
                ({{ $label }} {{ $video->updated_at->diffForHumans() }})
            </div>
        @endif
    <!-- End Progress -->
        @if($label && $hoursLate >= 6)
            @include('pending.partials.handlers')
        @endif
    </div>
@elseif($video->progress && $video->origin == 'edited')
    @php
        $progress = $video->progress - 20;
    @endphp
    <div class="pt-1 space-y-2">
        <!-- Progress for edited-->
        <div class="flex w-full h-3 bg-gray-200 rounded overflow-hidden dark:bg-neutral-700"
             role="progressbar"
             aria-valuenow="{{ $video->progress ?? 0 }}"
             aria-valuemin="0"
             aria-valuemax="100">
            <div class="flex flex-col justify-center rounded-full overflow-hidden
                        {{ $barColor }}
                text-xs text-white text-center whitespace-nowrap transition duration-500"
                 style="width: {{ $progress ?? 0 }}%">
                {{ $progress ?? 0 }}%
            </div>
        </div>

        @if ($label)
            <div class="{{ $textColor }} text-xs">
                ({{ $label }} {{ $video->updated_at->diffForHumans() }})
            </div>
        @endif
    <!-- End Progress -->
    </div>
@endif


