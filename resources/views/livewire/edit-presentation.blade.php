<div>
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
        .ed {
            padding: 8px 15px;
            border-radius: 5px !important;
            margin: 5px 0px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            font-size: 18px !important;
            font-weight: 300
        }
        .group {
            padding: 8px 15px;
            box-sizing: border-box;
            font-size: 18px !important;
            font-weight: 300
        }
    </style>
    <div class="container px-1 py-5 mx-auto">
        <div class="w-7/12 mx-2 rounded  p-2">
            <div class="row">
                <div class="col-sm-10"><h1>{{ __("Edit Presentation") }}</h1></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="rounded border shadow p-3 my-2">
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-4 flex-column d-flex">
                            <div class="flex justify-center">
                                <img src="{{$thumb}}?{{ rand() }}" width="300px" >
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
                        </div>


                        <div class="form-group col-sm-6 flex-column d-flex">
                            <div class="flex justify-center">
                                <table>
                                    <tr><th>{{ __("Origin") }}:</th><td>@if($origin == 'mediasite') {{ __("Migrated from Mediasite") }}
                                            @elseif($origin == 'cattura') {{ __("Recorded at DSV") }}
                                            @elseif($origin == 'manual') Uploaded by user
                                            @endif
                                        </td></tr>
                                    <tr><th>{{ __("Recording date") }}:</th><td>{{$date}}</td></tr>
                                    <tr><th>{{ __("Duration") }}:</th><td>{{$duration}}</td></tr>
                                    <tr><th>@if(empty($course))
                                                {{ __("Not associated to a course") }}
                                            @else
                                                {{ __("Associated to course") }}:
                                            @endif
                                        </th><td>{{$course}}</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="rounded border shadow p-3 my-2">
                    <label class="blue-text form-control-label px-3">{{ __("Presentation") }}</label>
                    <p>
                        {{ __("Title of the presentation and the date of recording.") }}
                    </p>

                    <!-- Title -->
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">{{ __("Title") }}<span class="text-danger"> *</span></label>
                            <input  wire:model="title"  name="title" type="text">
                            <div>
                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <!-- CreationDate -->
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">{{ __("Original Recording date") }}<span class="text-danger"> *</span></label>
                            <input id="creationdate" class="datepicker" wire:model="date" name="date" type="text" autocomplete="off" data-provide="datepicker" data-date-autoclose="true" data-date-today-highlight="true">
                            <div><small class="text-danger">{{ $errors->first('created') }}</small></div>
                        </div>


                    </div>

                    <!-- Presenters -->
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-6 flex-column d-flex">
                            @if(count($presenters) == 0)
                                <label class="form-control-label px-3">{{ __("No registered presenters") }}</label>
                            @else
                                <label class="form-control-label px-3">{{ __("Presenter") }}</label>
                            @endif
                        </div>
                    </div>
                    @if(count($presenters) == 0)

                    @else
                        <div class="row justify-content-between text-left">
                            @foreach($presenters as $key => $name)
                                <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="d-inline">
                                            <div wire:ignore class="d-flex justify-content-between" id="user-search">
                                               <input @if($key == 0) style="border-color: blue;" @endif class="form-control w-100 mx-auto edit" id="user-search-text-{{$key}}" type="search" wire:model.debounce.100s="presenters.{{$key}}" name="presenters[]"  placeholder="Name of presenter" aria-haspopup="true" autocomplete="off" aria-labelledby="user-search">
                                                <a class="absolute cursor-pointer p-2 top-2 right-2 text-gray-500" wire:click="remove_presenter({{$key}})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </a>
                                            </div>
                                            @if($key == 0)
                                            <div class="d-flex justify-content-between">
                                                <small class="form-text text-muted">{{ __("User with permissions to edit this presentation") }}</small>
                                            </div>
                                            @endif
                                        </div>
                                </div>
                                <div class="form-group col-sm-6 flex-column d-flex"></div>
                                @endforeach
                        </div>
                    @endif

                    <!-- Add new Presenters -->
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label class="form-control-label px-3">{{ __("Add presenters") }}</label>
                            <button type="button" wire:click.prevent="newpresenter({{$i}})" class="btn btn-outline-primary p-2 btn-sm">{{ __("Presenter") }} <i class="fas fa-user-plus"></i></button>
                        </div>

                        <div class="form-group col-sm-6 flex-column d-flex"><label class="form-control-label px-3">{{ __("Category") }}</label>
                            <input  wire:model="category"  name="category" type="text" disabled>
                        </div>
                    </div>

                    <!-- Course -->
                    <div wire:ignore class="row justify-content-between text-left">
                        <input type="hidden" name="course" value="{{$courseId}}">
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label class="form-control-label px-3">{{ __("Associated course") }}</label>
                            <select  wire:model.debounce.100s="courseEdit" name="courseEdit" id="select2">
                                <option value="">{{$course}}</option>
                                @foreach($courseselect as $key => $data)
                                    <option value="{{ $key }}">{{$key}} - {{ $data }}</option>
                                @endforeach
                            </select>
                        </div>


                        <!-- Permissions -->
                        <div wire:ignore class="form-group col-sm-6 flex-column d-flex">
                            <label class="form-control-label px-3">{{ __("Playback Group Permissions") }}</label>

                            <!--Video group permission settings-->
                            <div id="video_perm">
                                <select  class="group form-control" name="video_permission">
                                    @foreach($permissions as $perm)
                                        <option value="{{$perm->id}}" @if($presentationpermissonId == $perm->id) selected @endif >{{$perm->id}}: {{$perm->scope}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label class="form-control-label px-3">{{ __("Course Administrator") }}</label>
                            @foreach($course_responsible as $responsible)
                            <div class="ed">
                                {{$responsible['firstName']}} {{$responsible['lastName']}}
                            </div>
                            @endforeach

                        </div>

                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label class="form-control-label px-3">{{ __("Playback Individual Permissions") }}</label>
                            <!--Video individual permission settings-->
                            <button type="button" wire:click.prevent="add_individual_perm" class="btn btn-outline-primary p-2 btn-sm">{{$ipermissions}} {{ __("Set") }} <i class="fas fa-user-plus"></i></button>
                        </div>
                    </div>
                        <!-- Individual permissions -->
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-6 flex-column d-flex"></div>
                            @foreach($individuals as $key => $name)

                                <div class="form-group col-sm-6 flex-column d-flex">
                                    <div class="d-inline">
                                        <div wire:ignore class="d-flex justify-content-between" id="perm-search">

                                            <input class="form-control mx-auto perm" id="perm-search-text-{{$key}}" type="search" wire:model.debounce.100s="individuals.{{$key}}" name="individual_permissions[]"  placeholder="Name of user" aria-haspopup="true" autocomplete="off" aria-labelledby="perm-search">
                                            @error('individuals.*') <span class="error">{{ $message }}</span> @enderror

                                            <div class="p-2">
                                                <select name="individual_perm_type[]" class="form-control">
                                                    <option value="read" @if($individuals_permission[$key] == 'read') selected @endif>Read</option>
                                                    <option value="edit" @if($individuals_permission[$key] == 'edit') selected @endif>Edit</option>
                                                    <option value="delete"@if($individuals_permission[$key] == 'delete') selected @endif>Delete</option>
                                                </select>
                                            </div>

                                            <a class="absolute cursor-pointer p-2 top-2 right-2 text-gray-500" wire:click="remove_user({{$key}})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 flex-column d-flex"></div>
                            @endforeach
                    </div>
                        <!-- end Individual permissions -->
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($sources as $key => $source)
            <div class=" col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Stream: {{$loop->index + 1}} ( {{$source->name}} )</div>
                                    <small>
                                        <div class="custom-control custom-switch custom-switch-sm d-inline">
                                            <input type="checkbox" name="audio" id="audioSwitch{{$loop->index + 1}}" value="{{$loop->index}}" class="custom-control-input"  @if($playAudio[$key] == true) checked @endif >
                                            <label class="custom-control-label" for="audioSwitch{{$loop->index + 1}}">Audio</label>
                                        </div>
                                    </small>


                                <img src="{{$poster[$key]}}?{{ rand() }}" width="100%" >
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


        <div class="row justify-content-end">
            <div class="form-group col-sm-4"> <button type="submit" class="btn-block btn btn-outline-primary">{{ __("Update") }}</button> </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            language: 'sv',
            weekStart: 1,
            todayHighlight: true
        });

        $('#select2').select2({
            theme: "bootstrap"
        });
        $('#select2').on('change', function (e) {
            var item = $('#select2').select2("val");
        @this.set('courseEdit', item);
        });

    });
</script>
<script>
    // the selector will match all input controls of type :checkbox
    // and attach a click event handler
    $("input:checkbox").on('click', function() {
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
            return item.displayname+' ('+item.uid+')';
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
                return item.displayname+' ('+item.uid+')';
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
