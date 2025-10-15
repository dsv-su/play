@extends('layouts.app')
@section('content')
    @include('dsvheader')
    @include('navbar.navbar')
    <div class="max-w-screen-xl mx-auto px-4 py-6 sm:px-6 lg:px-8 md:pb-8 space-y-4">
        <section class="bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
            <div class="px-4 py-8 mx-auto overflow-x-hidden">
                @include('livewire.edit.partials.form.edit-banner')
                @include('livewire.edit.partials.form.form_title')
                <form id="presentation-edit-Form" method="post" action="{{route('presentation.save', $video)}}">
                    @csrf

                    <input type="hidden" name="type" value="{{$type}}">
                    @if(in_array($type, ['edit']))
                        <input type="hidden" name="id" value="{{$video->id}}">
                    @endif
                    <!-- Section: Meta -->
                    <livewire:edit.edit-presentation :video="$video" :type="'edit'" :courses="$courses" allowedCourseIds="$allowedCourseIds" />

                    <!--Section: Course -->
                    @include('manage.partials.course-section')

                    <!--Section: Presenters -->
                    @include('manage.partials.presenter-section')

                    <!--Section: Tags -->
                    @include('manage.partials.tag-section')

                    <!--Section: Permissions -->
                    @include('manage.partials.permission-section')

                    <!--Section: Streams -->
                    @include('manage.partials.streams-section')

                    <!--Section: Subtitles -->
                    @include('manage.partials.subtitles-section')
                </form>
            </div>
        </section>
    </div>
    @include('manage.partials.savebar')
    @include('livewire.edit.partials.form.modal')
    @include('layouts.darktoggler')
@endsection
