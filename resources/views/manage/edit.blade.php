@extends('layouts.suplay_upload')
@section('content')
    <form method="post" action="{{route('editpresentation', $video)}}">
        @csrf

        @livewire('edit-presentation', [
        'video' => $video,
        'permissions' => $permissions,
        'courses' => $courses
        ])

        <div class="container px-1 py-5 mx-auto">
            <div class="row justify-content-end">
                <div class="form-group col-sm-4"> <button type="submit" class="btn-block btn btn-outline-primary">{{ __("Update") }}</button> </div>
            </div>
        </div>


    </form>

@endsection
