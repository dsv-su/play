@extends('layouts.app')
@section('content')
    @include('dsvheader')
    @include('navbar.navbar')
    <div class="mx-auto max-w-screen-2xl px-4 py-6 pb-32 sm:px-6 lg:px-8">
        <section class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            <div class="border-b border-slate-200 bg-slate-50 px-4 py-5 sm:px-6 lg:px-8 dark:border-neutral-700 dark:bg-neutral-950">
                @include('livewire.edit.partials.form.edit-banner')
                @include('livewire.edit.partials.form.form_title')
            </div>

            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <form id="presentation-edit-Form" method="post" action="{{route('presentation.save', $video)}}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="type" value="{{$type}}">
                    @if(in_array($type, ['edit']))
                        <input type="hidden" name="id" value="{{$video->id}}">
                    @endif

                    <div class="space-y-5">
                        <livewire:edit.edit-presentation :video="$video" :type="'edit'" :courses="$courses" allowedCourseIds="$allowedCourseIds" />

                        @include('manage.partials.course-section')

                        @include('manage.partials.presenter-section')

                        @include('manage.partials.tag-section')

                        @include('manage.partials.permission-section')

                        @include('manage.partials.streams-section')

                        @include('manage.partials.subtitles-section')
                    </div>
                </form>
            </div>
        </section>
    </div>
    @include('manage.partials.savebar')
    @include('livewire.edit.partials.form.modal')
    @include('layouts.darktoggler')
@endsection
