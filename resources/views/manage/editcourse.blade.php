@extends('layouts.suplay_upload')
@section('content')
    <form method="post" action="{{route('course_edit_store', $course->id)}}">
        @csrf
        @livewire('coursesetting', [
        'course' => $course,
        'coursesettings_permissions' => $coursesettings_permissions,
        'individual_permissions' => $individual_permissions,
        'permissions' => $permissions,
        'user_permission' => $user_permission
        ])
    </form>
@endsection
