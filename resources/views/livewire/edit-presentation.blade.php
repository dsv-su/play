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
    </style>
    <div class="container px-1 py-5 mx-auto">
        <div class="w-7/12 mx-2 rounded  p-2">
            <div class="row">
                <div class="col-sm-10"><h1>{{ __("Edit Presentation") }}</h1></div>
            </div>

            <div class="row">
                <div class="col-sm-8">
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
                                    @if(count($presenters) == 0) <label class="form-control-label px-3">{{ __("No registered presenters") }}</label>
                                </div></div>
                                    @else
                                        <label class="form-control-label px-3">{{ __("Presenter") }}</label>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between text-left">
                                        @foreach($presenters as $key => $name)
                                        <div class="form-group col-sm-6 flex-column d-flex">

                                                <div class="d-inline">
                                                    <div wire:ignore class="d-flex justify-content-between" id="user-search">

                                                        <input class="form-control w-100 mx-auto edit" id="user-search-text-{{$key}}" type="search" wire:model="presenters.{{$key}}" name="presenters[]"  placeholder="Name of presenter" aria-haspopup="true" autocomplete="off" aria-labelledby="user-search">
                                                        <input type="hidden" name="uid[]" value={{$presenters_uid[$key]}}>

                                                    </div>
                                                </div>
                                        </div>
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                                <a class="absolute cursor-pointer  top-2 right-2 text-gray-500" wire:click="remove_presenter({{$key}})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </a>

                                        </div>

                                            @endforeach
                                    </div>
                                    @endif


                            <!-- Add new Presenters -->
                            <div class="row justify-content-between text-left">
                                <div class="form-group col-sm-6 flex-column d-flex"><label class="form-control-label px-3">{{ __("Add presenters") }}</label>
                                    <button type="button" wire:click.prevent="newpresenter" class="btn btn-outline-primary btn-sm presenteradd">{{ __("Presenter") }} <i class="fas fa-user-plus"></i></button>
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
                                    <select  wire:model="courseEdit" name="courseEdit" id="select2">
                                        <option value="">{{$course}}</option>
                                        @foreach($courseselect as $key => $data)
                                            <option value="{{ $key }}">{{$key}} - {{ $data }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div wire:ignore class="form-group col-sm-6 flex-column d-flex">
                                    <label class="form-control-label px-3">{{ __("Playback Permissions") }}</label>

                                    <!--Video permission settings-->
                                    <div id="video_perm">
                                        <select class="form-control" name="video_permission">
                                            @foreach($permissions as $perm)
                                                <option value="{{$perm->id}}" @if($presentationpermissonId == $perm->id) selected @endif >{{$perm->id}}: {{$perm->scope}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                </div>

                <!-- Right column -->
                <div class="col-sm-4">
                    <div class="rounded border shadow p-3 my-2">
                        <div class="flex justify-center">
                            <img src="{{$thumb}}?{{ rand() }}" width="100%">
                        </div>

                        <div class="flex justify-center small">
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
    </div>
    <div class="row">
        @foreach($sources as $key => $source)
        <div class="col-sm-4">
            <div class="rounded border shadow p-3 my-2">
                <div class="flex justify-center" >

                    <small>
                        <div class="custom-control custom-switch custom-switch-sm d-inline">
                            <input type="checkbox" name="audio" id="audioSwitch{{$loop->index + 1}}" value={{$loop->index}} class="custom-control-input"  @if($playAudio[$key] == true) checked @endif >
                            <label class="custom-control-label" for="audioSwitch{{$loop->index + 1}}">Audio &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [Video {{$loop->index + 1}}]</label>
                        </div>
                    </small>


                    <img src="{{$poster[$key]}}?{{ rand() }}" width="100%">
                    {{--}}<input class="form-control form-control-sm" type="file" wire:model="editfile.{{$key}}">{{--}}
                    @error('editfile.*') <span class="error">{{ $message }}</span> @enderror

                </div>
            </div>
        </div>
        @endforeach

    </div>


<div class="container px-1 py-5 mx-auto">
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
    window.addEventListener('contentChanged', event => {
        $(sukat);
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
</script>
