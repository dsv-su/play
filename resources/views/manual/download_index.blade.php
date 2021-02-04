@extends('layouts.suplay')
@section('content')
    <div class="container">
        <div class="row">
            <h2>Nerladdning av presentation id: {{$id}}</h2>
            <br>
        </div>
        <br>
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden"></span>
            </div>
        </div>
        <div id="fin">
            <a href="{{route('download_step3', $id)}}" role="button" class="btn btn-primary btn-lg float-right">Nästa <i class="fas fa-forward"></i></a>
        </div>
    </div>
    <script>
        $(document).ajaxStart(function(){
            // Show spinner container
            $("#fin").hide();
            $(".spinner-border").show();
        });
        $(document).ajaxComplete(function(){
            // Hide spinner container
            $(".spinner-border").hide();
            $("#fin").show();
            window.location = '/download_step2/{{$id}}';
        });
        $.get("/download_presentation/{{$id}}", function(data){
            $(".result").html(data);
        });
    </script>
@endsection
