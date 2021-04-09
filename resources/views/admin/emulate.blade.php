@extends('layouts.suplay')
@section('content')
    <div class="container">

        <div class="align-middle ml-auto my-auto">
            @if(!app()->make('play_auth') == 'Administrator')
            {{app()->make('play_user') ?? 'Not logged in'}}
            @else
                @if(app()->make('play_auth') == 'Administrator')
                    <form class="form-inline" method="post" action="{{route('emulateUser')}}">
                     @csrf
                        <label class="my-1 mr-2" for="role">{{app()->make('play_user') ?? 'Not logged in'}}</label>
                        <select class="custom-select my-1 mr-sm-2" id="role">
                            <option @if(app()->make('play_role') == 'Administrator') selected @endif value="Administrator">[Administrator]</option>
                            <option @if(app()->make('play_role') == 'Uploader') selected @endif value="Uploader">[Uploader]</option>
                            <option @if(app()->make('play_role') == 'Staff') selected @endif value="Staff">[Staff]</option>
                            <option @if(app()->make('play_role') == 'Student') selected @endif value="Student">[Student]</option>
                        </select>

                        <button type="submit" class="btn btn-primary-outline my-1">Change</button>
                    </form>
                @else
                [{{app()->make('play_role') ?? ''}}]
                @endif
           @endif
        </div>
@endsection
