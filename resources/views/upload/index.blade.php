@extends('layouts.suplay_upload')
@section('content')
    <style>
        .datepicker {
            padding: 8px 15px;
            border-radius: 5px !important;
            margin: 5px 0px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            font-size: 16px !important;
            font-weight: 300
        }
    </style>
    <!-- Header message section -->
    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <span class="su-theme-anchor"></span>
                <h3 class="su-theme-header mb-4">
                    <i class="fas fa-arrow-circle-up fa-icon-border mr-2"></i>{{ __("Upload presentation") }}
                </h3>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>

    <div class="container px-3 px-sm-0">
        <div class="row">
            <div class="col-md-8">
                <form method="post" action="{{route('upload_step1', $presentation->id)}}">
                    @csrf
                    <div class="rounded border shadow p-3 my-2">
                        <label class="form-control-label px-1">{{ __("Information about the presentation") }}</label>
                        <p class="font-1rem px-1">
                            {{ __("Enter the title of the presentation and the date of recording. If the recording date is unknown, you can enter today's date. Description is optional.") }}
                        </p>

                        <div class="row justify-content-between text-left">
                            <!-- Title -->
                            <div class="form-group col-sm-6 flex-column d-flex"><label
                                        class="form-control-label px-1">{{ __("Enter title") }}<span
                                            class="text-danger"> *</span></label>
                                <input id="title" name="title" type="text" placeholder="Title"
                                       value="{{ old('title') ? old('title'): $title ?? '' }}">
                                <div><small class="text-danger">{{ $errors->first('title') }}</small></div>
                            </div>

                            <!-- CreationDate -->
                            <div class="form-group col-sm-6 flex-column d-flex"><label
                                        class="form-control-label px-1">{{ __("Recording date") }}<span
                                            class="text-danger"> *</span></label>
                                <input id="creationdate" class="datepicker" name="created" type="text"
                                       autocomplete="off" data-provide="datepicker" data-date-autoclose="true"
                                       data-date-today-highlight="true">
                                <div><small class="text-danger">{{ $errors->first('created') }}</small></div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-12 flex-column d-flex"><label
                                        class="form-control-label px-1">{{ __("Description") }}</label>
                                <textarea id="description" name="description"
                                          placeholder="{{__("Add a presentation's description here (if needed)")}}"></textarea>
                            </div>
                        </div>

                        <div class="row justify-content-between text-left">
                            <div class="form-group col-12 flex-column d-flex">
                                <!-- Course association -->
                                <label class="form-control-label px-1">{{ __("Course association") }}</label>
                                <p class="font-1rem px-1 my-0">
                                    {{ __("Here you specify whether the recording should be associated with one or more courses. If you do not want the recording to be associated with a course or want to complete at a later time, leave the field blank.") }}
                                </p>
                                <select name="courses[]"
                                        class="form-control mx-1 selectpicker w-100" data-dropup-auto="false"
                                        data-none-selected-text="{{ __('No course association')}}"
                                        data-live-search="true" multiple>
                                    @foreach($courses as $course)
                                        <option value={{ $course->designation }}>{{ $course->name . ' (' . $course->designation .')' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Presenters and Tags -->
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-12 col-lg-6 flex-column d-flex">
                                <label class="form-control-label px-1">{{ __("Presenters") }}
                                    <span type="button" name="presenteradd"
                                          class="btn btn-primary px-1 py-0 presenteradd">{{__('Add')}}<i
                                                class="fas fa-user-plus ml-1"></i></span>
                                </label>
                                <p class="font-1rem px-1 my-0">
                                    {{ __("Add the presenters for this video. The uploader is listed as presenter by default.") }}
                                </p>
                                <div id="presenter_table">
                                    <input type="text" class="form-control w-100 mx-auto"
                                           value="{{app()->make('play_user')}} ({{app()->make('play_username')}})"
                                           disabled>
                                </div>
                            </div>
                            <div class="form-group col-12 col-lg-6 flex-column d-flex">
                                <label class="form-control-label px-1 py-0">{{ __("Tags") }}</label>
                                <p class="font-1rem px-1 my-0">
                                    {{ __("Also make the recording searchable by entering tags.") }}
                                </p>
                                <select name="tags[]"
                                        class="form-control mx-1 selectpicker w-100" data-dropup-auto="false"
                                        data-none-selected-text="{{ __('No tags selected')}}"
                                        data-live-search="true" multiple>
                                    @foreach($tags as $tag)
                                        <option value={{ $tag->name }}>{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Permissions -->
                        <label class="form-control-label px-1">{{ __("Playback Permissions") }}</label>
                        <p class="px-1 font-1rem mb-0">
                            {{ __("All uploaded presentations are accessible to DSV Students and Staff unless otherwise specified with the 'Custom' alternative.") }}
                        </p>
                        <div class="row mb-2 justify-content-between text-left">
                            <div class="form-group col-sm-6 mb-0 flex-column d-flex">
                                <select name="permission" class="form-control permission selectpicker"
                                        data-dropup-auto="false" id="permission">
                                    <option value="false" selected>@lang('lang.public')</option>
                                    <option value="true">@lang('lang.private')</option>
                                </select>
                            </div>
                            <!-- Custom permissions -->
                            <div id="video_perm" class="form-group col-sm-6 mb-0" hidden>
                                <select class="form-control selectpicker" data-dropup-auto="false"
                                        name="video_permission">
                                    @foreach($permissions as $permission)
                                        <option value="{{$permission->id}}">{{$permission->id}}
                                            : {{$permission->scope}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Policy -->
                        <div class="col alert alert-warning" role="alert">
                            <label class="form-control-label px-1">{{ __("DSV Disclaimer") }}</label>
                            <p class="px-1 font-1rem">
                                {{ __("Materials uploaded to DSVPlay may be subject to posted limitations on usage, reproduction and/or dissemination. You are responsible for adhering to such limitations if you upload materials.") }}
                            </p>
                            <div class="row justify-content-center">
                                <div class="form-group flex-column d-flex">
                                    <label class="form-control-label px-1">
                                        <input type="checkbox" name="disclaimer"> {{ __("I understand") }}<span
                                                class="text-danger"> *</span>
                                    </label>
                                    <div><small class="text-danger">{{ $errors->first('disclaimer') }}</small></div>
                                </div>
                            </div>
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
        <div class="row justify-content-center">
            <div class="form-group col-sm-4">
                <button id="submit" type="submit"
                        class="btn-block btn btn-outline-primary">{{ __("Upload") }}</button>
            </div>
        </div>
    </div>

    <!-- Modal spinners -->
    <div class="modal fade" id="loadtoserver" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="loader"></div>
                    <div class="loader-txt">
                        <p>{{ __("Upload in progress") }} <br><br><small>{{ __("Storing media on play-store") }}</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('./js/upload.js') }}"></script>
    <!-- Typeahead.js Bundle -->
    <script src="{{ asset('./js/typeahead/typeahead.bundle.js') }}"></script>
    <script>
        $(".datepicker").datepicker("setDate", new Date());
        $("#submit").click(function () {
            $('form').submit();
            $("#loadtoserver").modal({
                backdrop: "static", //remove ability to close modal with click
                keyboard: false, //remove option to close with keyboard
                show: true //Display loader!
            });
        });
    </script>

@endsection
