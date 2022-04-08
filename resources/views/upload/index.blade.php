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
                <h1 class="su-theme-header mb-4">
                    <i class="fas fa-arrow-circle-up fa-icon-border mr-2"></i>{{ __("Upload presentation") }}
                </h1>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>

    <div class="container px-3 px-sm-0">
        <div class="row">
            <div class="col-lg-12">
                <form class="needs-validation" method="post" action="{{route('upload_step1', $presentation->id)}}">
                    @csrf
                    <div class="rounded border shadow p-3 my-2">
                        <h5 class="mb-4">
                            <i class="fa fa-solid fa-1 fa-icon-border mr-2"></i><label
                                    class="form-control-label px-1">{{ __("Information about the presentation") }}</label>
                        </h5>

                        <p class="font-1rem px-1">
                            {{ __("Enter the title of the presentation and the date of recording. If the recording date is unknown, you can enter today's date. Description is optional.") }}
                        </p>

                        <div class="row justify-content-between text-left">
                            <!-- Title -->
                            <div class="form-group col-sm-6 flex-column d-flex"><label for="title"
                                                                                       class="form-control-label px-1">{{ __("Title in Swedish") }}
                                    <span
                                            class="text-danger"> *</span></label>
                                <input class="form-control" id="title" name="title" type="text"
                                       placeholder="{{ __("Title in Swedish") }}"
                                       value="{{ old('title') ? old('title'): $title ?? '' }}">
                                <div class="invalid-feedback">
                                    {{__("Title is required")}}
                                </div>
                                <div><small class="text-danger">{{ $errors->first('title') }}</small></div>
                            </div>

                            <!-- CreationDate -->
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label for="creationdate"
                                       class="form-control-label px-1">{{ __("Recording date") }}<span
                                            class="text-danger"> *</span></label>
                                <input id="creationdate" class="datepicker form-control" name="created" type="text"
                                       autocomplete="off" data-provide="datepicker" data-date-autoclose="true"
                                       data-date-today-highlight="true" required>
                                <div class="invalid-feedback">
                                    {{__('Recording date is required')}}
                                </div>
                                <div><small class="text-danger">{{ $errors->first('created') }}</small></div>
                            </div>
                        </div>
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label for="title_en" class="form-control-label px-1">{{ __("Title in English") }}<span
                                            class="text-danger"> *</span></label>
                                <input class="form-control" id="title_en" name="title_en" type="text"
                                       placeholder="{{ __("Title in English") }}"
                                       value="{{ old('title') ? old('title'): $title ?? '' }}">
                                <div class="invalid-feedback">
                                    {{__("Title in English is required")}}
                                </div>
                                <div><small class="text-danger">{{ $errors->first('title_en') }}</small></div>
                            </div>


                            <div class="form-group col-12 col-lg-6 flex-column d-flex"><label for="description"
                                                                                              class="form-control-label px-1">{{ __("Description") }}</label>
                                <textarea id="description" name="description" class="form-control"
                                          placeholder="{{__("Add a description here (optional)")}}"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="rounded border shadow p-3 my-2">
                        <!-- Course -->
                        <h5 class="mb-4">
                            <i class="fa fa-solid fa-2 fa-icon-border mr-2"></i><label
                                    class="form-control-label px-1">{{ __("Course association") }}</label>
                        </h5>
                        <p class="font-1rem px-1 my-0">
                            {{ __("Here you specify whether the presentation should be associated with one or more courses. If you do not want the presentation to be associated with a course or want to complete at a later time, leave the field blank.") }}
                        </p>
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-12 col-lg-6 flex-column d-flex mx-auto">
                                <!-- Course association -->

                                <select name="courses[]"
                                        class="form-control mx-1 selectpicker w-100" data-dropup-auto="false"
                                        data-none-selected-text="{{ __('No course association')}}"
                                        data-live-search="true" multiple>
                                    {{--}}
                                    @foreach($courses as $course)
                                        @if(!old('courses'))
                                        <option value={{ $course->designation }}>{{ $course->name . ' (' . $course->designation .')' }}</option>
                                        @else
                                        <option value="{{$course->designation}}" {{ old('courses') == $course->designation || in_array($course->designation, old('courses')) ? 'selected':''}}>{{$course->name . ' (' . $course->designation .')' }}</option>
                                        @endif
                                    @endforeach
                                    {{--}}

                                    @foreach($courses as $course)
                                        @if(!old('courses'))
                                            @if(Lang::locale() == 'swe')
                                                <option value="{{ $course->id }}"
                                                        data-subtext="{{$course->name}}">{{ $course->designation . ' '. $course->semester. $course->year}}</option>
                                            @else
                                                <option value="{{ $course->id }}"
                                                        data-subtext="{{$course->name_en}}">{{ $course->designation . ' '. $course->semester. $course->year }}</option>
                                            @endif
                                        @else
                                            @if(Lang::locale() == 'swe')
                                                <option value="{{$course->id}}"
                                                        data-subtext="{{$course->name}}" {{ old('courses') == $course->designation || in_array($course->designation, old('courses')) ? 'selected':''}}>{{$course->designation . ' '. $course->semester. $course->year}}</option>
                                            @else
                                                <option value="{{$course->id}}"
                                                        data-subtext="{{$course->name_en}}" {{ old('courses') == $course->designation || in_array($course->designation, old('courses')) ? 'selected':''}}>{{$course->designation . ' '. $course->semester. $course->year}}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12 col-lg-6 flex-column d-flex">

                            </div>
                        </div>
                    </div>
                    <div class="rounded border shadow p-3 my-2">
                        <!-- Presenters -->
                        <h5 class="mb-4">
                            <i class="fa fa-solid fa-3 fa-icon-border mr-2"></i><label
                                    class="form-control-label px-1">{{ __("Presenters") }}</label>
                        </h5>
                        <p class="font-1rem px-1 my-0">
                            {{ __("Add the presenters for this presentation. The uploader is listed as presenter by default.") }}
                        </p>
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-12 col-lg-6 flex-column d-flex">
                                <label class="form-control-label px-1" for="uploader">
                                    <span type="button" name="presenteradd"
                                          class="btn btn-primary px-1 py-0 presenteradd">{{__('Add')}}<i
                                                class="fas fa-user-plus ml-1"></i></span>
                                </label>

                                <div id="presenter_table">
                                    <input type="text" class="form-control w-100 mx-auto" id="uploader"
                                           value="{{app()->make('play_user')}} ({{app()->make('play_username')}})"
                                           readonly>
                                    @if(old('presenters'))
                                        @foreach(old('presenters') as $presenter)
                                            <div class="d-flex justify-content-between" id="user-search">
                                                <input class="form-control w-100 mx-auto" type="search"
                                                       id="user-search-text-{{$loop->index+1}}" name="presenters[]"
                                                       value="{{$presenter}}" autocomplete="off" aria-haspopup="true"
                                                       placeholder="Name or username" aria-labelledby="user-search">
                                                <a type="button" id="presenterremove"
                                                   class="absolute cursor-pointer p-2 top-2 right-2 text-gray-500 presenterremove"><i
                                                            class="fas fa-user-minus"></i></a>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rounded border shadow p-3 my-2" id="tag-search-form">

                        <h5 class="mb-4">
                            <i class="fa fa-solid fa-4 fa-icon-border mr-2"></i><label
                                    class="form-control-label px-1">{{ __("Tags") }}</label>
                        </h5>
                        <p class="font-1rem px-1 my-0">
                            {{ __("Enter tags for the presentation") }}
                        </p>
                        <div id="addedTags">
                        </div>
                        <div id="tag-search-form" class="flex-column d-flex col col-md-6 p-0">
                        <!--<span class="text-font-size-80">{{__('Add a tag')}}: </span>-->
                            <input wire:ignore class="mx-1 w-100" type="search"
                                   id="tag-search" name="q" autocomplete="off"
                                   aria-haspopup="true"
                                   placeholder="{{ __("Start typing to add a tag") }}"
                                   aria-labelledby="tag-search">
                        </div>
                    </div>
                    <div class="rounded border shadow p-3 my-2">
                        <!-- Permissions -->
                        <h5 class="mb-4">
                            <i class="fa fa-solid fa-5 fa-icon-border mr-2"></i><label
                                    class="form-control-label px-1">{{ __("Playback permissions") }}</label>
                        </h5>

                        <p class="px-1 font-1rem mb-0">
                            {{ __("All uploaded presentations are accessible to DSV Students and Staff unless otherwise specified with the 'Custom' alternative.") }}
                        </p>
                        <div class="row mb-2 justify-content-between text-left">
                            <div class="form-group col-sm-6 mb-0 flex-column d-flex">
                                <select name="permission" class="form-control permission selectpicker"
                                        data-dropup-auto="false" id="permission">
                                    @if(!old('permission'))
                                        <option value="false" selected>@lang('lang.public')</option>
                                        <option value="true">@lang('lang.private')</option>
                                    @else
                                        @if(old('permission') == true)
                                            <option value="true" selected>@lang('lang.private')</option>
                                        @else
                                            <option value="false" selected>@lang('lang.public')</option>
                                        @endif
                                    @endif
                                </select>
                            </div>
                            <!-- Custom permissions -->
                            @if(!old('video_permission'))
                                <div id="video_perm" class="form-group col-sm-6 mb-0" hidden>
                                    @else
                                        <div id="video_perm" class="form-group col-sm-6 mb-0">
                                            @endif

                                            <select class="form-control selectpicker" data-dropup-auto="false"
                                                    name="video_permission">
                                                @foreach($permissions as $permission)
                                                    @if(!old('video_permission'))
                                                        @if(Lang::locale() == 'swe')
                                                            <option value="{{$permission->id}}">{{$permission->id}}
                                                                : {{$permission->scope}}</option>
                                                        @else
                                                            <option value="{{$permission->id}}">{{$permission->id}}
                                                                : {{$permission->scope_en}}</option>
                                                        @endif
                                                    @else
                                                        @if(Lang::locale() == 'swe')
                                                            <option value="{{$permission->id}}" {{ old('video_permission') == $permission->id  ? 'selected':''}}>{{$permission->id}}
                                                                : {{$permission->scope}}</option>
                                                        @else
                                                            <option value="{{$permission->id}}" {{ old('video_permission') == $permission->id  ? 'selected':''}}>{{$permission->id}}
                                                                : {{$permission->scope_en}}</option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                </div>
                                <input type="hidden" name="prepopulate" value="1">
                                <!-- Policy -->
                                <!-- Disabled until PO agree on a suitable text -->
                                {{--}}
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
                                {{--}}
                        </div>
                    </div>
                </form>
            </div>
            <!--/col-9-->

            @livewire('file-upload', [
            'presentation' => $presentation,
            'permissions' => $permissions
            ])


            {{--}}
                    <div class="row justify-content-center">
                        <div class="form-group col-sm-4">
                            <button id="submit" type="submit"
                                    class="btn-block btn btn-outline-primary">{{ __("Upload") }}</button>
                        </div>
                    </div>
            {{--}}
        </div>

        <!-- Modal spinners -->
        <div class="modal fade" id="loadtoserver" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="loader"></div>
                        <div class="loader-txt">
                            <p>{{ __("Upload in progress") }}
                                <br><br><small>{{ __("Storing media on play-store") }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('./js/upload.js') }}"></script>
        <script>
            function remove(el) {
                var tag = el.attr('data-name');
                $('#addedTags').find('input[value="' + tag + '"]').remove();
                el.closest('span').remove();
            }

            $(document).on('click', '.tt-suggestion', function () {
                var tag = $(this).attr('data-name');
                if (!$('#addedTags').find('input[value="' + tag + '"]').length) {
                    $('#addedTags').append('<input type="hidden" value="' + tag + '" name="tags[]"><span class="badge badge-pill badge-light">' + tag + ' <a class="cursor-pointer" data-name="' + tag + '" onclick="remove($(this))"><i class="fa-solid fa-xmark"></i></a></span>');
                }
                if ($(this).attr('data-id') > 0) {
                } else {
                }
                $('#tag-search').typeahead('val', '');
            });
            jQuery(document).ready(function ($) {
                // Set the Options for "Bloodhound" suggestion engine
                var engine = new Bloodhound({
                    remote: {
                        url: '/findtag?query=%QUERY%',
                        wildcard: '%QUERY%'
                    },
                    datumTokenizer: Bloodhound.tokenizers.whitespace('query'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });

                $("#tag-search").typeahead({
                    classNames: {
                        menu: 'search_autocomplete'
                    },
                    hint: false,
                    autoselect: false,
                    highlight: true,
                    minLength: 1
                }, {
                    source: engine.ttAdapter(),
                    limit: 15,
                    // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
                    name: 'autocomplete-items',
                    display: function (item) {
                        return item.name;
                    },
                    templates: {
                        empty: [
                            ''
                        ],
                        header: [
                            ''
                        ],
                        suggestion: function (data) {
                            if (data.type == 'input') {
                                return '<a class="badge badge-secondary d-inline-block m-1 cursor-pointer" data-name="' + data.name + '">{{__('New tag')}}: ' + data.name + ' <i class="fa-solid fa-plus"></i></a>';
                            } else {
                                return '<a class="badge badge-light d-inline-block m-1 cursor-pointer" data-name="' + data.name + '">' + data.name + ' <i class="fa-solid fa-plus"></i></a>';
                            }
                        }
                    }
                }).on('keyup', function (e) {
                    //$(".tt-suggestion:first-child").addClass('tt-cursor');
                    let selected = $("#tag-search").attr('aria-activedescendant');
                    if (e.which === 13) {
                        if (selected) {
                            // window.location.href = $("#" + selected).find('a').prop('href');
                        }
                    }
                });
            });
            $(".datepicker").datepicker({
                format: "dd/mm/yyyy",
                weekStart: 1,
                todayHighlight: true
            }).datepicker("setDate", new Date());
            $("#submit").click(function () {
                let errors = 0;
                if ($('#title').val() == '') {
                    $('#title').addClass('is-invalid');
                    $('#title').removeClass('is-valid');
                    errors = 1;
                } else {
                    $('#title').removeClass('is-invalid');
                }
                if ($('#title_en').val() == '') {
                    $('#title_en').addClass('is-invalid');
                    $('#title_en').removeClass('is-valid');
                    errors = 1;
                } else {
                    $('#title_en').removeClass('is-invalid');
                }
                if ($('#creationdate').val() == '') {
                    $('#creationdate').addClass('is-invalid');
                    $('#creationdate').removeClass('is-valid');
                    errors = 1;
                } else {
                    $('#creationdate').removeClass('is-invalid');
                }
                if (errors) {
                    return false;
                }
                $('form').submit();
                $("#loadtoserver").modal({
                    backdrop: "static", //remove ability to close modal with click
                    keyboard: false, //remove option to close with keyboard
                    show: true //Display loader!
                });
            });
        </script>

@endsection
