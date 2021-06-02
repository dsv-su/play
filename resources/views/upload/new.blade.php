@extends('layouts.suplay_upload')
@section('content')
    <div class="container bootstrap snippet">

        <div class="row">
            <div class="col-sm-10"><h1>{{ __("Upload presentation") }}</h1></div>
        </div>

        <div class="row">
            <!--left col-->
            <div class="col-sm-6">
                <form class="form" action="##" method="post" id="form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="col-7">
                            <h2 class="fs-title">1.) {{ __("Information about the presentation") }}:</h2>
                        </div>
                        <p class="description">
                            {{ __("Enter the title of the presentation and the date of recording. If the recording date is unknown, you can enter today's date.") }}
                        </p>
                        <label class="fieldlabels">{{ __("Enter title") }}: </label>
                        <input class="form-control form-control-sm" id="title" name="title" type="text" value="{{ old('title') ? old('title'): $title ?? '' }}">
                        <small class="text-danger">{{ $errors->first('title') }}</small>

                        <label class="fieldlabels">{{ __("Recording date") }}: </label>
                        <input id="creationdate" class="form-control form-control-sm datepicker" name="created" type="text" value="{{ old('created') ? old('created'): $created ?? '' }}">
                        <small class="text-danger">{{ $errors->first('created') }}</small>

                        <label class="fieldlabels">{{ __("Presenter") }}: </label>
                        <p><small><strong>{{app()->make('play_user')}} ({{app()->make('play_username')}})</strong></small></p>

                        <label class="fieldlabels">{{ __("Additional presenters.") }}</label>
                        <button type="button" name="presenteradd" class="btn btn-outline-primary btn-sm presenteradd">{{ __("Presenter") }} <i class="fas fa-user-plus"></i></button>
                        <table class="table table-sm" id="presenter_table">
                        </table>

                        <div class="col-7">
                            <h2 class="fs-title">2.) {{ __("Course association") }}:</h2>
                        </div>
                        <p class="description">
                            {{ __("Here you specify whether the recording should be associated with one or more courses. If you do not want the recording to be associated with a course or want to complete at a later time, leave the field blank.") }}
                        </p>
                        <label class="fieldlabels">{{ __("Course association") }}: </label>
                        <br>
                        <button type="button" name="courseadd" class="btn btn-outline-primary btn-sm courseadd">@lang('lang.course') <i class="fas fa-chalkboard"></i></button>
                        <table class="table table-sm" id="course_table">
                            @if(count($courses) > 0)
                                H
                            @endif

                        </table>
                        <p class="description">
                            {{ __("Also make the recording searchable by entering tags.") }}
                        </p>
                        <label class="fieldlabels">{{ __("Tags") }}: </label>
                        <br>
                        <button type="button" name="tagadd" class="btn btn-outline-primary btn-sm tagadd">@lang('lang.tag') <i class="fas fa-tags"></i></button>
                        <table class="table table-sm" id="tag_table">
                        </table>
                        <p class="description">
                            {{ __("All uploaded presentations are public unless otherwise specified") }}
                        </p>
                        <label class="fieldlabels">{{ __("Playback permissions") }}</label>
                        <select name="permission" class="form-control" id="permission">
                            <option value="false" selected>@lang('lang.public')</option>
                            <option value="true">@lang('lang.private')</option>
                        </select>
                        <!--Video permission settings-->
                        <div id="video_perm" hidden>
                            <select class="form-control" name="video_permission">
                                @foreach($permissions as $permission)
                                    <option value="{{$permission->id}}">{{$permission->id}}: {{$permission->scope}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <br>
                            <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                            <button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
                        </div>
                    </div>
                </form>
            </div><!--/col-9-->
            <div class="col-sm-5">
                <div class="col-7">
                    <h3 class="fs-title">{{ __("Upload media") }}:</h3>
                </div>
                <p class="description">
                    {{ __("Upload video media. Up to 4 media files can be uploaded.") }}
                </p>

                <label class="fieldlabels">{{ __("Upload files") }}:</label>
                <button type="button" name="mediaadd" class="btn btn-outline-primary btn-sm mediaadd"><i class="fas fa-plus"></i> {{ __("Add") }}</button>

                <div class="text-center">
                    <h3>{{ __("Primary media") }}</h3>
                    <img src="{{asset('/images/dsvplay.png')}}" class="thumb img-thumbnail" alt="thumb">
                    <input type="file" id="file" class="text-center center-block file-upload" name="filenames[]">
                </div>

                <div id="media" class="text-center">

                </div>


            </div><!--/col-3-->
    </div><!--/row-->
        <!-- Modal for max upload-->
        <div class="modal fade" id="max" tabindex="-1" role="dialog" aria-labelledby="max" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="max">{{ __("Maximum allowed videos") }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ __("Maximum number of allowed streams for upload has been reached.") }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close") }}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal spinners -->
        <div class="modal fade" id="load" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="loader"></div>
                        <div class="loader-txt">
                            <p>{{ __("Work in progress") }} <br><br><small>{{ __("The media files are checked") }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="loadtoserver" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="loader"></div>
                        <div class="loader-txt">
                            <p>{{ __("Upload in progress") }} <br><br><small>{{ __("Storing media on play-store") }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<script src="{{ asset('./js/upload2.js') }}"></script>
<!-- Typeahead.js Bundle -->
<script src="{{ asset('./js/typeahead/typeahead.bundle.js') }}"></script>

@endsection
