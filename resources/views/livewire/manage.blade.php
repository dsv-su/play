<div>
    <!-- Layout buttons -->
        <span class="custom-control-inline custom-switch custom-switch" data-toggle="tooltip"
              title="{{__("Grid layout")}}">
            <button class="btn btn-outline-primary" wire:click="videoformat('{{$grid}}')"
                    @if($videoformat == 'grid') style="background-color: blue; !important; color: white; !important;" @endif>
                <i class="fa-solid fa-table-cells-large"></i>
            </button>
        </span>
        <span class="custom-control-inline custom-switch custom-switch" data-toggle="tooltip"
              title="{{__("Table layout")}}">
            <button class="btn btn-outline-primary" wire:click="videoformat('{{$table}}')"
                    @if($videoformat == 'table') style="background-color: blue; !important; color: white; !important;" @endif>
                <i class="fa-solid fa-table-list"></i>
            </button>
        </span>
        <span class="custom-control-inline custom-switch custom-switch" data-toggle="tooltip"
              title="{{__("List layout")}}">
            <button class="btn btn-outline-primary" wire:click="videoformat('{{$list}}')"
                    @if($videoformat == 'list') style="background-color: blue; !important; color: white; !important;" @endif>
                <i class="fa-solid fa-list"></i>
            </button>
        </span>
    <!-- end layout buttons -->
    <div class="card border border-primary mt-3" style="border-width:3px !important; border-radius: 10px !important; padding: 25px !important; z-index: 1000; !important;">
        <div class="container">
            <div class="d-flex row justify-content-center align-items-start">
                <div class="col-12 col-sm">
                    <form wire:submit.prevent="filter"
                          class="form-inline manage-filter d-flex justify-content-sm-center"
                          method="GET" id="manage-filter" role="search">
                        <label for="manage-filter" class="sr-only">{{ __("Type to search") }}</label>
                        <input class="form-control w-100" type="search"
                               wire:model.debounce.1000ms="filterTerm"
                               id="manage-filter-text" autocomplete="off"
                               aria-haspopup="true"
                               placeholder="{{ __("Type to search") }}"
                               style="font-size: 100% !important;"
                               aria-labelledby="manage-filter">
                    </form>
                </div>
            </div>
        </div>

        <!-- Dropdown filter -->
        @include('livewire.filter.dropdownfilter')
        <!-- end dropdownfilter -->

   </div>
    <!-- Loading spinners -->
   <div wire:loading wire:target="loadUncat">
       @include('livewire.modals.loading_spinner')
   </div>
   <div wire:loading wire:target="loadCourseVideos">
       @include('livewire.modals.loading_spinner')
   </div>
    <div wire:loading.delay wire:target="filterTerm">
        @include('livewire.modals.loading_spinner')
    </div>
    <div wire:loading.delay wire:target="resetFilter">
        @include('livewire.modals.reset_spinner')
    </div>
    <!-- end loading spinners -->

   <!-- Uncategorized -->
   <div id="accordion">
       {{--}}
       <!-- Disable/enable uncat counter -->
       @if($uncatcounter != 0)
       <div class="card">
           <div id="headingOne">
               <h2 class="col mt-4" style="line-height: 1.5em;">
                   <span class="badge badge-primary ml-2 mb-2" data-toggle="tooltip" title="{{__("Number of presentations")}}">{{$uncatcounter}}</span>
                   <span style="color:blue;">{{__("Uncategorized courses")}}</span>
               </h2>
               <div class="card border border-primary p-3">
                   <a wire:click.prevent="loadUncat" @if($uncat) class="link" @else class="link collapsed" @endif role="button" data-toggle="collapse" aria-expanded="false">
                       <i class="fa mr-2"></i>
                       {{__("Uncategorized")}}
                   </a>
                   <div id="collapseOne"
                        @if($uncat)
                        class="collapse show"
                        @else
                        class="collapse"
                        @endif
                        aria-labelledby="headingOne" data-parent="#accordion">
                       @include('home.videolayout', ['videos' => $uncat_videos])
                   </div>
               </div>
           </div>
       </div>
       @endif
       {{--}}

       <div class="d-flex justify-content-sm-start mt-4">
           <h2 class="col mt-4">
               <span class="badge badge-primary ml-2 mb-2">{{count($video_courses)}} </span> <span style="color:blue;">
                   @if(count($video_courses)>1 or count($video_courses)==0)
                       {{__("Courses")}}
                   @else
                       {{__("Course")}}
                   @endif
               </span>
           </h2>
       </div>

       <!--Courses -->
       @foreach($video_courses as $key => $video_course)
            <!-- Grey out background for non-editible courses -->
           <div class="card border border-primary mb-3"
               @if ($video_course->course->id && !(in_array(\App\Course::find($video_course->course->id)->userPermission(), ['edit', 'delete'])))
                   style="background-color: #e7ebec; !important;"
               @endif
                    >
               <div id="heading{{$key}}">
                   <h4 style="text-align:left;float:left; padding: 35px 15px 0;">
                       <a wire:click.prevent="loadCourseVideos({{$video_course->course->id}})"
                          @if($contend[$video_course->course->id]) class="link" @else class="link collapsed"
                          @endif role="button" data-toggle="collapse" aria-expanded="false"
                          aria-controls="collapse{{$key}}">
                           <i class="fa mr-2"></i>
                           {{$video_course->course->designation}}
                           {{$video_course->course->semester}}{{$video_course->course->year}}
                           —
                           @if(Lang::locale() == 'swe')
                               {{$video_course->course->name}}
                           @else
                               {{$video_course->course->name_en}}
                           @endif
                       </a>
                   </h4>
                   <h5 style="text-align:right; float:right; padding: 5px 15px 0 15px;">
                       @if(!$contend[$video_course->course->id])
                           @include('livewire.status.coursestatus')
                       @endif
                   </h5>
                   <hr style="clear:both; border: none;">
               </div>
               <div id="collapse{{$key}}"
                    @if($contend[$video_course->course->id])
                        class="collapse show"
                    @else
                        class="collapse"
                    @endif
                    aria-labelledby="heading{{$key}}" data-parent="#accordion">
                   @include('livewire.status.coursestatusfull')
                   @include('home.videolayout', ['videos' => $videos[$video_course->course->id]])
               </div>
           </div>
       @endforeach

   </div> <!-- accordian -->

</div>

<script>
   document.addEventListener("DOMContentLoaded", () => {
   $(function () {
       $('[data-toggle="tooltip"]').tooltip()
   })
   Livewire.hook('message.processed', (message, component) => {
       $(function () {
           $('[data-toggle="tooltip"]').tooltip();
           $("input[type='checkbox'][name='bulkedit']").each(function () {
           handleSelected($(this));
           });

           $("input[type='checkbox'][name='bulkedit']").on('change', function () {
               handleSelected($(this));
           });
       })
   })
   function handleSelected(checkbox) {
       let checked = checkbox.prop('checked');
       let id = checkbox.attr('data-id');
       if (checked) {
           if (!$('#bulkediting').find('input[name="bulkids[]"][value="'+id+'"]').length) {
               $('#bulkediting').append('<input type="hidden" name="bulkids[]" value=' + id + '>');
               }
       } else {
           $('#bulkediting').find('input[value="' + id + '"]').remove();
       }
       let n = $('#bulkediting').find('input[name="bulkids[]"]').length;
       if (n) {
           $('#bulkediting input[type="submit"]').val("{{__("Edit")}}" + ' ' + n + ' ' + "{{__("selected presentations")}}");
           $('#bulkcontainer').show();
       } else {
           $('#bulkcontainer').hide();
           }
       }
   });
</script>

