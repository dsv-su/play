@extends('layouts.suplay_upload')
@section('content')
    <div class="container">
        <div class="row">
            <h2>Ändra uppspelningsrättigheter</h2>
        </div>
        <br>
        <div class="row">
            <div class="card w-75">
                <div class="card-header">
                    Modify video permissions
                </div>
                <div class="card-body">
                    <h5 class="card-title">Titel: {{$title}}</h5>
                    <form method="post" action="{{route('admin_permission_store', $id)}}">
                        @csrf
                        <p class="card-text"><small class="text-muted">VideoID: {{$id}}, PresentationId: {{$presentation_id}}</small></p>
                        <p class="card-text">Längd: {{ $duration }} sek.</p>
                        <p class="card-text"><small class="text-muted">Entitlement:</small></p>
                        <select name="permission" class="form-control">
                            @if($permission == 'true')
                                <option value="true" selected>Private</option>
                                <option value="false">Public</option>
                            @else
                                <option value="false" selected>Public</option>
                                <option value="true">Private</option>
                            @endif
                        </select>
                        <input type="text" class="form-control" name="entitlement"  value="{{$entitlement}}">
                        <button type="submit" class="btn btn-primary btn-sm">Modify</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
