@extends('layouts.suplay')
@section('content')
    <style>
        .row {
            display: flex;
        }
        .col {
            flex: 1;
            padding: 1em;

        }
        .courseset {
            min-height: 100%;
            background-color: #f5f5f5;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 0 auto;
            /*display: -webkit-flex;
            display: flex;*/
        }

        .count-text {
            font-size: 13px;
            font-weight: normal;
            margin-top: 10px;
            margin-bottom: 0;
            text-align: center;
        }
    </style>
    <div class="container">
        @foreach($courselist as $year => $list)
            <h3 class="su-theme-header mb-4">{{$year}}</h3>
            @foreach($list as $courseId => $course)
            <div class="card mt-5 border-5 pt-2 active pb-0 px-3" style="background-color: #DADADA">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title"><b>{{$course}}</b></h4>
                        </div>

                        <div class="col">
                            <h6 class="card-subtitle mb-2 text-muted">
                                <p class="card-text text-muted small"></p>
                            </h6>
                        </div>

                        <div class="col-md-auto">
                            <ul class="list-inline d-flex">
                                <li class="list-inline-item">
                                    <div class="row text-center">
                                        <div class="col">
                                            <div class="courseset">
                                                <h2 class="timer count-title count-number">@if($individual_permissions[$courseId] ?? 0){{$individual_permissions[$courseId]}}@else 0 @endif</h2>
                                                <p class="count-text">{{ __("Editing permissions")  }}</p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="courseset">
                                                    @if($playback_permissions[$courseId] ?? 0)
                                                        @switch($playback_permissions[$courseId]->permission_id)
                                                            @case(1)
                                                                <h2 class="timer count-title count-number">{{ __("DSV") }}</h2>
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
                                                                <span style="color: blue;">
                                                                    <i class="fas fa-user-lock fa-3x"></i>
                                                                </span>
                                                        @endswitch
                                                    @else
                                                        <h2 class="timer count-title count-number">{{ __("DSV") }}</h2>
                                                    @endif
                                                <p class="count-text">
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
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="courseset">
                                                @if($coursesetlist[$courseId] ?? 0)
                                                    @if($coursesetlist[$courseId]['downloadable'] == false)
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
                                                @if($coursesetlist[$courseId] ?? 0)
                                                    @if($coursesetlist[$courseId]['visibility'] == false)
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

                                        <div class="col">
                                            <div class="courseset">
                                                <a class="btn btn-outline-primary" role="button" href="{{ route('course_edit', $courseId) }}"><span style="color: blue;"><i class="fas fa-cog fa-3x"></i></span></a>
                                                <p class="count-text ">{{ __("Edit") }}</p>
                                            </div>
                                        </div>

                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endforeach
    </div>

@endsection
