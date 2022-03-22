@extends('layouts.suplay')
@section('content')
    <!-- Header message section -->
    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <div>
                    <span class="su-theme-anchor"></span>
                    <h3 class="su-theme-header mb-4">
                        <span class="fas fa-layer-group fa-icon-border mr-2" aria-hidden="true"></span>
                        {{ __("Mediasite presentations currently queued for conversion") }}
                    </h3>
                </div>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>
    <div class="container px-0">
        <div class="d-flex mb-3 flex-wrap">
            @foreach ($videos as $video)
                <div class="col my-3">
                    @include('home.pending_video')
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
    </div><!-- /.container -->
@endsection
