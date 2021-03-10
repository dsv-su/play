@extends('layouts.suplay')
@section('content')
    <div class="container">
        <br>
        <div class="row">
            <div class="card w-75">
                <div class="card-header">
                    Modify permissions for videoID: <strong>{{$id}}</strong>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Titel: {{$title}}</h5>
                    <form method="post" action="{{route('store_permission', $id)}}">
                        @csrf
                        <p class="card-text">Längd: {{ $duration }} sek.</p>
                        <p class="card-text"><small class="text-muted">Permission group:</small></p>

                        <div class="col">
                            <label class="text-primary">Permissions:</label>
                            <div class="form-group">
                                <select name="perm[]" class="form-control" id="permission" multiple="multiple">
                                    @foreach($permissions as $permission)
                                        <option value="{{$permission->id}}" {{ old('perm') == $permission->id || in_array($permission->id, $thispermissions) ? 'selected':''}}>{{$permission->scope}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Modify</button>
                        <a href="{{route('add_permission')}}" role="button" class="btn btn-secondary btn-sm">Add/edit</a>
                        <a href="{{route('admin')}}" role="button" class="btn btn-warning btn-sm">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
