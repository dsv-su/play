@extends('layouts.app')
@section('content')
    @include('dsvheader')
    @include('navbar.navbar')
    <livewire:home.pending-presentations />
    @include('layouts.darktoggler')
@endsection
