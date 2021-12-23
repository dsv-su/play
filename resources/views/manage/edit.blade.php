@extends('layouts.suplay_upload')
@section('content')
    <form method="post" action="{{route('editpresentation', $video)}}">
        @csrf
        @livewire('edit-presentation', [
        'video' => $video,
        'permissions' => $permissions,
        'courses' => $courses,
        'tags' => $tags,
        'individual_permissions' => $individual_permissions,
        'user_permission' => $user_permission
        ])
    </form>
@endsection
