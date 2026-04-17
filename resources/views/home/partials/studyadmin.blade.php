@if ($video->getUniqueStudyAdminCat())
    @foreach($video->getUniqueStudyAdminCat() as $cat)
        <a href="/study/all"
           class="px-1.5 py-0 text-[10px] font-medium text-white bg-green-700 border border-green-800 rounded shadow-md pointer-events-auto">
            {{ __("STUDYINFO") }}
        </a>
    @endforeach
@elseif (optional($video->category)->category_name === 'Studieadmin')
    <a href="/study/all"
       class="px-1.5 py-0 text-[10px] font-medium text-white bg-green-700 border border-green-800 rounded shadow-md pointer-events-auto">
        {{ __("STUDYINFO") }}
    </a>
@endif

