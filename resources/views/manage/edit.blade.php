@extends('layouts.suplay_upload')
@section('content')
    @livewire('edit-presentation', [
    'video' => $video,
    'permissions' => $permissions
    ])
@endsection
