@extends('layouts.suplay')
@section('content')
    <div class="container">
        <h2>VideoPermissions</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin')}}">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">VideoPermissions</li>
            </ol>
        </nav>

        <div class="row">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Presentation</th>
                    <th scope="col">PresentationId</th>
                    <th scope="col">Permission</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($permissions as $permission)
                    <tr>
                        <td>Thumb</td>
                        <td>{{$permission->video_id}}</td>
                        <td>{{$permission->permission->scope}}</td>
                        <td><a role="button" class="btn btn-primary btn-sm"
                               href="/edit_permission/{{$permission->video_id}}">Modify</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
