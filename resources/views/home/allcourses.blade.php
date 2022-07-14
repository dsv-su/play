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
                        {{ __("All courses") }}
                    </h3>
                </div>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>
    <div class="container">
        @foreach ($courses as $course)
            <h3 class="col no-gutters mt-4" style="line-height: 1.5em;">
                <a class="link"
                   role="button" aria-expanded="false" href="/designation/{{$course->designation}}">
                    @if(Lang::locale() == 'swe'){{$course->designation . ' — ' .$course->name}}
                    @else{{$course->designation . ' — ' .$course->name_en}}
                    @endif</a>
                @foreach($course->terms as $term)
                    <span class="badge badge-light ml-2 mb-2">{{$term}}</span>
                @endforeach
            </h3>
        @endforeach
    </div>
@endsection
