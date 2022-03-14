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
                        {{ __("All semesters") }}
                    </h3>
                </div>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>
    <div class="container">
        @foreach ($terms as $key => $term)
            <h3 class="row no-gutters mt-4" style="line-height: 1.5em;">
                <a class="link"
                   role="button" aria-expanded="false" href="/semester/{{$term}}">
                    <i class="fa mr-2"></i>{{$term}}</a>
            </h3>
        @endforeach
    </div>
@endsection
