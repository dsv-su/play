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
    <div class="container banner-inner">
        <div class="alert alert-info text-center">
            {{__("Changes are saved upon clicking Update button at the bottom of the page.")}}
        </div>
    </div>

    <div class="container px-3 px-sm-0">
        <div class="row">
            <div class="col-sm-12">
                <div class="rounded border shadow p-3 my-2">
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-md-6 col-lg-4 mx-auto text-center">
                            @if($visability)
                                <img id="presentation" src="{{$thumb}}?{{ rand() }}" style="max-width: 300px;"
                                     class="mx-auto w-100">
                            @endif
                            <div class="d-flex justify-content-center h-100">
                                @if(!$visability)
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

                        <div class="form-group col-md-6 col-lg-8 px-md-3">
                            <div class="row">
                                <label class="col-4 col-lg-3 mb-0">{{__("Title")}}</label>
                                <div class="col">{{$video->title}}</div>
                            </div>
                            <div class="row">
                                <label class="col-4 col-lg-3 mb-0">{{ __("Origin") }}</label>
                                <div class="col">@if($origin == 'mediasite') {{ __("Migrated from Mediasite") }}
                                    @elseif($origin == 'cattura') {{ __("Recorded at DSV") }}
                                    @elseif($origin == 'manual') {{ __("Uploaded by user") }}
                                    @endif
                                </div>
                            </div>
                            <div class="row"><label class="col-4 col-lg-3 mb-0">{{ __("Recording date") }}</label>
                                <div class="col">{{$date}}</div>
                            </div>
                            <div class="row"><label class="col-4 col-lg-3 mb-0">{{ __("Duration") }}</label>
                                <div class="col">{{$duration}}</div>
                            </div>
                            <div class="row"><label class="col-4 col-lg-3 mb-0">{{__("Course")}}
                                </label>
                                <div class="col">@if (empty($course)) {{ __("Not associated to a course") }} @else {{implode(', ', $course)}} @endif</div>
                            </div>
                            <div class="row"><label for="visabilitySwitch"
                                                    class="col-4 col-lg-3 mb-0">{{__("Visibility")}}</label>
                                <div class="col">
                                       <span class="custom-control custom-switch custom-switch-lg">
                                        <input wire:click="visability" class="custom-control-input"
                                               id="visabilitySwitch" name="visability"
                                               type="checkbox" @if($visability == true) checked @endif>
                                        <label class="custom-control-label" style="margin-top: 3px;"
                                               for="visabilitySwitch"></label>
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
                        <div class="form-group col-12 col-md-6 flex-column d-flex"><label
                                    class="form-control-label px-1">{{ __("Title") }}<span class="text-danger"> *</span></label>
                            <input wire:model="title" name="title" id="title" type="text" required class="form-control">
                            <div class="invalid-feedback">
                                {{__('Title is required')}}
                            </div>
                            <div>
                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6 flex-column d-flex"><label
                                    class="form-control-label px-1">{{ __("Recording date") }}<span
                                        class="text-danger"> *</span></label>
                            <input id="creationdate" class="datepicker form-control" wire:model="date" name="date" type="text"
                                   autocomplete="off" data-provide="datepicker" data-date-autoclose="true"
                                   data-date-today-highlight="true" style="max-width: 150px;" required>
                            <div class="invalid-feedback">
                                {{__('Recording date is required')}}
                            </div>
                            <div><small class="text-danger">{{ $errors->first('created') }}</small></div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 col-md-6 flex-column d-flex"><label
                                    class="form-control-label px-1">{{ __("Description") }}</label>
                            <textarea id="description" wire:model="description" name="description"></textarea>
                        </div>
                    </div>

                    <!-- Course -->
                    <div class="row justify-content-between text-left">
                        <div wire:ignore class="form-group col-12 col-md-6 flex-column d-flex">
                            <input type="hidden" name="course" value="{{implode(',',$courseId)}}">
                            <label class="form-control-label px-1">{{ __("Associated course") }}</label>
                        <!--
                            <select wire:model.debounce.500s="courseEdit" name="courseEdit" id="select2">
                                <option value="">@if ($course) {{$course[0]}} @else No course association @endif</option>
                                @foreach($courseselect as $key => $data)
                            <option value="{{ $key }}">{{$key}} - {{ $data[0] }}</option>
                                @endforeach
                                </select>
-->
                            <select wire:model.debounce.100s="courseEdit" name="courseEdit[]"
                                    class="form-control mx-1 selectpicker w-100" data-dropup-auto="false"
                                    data-none-selected-text="{{ __('No course association')}}"
                                    data-live-search="true" multiple>
                                @foreach($courseselect as $key => $data)
                                    <option value={{ $key }}>{{ $data[0] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6 flex-column d-flex">
                            <label class="form-control-label px-1">{{ __("Course manager(s)") }}</label>
                            <div class="mx-1 my-2 font-1rem">
                                @if (empty($course_responsible))
                                    {{__("No course manager added")}}
                                @else
                                    @foreach($course_responsible as $i=>$id) @foreach($id as $k=>$responsible) <span
                                            class="m-1 badge badge-pill badge-light font-1rem">{{$responsible['firstName']}} {{$responsible['lastName']}}</span> @endforeach @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Presenters and Tags -->
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 col-md-6 flex-column d-flex">
                            <label class="form-control-label px-1">{{ __("Presenters") }}
                                <span type="button" wire:click.prevent="newpresenter"
                                      class="btn btn-primary px-1 py-0">{{__('Add')}}<i
                                            class="fas fa-user-plus ml-1"></i></span>
                            </label>
                            @if(count($presenters) > 0)
                                @foreach($presenters as $key => $name)
                                    <div class="d-inline">
                                        <div wire:ignore class="d-flex justify-content-between" id="user-search">
                                            <input @if($key == 0) style="border-color: blue;"
                                                   @endif class="form-control w-100 mx-auto edit"
                                                   id="user-search-text-{{$key}}" type="search"
                                                   wire:model="presenters.{{$key}}" name="presenters[]"
                                                   placeholder="Start typing name or username" aria-haspopup="true"
                                                   autocomplete="off" aria-labelledby="user-search">
                                            <a class="absolute cursor-pointer p-2 top-2 right-2 text-gray-500"
                                               wire:click="remove_presenter({{$key}})">
                                                <i class="fas fa-user-minus"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="mx-1 my-2 font-1rem">{{ __("No registered presenters") }}</div>
                            @endif
                        </div>
                        <div wire:ignore class="form-group col-12 col-md-6 flex-column d-flex">
                            <label class="form-control-label px-1">{{ __("Tags") }}</label>
                            <select name="tags[]"
                                    class="form-control mx-1 selectpicker w-100" data-dropup-auto="false"
                                    data-none-selected-text="{{ __("No tags")}}"
                                    data-live-search="true" multiple>
                                @foreach($tags as $tag)
                                    <option value={{ $tag->id }}>{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Permissions -->
                    <div class="row justify-content-between text-left">
                        <!--Video group permission settings-->
                        <div class="form-group col-12 col-md-6 flex-column d-flex">
                            <label class="form-control-label px-1">{{ __("Playback group permissions") }}</label>
                            <div id="video_perm">
                                <select class="form-group form-control" name="video_permission" style="margin: 5px 0px;"
                                        @if(!$visability) style="background: #dddddd" @endif>
                                    @foreach($permissions as $perm)
                                        <option value="{{$perm->id}}"
                                                @if($presentationpermissonId == $perm->id) selected @endif >{{$perm->id}}
                                            : {{$perm->scope}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Individual permissions -->
                        <div class="form-group col-12 col-md-6 flex-column d-flex">
                            <label class="form-control-label px-1">{{ __("Individual permissions") }}
                                <span type="button" wire:click.prevent="add_individual_perm"
                                      class="btn btn-primary px-1 py-0">{{$ipermissions}} {{ __("Set") }} <i
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
                                                   aria-labelledby="perm-search">
                                            @error('individuals.*') <span class="error">{{ $message }}</span> @enderror

                                            <div class="p-1 col-auto">
                                                <select name="individual_perm_type[]" class="form-control">
                                                    <option value="read"
                                                            @if($individuals_permission[$key] == 'read') selected @endif>
                                                        Read
                                                    </option>
                                                    <option value="edit"
                                                            @if($individuals_permission[$key] == 'edit') selected @endif>
                                                        Edit
                                                    </option>
                                                    <option value="delete"
                                                            @if($individuals_permission[$key] == 'delete') selected @endif>
                                                        Delete
                                                    </option>
                                                </select>
                                            </div>

                                            <a class="absolute cursor-pointer p-2 top-2 right-2 text-gray-500 my-auto"
                                               wire:click="remove_user({{$key}})">
                                                <i class="fas fa-user-minus align-content-center"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="mx-1 my-2 font-1rem">{{ __("No individual permissions added") }}</div>
                            @endif
                        </div>
                        <!-- end Individual permissions -->
                        <!-- Alert warning -->
                        @if(!$visability)
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
                                                        {{ __("Camera") }} @else {{$source->name}} @endif @endif
                                            </div>
                                            <div class="position-relative">
                                                <img class=@if ($hidden[$key]) "opacity-1" @else "opacity-5" @endif
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

            <div class="col-sm-12">
                <button type="submit" id="submit"
                        class="btn btn-outline-primary mx-auto d-flex font-125rem m-3">{{ __("Update") }}</button>
            </div>

        </div>
    </div>
</div>

<script>
    $("#submit").click(function () {
        let errors = 0;
        if ($('#title').val() == '') {
            $('#title').addClass('is-invalid');
            $('#title').removeClass('is-valid');
            errors = 1;
        } else {
            $('#title').removeClass('is-invalid');
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
    });
</script>

<script>
    $(document).ready(function () {
        $('.selectpicker[name="courseEdit[]"]').selectpicker('val', {{$courseids}}.map(String));
    @this.set('courseEdit', {{$courseids}}.map(String));
        $('.selectpicker[name="tags[]"]').selectpicker('val', {{$tagids}}.map(String));

        $(".datepicker").datepicker({
            format: "dd/mm/yyyy",
            weekStart: 1,
            todayHighlight: true
        });

        $('select[name="courseEdit[]"]').on('change', function (e) {
            var item = $(this).val();
        @this.set('courseEdit', item);
        });
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
<!-- Typeahead.js Bundle -->
<script src="{{ asset('./js/typeahead/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(sukat);
    $(document).ready(sukatuser);
    window.addEventListener('contentChanged', event => {
        $(sukat);
    });
    window.addEventListener('permissionChanged', event => {
        $(sukatuser);
    });

    function sukat($) {
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

        $('.edit:first-child').typeahead({
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
            let selected = $("#user-search-text").attr('aria-activedescendant');
            if (e.which == 13) {
                if (selected) {

                } else {
                    $(".tt-suggestion:first-child").addClass('tt-cursor');
                }
            }
        });
        /* end typeahead */
    }

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
            }
        });
        /* end typeahead */
    }
</script>
