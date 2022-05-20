<div>
    @if(app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader')
    <div class="container p-3 my-3">
        <div class="d-flex justify-content-start">
            <label for="filterSwitch">{{__("Textfilter")}}</label>
            <div class="col">
            <span class="custom-control custom-switch custom-switch-lg">
                <input wire:click="filterToggle" class="custom-control-input" id="filterSwitch" name="filter" type="checkbox" @if($filterswitch == true) checked @endif>
                <label class="custom-control-label" style="margin-top: 3px;" for="filterSwitch"></label></span>
            </div>

        </div>
    </div>
    @endif

    <!-- Filter -->
    <div class="container">
        @if($filterswitch)
        <form wire:submit.prevent="filter" class="form-inline manage-filter d-flex justify-content-sm-start" method="GET" id="manage-filter"
              role="search">

            <label for="manage-filter"
                   class="sr-only">{{ __("Filter courses") }}</label>
            <input class="form-control w-75 " type="search"
                   wire:model="filterTerm"
                   id="manage-filter-text" autocomplete="off"
                   aria-haspopup="true"
                   placeholder="{{ __("Filter courses") }}"
                   style="font-size: 100% !important;"
                   aria-labelledby="manage-filter">
        </form>
        @endif
        @if(app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader')
            <!-- User filter -->
            @include('home.user_manage_filter')
            <!-- end User filter -->

        @endif
    </div>

    <div wire:loading wire:target="loadUncat">
        @include('livewire.modals.loading_spinner')
    </div>
    <div wire:loading wire:target="loadCourseVideos">
        @include('livewire.modals.loading_spinner')
    </div>

    <!-- Uncategorized -->
    <div id="accordion">
        <div class="card">
            <div id="headingOne">
                <h3 class="col mt-4" style="line-height: 1.5em;">
                    <a wire:click.prevent="loadUncat" @if($uncat) class="link" @else class="link collapsed"
                       @endif role="button" data-toggle="collapse" aria-expanded="false">
                        <i class="fa mr-2"></i>
                        {{__("Uncategorized")}}
                    </a>
                    <span class="badge badge-primary ml-2 mb-2" data-toggle="tooltip"
                          title="{{__("Number of presentations")}}">{{$uncatcounter}}</span>
                </h3>
            </div>

            <div id="collapseOne"
                 @if($uncat)
                     class="collapse show"
                 @else
                     class="collapse"
                 @endif
                 aria-labelledby="headingOne" data-parent="#accordion">
                <div class="d-flex flex-wrap">
                    @foreach ($uncat_videos as $video)
                        <div wire:key="{{ $video->id}}" class="col my-3">
                            @include('home.video_m')
                        </div>
                    @endforeach
                    <div class="col">
                        <div class="card video my-0 mx-auto"></div>
                    </div>
                    <div class="col">
                        <div class="card video my-0 mx-auto"></div>
                    </div>
                    <div class="col">
                        <div class="card video my-0 mx-auto"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-sm-start mt-4">
            <h2><span class="badge badge-primary ml-2 mb-2">{{count($video_courses)}} </span> <span style="color:blue;">@if(count($video_courses)>1 or count($video_courses)==0) {{__("Courses")}} @else {{__("Course")}} @endif</span></h2>
        </div>
        <!--Courses -->
        @foreach($video_courses as $key => $video_course)
            <div class="card">
                <div id="heading{{$key}}">
                    <h3 class="col mt-4" style="line-height: 1.5em;">
                        <a wire:click.prevent="loadCourseVideos({{$video_course->course->id}})"
                           @if($contend[$video_course->course->id]) class="link" @else class="link collapsed"
                           @endif role="button" data-toggle="collapse" aria-expanded="false"
                           aria-controls="collapse{{$key}}">
                            <i class="fa mr-2"></i>
                            {{$video_course->course->designation}}
                            {{$video_course->course->semester}}
                            {{$video_course->course->year}}
                            @if(Lang::locale() == 'swe')
                                {{$video_course->course->name}}
                            @else
                                {{$video_course->course->name_en}}
                            @endif
                        </a>
                        @if(!$contend[$video_course->course->id])
                            @include('livewire.status.coursestatus')
                        @endif
                    </h3>
                </div>
                <div id="collapse{{$key}}"
                     @if($contend[$video_course->course->id])
                         class="collapse show"
                     @else
                         class="collapse"
                     @endif
                     aria-labelledby="heading{{$key}}" data-parent="#accordion">
                    @include('livewire.status.coursestatusfull')
                    <div class="d-flex flex-wrap">
                        @foreach ($videos[$video_course->course->id] as $video)
                            <div wire:key="{{ $video['id'] }}" class="col my-3">
                                @include('home.video_m')
                            </div>
                        @endforeach
                        <div class="col">
                            <div class="card video my-0 mx-auto"></div>
                        </div>
                        <div class="col">
                            <div class="card video my-0 mx-auto"></div>
                        </div>
                        <div class="col">
                            <div class="card video my-0 mx-auto"></div>
                        </div>
                    </div>
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
                $('[data-toggle="tooltip"]').tooltip()
            })
        })
    });
</script>
