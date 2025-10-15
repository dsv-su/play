<!-- Study Admin Category -->
@if (!$video->courses->isEmpty() && $video->getUniqueStudyAdminCat())
    @foreach($video->getUniqueStudyAdminCat() as $cat)
        <a href="/category/Studieadmin"
           class="px-1.5 py-0 text-[10px] font-medium text-white bg-green-600 border border-green-700 rounded shadow-md">{{__("STUDYINFO")}}</a>
    @endforeach
@elseif ($video->category->category_name == 'Studieadmin')
    <a href="/category/Studieadmin"
       class="px-1.5 py-0 text-[10px] font-medium text-white bg-green-600 border border-green-700 rounded shadow-md">{{__("STUDYINFO")}}</a>
@endif
