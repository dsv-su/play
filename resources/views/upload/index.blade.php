@extends('layouts.suplay_upload')
@section('content')
    <div class="container bootstrap snippet">
        <div class="w-7/12 mx-2 rounded border p-2">
            <div class="row">
                <div class="col-sm-10"><h1>{{ __("Upload presentation") }}</h1></div>
            </div>
            <div class="row">
                <div class="col-sm-7">
                    <form method="post" action="{{route('upload_step1', $presentation->id)}}">
                        @csrf
                        <div class="rounded border shadow p-3 my-2">
                            <div class="rounded border shadow p-3 my-2">
                                <p class="font-bold text-lg">1.) {{ __("Information about the presentation") }}:</p>
                                <small>
                                    {{ __("Enter the title of the presentation and the date of recording. If the recording date is unknown, you can enter today's date.") }}
                                </small>
                                <br>
                                <!-- Title -->
                                <label class="fieldlabels">{{ __("Enter title") }}: </label>
                                <input class="form-control form-control-sm" id="title"  name="title" type="text" value="{{ old('title') ? old('title'): $title ?? '' }}">
                                <div><small class="text-danger">{{ $errors->first('title') }}</small></div>
                                <!-- Date -->
                                <label class="fieldlabels">{{ __("Recording date") }}: </label>
                                <input id="creationdate" class="form-control form-control-sm datepicker"
                                       name="created" type="text" autocomplete="off" data-provide="datepicker"
                                       data-date-autoclose="true" data-date-today-highlight="true">
                                <div><small class="text-danger">{{ $errors->first('created') }}</small></div>
                            </div>
                            <!-- Presenters -->
                            <label class="fieldlabels">{{ __("Presenter") }}: </label>
                            <p><small><strong>{{app()->make('play_user')}} ({{app()->make('play_username')}})</strong></small></p>

                            <label class="fieldlabels">{{ __("Additional presenters.") }}</label>
                            <button type="button" name="presenteradd" class="btn btn-outline-primary btn-sm presenteradd">{{ __("Presenter") }} <i class="fas fa-user-plus"></i></button>
                            <table class="table table-sm" id="presenter_table">
                            </table>

                            <div class="rounded border shadow p-3 my-2">
                                <p class="font-bold text-lg">2.) {{ __("Course association") }}:</p>
                                <small>
                                    {{ __("Here you specify whether the recording should be associated with one or more courses. If you do not want the recording to be associated with a course or want to complete at a later time, leave the field blank.") }}
                                </small>
                            </div>
                            <label class="fieldlabels">{{ __("Course association") }}: </label>
                            <br>
                            <button type="button" name="courseadd" class="btn btn-outline-primary btn-sm courseadd">@lang('lang.course') <i class="fas fa-chalkboard"></i></button>
                            <table class="table table-sm" id="course_table">

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

                </div>

                <!--/col-9-->
                @livewire('file-upload', [
                'presentation' => $presentation,
                'permissions' => $permissions
                ])
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
