@extends('errors::minimal')

@section('title', __('Unsupported device'))
@section('code', '412')
@section('message', __($exception->getMessage() ?: 'Unsupported device'))
