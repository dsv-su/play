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

    </style>
    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <div>
                    <span class="su-theme-anchor"></span>
                    <h3 class="su-theme-header mb-4">
                        <span class="fas fa-address-card fa-icon-border mr-2" aria-hidden="true"></span>
                        {{__('Manage courses')}}
                    </h3>
                </div>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>
    <div class="container">
        @foreach($courselist as $year => $list)
            <h4 class="su-theme-header mb-4">{{$year}}</h4>
            @foreach($list as $courseId => $course)
                <div class="card video mt-5 border-5 pt-2 active pb-0 px-3 bg-light">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="card-title"><b>{{$course}}</b></h3>
                            </div>
                            <div class="col">
                                        <div class="row text-center">
                                            <div class="col">
                                                <div class="alert alert-secondary">
                                                    <span class="count-title">@if($presentations[$courseId] ?? 0)
                                                            {{$presentations[$courseId]}} @else 0 @endif</span>
                                                    <p class="count-text">{{ __("Presentations")  }}</p>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="alert alert-secondary">
                                                    <span class="count-title">
                                                           @if($individual_permissions[$courseId] ?? 0){{$individual_permissions[$courseId]}} @else
                                                            0 @endif
                                                        </span>
                                                    <p class="count-text">{{ __("Editing permissions")  }}</p>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="alert alert-secondary">
                                                    @if($playback_permissions[$courseId] ?? 0)
                                                        @switch($playback_permissions[$courseId]->permission_id)
                                                            @case(1)
                                                            <h2 class="timer count-title count-number">{{ __("DSV") }}</h2>
                                                            @break
                                                            @case(2)
                                                            <h2 class="timer count-title count-number">{{ __("Staff") }}</h2>
                                                            @break
                                                            @case(4)
                                                            <i class="fas fa-globe fa-3x"></i>
                                                            @break
                                                            @default
                                                            <i class="fas fa-user-lock fa-3x"></i>
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
                                                <div class="alert alert-secondary">
                                                    @if($coursesetlist[$courseId] ?? 0)
                                                        @if($coursesetlist[$courseId]['downloadable'] == false)
                                                            <span style="color: red;" class="count-title">
                                                            <i class="fas fa-times"></i>
                                                        </span>
                                                        @else
                                                            <span style="color: green;" class="count-title">
                                                            <i class="fas fa-check"></i>
                                                        </span>
                                                        @endif
                                                    @else
                                                        <span style="color: green;" class="count-title">
                                                        <i class="fas fa-times"></i>
                                                    </span>
                                                    @endif
                                                    <p class="count-text">{{ __("Downloadable") }}</p>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="alert alert-secondary">
                                                    @if($coursesetlist[$courseId] ?? 0)
                                                        @if($coursesetlist[$courseId]['visibility'] == false)
                                                            <span style="color: red;" class="count-title">
                                                            <i class="fas fa-times"></i>
                                                        </span>
                                                        @else
                                                            <span style="color: green;" class="count-title">
                                                            <i class="fas fa-check"></i>
                                                        </span>
                                                        @endif
                                                    @else
                                                        <span style="color: green;" class="count-title">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    @endif
                                                    <p class="count-text">{{ __("Visibility") }}</p>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <div class="alert alert-secondary">
                                                    <a class="badge badge-primary count-title" role="button"
                                                       href="{{ route('course_edit', $courseId) }}"><span class=""><i
                                                                    class="fas fa-cog "></i></span></a>
                                                    <p class="count-text ">{{ __("Edit") }}</p>
                                                </div>
                                            </div>

                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>

@endsection
