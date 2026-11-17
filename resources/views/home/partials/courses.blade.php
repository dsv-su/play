@if (!$video->courses->isEmpty())
    <div class="presentation-card-courses">
        @foreach($video->getUniqueDesignations() as $designation)
            <a href="/designation/{{ $designation }}"
               data-tooltip-target="course-tooltip"
           class="presentation-card-chip presentation-card-chip-course">
                {{ $designation }}
            </a>
        @endforeach
    </div>
@endif
