<div class="space-y-2">
    <!-- Handlers -->
    <div class="text-xs">
        @php $handlers = $video->pending->handlers ?? []; @endphp

        @forelse($handlers as $h)
            <div class="flex justify-between items-center w-48">
                <span>{{ $h }}</span>
                <span class="bg-transparent text-yellow-500 border border-yellow-500 text-[8px] font-medium px-1 py-0.3 rounded-full">
            Pending
        </span>
            </div>
        @empty
        <div class="text-xs text-gray-500">No handlers</div>
        @endforelse

    <!-- Handlers -->
    </div>

</div>
