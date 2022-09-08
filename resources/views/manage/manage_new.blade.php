@extends('layouts.suplay')
@section('content')
    <!-- Header message section -->
    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <span class="su-theme-anchor"></span>
                <h3 class="su-theme-header mb-4">
                   <i class="fas fa-edit fa-icon mr-2"></i> {{__('Manage presentations')}}
                </h3>
            </div>
        </div>
    </div>
    <!-- end Header -->
    <div wire:ignore class="container banner-inner">
        @if(session()->has('message'))
            <div class="alert text-center @if (session('success')) alert-success @elseif (session('warning')) alert-warning @elseif (session('error')) alert-danger @else alert-info @endif">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <!-- Courselist -->
    <div class="container px-0">
        <livewire:manage />
    </div>

@endsection
