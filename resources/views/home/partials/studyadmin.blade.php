@if ($video->getUniqueStudyAdminCat())
    @foreach($video->getUniqueStudyAdminCat() as $cat)
        <a href="/study/all"
           class="presentation-card-chip presentation-card-chip-study">
            {{ __("STUDYINFO") }}
        </a>
    @endforeach
@elseif (optional($video->category)->category_name === 'Studieadmin')
    <a href="/study/all"
       class="presentation-card-chip presentation-card-chip-study">
        {{ __("STUDYINFO") }}
    </a>
@endif

