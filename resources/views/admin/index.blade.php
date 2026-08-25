

@extends('layouts.app')

@section('title', 'Admin Settings -')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 dark:text-white">Admin Interface</h1>
        
        <livewire:admin.admin-settings />
    </div>
@endsection
