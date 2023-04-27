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
                    <i class="fas fa-arrow-circle-up fa-icon mr-2"></i>{{ __("Upload presentation") }}
                </h1>
                <p class="font-1rem px-1">
                    {{ __("Fill out the form below and click the upload button when you're done to upload your presentation") }}
                </p>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>

    <div class="container px-3 px-sm-0">
        <form class="needs-validation" method="post" action="{{route('upload_step1', $presentation->id)}}">
        @csrf
        <!-- 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="rounded border shadow p-3 my-2">
                    <h5 class="mb-4">
                        <i class="fa fa-solid fa-1 fa-icon mr-2"></i><label
                                class="form-control-label px-1">{{ __("Information about the presentation") }}</label>
                    </h5>

                    <p class="font-1rem px-1">
                        {{ __("Enter the title of the presentation and the date of recording. If the recording date is unknown, you can enter today's date. Description is optional.") }}
                    </p>

                    <div class="row justify-content-between text-left">
                        <!-- Title -->
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label for="title" class="form-control-label px-1">{{ __("Title in Swedish") }}
                                <span class="text-danger"> *</span></label>
                            <input class="form-control" id="title" name="title" type="text"
                                   placeholder="{{ __("Title in Swedish") }}"
                                   value="{{ old('title') ? old('title'): $title ?? '' }}">
                            <div class="invalid-feedback">
                                {{__("Title is required")}}
                            </div>
                            <div><small class="text-danger">{{ $errors->first('title') }}</small></div>
                        </div>
                        <!-- Title english-->
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label for="title_en" class="form-control-label px-1">{{ __("Title in English") }}<span
                                    class="text-danger"> *</span></label>
                            <input class="form-control" id="title_en" name="title_en" type="text"
                                   placeholder="{{ __("Title in English") }}"
                                   value="{{ old('title_en') ? old('title'): $title_en ?? '' }}">
                            <div class="invalid-feedback">
                                {{__("Title in English is required")}}
                            </div>
                            <div><small class="text-danger">{{ $errors->first('title_en') }}</small></div>
                        </div>
                    </div>
                    <div class="row justify-content-between text-left">
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

                        <div class="form-group col-12 col-lg-6 flex-column d-flex">
                            <label for="description" class="form-control-label px-1">{{ __("Description") }}</label>
                            <textarea id="description" name="description" class="form-control"
                                      placeholder="{{__("Add a description here (optional)")}}"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 2 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="rounded border shadow p-3 my-2">
                    <!-- Course -->
                    <h5 class="mb-4">
                        <i class="fa fa-solid fa-2 fa-icon mr-2"></i><label
                                class="form-control-label px-1">{{ __("Course association") }}</label>
                    </h5>
                    <p class="font-1rem px-1 my-0">
                        {{ __("Here you specify whether the presentation should be associated with one or more courses. If you do not want the presentation to be associated with a course or want to complete at a later time, leave the field blank.") }}
                    </p>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 col-lg-6 flex-column d-flex">
                            <!-- Course association -->
                            <div id="addedCourses" class="mx-1 my-2">
                            </div>
                            <div id="course-search-form" class="flex-column d-flex p-0">
                                <input class="mx-1 w-100" type="search"
                                       id="course-search" name="q" autocomplete="off"
                                       aria-haspopup="true"
                                       placeholder="{{ __("Start typing to add a course") }}"
                                       aria-labelledby="course-search">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 3 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="rounded border shadow p-3 my-2">
                    <!-- Presenters -->
                    <h5 class="mb-4">
                        <i class="fa fa-solid fa-3 fa-icon mr-2"></i><label
                                class="form-control-label px-1">{{ __("Presenters") }}</label>
                    </h5>
                    <p class="font-1rem px-1 my-0">
                        {{ __("Add the presenters for this presentation. The uploader is listed as presenter by default.") }}
                    </p>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 col-lg-6 flex-column d-flex">
                            <div id="addedPresenters" class="mx-1 my-2">
                                <span class="badge badge-pill badge-light" data-toggle="tooltip"
                                      data-title="SU username: {{app()->make('play_username')}}">{{app()->make('play_user')}}</span>
                            </div>
                            <div id="presenter-search-form" class="flex-column d-flex p-0">
                                <input class="mx-1 w-100" type="search"
                                       id="presenter-search" name="q" autocomplete="off"
                                       aria-haspopup="true"
                                       placeholder="{{ __("Start typing to add a presenter") }}"
                                       aria-labelledby="presenter-search">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 4 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="rounded border shadow p-3 my-2">
                    <!-- Tags -->
                    <h5 class="mb-4">
                        <i class="fa fa-solid fa-4 fa-icon mr-2"></i><label
                                class="form-control-label px-1">{{ __("Tags") }}</label>
                    </h5>
                    <p class="font-1rem px-1 my-0">
                        {{ __("Enter tags for the presentation") }}
                    </p>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 col-lg-6 flex-column d-flex">
                            <div id="addedTags" class="mx-1 my-2">
                            </div>
                            <div id="tag-search-form" class="flex-column d-flex p-0">
                                <input class="mx-1 w-100" type="search"
                                       id="tag-search" name="q" autocomplete="off"
                                       aria-haspopup="true"
                                       placeholder="{{ __("Start typing to add a tag") }}"
                                       aria-labelledby="tag-search">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 5 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="rounded border shadow p-3 my-2">
                    <!-- Permissions -->
                    <h5 class="mb-4">
                        <i class="fa fa-solid fa-5 fa-icon mr-2"></i><label
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
                            <input type="hidden" name="prepopulate" value="1">
                    </div>
                </div>
            </div>
        </div>
        <!-- 6 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="rounded border shadow p-3 my-2">
                    <!-- Visibility -->
                    <h5 class="mb-4">
                        <i class="fa fa-solid fa-6 fa-icon mr-2"></i><label
                            class="form-control-label px-1">{{ __("Presentation visibility") }}</label>
                    </h5>
                    <livewire:uploadvisibility />
                </div>
            </div>
        </div>
        <!-- Upload bar -->
        <div class="container-fluid px-2 play_savebar">
            <div class="bar p-3 su-header-container__primary">
                <div class="d-flex row no-gutters justify-content-end">
                    <div class="col-md-4">
                        <div class="d-flex flex-row">
                            <p class="font-1rem px-1">
                                {{ __("Click the upload button when you're done to upload your presentation") }} <i class="fa-solid fa-arrow-right-long"></i>
                            </p>
                            <button type="submit" id="submit" class="btn btn-lg btn-light m-auto" disabled><strong>{{ __("UPLOAD") }}</strong></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end upload bar -->
        </form>
        <!-- 7 -->
        <div class="row">
            <div class="col-lg-12 my-2">
                <div class="rounded border shadow p-3 my-2">
                    <h5 class="mb-4">
                        <i class="fa fa-solid fa-7 fa-icon mr-2"></i><label class="form-control-label px-1"
                                                                            for="custom">{{__("Upload custom thumb") }}</label>
                    </h5>
                    <p class="font-1rem px-1">
                        {{ __("If you want, you can upload a custom image to represent your presentation.") }}
                    </p>
                <!-- Custom thumb -->
                    <div class="row justify-content-between text-left">
                        <div class="col-3 col-sm-3 my-2 d-flex align-items-center">
                            <div class="my-auto">
                                <div id="customThumbHolder">
                                    <form action="{{ route('thumb-upload') }}" class="dropzone" id="customthumbupload">
                                        <input type="file" name="thumb"  style="display: none;">
                                        <input type="hidden" name="thumbdir"  id="thumbdir" value="{{ $presentation->local }}">
                                        @csrf
                                        <div class="dz-message" data-dz-message>
                                            <span>{{__('Drop a picture here or click to browse')}}</span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 8 -->
        <div class="row">
            <div class="col-lg-12 my-2">
                <div class="rounded border shadow p-3 my-2">
                    <h5 class="mb-4">
                        <i class="fa fa-solid fa-8 fa-icon mr-2"></i><label
                            class="form-control-label px-1">{{ __("Mediafiles to be uploaded") }}</label>
                    </h5>
                    <p class="font-1rem px-1">
                        {{ __("Up to 4 media files per presentation can be uploaded.") }} {{ __("Each uploaded file should be the same length.") }}
                    </p>

                    <div class="row justify-content-between text-left">
                        <div class="form-group col-md-6 flex-column d-flex">

                            @livewire('uploadstatus', ['presentation' => $presentation ])

                            <label class="form-control-label px-1">{{ __("Files to upload") }}<span
                                    class="text-danger"> *</span> Files </label>

                            <div class="form-group">
                                <div id="uploaderHolder">
                                    <form action="{{ route('file-upload') }}" class="dropzone" id="datanodeupload">
                                        <input type="file" name="file"  style="display: none;">
                                        <input type="hidden" name="localdir"  id="localdir" value="{{ $presentation->local }}">
                                        @csrf
                                        <div class="dz-message" data-dz-message>
                                            <span>{{__('Drop files here or click to browse')}}</span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6 flex-column d-flex">

                            @livewire('autosubtitles', ['presentation' => $presentation ])

                            {{--}}
                            <!-- Subtitle -->
                            <div id="subtitleHolder">
                                <form action="{{ route('subtitle-upload') }}" class="dropzone" id="subtitleupload">
                                    <input type="file" name="subtitle"  style="display: none;">
                                    <input type="hidden" name="subtitledir"  id="subtitledir" value="{{ $presentation->local }}">
                                    @csrf
                                    <div class="dz-message" data-dz-message>
                                        <span>{{ __("Drop a WebVTT (.vtt) file here or click to browse") }}</span>
                                    </div>
                                </form>
                            </div>
                            {{--}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end container -->


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
            Dropzone.discover();
            var home_url = "{{env('APP_URL') }}";
            var deleteAction = '{{ route("file-delete") }}';
            var deleteThumb = '{{ route("thumb-delete") }}';
            var deleteSubtitle = '{{ route("subtitle-delete") }}';
            var dir =  document.getElementById('localdir').value;
            var thumbdir =  document.getElementById('thumbdir').value;
            var subtitledir =  document.getElementById('subtitledir').value;
            var token = '{!! csrf_token() !!}';

            function remove(el) {
                var type = el.closest('div').attr('id');
                if (type == 'addedTags') {
                    var tag = el.attr('data-name');
                    $('#addedTags').find('input[value="' + tag + '"]').remove();
                }
                if (type == 'addedCourses') {
                    var courseid = el.attr('data-id');
                    $('#addedCourses').find('input[value="' + courseid + '"]').remove();
                }
                if (type == 'addedPresenters') {
                    var name = el.attr('data-name');
                    $('#addedPresenters').find('input[value="' + name + '"]').remove();
                }
                el.closest('span').remove();
            }

            $(document).on('mouseover', '#course-search-form .tt-suggestion', function () {
                $(this).tooltip('show');
            });
            $(document).on('mouseover', '#addedCourses span', function () {
                $(this).tooltip('show');
            });
            $(document).on('mouseover', '#presenter-search-form .tt-suggestion', function () {
                $(this).tooltip('show');
            });
            $(document).on('mouseover', '#addedPresenters span', function () {
                $(this).tooltip('show');
            });
            $(document).on('click', '#course-search-form .tt-suggestion', function () {
                $(this).tooltip('hide');
                var courseid = $(this).attr('data-id');
                var coursename = $(this).attr('data-name');
                var fullname = $(this).attr('data-fullname');
                if (!$('#addedCourses').find('input[value="' + courseid + '"]').length) {
                    $('#addedCourses').append('<input type="hidden" value="' + courseid + '" name="courses[]"><span class="badge badge-pill badge-light"><span data-toggle="tooltip" data-title="' + fullname + '">' + coursename + ' </span><a class="cursor-pointer" data-id="' + courseid + '" onclick="remove($(this))"><i class="fa-solid fa-xmark"></i></a></span>');
                }
                $('#course-search').typeahead('val', '');
            });
            $(document).on('click', '#tag-search-form .tt-suggestion', function () {
                var tag = $(this).attr('data-name');
                if (!$('#addedTags').find('input[value="' + tag + '"]').length) {
                    $('#addedTags').append('<input type="hidden" value="' + tag + '" name="tags[]"><span class="badge badge-pill badge-light">' + tag + ' <a class="cursor-pointer" data-name="' + tag + '" onclick="remove($(this))"><i class="fa-solid fa-xmark"></i></a></span>');
                }
                $('#tag-search').typeahead('val', '');
            });
            $(document).on('click', '#presenter-search-form .tt-suggestion', function () {
                $(this).tooltip('hide');
                var username = $(this).attr('data-id');
                var name = $(this).attr('data-name');
                var role = $(this).attr('data-role');
                if (username != 0) {
                    if (!$('#addedPresenters').find('input[value="' + username + '"]').length) {
                        var label = (role == 'DSV' ? '<span class="bagde badge-primary ml-2 px-1" style="border-radius: 4px;">DSV</span>' : (role == 'Student' ? '<span class="bagde badge-success mx-1 px-1" style="border-radius: 4px;">Student</span>' : ''));
                        $('#addedPresenters').append('<input type="hidden" value="' + username + '" name="presenters[]"><span class="badge badge-pill badge-light" data-toggle="tooltip" data-title="SU username: ' + username + '">' + name + label + ' <a class="cursor-pointer" data-name="' + username + '" onclick="remove($(this))"><i class="fa-solid fa-xmark"></i></a></span>');
                    }
                } else {
                    if (!$('#addedPresenters').find('input[value="' + name + '"]').length) {
                        $('#addedPresenters').append('<input type="hidden" value="' + name + '" name="presenters[]"><span class="badge badge-pill badge-light" data-toggle="tooltip" data-title="External">' + name + ' <a class="cursor-pointer" data-name="' + name + '" onclick="remove($(this))"><i class="fa-solid fa-xmark"></i></a></span>');
                    }
                }
                $('#presenter-search').typeahead('val', '');
            });

            jQuery(document).ready(function ($) {
                var engine2 = new Bloodhound({
                    remote: {
                        url: '/findcourse?query=%QUERY%',
                        wildcard: '%QUERY%'
                    },
                    datumTokenizer: Bloodhound.tokenizers.whitespace('query'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });

                $("#course-search").typeahead({
                    classNames: {
                        menu: 'search_autocomplete'
                    },
                    hint: false,
                    autoselect: false,
                    highlight: true,
                    minLength: 2
                }, {
                    source: engine2.ttAdapter(),
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
                            var fullname = @if(Lang::locale() == 'swe') data.name
                            @else data.name_en @endif;
                            return '<a class="badge badge-light d-inline-block m-1 cursor-pointer" data-toggle="tooltip" title="' + data.name + '" data-id="' + data.id + '" data-name="' + data.designation + ' ' + data.semester + data.year + '" data-fullname="' + data.name + '">' + data.designation + ' ' + data.semester + data.year + ' <i class="fa-solid fa-plus"></i></a>';
                            // Show only designations for now since play-store can't handle course ids
                            //return '<a class="badge badge-light d-inline-block m-1 cursor-pointer" data-toggle="tooltip" data-title="' + fullname + '" data-id="' + data.id + '" data-name="' + data.designation + '" data-fullname="' + data.name + '">' + data.designation + ' <i class="fa-solid fa-plus"></i></a>';
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
                    minLength: 2
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

                /* Typeahead SUKAT user */
                // Set the Options for "Bloodhound" suggestion engine
                var engine3 = new Bloodhound({
                    remote: {
                        url: '/findperson?q=%QUERY%',
                        wildcard: '%QUERY%'
                    },
                    datumTokenizer: Bloodhound.tokenizers.whitespace('query'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });

                $('#presenter-search').typeahead({
                    classNames: {
                        menu: 'search_autocomplete'
                    },
                    hint: false,
                    autoselect: false,
                    highlight: true,
                    minLength: 3
                }, {
                    source: engine3.ttAdapter(),
                    limit: 20,
                    // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
                    name: 'autocomplete-items',
                    display: function (item) {
                        return item.fullname + ' (' + item.uid + ')';
                    },
                    templates: {
                        empty: [
                            ''
                        ],
                        header: [
                            ''
                        ],
                        suggestion: function (data) {
                            if ($('#addedPresenters').find('input[value="' + data.name + '"]').length) {
                                return '<span></span>';
                            } else {
                                if (!data.uid) {
                                    var string = (!data.local ? '{{__('New external')}}: ' : '');
                                    return '<a class="badge badge-secondary d-inline-block m-1 cursor-pointer" data-id=0 data-name="' + data.name + '">' + string + data.name + ' <i class="fa-solid fa-plus"></i></a>';
                                } else {
                                    var label = (data.role == 'DSV' ? '<span class="bagde badge-primary ml-2 px-1" style="border-radius: 4px;">DSV</span>' : (data.role == 'Student' ? '<span class="bagde badge-success mx-1 px-1" style="border-radius: 4px;">Student</span>' : ''));
                                    return '<a class="badge badge-light d-inline-block m-1 cursor-pointer" data-toggle="tooltip" data-role="' + data.role + '" data-title="SU username: ' + data.uid + '" data-name="' + data.name + '" data-id="' + data.uid + '">' + data.name + label + ' <i class="fa-solid fa-plus"></i></a>';
                                }
                            }
                        }
                    }
                }).on('keyup', function (e) {
                    let selected = $("#presenter-search").attr('aria-activedescendant');
                    if (e.which === 13) {
                        if (selected) {
                            // window.location.href = $("#" + selected).find('a').prop('href');
                        }
                    }
                });
                /* end typeahead */
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
                    window.scrollTo(0, 0);
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
