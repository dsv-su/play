@extends('layouts.suplay_upload')
@section('content')
    <div class="container">
        <div class="row">
            <h2>Manuell uppladdning - Admin</h2>
        </div>
        <div class="row">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Created</th>
                    <th scope="col">Status</th>
                    <th scope="col">Title</th>
                    <th scope="col">Local</th>
                    <th scope="col">Uploader</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                @foreach($presentations as $presentation)
                <tbody>
                    @if($presentation->status == 'pending')
                        <tr class="table-warning">
                    @elseif($presentation->status == 'failed' or $presentation->status == 'stored')
                        <tr class="table-danger">
                    @endif
                            <td>{{$presentation->created_at}}</td>
                            <td>{{$presentation->status}}</td>
                            <td>{{$presentation->title}}</td>
                            <td>{{$presentation->local}}</td>
                            @foreach($presentation->presenters as $uploader)
                                @if ($loop->first)
                                    <td>{{$uploader}}</td>
                                @endif
                            @endforeach
                            @if($presentation->status == 'failed' or $presentation->status == 'stored')
                                <td><a role="button" class="btn btn-danger btn-sm" href="{{route('manual_admin_notify', $presentation->id)}}">Notify</a></td>
                            @elseif($presentation->status == 'pending')
                                <td><a role="button" class="btn btn-warning btn-sm" href="{{route('manual_admin_erase', $presentation->id)}}">Erase</a></td>
                            @elseif($presentation->status == 'notified')
                                <td><a role="button" class="btn btn-info btn-sm" href="{{route('manual_admin_unregister', $presentation->id)}}">Unregister</a></td>
                            @elseif($presentation->status == 'sent')
                                <td><a role="button" class="btn btn-primary btn-sm" href="{{route('manual_admin_unregister', $presentation->id)}}">Unregister</a></td>
                            @endif
                        </tr>
                </tbody>

                @endforeach
            </table>

        </div>
        <div class="row">
            <h2>Ändra uppspelningsbehörighet - Admin</h2>
        </div>
        <div class="row">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Presentation</th>
                    <th scope="col">Title</th>
                    <th scope="col">Duration</th>
                    <th scope="col">Permission</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                @foreach($videos as $video)
                    <tbody>
                    @if($video->permission == 'true')
                        <tr class="table-warning">
                        @else
                        <tr>
                    @endif
                            <td>{{$video->presentation_id}}</td>
                            <td>{{$video->title}}</td>
                            <td>{{$video->duration}}</td>
                            @if($video->permission == 'true')
                                <td>private</td>
                            @else
                                <td>public</td>
                            @endif
                            <td><a role="button" class="btn btn-primary btn-sm" href="{{route('admin_permission', $video->id)}}">Modify</a></td>
                        </tr>
                    </tbody>

                @endforeach
            </table>

        </div>
    </div>
@endsection
