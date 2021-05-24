@extends('layouts.suplay')
@section('content')
    @if(session()->has('message'))
        <div class="container align-self-center">
            <div class="alert {{session('alert') ?? 'alert-info'}}">
                {{ session('message') }}
            </div>
        </div>
    @endif
    <div class="container align-self-center">
        <form class="form-inline form-main-search d-flex justify-content-between"
              id="header-main-search-form" name="header-main-search-form"
              action="{{ route('search') }}" method="POST" data-search="/s%C3%B6k"
              role="search">
            @csrf
            <label for="header-main-search-text" class="sr-only">{{ __("Search for videos") }}</label>
            <input class="form-control w-100 mx-auto" type="search"
                   id="header-main-search-text" name="q" autocomplete="off"
                   aria-haspopup="true"
                   placeholder="{{ __("Search for videos") }}"
                   aria-labelledby="header-main-search-form">
        </form>
    </div>

    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <div>
                    <span class="su-theme-anchor"></span>
                    <h3 class="su-theme-header mb-4">
                        @if(count($latest)>0)
                        <span class="far fa-clock fa-icon-border mr-2" aria-hidden="true"></span>
                            {{ __("Last added") }}
                        @else
                            {{ __("No presentations from ongoing courses were found") }}
                        @endif
                        @if (in_array(app()->make('play_role'), [ 'Student','Student1', 'Student2', 'Student3']) && count($latest)>0)
                                {{ __("from your ongoing courses") }}
                        @endif
                        @if (isset($course))
                                {{ __("from the course") }} <i>{{$course}}</i>
                        @elseif (isset($tag)) {{ __("after the tag: ") }} <i>{{$tag}}</i>
                        @elseif (isset($presenter))  {{ __("by") }} <i>{{$presenter}}</i>
                        @endif
                    </h3>

                </div>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>

    <div class="container px-0">
        <div class="d-flex mb-3 flex-wrap">
            @foreach ($latest as $video)
                <div class="col my-3">
                    @include('home.video')
                </div>
            @endforeach
            <div class="col">
                <div class="card video my-0 mx-auto "></div>
            </div>
            <div class="col">
                <div class="card video my-0 mx-auto "></div>
            </div>
            <div class="col">
                <div class="card video my-0 mx-auto "></div>
            </div>
        </div>

    </div><!-- /.container -->

@endsection
