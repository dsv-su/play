@extends('layouts.app')
@section('content')
    @include('dsvheader')
    @include('navbar.navbar')
    <div class="max-w-screen-xl mx-auto px-4 py-6 sm:px-6 lg:px-8 md:pb-8 space-y-4">
        <section class="bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
            <div class="px-4 py-8 mx-auto">
                @include('livewire.edit.partials.form.edit-banner')

                <form id="bulk-edit-Form" method="post" action="{{route('bulk.save')}}">
                    @csrf

                    <!--Section: Bulk list -->
                    @include('manage.partials.bulk-list-section')

                    <!-- Section: Bulk downloadable -->
                    @include('manage.partials.bulk-download-section')

                    <!-- Section: Bulk visibility -->
                    @include('manage.partials.bulk-visibility-section')

                    <!--Section: Course -->
                    @include('manage.partials.bulk-course-section')

                    <!--Section: Presenters -->
                    @include('manage.partials.bulk-presenter-section')

                    <!--Section: Tags -->
                    @include('manage.partials.bulk-tag-section')

                    <!--Section: Info -->
                    @include('manage.partials.bulk-info-section')

                    <input type="hidden" name="videos" value="{{ $videos }}">

                </form>
            </div>
        </section>
    </div>
    <!-- Tooltips -->
    @include('home.partials.tooltips')

    @include('manage.partials.bulk-savebar')
    @include('livewire.edit.partials.form.bulk-modal')
    @include('layouts.darktoggler')
@endsection
