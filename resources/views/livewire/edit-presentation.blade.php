<div>
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
                    <i class="fas fa-edit fa-icon-border mr-2"></i>{{ __("Edit presentation") }}
                </h3>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>

    <div wire:ignore class="container banner-inner">
        @if(session()->has('message'))
            <div class="alert text-center @if (session('success')) alert-success @elseif (session('warning')) alert-warning @elseif (session('error')) alert-danger @else alert-info @endif">
                {{ session('message') }}
            </div>
        @else
            <div class="alert alert-info text-center">
                {{__("Changes are saved upon clicking Save button at the bottom of the page.")}}
            </div>
        @endif
    </div>

    <div class="container px-3 px-sm-0">
        <div class="row">
            <div class="col-sm-12">
                <div class="rounded border shadow p-3 my-2">
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-md-6 col-lg-4 mx-auto text-center">
                            @if($visibility)
                                <img id="presentation" src="{{$thumb}}?{{ rand() }}" style="max-width: 300px;"
                                     class="w-100">
                            @endif
                            <div class="d-flex justify-content-center h-100">
                                @if(!$visibility)
                                    <div id="presentation_hidden" class="alert alert-secondary m-auto"
                                         role="alert">{{ __("Presentation hidden") }}</div>
                                @endif
                            </div>
                            {{--}}
                            <div class="rounded border shadow p-3 my-2">
                            @if($editt)
                            <div class="flex justify-center">
                                <img src="{{$editt->temporaryUrl}}?{{ rand() }}" width="90%">
                            </div>
                            @endif
                            <small>Upload new thumb</small>
                            <input type="file" class="form-control form-control-sm" wire:model="editt">
                                @error('editt') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            {{--}}
                        </div>

                        <div class="form-group col-md-6 col-lg-8 px-md-3 mb-0">
                            <div class="row">
                                <label class="col-4 col-lg-3 mb-0">{{__("Title")}}</label>
                                <div class="col">{{$video->title}}</div>
                            </div>
                            <div class="row">
                                <label class="col-4 col-lg-3 mb-0">{{ __("Origin") }}</label>
                                <div class="col">@if($origin == 'mediasite')
                                        {{ __("Migrated from Mediasite") }}
                                    @elseif($origin == 'cattura')
                                        {{ __("Recorded at DSV") }}
                                    @elseif($origin == 'manual')
                                        {{ __("Uploaded by user") }}
                                    @endif
                                </div>
                            </div>
                            <div class="row"><label class="col-4 col-lg-3 mb-0">{{ __("Recording date") }}</label>
                                <div class="col">{{$date}}</div>
                            </div>
                            <div class="row"><label class="col-4 col-lg-3 mb-0">{{ __("Duration") }}</label>
                                <div class="col">{{$duration}}</div>
                            </div>
                            <div class="row">
                                <label class="col-4 col-lg-3 mb-0">{{__("Course")}}</label>
                                <div class="col">@if (empty($course))
                                        {{ __("Not associated to a course") }}
                                    @else
                                        {{implode(', ', $course)}}
                                    @endif</div>
                            </div>
                            <div class="row"><label for="visibilitySwitch"
                                                    class="col-4 col-lg-3 mb-0">{{__("Visibility")}}</label>
                                <div class="col">
                                       <span class="custom-control custom-switch custom-switch-lg">
                                        <input wire:click="visibility" class="custom-control-input"
                                               id="visibilitySwitch" name="visibility"
                                               type="checkbox" @if($visibility == true) checked @endif>
                                        <label class="custom-control-label" style="margin-top: 3px;"
                                               for="visibilitySwitch"></label>
                                    </span>
                                </div>
                            </div>
                            <div class="row"><label for="downloadSwitch"
                                                    class="col-4 col-lg-3 mb-0">{{__("Downloadable")}}</label>
                                <div class="col">
                                       <span class="custom-control custom-switch custom-switch-lg">
                                        <input class="custom-control-input"
                                               id="downloadSwitch" name="download"
                                               type="checkbox" @if($download == true) checked @endif>
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
                    <!-- Title -->
                    <div class="row justify-content-between text-left">

                        <div class="form-group col-12 col-md-6 flex-column d-flex">
                            <label class="form-control-label px-1">{{ __("Title in Swedish") }}<span
                                        class="text-danger"> *</span></label>
                            <input wire:model="title" name="title" id="title" type="text" required class="form-control">
                            <div class="invalid-feedback">
                                {{__("Title is required")}}
                            </div>
                            <div>
                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-group col-12 col-md-6 flex-column d-flex">
                            <label class="form-control-label px-1">{{ __("Recording date") }}<span class="text-danger"> *</span></label>
                            <input id="creationdate" class="datepicker form-control" wire:model="date" name="date"
                                   type="text"
                                   autocomplete="off" data-provide="datepicker" data-date-autoclose="true"
                                   data-date-today-highlight="true" style="max-width: 150px;" required>
                            <div class="invalid-feedback">
                                {{__("Recording date is required")}}
                            </div>
                            <div><small class="text-danger">{{ $errors->first('created') }}</small></div>
                        </div>

                        <div class="form-group col-12 col-md-6 flex-column d-flex">
                            <label class="form-control-label px-1">{{ __("Title in English") }}<span
                                        class="text-danger"> *</span></label>
                            <input wire:model="title_en" name="title_en" id="title_en" type="text" required
                                   class="form-control">
                            <div class="invalid-feedback">
                                {{__("Title in English is required")}}
                            </div>
                            <div>
                                @error('title_en') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <!-- Description -->
                        <div class="form-group col-12 col-md-6 flex-column d-flex"><label
                                    class="form-control-label px-1">{{ __("Description") }}</label>
                            <textarea id="description" wire:model="description" name="description"></textarea>
                        </div>

                    </div>

                    <!-- Course -->
                    <div class="row justify-content-between text-left">

                        <div class="form-group col-12 col-md-6 flex-column d-flex" id="course-search-form">
                            <label class="form-control-label px-1">{{ __("Course association") }}</label>
                            <div id="addedCourses" class="mx-1 my-2">
                                @if (empty($courseids))
                                    <span class="font-1rem">{{__('No course association')}}</span>
                                @else
                                    @foreach($courseids as $courseid => $names)
                                        <input type="hidden" value="{{$courseid}}" name="courseids[]">
                                        <span class="badge badge-pill badge-light"><span data-toggle="tooltip"
                                                                                         data-title="{{$names['fullname']}}">{{$names['shortname']}}</span> <a
                                                    class="cursor-pointer" wire:click="remove_course({{$courseid}})"><i
                                                        class="fa-solid fa-xmark"></i></a></span>
                                    @endforeach
                                @endif
                            </div>
                            <div wire:ignore id="course-search-form" class="flex-column d-flex">
                                <input class="mx-1 w-100" type="search"
                                       id="course-search" name="q" autocomplete="off"
                                       aria-haspopup="true"
                                       placeholder="{{ __("Start typing to add a course") }}"
                                       aria-labelledby="course-search">
                            </div>
                        </div>

                        <div class="form-group col-12 col-md-6 flex-column d-flex">
                            <label class="form-control-label px-1">{{ __("Course manager(s)") }}</label>
                            <div class="mx-1 my-2 font-1rem">
                                @if (empty($course_responsible))
                                    {{__("No course manager added")}}
                                @else
                                    @foreach($course_responsible as $i=>$id)
                                        @foreach($id as $k=>$responsible)
                                            <span
                                                    class="m-1 badge badge-pill badge-light font-1rem">{{$responsible['firstName']}} {{$responsible['lastName']}}</span>
                                        @endforeach
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Presenters and Tags -->
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 col-md-6 flex-column d-flex">
                            <label class="form-control-label px-1">{{ __("Presenters") }}
                            </label>
                            <div id="addedPresenters" class="mx-1 my-2">
                                @if (empty($presenters))
                                    <span class="font-1rem">{{__('No registered presenters')}}</span>
                                @else
                                    @foreach($presenters as $key => $presenter)
                                        <input type="hidden" @if ($presenter['type'] == 'sukat') value="{{$presenter['uid']}}" @else value="0" @endif name="presenteruids[]">
                                        <input type="hidden" value="{{$presenter['name']}}" name="presenternames[]">
                                        <span class="badge badge-pill badge-light">
                                            <span data-toggle="tooltip" @if ($presenter['type'] == 'sukat')  data-title="SU username: {{$presenter['uid']}}" @else data-title="External" @endif>{{$presenter['name']}}
                                            </span>@if (isset($presenter['role']) && $presenter['role'] == 'DSV') <span class="badge badge-primary px-1" style="border-radius: 4px;">DSV</span> @endif
                                            @if (isset($presenter['role']) && $presenter['role'] == 'Student') <span class="badge badge-success px-1" style="border-radius: 4px;">Student</span> @endif<a
                                                    class="cursor-pointer" wire:click="remove_presenter({{$key}})"><i
                                                        class="fa-solid fa-xmark"></i></a></span>
                                    @endforeach
                                @endif
                            </div>
                            <div wire:ignore id="presenter-search-form" class="flex-column d-flex">
                                <input class="mx-1 w-100" type="search"
                                       id="presenter-search" name="q" autocomplete="off"
                                       aria-haspopup="true"
                                       placeholder="{{ __("Start typing to add a presenter") }}"
                                       aria-labelledby="presenter-search">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6 flex-column d-flex">
                            <label class="form-control-label px-1">{{ __("Tags") }}</label>
                            <div id="addedTags" class="mx-1 my-2">
                                @if (empty($tagids))
                                    <span class="font-1rem">{{__('No tags added')}}</span>
                                @else
                                    @foreach($tagids as $key => $tagid)
                                        <input type="hidden" value="{{$tagid}}" name="tags[]">
                                        <span class="badge badge-pill badge-light">{{\App\Tag::find($tagid)->name}} <a
                                                    class="cursor-pointer" wire:click="remove_tag({{$key}})"><i
                                                        class="fa-solid fa-xmark"></i></a></span>
                                    @endforeach
                                @endif
                            </div>
                            <div wire:ignore id="tag-search-form" class="flex-column d-flex">
                                <input class="mx-1 w-100" type="search"
                                       id="tag-search" name="q" autocomplete="off"
                                       aria-haspopup="true"
                                       placeholder="{{ __("Start typing to add a tag") }}"
                                       aria-labelledby="tag-search">
                            </div>
                        </div>
                    </div>

                    <!-- Permissions -->
                    <div class="row justify-content-between text-left">
                        <!--Video group permission settings-->
                        <div class="form-group col-12 col-md-6 flex-column d-flex">
                            <label class="form-control-label px-1"><i
                                        class="fas fa-play fa-border fa-pull-left"></i>{{ __("Playback group permissions") }}
                            </label>
                            <div id="video_perm">
                                <select class="form-group form-control" name="video_permission" style="margin: 5px 0px;"
                                        @if(!$visibility) style="background: #dddddd" @endif>
                                    @foreach($permissions as $perm)
                                        <option value="{{$perm->id}}"
                                                @if($presentationpermissonId == $perm->id) selected @endif >{{$perm->id}}
                                            : {{ Lang::locale() == 'swe' ? $perm->scope : $perm->scope_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Individual permissions -->
                        <div class="form-group col-12 col-md-6 flex-column d-flex">
                            <label class="form-control-label px-1"><i
                                        class="fas fa-user fa-border fa-pull-left"></i>{{ __("Individual permissions") }}
                                <span class="badge badge-light">{{$ipermissions}} {{ __("Set") }}</span>
                                <span type="button" wire:click.prevent="add_individual_perm"
                                      class="btn btn-primary px-1 py-0">{{__("Add")}} <i
                                            class="fas fa-user-plus"></i></span></label>
                            @if (count($individuals)>0)
                                @foreach($individuals as $key => $name)
                                    <div class="d-inline">
                                        <div wire:ignore class="d-flex justify-content-between" id="perm-search">
                                            <input class="form-control mx-auto perm" id="perm-search-text-{{$key}}"
                                                   type="search" wire:model="individuals.{{$key}}"
                                                   name="individual_permissions[]"
                                                   placeholder="Start typing name or username"
                                                   aria-haspopup="true" autocomplete="off"
                                                   aria-labelledby="perm-search" @if ($name) readonly @endif>
                                            @error('individuals.*') <span class="error">{{ $message }}</span> @enderror
                                            <div class="p-1 col-auto">
                                                <select name="individual_perm_type[]" class="form-control">
                                                    <option value="read"
                                                            @if($individuals_permission[$key] == 'read') selected @endif
                                                            @if ($user_permission != 'delete' && $individuals_permission[$key] == 'delete') disabled @endif>
                                                        Read
                                                    </option>
                                                    <option value="edit"
                                                            @if($individuals_permission[$key] == 'edit') selected @endif
                                                            @if ($user_permission != 'delete' && $individuals_permission[$key] == 'delete') disabled @endif>
                                                        Edit
                                                    </option>
                                                    <option value="delete"
                                                            @if($individuals_permission[$key] == 'delete') selected
                                                            @endif
                                                            @if ($user_permission != 'delete' && $individuals_permission[$key] != 'delete') disabled @endif>
                                                        Delete
                                                    </option>
                                                </select>
                                            </div>
                                            @if ($user_permission == 'delete' || $individuals_permission[$key] != 'delete')
                                                <a class="absolute cursor-pointer p-2 top-2 right-2 text-gray-500 my-auto"
                                                   wire:click="remove_user({{$key}})">
                                                    <i class="fas fa-user-minus align-content-center"></i>
                                                </a>
                                            @else
                                                <span class="absolute p-2 top-2 right-2 text-gray-500 my-auto text-white">
                                                <i class="fas fa-user-minus align-content-center"></i></span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="mx-1 my-2 font-1rem">{{ __("No individual permissions added") }}</div>
                            @endif
                        </div>
                        <!-- end Individual permissions -->
                        <!-- Alert warning -->
                        @if(!$visibility)
                            <div class="form-group col-12 col-md-6 flex-column d-flex">
                                <div class="col alert alert-warning" role="alert">
                                    <p class="px-1 font-1rem">
                                        {{ __("The presentation is hidden and locked for playback. Accessible only by individual users with editing permissions") }}
                                    </p>
                                </div>
                            </div>
                        @endif
                        <!-- -->
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="row">
                    @foreach($sources as $key => $source)
                        <div class="col-xl-3 col-sm-6 my-2">
                            <div class="card border-left-info rounded border shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-center">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                <!-- probably need to switch that logic on renaming a primary stream -->
                                                {{ __("Stream") }} {{$loop->index + 1}}
                                                @if (!is_numeric($source->name))
                                                    : @if ($origin == 'cattura' && !in_array($source->name, ['right', 'left', 'main']))
                                                        {{ __("Camera") }}
                                                    @else
                                                        {{$source->name}}
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="position-relative">
                                                <img class=@if ($hidden[$key]) "opacity-1" @else
                                                    "opacity-5"
                                                @endif
                                                src="{{$poster[$key]}}?{{ rand() }}" width="100%">
                                                <div class="d-flex justify-content-center h-100">
                                                    <div id="stream_hidden" class="alert alert-secondary m-auto"
                                                         @if (!$hidden[$key]) style="display: none;" @endif
                                                         role="alert">{{ __("Stream hidden") }}</div>
                                                </div>
                                            </div>
                                            {{--}}<input class="form-control form-control-sm" type="file" wire:model="editfile.{{$key}}">{{--}}
                                            @error('editfile.*') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="row m-2 d-flex justify-content-center font-1rem line-15rem font-weight-light">
                                        <div class="custom-control custom-switch mx-1">
                                            <input type="checkbox" name="audio"
                                                   id="audioSwitch{{$loop->index + 1}}"
                                                   value="{{$loop->index}}" class="custom-control-input"
                                                   @if($playAudio[$key] == true) checked @endif >
                                            <label class="custom-control-label"
                                                   for="audioSwitch{{$loop->index + 1}}">{{ __("Audio") }}</label>
                                        </div>
                                        <div class="custom-control custom-switch mx-1">
                                            <input type="checkbox" name="hidden[]"
                                                   id="hiddenSwitch{{$loop->index + 1}}"
                                                   value="{{$loop->index}}" class="custom-control-input"
                                                   @if($hidden[$key] == true) checked @endif >
                                            <label class="custom-control-label"
                                                   for="hiddenSwitch{{$loop->index + 1}}">{{ __("Hidden") }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-sm-12 d-flex align-items-center">
                <button type="submit" id="submit"
                        class="btn btn-outline-primary ml-auto d-inline-block font-125rem m-3">{{ __("Save") }}</button>
                <a href="{{route('manage')}}" id="back"
                   class="btn btn-outline-primary mr-auto  d-inline-block font-125rem m-3">{{ __("Return back") }}</a>
            </div>

        </div>
    </div>
</div>

<script>
    $("#submit").click(function () {
        if ($('#title').val() == '') {
            $('#title').addClass('is-invalid');
            $('#title').removeClass('is-valid');
        } else {
            $('#title').removeClass('is-invalid');
        }
        if ($('#title_en').val() == '') {
            $('#title_en').addClass('is-invalid');
            $('#title_en').removeClass('is-valid');
        } else {
            $('#title_en').removeClass('is-invalid');
        }
        if ($('#creationdate').val() == '') {
            $('#creationdate').addClass('is-invalid');
            $('#creationdate').removeClass('is-valid');
        } else {
            $('#creationdate').removeClass('is-invalid');
        }
    });
</script>

<script>
    $(document).ready(function () {
        $(".datepicker").datepicker({
            format: "dd/mm/yyyy",
            weekStart: 1,
            todayHighlight: true
        });

    @this.set('courseEdit', {{json_encode(array_keys($courseids))}}.map(String));
    });
</script>

<script>
    // AudioSwitch the selector will match all input controls of type :checkbox
    // and attach a click event handler
    $("input:checkbox[name='audio']").on('click', function () {
        // in the handler, 'this' refers to the box clicked on
        var $box = $(this);
        if ($box.is(":checked")) {
            // the name of the box is retrieved using the .attr() method
            // as it is assumed and expected to be immutable
            var group = "input:checkbox[name='" + $box.attr("name") + "']";
            // the checked state of the group/box on the other hand will change
            // and the current value is retrieved using .prop() method
            $(group).prop("checked", false);
            $box.prop("checked", true);
        } else {
            $box.prop("checked", false);
        }
    });
    // Hidden checkboxes
    $("input:checkbox[name='hidden[]']").on('click', function () {
        $(this).closest('.card-body').find('img').toggleClass('opacity-5 opacity-2');
        $(this).closest('.card-body').find('#stream_hidden').toggle();
    });
</script>
<script>
    $(document).ready(sukatuser);
    window.addEventListener('permissionChanged', event => {
        $(sukatuser);
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
            limit: 20,
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
                        return '<a class="badge badge-secondary d-inline-block m-1 cursor-pointer" data-id=0 data-name="' + data.name + '">{{__('New tag')}}: ' + data.name + ' <i class="fa-solid fa-plus"></i></a>';
                    } else {
                        if ($('#addedTags').find('input[value="' + data.id + '"]').length) {
                            return '<span></span>';
                        } else {
                            return '<a class="badge badge-light d-inline-block m-1 cursor-pointer" data-id=' + data.id + '>' + data.name + ' <i class="fa-solid fa-plus"></i></a>';
                        }
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

        // Set the Options for "Bloodhound" suggestion engine
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
            minLength: 1
        }, {
            source: engine2.ttAdapter(),
            limit: 20,
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
                    if ($('#addedCourses').find('input[value="' + data.id + '"]').length) {
                        return '<span></span>';
                    } else {
                        var name = @if (Lang::locale() == 'swe') data.name
                        @else data.name_en @endif;
                        return '<a class="badge badge-light d-inline-block m-1 cursor-pointer" data-toggle="tooltip" data-title="' + name + '" data-id="' + data.id + '">' + data.designation + ' ' + data.semester + data.year + ' <i class="fa-solid fa-plus"></i></a>';
                    }
                }
            }
        }).on('keyup', function (e) {
            //$(".tt-suggestion:first-child").addClass('tt-cursor');
            let selected = $("#course-search").attr('aria-activedescendant');
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
                            return '<a class="badge badge-light d-inline-block m-1 cursor-pointer" data-toggle="tooltip" data-title="SU username: ' + data.uid + '" data-name="' + data.name + '" data-id="' + data.uid + '">' + data.name + label + ' <i class="fa-solid fa-plus"></i></a>';
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

    function sukatuser($) {
        /* Typeahead SUKAT user */
        // Set the Options for "Bloodhound" suggestion engine
        var engine = new Bloodhound({
            remote: {
                url: '/ldap_search?q=%QUERY%',
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.whitespace('query'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });

        $('.perm:first-child').typeahead({
            classNames: {
                menu: 'search_autocomplete'
            },
            hint: false,
            autoselect: true,
            highlight: true,
            minLength: 1
        }, {
            source: engine.ttAdapter(),
            limit: 10,
            // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
            name: 'autocomplete-items',
            display: function (item) {
                return item.displayname + ' (' + item.uid + ')';
            },
            templates: {
                empty: [
                    '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                ],
                header: [
                    '<div class="list-group search-results-dropdown">'
                ],
                suggestion: function (data) {
                    return '<li>' + data.displayname + ' (' + data.uid + ')' + '</li>';
                }
            }
        }).on('keyup', function (e) {
            $(".tt-suggestion:first-child").addClass('tt-cursor');
            let selected = $("#perm-search-text").attr('aria-activedescendant');
            if (e.which == 13) {
                if (selected) {
                } else {
                    $(".tt-suggestion:first-child").addClass('tt-cursor');
                }
                // Disable the input after Enter
                $(this).prop('readonly', true);
                // Resubmit the chosen value
                var values = $("input[name='individual_permissions[]']").map(function () {
                    return $(this).val();
                }).get();
            @this.set('individuals', values);
            }
        });
        /* end typeahead */
    }

    // Resubmit the chosen value and disable input when selected from the typeahead
    $(document).on('click', '.tt-suggestion', function () {
        $(this).tooltip('hide');
        var type = $(this).closest('div.d-flex').prop('id');
        if (type == 'perm-search') {
            $(this).closest('.twitter-typeahead').find('input').prop('readonly', true);
            var values = $("input[name='individual_permissions[]']").map(function () {
                return $(this).val();
            }).get();
        @this.set('individuals', values);
        } else if (type == 'user-search') {
            $(this).closest('.twitter-typeahead').find('input').prop('readonly', true);
            var values = $("input[name='presenters[]']").map(function () {
                return $(this).val();
            }).get();
        @this.set('presenters', values);
        } else if (type == 'tag-search-form') {
            if ($(this).attr('data-id') > 0) {
            @this.add_tag($(this).attr('data-id'));
            } else {
            @this.create_tag($(this).attr('data-name'));
            }
            $('#tag-search').typeahead('val', '');
        } else if (type == 'course-search-form') {
        @this.add_course($(this).attr('data-id'));
            $('#course-search').typeahead('val', '');
        } else if (type == 'presenter-search-form') {
        @this.add_presenter($(this).attr('data-id'), $(this).attr('data-name'));
            $('#presenter-search').typeahead('val', '');
        }
    });
    $(document).on('mouseover', '#addedCourses span', function () {
        $(this).tooltip('show');
    });
    $(document).on('mouseover', '#addedPresenters span', function () {
        $(this).tooltip('show');
    });
    $(document).on('mouseover', '#presenter-search-form .tt-suggestion', function () {
        $(this).tooltip('show');
    });
    $(document).on('mouseover', '#course-search-form .tt-suggestion', function () {
        $(this).tooltip('show');
    });
</script>
