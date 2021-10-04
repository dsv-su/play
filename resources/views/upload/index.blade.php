@extends('layouts.suplay_upload')
@section('content')
    <style>
        .datepicker {
            padding: 8px 15px;
            border-radius: 5px !important;
            margin: 5px 0px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            font-size: 18px !important;
            font-weight: 300
        }
    </style>
    <div class="container px-1 py-5 mx-auto">
        <div class="w-7/12 mx-2 rounded  p-2">
            <div class="row">
                <div class="col-sm-10"><h1>{{ __("Upload presentation") }}</h1></div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <form method="post" action="{{route('upload_step1', $presentation->id)}}">

                        @csrf
                        <div class="rounded border shadow p-3 my-2">

                                <label class="blue-text form-control-label px-3">{{ __("Information about the presentation") }}</label>
                                <p>
                                    {{ __("Enter the title of the presentation and the date of recording. If the recording date is unknown, you can enter today's date.") }}
                                </p>

                                <!-- Title -->
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">{{ __("Enter title") }}<span class="text-danger"> *</span></label>
                                        <input  id="title"  name="title" type="text" value="{{ old('title') ? old('title'): $title ?? '' }}">
                                        <div><small class="text-danger">{{ $errors->first('title') }}</small></div>
                                    </div>
                                <!-- CreationDate -->
                                    <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">{{ __("Recording date") }}<span class="text-danger"> *</span></label>
                                        <input id="creationdate" class="datepicker" name="created" type="text" autocomplete="off" data-provide="datepicker" data-date-autoclose="true" data-date-today-highlight="true">
                                        <div><small class="text-danger">{{ $errors->first('created') }}</small></div>
                                    </div>
                                </div>

                            <!-- Description -->
                            <div class="row justify-content-between text-left">
                                <div class="form-group col-12 flex-column d-flex"><label
                                            class="form-control-label px-1">{{ __("Description") }}</label>
                                    <textarea id="description" name="description" placeholder="Add a presentation's description here"></textarea>
                                </div>
                            </div>

                            <!-- Presenters -->
                            <div class="row justify-content-between text-left">
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">{{ __("Presenter") }}</label>
                                    <input  type="text" value="{{app()->make('play_user')}} ({{app()->make('play_username')}})" disabled>
                                </div>
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">{{ __("Additional presenters.") }}</label>
                                    <button type="button" name="presenteradd" class="btn btn-outline-primary btn-sm presenteradd">{{ __("Presenter") }} <i class="fas fa-user-plus"></i></button>
                                </div>
                            </div>

                            <div class="row justify-content-between text-left">
                                <table class="table table-sm" id="presenter_table">
                                </table>
                            </div>

                            <label class="blue-text form-control-label px-3">{{ __("Course association") }}</label>
                            <p>
                                {{ __("Here you specify whether the recording should be associated with one or more courses. If you do not want the recording to be associated with a course or want to complete at a later time, leave the field blank.") }}
                            </p>

                            <div class="row justify-content-between text-left">
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">{{ __("Course association") }}</label>
                                    <button type="button" name="courseadd" class="btn btn-outline-primary btn-sm courseadd">@lang('lang.course') <i class="fas fa-chalkboard"></i></button>
                                </div>

                            </div>
                            <div class="row justify-content-between text-left">
                                <table class="table table-sm" id="course_table">
                                </table>

                            </div>
                            <label class="blue-text form-control-label px-3">{{ __("Tags") }}</label>
                            <p>
                                {{ __("Also make the recording searchable by entering tags.") }}
                            </p>
                            <div class="row justify-content-between text-left">
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">{{ __("Tags") }}</label>
                                    <button type="button" name="tagadd" class="btn btn-outline-primary btn-sm tagadd">@lang('lang.tag') <i class="fas fa-tags"></i></button>
                                </div>
                            </div>
                            <div class="row justify-content-between text-left">
                                <table class="table table-sm" id="tag_table">
                                </table>
                            </div>
                            <label class="blue-text form-control-label px-3">{{ __("Playback Permissions") }}</label>
                            <p>
                                {{ __("All uploaded presentations are accessible to DSV Students and Staff unless otherwise specified with the 'Custom' alternative") }}
                            </p>
                            <div class="row justify-content-between text-left">
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">{{ __("Playback Permissions") }}</label>
                                    <select name="permission" class="form-control permission" id="permission">
                                        <option value="false" selected>@lang('lang.public')</option>
                                        <option value="true">@lang('lang.private')</option>
                                    </select>
                                </div>

                            </div>

                            <!--Video permission settings-->

                            <div id="video_perm" hidden>
                                <select class="form-control" name="video_permission">
                                    @foreach($permissions as $permission)
                                        <option value="{{$permission->id}}">{{$permission->id}}: {{$permission->scope}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="blue-text form-control-label px-3">{{ __("DSV Disclaimer") }}</label>
                            <p>
                                {{ __("Materials uploaded to DSVPlay may be subject to posted limitations on usage, reproduction and/or dissemination. You are responsible for adhering to such limitations if you upload materials.") }}
                            </p>
                            <div class="row justify-content text-right">
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3"><input type="checkbox" name="disclaimer"> {{ __("I understand") }}<span class="text-danger"> *</span></label>
                                    <div><small class="text-danger">{{ $errors->first('disclaimer') }}</small></div>
                                </div>
                            </div>



                        </div>


                        <div class="row justify-content-end">
                            <div class="form-group col-sm-4"> <button id="submit" type="submit" class="btn-block btn btn-outline-primary">{{ __("Upload") }}</button> </div>
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


<script src="{{ asset('./js/upload.js') }}"></script>
<!-- Typeahead.js Bundle -->
<script src="{{ asset('./js/typeahead/typeahead.bundle.js') }}"></script>
<script>
    $("#submit").click(function(){
        $("#loadtoserver").modal({
            backdrop: "static", //remove ability to close modal with click
            keyboard: false, //remove option to close with keyboard
            show: true //Display loader!
        });
    });
</script>

@endsection
