@extends('layouts.suplay')
@section('content')
    <div class="container">
        <h2>Upload</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin')}}">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Uploads</li>
            </ol>
        </nav>
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
                                <td><a role="button" class="btn btn-danger btn-sm"
                                       href="{{route('manual_admin_notify_fail', $manual_presentation->id)}}">Notify
                                        fail</a></td>
                            @elseif($manual_presentation->status == 'pending')
                                <td><a role="button" class="btn btn-warning btn-sm"
                                       href="{{route('manual_admin_erase', $manual_presentation->id)}}">Erase</a>
                                </td>
                            @elseif($manual_presentation->status == 'notified')
                                <td><a role="button" class="btn btn-info btn-sm"
                                       href="{{route('manual_admin_unregister', $manual_presentation->id)}}">Unregister</a>
                                </td>
                            @elseif($manual_presentation->status == 'sent' or $manual_presentation->status == 'init')
                                <td><a role="button" class="btn btn-primary btn-sm"
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