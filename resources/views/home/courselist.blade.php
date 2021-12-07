@foreach ($videos as $key => $videocourse)
    <h3 class="col mt-4">
        @if (isset($videocourses))
            <a class="link" data-toggle="collapse"
               href="#collapse{{$key}}" role="button" aria-expanded="false"
               aria-controls="collapse{{$key}}">
                <i class="fa mr-2"></i>{{\App\Course::find($key) ? \App\Course::find($key)->name . ' ' . \App\Course::find($key)->semester.\App\Course::find($key)->year : 'Uncategorized'}}</a>
            <span class="badge badge-primary">{{count($videocourse)}}</span>
            @if (isset($manage) && $manage)
                @if ($key) <a class="badge badge-primary" role="button" style="height: 32.38px;"
                              href="{{ route('course_edit', $key) }}"><i class="fas fa-cog"></i></a>
                @endif
            @endif
        @else
            <a class="link @if ($videos->first() !== $videocourse) collapsed @endif" data-toggle="collapse"
               href="collapse{{$key}}" role="button" aria-expanded="false"
               aria-controls="collapse{{$key}}"><i class="fa mr-2"></i>
                {{\App\Course::find($key)->semester.\App\Course::find($key)->year}}
            </a>
            <span class="badge badge-primary">{{count($videocourse)}}</span>
        @endif
    </h3>

    <div class="collapse @if ($videos->first() == $videocourse || (isset($manage) && $manage)) show @endif"
         id="collapse{{$key}}">
        @if (isset($manage) && $manage)
            <div class="col">
            <div class="alert alert-secondary d-inline-block" role="alert">
                    <ul class="list-inline d-flex m-0">
                        <li class="list-inline-item">
                            <div class="row text-center">
                                <div class="col">
                                    <div class="courseset">
                                        <h2 class="timer count-title count-number">@if($individual_permissions[$key] ?? 0){{$individual_permissions[$key]}}@else 0 @endif</h2>
                                        <p class="count-text">{{ __("Editing permissions")  }}</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="courseset">
                                        @if($playback_permissions[$key] ?? 0)
                                            @switch($playback_permissions[$key]->permission_id)
                                                @case(1)
                                                <span style="color:green;">
                                                                    <h2 class="timer count-title count-number">{{ __("DSV") }}</h2>
                                                                </span>
                                                @break
                                                @case(2)
                                                <h2 class="timer count-title count-number">{{ __("Staff") }}</h2>
                                                @break
                                                @case(4)
                                                <span style="color: red;">
                                                                    <i class="fas fa-globe fa-3x"></i>
                                                                </span>
                                                @break
                                                @default
                                                <i class="fas fa-user-lock fa-3x"></i>
                                            @endswitch
                                        @else
                                            <span style="color:green;">
                                                        <h2 class="timer count-title count-number">{{ __("DSV") }}</h2>
                                                        </span>
                                        @endif
                                        <p class="count-text">
                                            @if($playback_permissions[$key] ?? 0)
                                                @switch($playback_permissions[$key]->permission_id)
                                                    @case(1)
                                                    {{ __("Students/Staff") }}
                                                    @break
                                                    @case(2)
                                                    {{ __("DSV Staff") }}
                                                    @break
                                                    @case(4)
                                                    {{ __("Public") }}
                                                    @break
                                                    @default
                                                    {{ __("Custom") }}
                                                @endswitch
                                            @else
                                                {{ __("Students/Staff") }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="courseset">
                                        @if($coursesetlist[$key] ?? 0)
                                            @if($coursesetlist[$key]['downloadable'] == false)
                                                <span style="color: red;">
                                                            <i class="fas fa-times fa-3x"></i>
                                                        </span>
                                            @else
                                                <span style="color: green;">
                                                            <i class="fas fa-check fa-3x"></i>
                                                        </span>
                                            @endif
                                        @else
                                            <span style="color: green;">
                                                        <i class="fas fa-times fa-3x"></i>
                                                    </span>
                                        @endif
                                        <p class="count-text">{{ __("Downloadable") }}</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="courseset">
                                        @if($coursesetlist[$key] ?? 0)
                                            @if($coursesetlist[$key]['visibility'] == false)
                                                <span style="color: red;">
                                                            <i class="fas fa-times fa-3x"></i>
                                                        </span>
                                            @else
                                                <span style="color: green;">
                                                            <i class="fas fa-check fa-3x"></i>
                                                        </span>
                                            @endif
                                        @else
                                            <span style="color: green;">
                                                        <i class="fas fa-check fa-3x"></i>
                                                    </span>
                                        @endif
                                        <p class="count-text">{{ __("Visibility") }}</p>
                                    </div>
                                </div>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            @endif
        <div class="d-flex flex-wrap">
            @foreach ($videocourse as $video)
                <div class="col my-3">
                    @include('home.video')
                </div>
            @endforeach
            <div class="col">
                <div class="card video my-0 mx-auto border-0"></div>
            </div>
            <div class="col">
                <div class="card video my-0 mx-auto border-0"></div>
            </div>
            <div class="col">
                <div class="card video my-0 mx-auto border-0"></div>
            </div>
        </div>
    </div>
@endforeach