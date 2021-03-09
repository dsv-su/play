@extends('layouts.suplay')
@section('content')
    <div class="container">
        <h3>Admin</h3>
        <div class="row">
            <div class="col-md-2 mb-3">
                <ul class="nav nav-pills flex-column" id="admin" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="video-tab" data-toggle="tab" href="#video" role="tab" aria-controls="video" aria-selected="true">Owner info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="permission-tab" data-toggle="tab" href="#permission" role="tab" aria-controls="permission" aria-selected="false">Permissions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="upload-tab" data-toggle="tab" href="#upload" role="tab" aria-controls="upload" aria-selected="false">Upload</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="download-tab" data-toggle="tab" href="#download" role="tab" aria-controls="download" aria-selected="false">Download</a>
                    </li>
                </ul>
            </div>
            <!-- /.col-md-4 -->
            <div class="col-md-10">
                <div class="tab-content" id="adminContent">
                    <div class="tab-pane fade show active" id="video" role="tabpanel" aria-labelledby="video-tab">

                        <h2>Video</h2>
                        <div class="container px-0">
                            <div class="d-flex mb-3 flex-wrap">
                            @foreach ($owners as $video)
                                <div class="col my-3">
                                    @include('home.video')
                                </div>
                            @endforeach
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="permission" role="tabpanel" aria-labelledby="permission-tab">
                        <h2>Video Permissons</h2>
                        <div class="row">
                            New
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">PresentationId</th>
                                    <th scope="col">Permission</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($permissions as $permission)
                                    <tr>
                                        <td>{{$permission->video_id}}</td>
                                        <td>{{$permission->permission->scope}}</td>
                                        <td><a role="button" class="btn btn-primary btn-sm" href="/set_permission/{{$permission->video_id}}">Modify</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                        <h2>Upload</h2>
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
                                            <td>{{$manual_presentation->user}}</td>
                                            @if($manual_presentation->status == 'failed' or $manual_presentation->status == 'stored')
                                                <td><a role="button" class="btn btn-danger btn-sm" href="{{route('manual_admin_notify_fail', $manual_presentation->id)}}">Notify fail</a></td>
                                            @elseif($manual_presentation->status == 'pending')
                                                <td><a role="button" class="btn btn-warning btn-sm" href="{{route('manual_admin_erase', $manual_presentation->id)}}">Erase</a></td>
                                            @elseif($manual_presentation->status == 'notified')
                                                <td><a role="button" class="btn btn-info btn-sm" href="{{route('manual_admin_unregister', $manual_presentation->id)}}">Unregister</a></td>
                                            @elseif($manual_presentation->status == 'sent' or $manual_presentation->status == 'init')
                                                <td><a role="button" class="btn btn-primary btn-sm" href="{{route('manual_admin_unregister', $manual_presentation->id)}}">Unregister</a></td>
                                            @endif
                                        </tr>
                                    </tbody>

                                @endforeach
                            </table>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="download" role="tabpanel" aria-labelledby="download-tab">
                        <h2>Download</h2>
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
                                                <td><a role="button" class="btn btn-primary btn-sm" href="{{route('download_delete', $presentation->id)}}">Unregister</a></td>
                                                <td><a role="button" class="btn btn-warning btn-sm" href="{{route('admin_download_notify_resend', $presentation->id)}}">Resend Notify</a></td>
                                            @endif
                                        </tr>
                                    </tbody>

                                @endforeach
                            </table>

                        </div>

                    </div>
                </div>
            </div>
            <!-- /.col-md-8 -->
        </div>



    </div>
    <!-- /.container -->


@endsection
