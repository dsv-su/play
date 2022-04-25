<div>
    <!-- Filter -->
    <div class="container align-self-center">
        <form class="form-inline manage-filter d-flex justify-content-between" method="GET" id="manage-filter" role="search">
            <h2><span style="color:blue;">{{count($video_courses)}}</span></h2>
            <label for="manage-filter" class="sr-only">{{ __("Filter courses") }}</label>
            <input class="form-control w-50 mx-auto" type="search"
                   wire:model="filterTerm"
                   id="manage-filter-text" autocomplete="off"
                   aria-haspopup="true"
                   placeholder="{{ __("Filter courses") }}"
                   aria-labelledby="manage-filter">
        </form>
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
                    <a wire:click.prevent="loadUncat" @if($uncat) class="link" @else class="link collapsed" @endif role="button" data-toggle="collapse"  aria-expanded="false">
                        <i class="fa mr-2"></i>
                        {{__("Uncategorized")}}
                    </a>
                    <span class="badge badge-primary ml-2 mb-2" data-toggle="tooltip" title="{{__("Number of presentations")}}">{{$uncatcounter}}</span>
                </h3>
            </div>

            <div id="collapseOne"
                 @if($uncat)
                 class="collapse show"
                 @else
                 class="collapse"
                 @endif
                 aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <div class="card-deck inner">
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
        </div>
        <!--Courses -->
        @foreach($video_courses as $key => $video_course)
            <div class="card">
                <div id="heading{{$key}}">
                    <h3 class="col mt-4" style="line-height: 1.5em;">
                        <a wire:click.prevent="loadCourseVideos({{$video_course->course->id}})" @if($contend[$video_course->course->id]) class="link" @else class="link collapsed" @endif role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse{{$key}}">
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
                    <div class="card">
                        @include('livewire.status.coursestatus')
                    </div>

                    <div class="card-body">
                        <div class="card-body">
                            <div class="card-deck inner">
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
                </div>
            </div>
        @endforeach
    </div> <!-- accordian -->
</div>
