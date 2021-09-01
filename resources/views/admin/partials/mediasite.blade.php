@extends('layouts.suplay')
@section('content')
    <div class="container">
        <h2>Mediasite</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin')}}">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mediasite</li>
            </ol>
        </nav>

        <h2>Mediasite</h2>
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
                @foreach($mediasite_presentations as $presentation)
                    <tbody>
                    <tr>
                        <td>{{$presentation->status}}</td>
                        <td>{{$presentation->id}}</td>
                        <td>{{$presentation->updated_at}}</td>
                        <td>{{$presentation->title}}</td>
                        @if($presentation->status == 'sent')
                            <td><a role="button" class="btn btn-primary btn-sm" href="#">Unregister</a>
                                <a role="button" class="btn btn-warning btn-sm" href="#">Resend
                                    Notify</a></td>
                        @endif
                    </tr>
                    </tbody>
                @endforeach
            </table>
        </div>
        <h2>Mediasite Folders</h2>
        <div class="row">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Status</th>
                    <th scope="col">Id</th>
                    <th scope="col">Updated</th>
                    <th scope="col">Title</th>
                </tr>
                </thead>
                @foreach($mediasite_folders as $folder)
                    <tbody>
                    <tr class="@if ($folder->completed() == 1) table-success @elseif ($folder->completed() == 2) table-warning @elseif ($folder->completed() == 3) table-info @endif">
                        <td>@if ($folder->completed() == 1) completed @elseif ($folder->completed() == 2) partially completed @elseif ($folder->completed() == 3) empty @endif</td>
                        <td>{{$folder->id}}</td>
                        <td>{{$folder->updated_at}}</td>
                        <td>{{$folder->name}}</td>
                    </tr>
                    </tbody>

                @endforeach
            </table>

        </div>
    </div>
@endsection
