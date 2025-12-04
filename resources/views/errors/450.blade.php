@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message')
    {!! 'Please log in to DSVPlay (<a href="https://play.dsv.su.se" style="color:#0d6efd; text-decoration: underline;">play.dsv.su.se</a>) before accessing this presentation' !!}
@endsection


