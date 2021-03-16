@extends('layouts.suplay')
@section('content')
    @if(session()->has('message'))
        <div class="alert {{session('alert') ?? 'alert-info'}}">
            {{ session('message') }}
        </div>
    @endif
    <div class="container align-self-center">
        <form class="form-inline form-main-search d-flex justify-content-between"
              id="header-main-search-form" name="header-main-search-form"
              action="{{ route('search') }}" method="POST" data-search="/s%C3%B6k"
              role="search">
            @csrf
            <label for="header-main-search-text" class="sr-only">Sök på videos</label>
            <input class="form-control w-100 mx-auto" type="search"
                   id="header-main-search-text" name="q" autocomplete="off"
                   aria-haspopup="true"
                   placeholder="Sök på videos"
                   aria-labelledby="header-main-search-form">
        </form>
    </div>
    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <div>
                    <span class="su-theme-anchor"></span>
                    <h3 class="su-theme-header mb-4">
                        @if($term ?? '' and $year ?? '')
                            <span class="fas fa-layer-group fa-icon-border mr-2" aria-hidden="true"></span>
                            Presentationer från {{$term}} {{$year}}
                        @elseif($designation ?? '')
                            <span class="fas fa-address-card fa-icon-border mr-2" aria-hidden="true"></span>
                            Kurs: <i>{{$designation}}</i>
                        @elseif($category ?? '')
                            <span class="fas fa-address-card fa-icon-border mr-2" aria-hidden="true"></span>
                            Kategori: <i>{{$category}}</i>
                        @endif

                    </h3>

                </div>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>

    <div class="container px-0">
        @if(count($videos) > 0)
        @foreach ($videos as $key => $videocourse)
        <h3>@if($designation ?? '') {{$designation}} @elseif($category ?? '') {{$category}} @endif {{$key}} ({{count($videocourse)}} st)</h3>

            <div class="d-flex mb-3 flex-wrap">
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
        @endforeach
        @else
        <h3>Inga presentationer</h3>
        @endif
    </div><!-- /.container -->
@endsection