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
                            @if($presentation->status == 'failed' or $presentation->status == 'stored')
                                <td><a role="button" class="btn btn-danger btn-sm" href="{{route('manual_admin_notify', $presentation->id)}}">Notify</button></td>
                            @elseif($presentation->status == 'pending')
                                <td><a role="button" class="btn btn-warning btn-sm" href="{{route('manual_admin_erase', $presentation->id)}}">Erase</button></td>
                            @elseif($presentation->status == 'notified')
                                <td><a role="button" class="btn btn-info btn-sm" href="{{route('manual_admin_unregister', $presentation->id)}}">Unregister</button></td>
                            @elseif($presentation->status == 'sent')
                                <td><a role="button" class="btn btn-primary btn-sm" href="{{route('manual_admin_unregister', $presentation->id)}}">Unregister</button></td>
                            @endif
                        </tr>
                </tbody>

                @endforeach
            </table>

        </div>

    </div>
@endsection
