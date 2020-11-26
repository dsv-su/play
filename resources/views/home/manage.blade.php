@extends('layouts.dsvplay')
@section('content')

    <h4>Video management</h4>
    <div class="wrapper">
        @foreach($videos as $video)
            <div class="">
                <img src="{{$video->image}}" alt="Card image cap" style="max-width: 100px;">
                    <h5>{{$video->title}}</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        cards content.</p>

            </div>
        @endforeach
    </div>