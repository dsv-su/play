@extends('layouts.suplay')
@section('content')
    <div class="container">
        <br>
        <div class="row">
            <!-- -->
            @if(app()->make('play_role') == 'Administrator')
                <h1 class="word-wrap_xs-only" id="sub-entry-page-header" lang="en">Modify permissions for presentation</h1>
            @else
                <h1 class="word-wrap_xs-only" id="sub-entry-page-header" lang="sv">Redigera rättigheter för presentation</h1>
            @endif
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{$video->title}}
                    </div>
                    <img class="card-img-top" src="{{ $video->thumb}}" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text border-bottom pb-3"><small>ID: {{$video->id}}</small></p>
                        @if(app()->make('play_role') == 'Administrator')
                            <p class="card-text"><small>Length: {{ $video->duration }} H.</small></p>
                        @else
                            <p class="card-text"><small>Längd: {{ $video->duration }} H.</small></p>
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
                                <label class="text-primary">Assign Permissions:</label>
                            @else
                                <label class="text-primary">Tilldela rättigheter:</label>
                            @endif

                            <div class="form-group">
                                <select name="perm[]" class="form-control" id="permission" multiple="multiple">
                                    @foreach($permissions as $permission)
                                        <option value="{{$permission->id}}" {{ old('perm') == $permission->id || in_array($permission->id, $thispermissions) ? 'selected':''}}>{{$permission->scope}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if(app()->make('play_role') == 'Administrator')
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary btn-sm">Modify</button>
                                <a href="{{route('add_permission')}}" role="button" class="btn btn-secondary btn-sm">Add/edit</a>
                                <a href="{{route('admin')}}" role="button" class="btn btn-warning btn-sm">Cancel</a>
                            </div>
                        @else
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary btn-sm">Redigera</button>
                                <a href="{{route('admin')}}" role="button" class="btn btn-warning btn-sm">Avbryt</a>
                            </div>
                            <br>
                            <p class="card-text"><small>Om du behöver en speciell rättighetsgrupp som inte finns i listan bör du kontakta support.</small></p>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
