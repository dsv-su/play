@extends('layouts.suplay_upload')
@section('content')
    <div class="container">
        <div class="row">
            <h2>Download - Admin</h2>
        </div>
        <div class="row">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Status</th>
                    <th scope="col">Id</th>
                    <th scope="col">Updated</th>
                    <th scope="col">Title</th>
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
                            <td>{{$presentation->status}}</td>
                            <td>{{$presentation->id}}</td>
                            <td>{{$presentation->updated_at}}</td>
                            <td>{{$presentation->title}}</td>
                            @if($presentation->status == 'request download')
                                <td><a role="button" class="btn btn-danger btn-sm" href="{{route('download_delete', $presentation->id)}}">Erase</a></td>
                            @elseif($presentation->status == 'failed' or $presentation->status == 'stored')
                                <td><a role="button" class="btn btn-danger btn-sm" href="{{route('download_delete', $presentation->id)}}">Erase</a></td>
                                <td><a role="button" class="btn btn-danger btn-sm" href="{{route('admin_download_notify_resend', $presentation->id)}}">Resend Notify</a></td>
                            @elseif($presentation->status == 'update' or $presentation->status == 'newmedia')
                                <td><a role="button" class="btn btn-warning btn-sm" href="{{route('download_delete', $presentation->id)}}">Erase</a></td>
                            @elseif($presentation->status == 'sent')
                                <td><a role="button" class="btn btn-primary btn-sm" href="#">Unregister</a></td>
                                <td><a role="button" class="btn btn-warning btn-sm" href="{{route('admin_download_notify_resend', $presentation->id)}}">Resend Notify</a></td>
                            @endif
                        </tr>
                    </tbody>

                @endforeach
            </table>

        </div>
        <div class="row">
            <h2>Upload - Admin</h2>
        </div>
        <div class="row">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Status</th>
                    <th scope="col">Id</th>
                    <th scope="col">Created</th>

                    <th scope="col">Title</th>
                    <th scope="col">Local</th>
                    <th scope="col">Uploader</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                @foreach($manual_presentations as $manual_presentation)
                <tbody>
                    @if($manual_presentation->status == 'pending')
                        <tr class="table-warning">
                    @elseif($manual_presentation->status == 'failed' or $manual_presentation->status == 'stored')
                        <tr class="table-danger">
                    @endif
                            <td>{{$manual_presentation->status}}</td>
                            <td>{{$manual_presentation->id}}</td>
                            <td>{{$manual_presentation->created_at}}</td>
                            <td>{{$manual_presentation->title}}</td>
                            <td>{{$manual_presentation->local}}</td>
                            @foreach($manual_presentation->presenters as $uploader)
                                @if ($loop->first)
                                    <td>{{$uploader}}</td>
                                @endif
                            @endforeach
                            @if($manual_presentation->status == 'failed' or $manual_presentation->status == 'stored')
                                <td><a role="button" class="btn btn-danger btn-sm" href="{{route('manual_admin_notify_fail', $manual_presentation->id)}}">Notify fail</a></td>
                            @elseif($manual_presentation->status == 'pending')
                                <td><a role="button" class="btn btn-warning btn-sm" href="{{route('manual_admin_erase', $manual_presentation->id)}}">Erase</a></td>
                            @elseif($manual_presentation->status == 'notified')
                                <td><a role="button" class="btn btn-info btn-sm" href="{{route('manual_admin_unregister', $manual_presentation->id)}}">Unregister</a></td>
                            @elseif($manual_presentation->status == 'sent')
                                <td><a role="button" class="btn btn-primary btn-sm" href="{{route('manual_admin_unregister', $manual_presentation->id)}}">Unregister</a></td>
                            @endif
                        </tr>
                </tbody>

                @endforeach
            </table>

        </div>
        <div class="row">
            <h2>Modify video permissions - Admin</h2>
        </div>
        <div class="row">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">PresentationId</th>
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
                            <td>{{$video->id}}</td>
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
