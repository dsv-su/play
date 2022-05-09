@extends('layouts.suplay')
@section('content')
    <div class="container">
        <br>
        <div class="row">
            <!-- -->
            @if(app()->make('play_role') == 'Administrator')
                <h1 class="word-wrap_xs-only" id="sub-entry-page-header" lang="en">{{ __("Modify permissions for presentation") }}</h1>
            @else
                <h1 class="word-wrap_xs-only" id="sub-entry-page-header" lang="sv">{{ __("Modify permissions for presentation") }}</h1>
            @endif
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{$video->LangTitle}}
                    </div>
                    <img class="card-img-top" src="{{ $video->thumb}}" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text border-bottom pb-3"><small>ID: {{$video->id}}</small></p>
                        @if(app()->make('play_role') == 'Administrator')
                            <p class="card-text"><small>{{ __("Length") }}: {{ $video->duration }} H.</small></p>
                        @else
                            <p class="card-text"><small>{{ __("Length") }}: {{ $video->duration }} H.</small></p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- -->
            <div class="card border-primary mb-3"><!--class="card w-75"-->

                <div class="card-body">
                    <form method="post" action="{{route('store_permission', $video->id)}}">
                        @csrf
                        <div class="col">
                            @if(app()->make('play_role') == 'Administrator')
                                <label class="text-primary">{{ __("Assign Group Permission") }}:</label>
                            @else
                                <label class="text-primary">{{ __("Assign Group Permission") }}:</label>
                            @endif

                            <div class="form-group">
                                <select name="perm[]" class="form-control" id="permission" >
                                    @foreach($permissions as $permission)
                                        @if(Lang::locale() == 'swe')
                                        <option value="{{$permission->id}}" {{ old('perm') == $permission->id || in_array($permission->id, $thispermissions) ? 'selected':''}}>{{$permission->scope}}</option>
                                        @else
                                            <option value="{{$permission->id}}" {{ old('perm') == $permission->id || in_array($permission->id, $thispermissions) ? 'selected':''}}>{{$permission->scope_en}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if(app()->make('play_role') == 'Administrator')
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary btn-sm">{{ __("Modify") }}</button>
                                <a href="{{route('add_permission')}}" role="button" class="btn btn-secondary btn-sm">{{ __("Add/edit") }}</a>
                                <a href="{{route('admin')}}" role="button" class="btn btn-warning btn-sm">{{ __("Cancel") }}</a>
                            </div>
                        @else
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary btn-sm">{{ __("Modify") }}</button>
                                <a href="{{route('admin')}}" role="button" class="btn btn-warning btn-sm">{{ __("Cancel") }}</a>
                            </div>
                            <br>
                            <p class="card-text"><small>{{ __("If you need a special group that is not on the list, you should contact support.") }}</small></p>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
