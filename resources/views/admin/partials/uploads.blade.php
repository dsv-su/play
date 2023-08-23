@extends('layouts.suplay')
@section('content')
    <div class="container">
        <h2>Package status</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin_flush')}}">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Package status</li>
            </ol>
        </nav>

        {{--}}
        <div class="card" style="border: 1px solid #3E7DC0 !important;">
            <div class="card-body">
                {{ __("Uploads are deleted after status completed.") }}
            </div>
        </div>
        {{--}}
        <h3>Incoming - Queue status</h3>
        <div class="row">
            <table class="table table-sm table-bordered" style="font-size: small;">
                <thead>
                <tr>
                    <th scope="col">Pkg_id</th>
                    <th scope="col">Latest Handler</th>
                    <th scope="col">Pending Handler</th>
                    <th scope="col">jobid</th>
                    <th scope="col">Title</th>
                    <th scope="col">Last updated</th>
                </tr>
                </thead>
                <tbody>
                @foreach($queued_presentations as $queued_presentation)
                    <tr>
                        <td>{{$queued_presentation->id}}</td>
                        <td>
                            @if($queued_presentation->origin == 'manual')
                                <span class="badge badge-primary">{{$queued_presentation->origin}}</span>
                            @elseif($queued_presentation->origin == 'edit')
                                <span class="badge badge-secondary">{{$queued_presentation->origin}}</span>
                            @elseif($queued_presentation->origin == 'mediasite')
                                <span class="badge badge-info">{{$queued_presentation->origin}}</span>
                            @else
                                {{$queued_presentation->origin}}
                            @endif

                        </td>
                        <td>
                            @if(json_decode($queued_presentation->presentation, true)['pending'] ?? false)
                                @foreach(json_decode($queued_presentation->presentation, true)['pending'] as $pending)
                                    {{$pending}}
                                @endforeach
                            @endif
                        </td>
                        <td>{{$queued_presentation->notification_id}}</td>
                        <td>{{Str::limit($queued_presentation->title, 16)}}</td>
                        <td>{{$queued_presentation->updated_at}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <h3>Uploads/Edit - status</h3>
        <div class="row">
            <table class="table table-sm table-bordered" style="font-size: small;">
                <thead>
                <tr>
                    <th scope="col">Status</th>
                    <th scope="col">Type</th>
                    <th scope="col">jobid</th>
                    <th scope="col">pkg_id</th>
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

                        <td>
                            @if($manual_presentation->status == 'stored')
                                <span class="badge badge-warning">
                            @elseif($manual_presentation->status == 'sent')
                                <span class="badge badge-info">
                            @elseif($manual_presentation->status == 'completed')
                                <span class="badge badge-success">
                            @elseif($manual_presentation->status == 'failed')
                                <span class="badge badge-danger">
                            @endif
                                {{$manual_presentation->status}}</span>
                        </td>
                        <td>
                            @if($manual_presentation->type == 'manual')
                                <span class="badge badge-primary">
                            @elseif($manual_presentation->type == 'edit')
                                <span class="badge badge-secondary">
                            @else
                                <span class="badge badge-info">
                            @endif
                                {{$manual_presentation->type}}</span>
                        </td>
                        <td>{{$manual_presentation->jobid}}</td>
                        <td>{{$manual_presentation->pkg_id}}</td>
                        <td>{{\Carbon\Carbon::parse($manual_presentation->created_at)->format('Y-m-d H:i')}}</td>
                        <td>{{Str::limit($manual_presentation->Langtitle, 10)}}</td>
                        <td>{{$manual_presentation->local}}</td>
                        <td>{{$manual_presentation->user}}</td>

                        @if($manual_presentation->status == 'failed' or $manual_presentation->status == 'stored' or $manual_presentation->status == 'sent')
                            <td>
                                <a role="button" class="btn btn-danger btn-sm" style="font-size: smaller;"
                                   href="{{route('manual_admin_notify_fail', $manual_presentation->id)}}">Notify
                                    fail</a>
                                <a role="button" class="btn btn-warning btn-sm" style="font-size: smaller;"
                                               href="{{route('manual_admin_erase', $manual_presentation->id)}}">Erase</a>
                            </td>
                        @elseif($manual_presentation->status == 'pending')
                            <td>
                                <a role="button" class="btn btn-warning btn-sm" style="font-size: smaller;"
                                   href="{{route('manual_admin_erase', $manual_presentation->id)}}">Erase</a>
                                <a role="button" class="btn btn-info btn-sm" style="font-size: smaller;"
                                   href="{{route('manual_admin_cancel', $manual_presentation->id)}}">Notify user</a>
                                <a role="button" class="btn btn-danger btn-sm" style="font-size: smaller;"
                                   href="{{route('upload_store', $manual_presentation->id)}}">Resend</a>
                            </td>
                        @elseif($manual_presentation->status == 'notified')
                            <td>
                                <a role="button" class="btn btn-info btn-sm" style="font-size: smaller;"
                                   href="{{route('manual_admin_unregister', $manual_presentation->id)}}">Unregister</a>
                            </td>
                        @elseif($manual_presentation->status == 'sent' or $manual_presentation->status == 'init')
                            <td><a role="button" class="btn btn-primary btn-sm" style="font-size: smaller;"
                                   href="{{route('manual_admin_unregister', $manual_presentation->id)}}">Unregister</a>
                            </td>
                        @endif
                        </tr>
                    </tbody>

                @endforeach
            </table>

        </div>
    </div>
@endsection
