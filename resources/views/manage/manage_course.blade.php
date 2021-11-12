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
            /*min-height: 100px;
            margin: 0 auto;
            /*display: -webkit-flex;
            display: flex;  Standard syntax */
        }

        .count-text {
            font-size: 13px;
            font-weight: normal;
            margin-top: 10px;
            margin-bottom: 0;
            text-align: center;
        }
        .fa-cog {
            color: blue;
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
                                <p class="card-text text-muted small">Here some instructions</p>
                            </h6>
                        </div>
                        <div class="col-md-auto">
                            <ul class="list-inline d-flex">
                                <li class="list-inline-item">
                                    <div class="row text-center">
                                        <div class="col">
                                            <div class="courseset">
                                                <h2 class="timer count-title count-number">0</h2>
                                                <p class="count-text">{{ __("Editing permissions")  }}</p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="courseset">
                                                <h2 class="timer count-title count-number">0</h2>
                                                <p class="count-text">{{ __("Visibility") }}</p>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="courseset">
                                                <h2 class="timer count-title count-number">0</h2>
                                                <p class="count-text">{{ __("Viewing permissions") }}</p>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="courseset">
                                                <a href="{{ route('course_edit', $courseId) }}"><div class="timer count-title count-number"><i class="fas fa-cog"></i></div></a>
                                                <p class="count-text ">Edit</p>
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
