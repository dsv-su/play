@extends('layouts.suplay')
@section('content')
    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <div>
                    <span class="su-theme-anchor"></span>
                    <h3 class="su-theme-header mb-4">
                        <span class="far fa-clock fa-icon mr-2" aria-hidden="true"></span>
                        {{ __("Pending uploads") }}
                    </h3>
                </div>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>

    <div class="container">
        <div class="row">
            @foreach ($pending as $key => $video)
                <div class="col my-3">
                    <!-- Video - child view - will inherit all data available in the parent view-->
                    <div class="card video m-auto" id="{{$video->id}}">
                    <!-- hide action icons for now
                    <div id="action-icons" class="flex-column m-1">
                                <div class="mb-1">
                                    <a href="{{route('presentation_edit', $video->id)}}" data-toggle="tooltip" data-placement="left"
                                       title="{{ __('Edit presentation') }}" class="btn btn-dark btn-sm"><i
                                                class="far fa-edit fa-fw"></i></a>
                                </div>
                                <div class="mb-1">
                                    <form>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <a href="#" data-toggle="tooltip" data-placement="left"
                                           title="{{ __("Delete presentation") }}"
                                           class="btn btn-dark btn-sm delete"><i
                                                    class="far fa-trash-alt fa-fw"></i></a>
                                    </form>
                                </div>
                    </div>
-->
                        <div class="card-header position-relative"
                             style="background-image: url({{ url('/storage/'.$video->local.'/'. $video->thumb) }}); height:200px;">
                            <div class="d-flex justify-content-center h-100">
                                <div class="d-inline alert alert-secondary m-auto"
                                     role="alert">{{ __("Processing started at ") }} {{$video->created_at}}</div>
                            </div>
                            <p class="m-1 px-1"> {{\Carbon\Carbon::parse($video->duration)->toTimeString()}} </p>
                        </div>
                        <div class="card-body p-1 overflow-hidden">
                            <div class="d-flex align-items-start">
                                <div class=""><h4 class="card-text font-1rem px-1 py-2"><a
                                                href="{{ route('player', ['video' => $video]) }}"
                                                class="link">{{ $video->title }}</a></h4>
                                </div>
                                @if ($video->description)
                                    <div class="ml-auto showmore">
                                        <a tabindex="0" class="btn btn-sm" role="button" data-toggle="popover"
                                           data-trigger="focus"
                                           data-original-title="Description"
                                           data-placement="bottom"
                                           data-content="{{$video->description}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor"
                                                 class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <p class="card-text">
                                @if ($video->courses)
                                    @foreach($video->courses as $designation)
                                        <a href="/designation/{{$designation}}"
                                           class="badge badge-primary">{{$designation}}</a>
                                    @endforeach
                                @endif
                                @if ($video->presenters)
                                    @foreach($video->presenters as $username)
                                        <span class="badge badge-light">{{$username}}</span>
                                    @endforeach
                                @endif
                                @if ($video->tags)
                                    @foreach($video->tags as $tag)
                                        <span class="badge badge-secondary">{{$tag}}</span>
                                    @endforeach
                                @endif
                            </p>
                        </div>
                    </div>
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

@endsection
