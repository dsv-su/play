@extends('layouts.suplay')
@section('content')
    <style>
        .row {
            display: flex;
        }

        .col {
            flex: 1;
            padding: 0.5em;
        }

        .col p {
            margin: 0.5rem
        }

        .video-icon, .badge {
            font-size: 40px;
            font-family: "TheSansC5-SemiBoldWeb", Verdana, sans-serif;
        }

        .text-lowercase {
            font-size: 24px;
            font-family: "TheSansB2-Light", Verdana, sans-serif;
        }

    </style>
    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <div>
                    <span class="su-theme-anchor"></span>
                    <h3 class="su-theme-header mb-4">
                        <span class="fas fa-address-card fa-icon-border mr-2" aria-hidden="true"></span>
                        {{__("Manage courses")}}
                    </h3>
                </div>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>
    <div class="container">
        @foreach($courselist as $term => $list)
            <h4 class="su-theme-header col my-1 p-2 d-flex align-items-center" style="line-height: 1.5em;">
                <a class="link @if(array_key_first($courselist) !== $term) collapsed @else expanded @endif text-decoration-none"
                   data-toggle="collapse"
                   href="#collapse{{$term}}" role="button" aria-expanded="false"
                   aria-controls="collapse{{$term}}"><i class="fa mr-2"></i>{{$term}}
                </a>
                <span class="badge badge-light ml-3 text-lowercase">{{count($list)}} {{__("courses")}}</span>
            </h4>
            <div class="mb-4 collapse @if(array_key_first($courselist) !== $term) hide @else show @endif" id="collapse{{$term}}">
                @foreach($list as $courseId => $course)
                    <div class="shadow-sm card video mt-2 mb-4 border-5 pt-2 active pb-0 px-3 bg-light">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 px-1">
                                    <h3 class="card-title"><b>{{$course}}</b></h3>
                                </div>
                                <div class="col">
                                    <div class="row text-center">
                                        <div class="col col-xl-2">
                                            <div class="alert alert-secondary h-100 d-flex align-content-center p-1">
                                                <div class="my-auto align-middle mx-auto">
                                                    <span class="video-icon">@if($presentations[$courseId] ?? 0)
                                                            <a class="badge badge-primary" role="button"
                                                               href="{{ route('course.videos', $courseId) }}">{{$presentations[$courseId]}}</a> @else
                                                            0 @endif</span>
                                                    <p>{{ __("Presentations")  }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-xl-2">
                                            <div class="alert alert-secondary h-100 d-flex align-content-center p-1">
                                                <div class="my-auto align-middle mx-auto">
                                                    <span class="video-icon">
                                                           @if($individual_permissions[$courseId] ?? 0){{$individual_permissions[$courseId]}} @else
                                                            0 @endif
                                                        </span>
                                                    <p>{{ __("Permissions")  }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-xl-2">
                                            <div class="alert alert-secondary h-100 d-flex align-content-center p-1">
                                                <div class="my-auto align-middle mx-auto">
                                                    @if($playback_permissions[$courseId] ?? 0)
                                                        @switch($playback_permissions[$courseId]->permission_id)
                                                            @case(1)
                                                            <span class="video-icon text-success">{{ __("DSV") }}</span>
                                                            @break
                                                            @case(2)
                                                            <span class="video-icon text-secondary">{{ __("Staff") }}</span>
                                                            @break
                                                            @case(4)
                                                            <span class="video-icon"><i
                                                                        class="fas fa-globe text-warning"></i></span>
                                                            @break
                                                            @default
                                                            <span class="video-icon"><i
                                                                        class="fas fa-user-lock text-info"></i></span>
                                                        @endswitch
                                                    @else
                                                        <span class="video-icon text-success">{{ __("DSV") }}</span>
                                                    @endif
                                                    <p>
                                                    <!--
                                                    @if($playback_permissions[$courseId] ?? 0)
                                                        @switch($playback_permissions[$courseId]->permission_id)
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
                                                            -->
                                                        <!-- We need to display the term rather than value -->
                                                        {{__("Playback") }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-xl-2">
                                            <div class="alert alert-secondary h-100 d-flex align-content-center p-1">
                                                <div class="my-auto align-middle mx-auto">
                                                    @if($coursesetlist[$courseId] ?? 0)
                                                        @if($coursesetlist[$courseId]['downloadable'] == false)
                                                            <span class="text-danger video-icon">
                                                            <i class="fas fa-times"></i>
                                                        </span>
                                                        @else
                                                            <span class="text-success video-icon">
                                                            <i class="fas fa-check"></i>
                                                        </span>
                                                        @endif
                                                    @else
                                                        <span class="text-danger video-icon">
                                                        <i class="fas fa-times"></i>
                                                    </span>
                                                    @endif
                                                    <p>{{ __("Downloadable") }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-xl-2">
                                            <div class="alert alert-secondary h-100 d-flex align-content-center p-1">
                                                <div class="my-auto align-middle mx-auto">
                                                    @if($coursesetlist[$courseId] ?? 0)
                                                        @if($coursesetlist[$courseId]['visibility'] == false)
                                                            <span class="text-danger video-icon">
                                                            <i class="fas fa-times"></i>
                                                        </span>
                                                        @else
                                                            <span class="text-success video-icon">
                                                            <i class="fas fa-check"></i>
                                                        </span>
                                                        @endif
                                                    @else
                                                        <span class="text-success video-icon">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    @endif
                                                    <p>{{ __("Visibility") }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col col-xl-2">
                                            <div class="alert alert-secondary h-100 d-flex align-content-center p-1">
                                                <div class="my-auto align-middle mx-auto">
                                                    <a class="badge badge-primary video-icon" role="button"
                                                       href="{{ route('course_edit', $courseId) }}"><span class=""><i
                                                                    class="fas fa-cog "></i></span></a>
                                                    <p>{{ __("Settings") }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
