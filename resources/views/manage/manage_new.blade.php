@extends('layouts.suplay')
@section('content')
    <!-- Header message section -->
    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <span class="su-theme-anchor"></span>
                <h3 class="su-theme-header mb-4">
                   <i class="fas fa-edit fa-icon-border mr-2"></i> {{__('Manage presentations')}}
                </h3>
            </div>
        </div>
    </div>
    <!-- end Header -->

    <!-- Courselist -->
    <div class="container px-0">
        <livewire:manage />
    </div>

@endsection