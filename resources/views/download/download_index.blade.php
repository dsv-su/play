@extends('layouts.suplay')
@section('content')
    <div class="container">
        <div class="row">
            @if(app()->make('play_role') == 'Administrator')
                <h1 class="word-wrap_xs-only" id="sub-entry-page-header" lang="en">Presentation</h1>
            @else
                <h1 class="word-wrap_xs-only" id="sub-entry-page-header" lang="sv">Presentation</h1>
            @endif
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{$video->title}}
                    </div>
                    <img class="card-img-top" src="{{ $video->thumb}}" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text border-bottom pb-3"><small>ID: {{$video->id}}</small></p>
                        @if(app()->make('play_role') == 'Administrator')
                            <p class="card-text"><small>Length: {{ $video->duration }} H.</small></p>
                        @else
                            <p class="card-text"><small>Längd: {{ $video->duration }} H.</small></p>
                        @endif
                    </div>
                </div>
            </div>
        <br>
        <div id="fin">
            @if(app()->make('play_role') == 'Administrator')
                <div class="float-right">
                    <a href="{{route('download_step3', $video->id)}}" role="button" class="btn btn-primary btn-sm">Edit</a>
                    <a href="{{route('manage')}}" role="button" class="btn btn-warning btn-sm">Back</a>
                </div>
            @else
                <div class="float-right">
                    <a href="{{route('download_step3', $video->id)}}" role="button" class="btn btn-primary btn-sm">Redigera</a>
                    <a href="{{route('manage')}}" role="button" class="btn btn-warning btn-sm">Tillbaka</a>
                </div>
            @endif
        </div>
    </div>
    <!-- Modal -->
        <div class="modal fade" id="load" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="loader"></div>
                        <div class="loader-txt">
                            <p>Nerladdning pågår<br></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <script>
        $(document).ajaxStart(function(){
            // Show spinner
            $("#fin").hide();
            $('.modal').modal('show');
        });
        $(document).ajaxComplete(function(){
            // Hide spinner
            $('.modal').modal('hide');
            $("#fin").show();
            window.location = '/download_step2/{{$video->id}}';
        });
        $.get("/download_presentation/{{$video->id}}", function(data){
            $(".result").html(data);
        });
    </script>
@endsection
