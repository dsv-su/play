@extends('layouts.app')
@section('content')
    @include('dsvheader')
    @include('navbar.navbar')
    <div class="max-w-screen-xl mx-auto px-4 py-6 sm:px-6 lg:px-8 md:pt-8 md:pb-8 space-y-8">
        <livewire:search.index />
        @if(!empty($tag))
            <livewire:search.Tag-results :videos="$videos" :tag="$tag" />
        @elseif(!empty($presenter_search))
            <livewire:search.Presenter-results :videos="$videos" :presenter_search="$presenter_search" />
        @elseif(!empty($designation))
            <livewire:search.Course-results :videos="$videos" :designation="$designation" />
        @endif

    </div>
    @include('layouts.darktoggler')
@endsection

