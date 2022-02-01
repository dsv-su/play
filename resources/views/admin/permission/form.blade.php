@extends('layouts.suplay')
@section('content')
    <div class="container">
    <h2>Permissons</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin')}}">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Permissions</li>
            </ol>
        </nav>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                Hey Admin!<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session()->has('message'))
            <div class="alert {{session('alert') ?? 'alert-info'}}">
                {{ session('message') }}
            </div>
        @endif
        <div class="row">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">PresentationId</th>
                    <th scope="col">Permission</th>
                    <th scope="col">Permission(eng)</th>
                    <th scope="col">Entitlement</th>
                    <th scope="col" colspan="2">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($permissions as $permission)
                    <tr>
                        <td>{{$permission->id}}</td>
                        <td>{{$permission->scope}}</td>
                        <td>{{$permission->scope_en}}</td>
                        <td>{{$permission->entitlement}}</td>
                        <td>
                            @if($permission->id != 4) <!-- Disable action for public permission -->
                            <a role="button" class="btn btn-primary btn-sm" href="{{route('modify_permission', $permission->id)}}">Modify</a>
                            @endif
                        </td>
                        <td>
                            @if($permission->id != 4) <!-- Disable action for public permission -->
                            <a role="button" class="btn btn-danger btn-sm" href="{{route('delete_permission', $permission->id)}}">Delete</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
            @if($modify == 0)
            <form class="form-group" method="post" action="{{route('store_new_permission')}}">
                @csrf
                <div class="form-group mb-2">
                    <label for="permission" class="sr-only">Permission</label>
                    <input name="permission" type="text" class="form-control" id="permission" placeholder="Permission(swe)">
                    <small class="text-danger">{{ $errors->first('permission') }}</small>
                    <label for="permission_en" class="sr-only">Permission</label>
                    <input name="permission_en" type="text" class="form-control" id="permission" placeholder="Permission(eng)">
                    <small class="text-danger">{{ $errors->first('permission_en') }}</small>
                    <label for="entitlement" class="sr-only">Entitlement</label>
                    <input name="entitlement" type="text" class="form-control" id="entitlement" placeholder="urn:mace:swami.se:gmai:dsv-user:xxxx">
                    <small class="text-danger">{{ $errors->first('entitlement') }}</small>
                </div>
                <button type="submit" class="btn btn-primary mb-2">Add permission</button>
                <a href="{{route('admin')}}" role="button" class="btn btn-warning mb-2">Cancel</a>
            </form>
            @elseif($modify == 1)
            <form class="form-group" method="post" action="{{route('store_new_permission')}}">
                @csrf
                <div class="form-group mb-2">
                    <label for="permission" class="sr-only">Permission</label>
                    <input name="permission" type="text" class="form-control bg-primary text-white" id="permission" placeholder="Permission Name" value="{{$thispermission->scope}}">
                    <small class="text-danger">{{ $errors->first('permission') }}</small>
                    <label for="permission_en" class="sr-only">Permission</label>
                    <input name="permission_en" type="text" class="form-control bg-primary text-white" id="permission_en" placeholder="Permission Name(eng)" value="{{$thispermission->scope_en}}">
                    <small class="text-danger">{{ $errors->first('permission_en') }}</small>
                    <label for="entitlement" class="sr-only">Entitlement</label>
                    <input name="entitlement" type="text" class="form-control bg-primary text-white" id="entitlement" placeholder="urn:mace:swami.se:gmai:dsv-user:xxxx" value="{{$thispermission->entitlement}}">
                    <small class="text-danger">{{ $errors->first('entitlement') }}</small>
                    <input type="hidden" name="modify" value="1">
                    <input type="hidden" name="pid" value="{{$thispermission->id}}">
                </div>
                <button type="submit" class="btn btn-primary mb-2">Modify permission</button>
                <a href="{{route('admin')}}" role="button" class="btn btn-warning mb-2">Cancel</a>
            </form>
            @endif
    </div>
@endsection
