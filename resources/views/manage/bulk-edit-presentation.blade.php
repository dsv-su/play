@extends('layouts.suplay')
@section('content')
    <div>
        <form class="mx-3" id="bulkediting" method="post" action="{{route('edit.bulk.store')}}">
            @csrf
            @method('POST')
            <!-- Header message section -->
            <div class="container banner-inner">
                <div class="row no-gutters w-100">
                    <div class="col-12">
                        <span class="su-theme-anchor"></span>
                        <h3 class="su-theme-header mb-4">
                            <i class="fas fa-edit fa-icon mr-2"></i>{{ __("Bulk edit presentations") }}
                        </h3>
                    </div> <!-- col-12 -->
                </div> <!-- row no-gutters -->
            </div>

            <div class="container banner-inner">
                <div class="alert alert-info text-center">
                    {{__("Changes are saved upon clicking Save button at the bottom of the page.")}}
                </div>
            </div>

            <div class="container px-3 px-sm-0">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="rounded border shadow p-3 my-2">
                            <h5 class="mb-4">
                                <label class="form-control-label px-1">{{ __("Presentations to be edited") }}</label>
                            </h5>
                            @foreach($videos as $video)
                                <input type="hidden" value="{{$video->id}}" name="videos[]">
                                @include('home.video_table', ['video'=>$video, 'bulk' => 1])
                            @endforeach
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="rounded border shadow p-3 my-2">
                            <!-- Switches -->
                            <div class="row">
                                <div class="col-12 col-sm-6 justify-content-center d-sm-flex">
                                    <div class="form-group my-auto form-row mx-3">
                                        <label for="visibilitySwitch"
                                               class="col px-0 col-auto mb-0">{{__("Visibility")}}</label>
                                        <div class="col">
                                    <span class="custom-control custom-switch custom-switch-lg" data-toggle="tooltip"
                                          title="{{__("Switch the toggle to change")}}">
                                    <input class="custom-control-input"
                                           id="visibilitySwitch" name="visibility"
                                           type="checkbox">
                                    <label class="custom-control-label" style="margin-top: 3px;"
                                           for="visibilitySwitch"></label>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-md-6 justify-content-center d-sm-flex">
                                    <div class="form-group my-auto form-row mx-3">
                                        <label for="downloadSwitch"
                                               class="col px-0 col-auto mb-0">{{__("Downloadable")}}</label>
                                        <div class="col">
                                       <span class="custom-control custom-switch custom-switch-lg" data-toggle="tooltip"
                                             title="{{__("Switch the toggle to change")}}">
                                        <input class="custom-control-input"
                                               id="downloadSwitch" name="downloadable"
                                               type="checkbox">
                                        <label class="custom-control-label" style="margin-top: 3px;"
                                               for="downloadSwitch"></label>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="rounded border shadow p-3 my-2">
                            <!-- Course -->
                            <h5 class="mb-1">
                                <label class="form-control-label px-1">{{ __("Course association") }}</label>
                            </h5>
                            <div id="addedCourses" class="mx-1 my-2">
                            </div>
                            <div class="row justify-content-between text-left">
                                <div class="form-group col-12 col-lg-6 flex-column d-flex">
                                    <!-- Course association -->
                                    <div id="course-search-form" class="flex-column d-flex p-0">
                                        <input class="mx-1 w-100" type="search"
                                               id="course-search" autocomplete="off"
                                               aria-haspopup="true"
                                               placeholder="{{ __("Start typing to add a course") }}"
                                               aria-labelledby="course-search">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="rounded border shadow p-3 my-2">
                            <!-- Presenters -->
                            <h5 class="mb-1">
                                <label class="form-control-label px-1">{{ __("Presenters") }}</label>
                            </h5>
                            <div id="addedPresenters" class="mx-1 my-2">
                            </div>
                            <div class="row justify-content-between text-left">
                                <div class="form-group col-12 col-lg-6 flex-column d-flex">
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

                    <div class="col-sm-12">
                        <div class="rounded border shadow p-3 my-2">
                            <h5 class="mb-1">
                                <label class="form-control-label px-1">{{ __("Tags") }}</label>
                            </h5>
                            <div id="addedTags" class="mx-1 my-2">
                            </div>
                            <div class="row justify-content-between text-left">
                                <div class="form-group col-12 col-lg-6 flex-column d-flex">
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

                        <div class="col-sm-12 d-flex align-items-center">
                            <button type="submit" id="submit"
                                    class="btn btn-outline-primary ml-auto d-inline-block font-125rem m-3">{{ __("Save") }}</button>
                            <a href="{{url()->previous()}}" id="back"
                               class="btn btn-outline-primary mr-auto  d-inline-block font-125rem m-3">{{ __("Return back") }}</a>
                        </div>

                    </div>
                </div>
        </form>
    </div>


    <script>
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
                    $('#addedPresenters').append('<input type="hidden" value="' + username + '" name="supresenters[]"><span class="badge badge-pill badge-light" data-toggle="tooltip" data-title="SU username: ' + username + '">' + name + label + ' <a class="cursor-pointer" data-name="' + username + '" onclick="remove($(this))"><i class="fa-solid fa-xmark"></i></a></span>');
                }
            } else {
                if (!$('#addedPresenters').find('input[value="' + name + '"]').length) {
                    $('#addedPresenters').append('<input type="hidden" value="' + name + '" name="externalpresenters[]"><span class="badge badge-pill badge-light" data-toggle="tooltip" data-title="External">' + name + ' <a class="cursor-pointer" data-name="' + name + '" onclick="remove($(this))"><i class="fa-solid fa-xmark"></i></a></span>');
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
                        //return '<a class="badge badge-light d-inline-block m-1 cursor-pointer" data-toggle="tooltip" title="' + data.name + '" data-id="' + data.id + '" data-name="' + data.designation + ' ' + data.semester + data.year + '" data-fullname="' + data.name + '">' + data.designation + ' ' + data.semester + data.year + ' <i class="fa-solid fa-plus"></i></a>';
                        // Show only designations for now since play-store can't handle course ids
                        return '<a class="badge badge-light d-inline-block m-1 cursor-pointer" data-toggle="tooltip" data-title="' + fullname + '" data-id="' + data.id + '" data-name="' + data.designation + ' ' + data.semester + data.year + '" data-fullname="' + data.name + '">' + data.designation + ' ' + data.semester + data.year + ' <i class="fa-solid fa-plus"></i></a>';
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
            $('form').submit();
        });
    </script>
@endsection