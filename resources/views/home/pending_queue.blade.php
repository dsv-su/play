@extends('layouts.suplay')
@section('content')
    <!-- Header message section -->
    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <div>
                    <span class="su-theme-anchor"></span>
                    <h3 class="su-theme-header mb-4">
                        <span class="fas fa-layer-group fa-icon mr-2" aria-hidden="true"></span>
                        {{ __("Presentations from lecture halls or mediasite currently queued for conversion") }}
                    </h3>
                </div>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>
    <div class="container px-0">
        <div class="d-flex mb-3 flex-wrap">
            @foreach ($queue as $item)
                <div class="col my-3">
                    <div class="card video m-auto faded" style="box-shadow: 0 1rem 3rem rgba(240, 173, 78, 1.5)!important;">
                        <div class="card-header position-relative">
                            <div class="d-flex justify-content-center h-100">
                                <div class="d-inline alert alert-secondary m-auto"
                                     role="alert">{{ __("Processing") }}</div>
                            </div>
                        </div>
                        <div class="card-body p-1 overflow-hidden">
                            <div class="d-flex align-items-start">
                                <div>
                                    <h4 class="card-text font-1rem px-1 pt-2">{{ $item->recorder ?? ''}}</h4>
                                    <h4 class="card-text font-1rem px-1 pb-2">(recorded on {{$item->date ?? '' }} at {{$item->time ?? ''}})</h4>
                                </div>
                            </div>
                        </div>
                    </div>
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
