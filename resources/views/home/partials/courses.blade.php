@if (!$video->courses->isEmpty())
    <div class="flex flex-wrap gap-1 mt-1">
        @foreach($video->getUniqueDesignations() as $designation)
            <a href="search/designation/{{ $designation }}"
               class="px-1.5 py-0 text-[10px] font-medium text-white bg-blue-800 border border-blue-900 rounded shadow-md">
                {{ $designation }}
            </a>
        @endforeach
    </div>
@endif
