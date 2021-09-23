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
    <div class="container px-1 py-1 mx-auto">
        <div class="w-7/12 mx-2 rounded p-2">
            <div class="row">
                <div class="col-sm-10"><h1>{{ __("Edit Presentation") }}</h1></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="rounded border shadow p-3 my-2">
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-md-6 col-lg-4 mx-auto text-center">
                            <img id="presentation" src="{{$thumb}}?{{ rand() }}" style="max-width: 300px;"
                                 class="mx-auto w-100">
                            <div class="d-flex justify-content-center h-100">
                                <div id="presentation_hidden" class="alert alert-secondary m-auto"
                                     role="alert">{{ __("Presentation hidden") }}</div>
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
                                    @elseif($origin == 'manual') Uploaded by user
                                    @endif
                                </div>
                            </div>
                            <div class="row"><label class="col-4 col-lg-3 mb-0">{{ __("Recording date") }}</label>
                                <div class="col">{{$date}}</div>
                            </div>
                            <div class="row"><label class="col-4 col-lg-3 mb-0">{{ __("Duration") }}</label>
                                <div class="col">{{$duration}}</div>
                            </div>
                            <div class="row"><label class="col-4 col-lg-3 mb-0">{{__('Course')}}
                                </label>
                                <div class="col">@if (empty($course)) {{ __("Not associated to a course") }} @else {{$course}} @endif</div>
                            </div>
                            <div class="row"><label for="visabilitySwitch"
                                                    class="col-4 col-lg-3 mb-0">{{__('Visibility')}}</label>
                                <div class="col">
                                       <span class="custom-control custom-switch custom-switch-lg">
                                        <input class="custom-control-input" id="visabilitySwitch" name="visability"
                                               type="checkbox" @if($video->visability == true) checked @endif>
                                        <label class="custom-control-label" style="margin-top: 3px;"
                                               for="visabilitySwitch"></label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 font-16">
                <div class="rounded border shadow p-3 my-2">
                <!--
                    <label class="blue-text form-control-label px-1">{{ __("Presentation") }}</label>
                    <p>{{ __("Title of the presentation and the date of recording.") }}</p>
                -->
                    <!-- Title and Date-->
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 col-md-6 flex-column d-flex"><label
                                    class="form-control-label px-1">{{ __("Title") }}<span class="text-danger"> *</span></label>
                            <input wire:model="title" name="title" type="text">
                            <div>
                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6 flex-column d-flex"><label
                                    class="form-control-label px-1">{{ __("Recording date") }}<span
                                        class="text-danger"> *</span></label>
                            <input id="creationdate" class="datepicker" wire:model="date" name="date" type="text"
                                   autocomplete="off" data-provide="datepicker" data-date-autoclose="true"
                                   data-date-today-highlight="true">
                            <div><small class="text-danger">{{ $errors->first('created') }}</small></div>
                        </div>
                    </div>

                    <!-- Course and Presenters -->
                    <div class="row justify-content-between text-left">
                        <div wire:ignore class="form-group col-12 col-md-6 flex-column d-flex">
                            <input type="hidden" name="course" value="{{$courseId}}">
                            <label class="form-control-label px-1">{{ __("Associated course") }}</label>
                            <select wire:model.debounce.500s="courseEdit" name="courseEdit" id="select2">
                                <option value="">{{$course}}</option>
                                @foreach($courseselect as $key => $data)
                                    <option value="{{ $key }}">{{$key}} - {{ $data }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div wire:ignore class="form-group col-12 col-md-6 flex-column d-flex">
                            <label class="form-control-label px-1">{{ __("Course manager") }}</label>
                            @foreach($course_responsible as $responsible)
                                <div class="ed">
                                    {{$responsible['firstName']}} {{$responsible['lastName']}}
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group col-12 col-md-6 flex-column d-flex">
                            <label class="form-control-label px-1">{{ __("Presenters") }}
                                <span type="button" wire:click.prevent="newpresenter({{$i}})"
                                      class="badge badge-primary">{{__('Add')}}<i
                                            class="fas fa-user-plus ml-1"></i></span>
                            </label>
                            @if(count($presenters) > 0)
                                @foreach($presenters as $key => $name)
                                    <div class="d-inline">
                                        <div wire:ignore class="d-flex justify-content-between" id="user-search">
                                            <input @if($key == 0) style="border-color: blue;"
                                                   @endif class="form-control w-100 mx-auto edit"
                                                   id="user-search-text-{{$key}}" type="search"
                                                   wire:model.debounce.100s="presenters.{{$key}}" name="presenters[]"
                                                   placeholder="Name of presenter" aria-haspopup="true"
                                                   autocomplete="off" aria-labelledby="user-search">
                                            <a class="absolute cursor-pointer p-2 top-2 right-2 text-gray-500"
                                               wire:click="remove_presenter({{$key}})">
                                                <i class="fas fa-user-minus"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="m-1">{{ __("No registered presenters") }}</div>
                            @endif
                        </div>
                    </div>

                    <!-- Permissions -->
                    <div class="row justify-content-between text-left">
                        <!--Video group permission settings-->
                        <div wire:ignore class="form-group col-12 col-md-6 flex-column d-flex">
                            <label class="form-control-label px-1">{{ __("Playback Group Permissions") }}</label>
                            <div id="video_perm">
                                <select class="form-group form-control" name="video_permission">
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
                            <label class="form-control-label px-1">{{ __("Playback Individual Permissions") }}
                                <span type="button" wire:click.prevent="add_individual_perm"
                                      class="badge badge-primary">{{$ipermissions}} {{ __("Set") }} <i
                                            class="fas fa-user-plus"></i></span></label>
                            @if (count($individuals)>0)
                                @foreach($individuals as $key => $name)
                                    <div class="d-inline">
                                        <div wire:ignore class="d-flex justify-content-between" id="perm-search">

                                            <input class="form-control mx-auto perm" id="perm-search-text-{{$key}}"
                                                   type="search" wire:model.debounce.100s="individuals.{{$key}}"
                                                   name="individual_permissions[]" placeholder="Name of user"
                                                   aria-haspopup="true" autocomplete="off"
                                                   aria-labelledby="perm-search">
                                            @error('individuals.*') <span class="error">{{ $message }}</span> @enderror

                                            <div class="p-2 col-auto">
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

                                            <a class="absolute cursor-pointer p-2 top-2 right-2 text-gray-500"
                                               wire:click="remove_user({{$key}})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="m-1 font-1rem">{{ __("No individual permissions added") }}</div>
                            @endif
                        </div>
                        <!-- end Individual permissions -->
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="row">
                    @foreach($sources as $key => $source)
                        <div class="col-xl-3 col-md-6 my-2">
                            <div class="card border-left-info rounded border shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Stream: {{$loop->index + 1}} ( {{$source->name}} )
                                            </div>
                                            <small>
                                                <div class="custom-control custom-switch custom-switch-sm d-inline">
                                                    <input type="checkbox" name="audio"
                                                           id="audioSwitch{{$loop->index + 1}}"
                                                           value="{{$loop->index}}" class="custom-control-input"
                                                           @if($playAudio[$key] == true) checked @endif >
                                                    <label class="custom-control-label"
                                                           for="audioSwitch{{$loop->index + 1}}">Audio</label>
                                                </div>
                                            </small>


                                            <img src="{{$poster[$key]}}?{{ rand() }}" width="100%">
                                            {{--}}<input class="form-control form-control-sm" type="file" wire:model="editfile.{{$key}}">{{--}}
                                            @error('editfile.*') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-auto">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-sm-12">
                <button type="submit" class="btn btn-outline-primary mx-auto d-flex">{{ __("Update") }}</button>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function () {
            if ($("#visabilitySwitch").is(":checked")) {
                $("#presentation_hidden").hide();
                $("#presentation").show();
            } else {
                $("#presentation").hide();
                $("#presentation_hidden").show();
            }

            $('.datepicker').datepicker({
                language: 'sv',
                weekStart: 1,
                todayHighlight: true
            });

            $('#select2').select2({
                theme: "bootstrap",
                width: "resolve",
            });
            $('#select2').on('change', function (e) {
                var item = $('#select2').select2("val");
            @this.set('courseEdit', item);
            });

        });
    </script>

    <script>
        //VisabilitySwitch for toggling the visability of the presentation
        $("#visabilitySwitch").click(function () {
            $("#presentation_hidden").toggle();
            $("#presentation").toggle("slow");
        });
        // AudioSwitch the selector will match all input controls of type :checkbox
        // and attach a click event handler
        $("input:checkbox").on('click', function () {
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
