@extends('layouts.suplay')
@section('content')
    <div class="container">
        <h2>Downloads</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin')}}">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Downloads</li>
            </ol>
        </nav>
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
                            @if($presentation->status == 'request download' or $presentation->status == 'stored')
                                <td><a role="button" class="btn btn-danger btn-sm"
                                       href="{{route('download_delete', $presentation->id)}}">Erase</a>
                                </td>
                            @elseif($presentation->status == 'failed' or $presentation->status == 'updated')
                                <td><a role="button" class="btn btn-danger btn-sm"
                                       href="{{route('download_delete', $presentation->id)}}">Erase</a>
                                </td>
                                <td><a role="button" class="btn btn-danger btn-sm"
                                       href="{{route('admin_download_notify_resend', $presentation->id)}}">Resend
                                        Notify</a></td>
                            @elseif($presentation->status == 'update' or $presentation->status == 'newmedia')
                                <td><a role="button" class="btn btn-warning btn-sm"
                                       href="{{route('download_delete', $presentation->id)}}">Erase</a>
                                </td>
                            @elseif($presentation->status == 'sent')
                                <td><a role="button" class="btn btn-primary btn-sm"
                                       href="{{route('download_delete', $presentation->id)}}">Unregister</a>
                                    <a role="button" class="btn btn-warning btn-sm"
                                       href="{{route('admin_download_notify_resend', $presentation->id)}}">Resend
                                        Notify</a></td>
                            @endif
                        </tr>
                    </tbody>

                @endforeach
            </table>
        </div>
    </div>

@endsection
