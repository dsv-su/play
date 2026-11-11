@extends('layouts.app')
@section('content')
    @include('dsvheader')
    @include('navbar.navbar')
    @if(!empty($presenter_search))
        <livewire:search.presenter-results :presenter_search="$presenter_search" />
    @elseif(isset($tag))
        <livewire:search.tag-results :tag="$tag" />
    @elseif(isset($designation))
        <livewire:search.course-results :designation="$designation" />
    @endif
    @include('layouts.darktoggler')
@endsection
