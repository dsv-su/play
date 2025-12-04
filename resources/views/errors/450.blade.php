@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('Please log in to DSVPlay (play.dsv.su.se) before accessing this presentation'))
