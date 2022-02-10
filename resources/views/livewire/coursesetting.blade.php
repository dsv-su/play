<div>
    <!-- Header message section -->
    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <span class="su-theme-anchor"></span>
                <h3 class="su-theme-header mb-4">
                    <i class="fas fa-edit fa-icon-border mr-2"></i>{{ __("Course settings") }}
                </h3>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>

    <div class="container banner-inner">
        <div class="alert alert-info text-center">
            {{__("Changes are saved upon clicking Save & Close button at the bottom of the page.")}}
        </div>
    </div>
    <div class="container px-3 px-sm-0">
        <div class="row">
            <div class="col-12">
                <div class="rounded border shadow p-3 my-2 d-flex align-items-center justify-content-center">
                    <div class="form-group form-row m-auto d-none d-md-block">
                        <i class="far fa-file-alt fa-4x"></i>
                    </div>

                    <div class="form-group col col-auto col-md-9 px-sm-3 px-md-0 my-auto">
                        <div class="row">
                            <label class="col-4 col-lg-3 mb-0">{{__("Course id")}}</label>
                            <div class="col"><strong>{{$course->id}}</strong></div>
                        </div>
                        <div class="row">
                            <label class="col-4 col-lg-3 mb-0">{{ __("Course name") }}</label>
                            <div class="col">
                                @if(Lang::locale() == 'swe')
                                    {{$course->name}}
                                @else
                                    {{$course->name_en}}
                                @endif
                            </div>
                        </div>
                        <div class="row"><label class="col-4 col-lg-3 mb-0">{{ __("Designation") }}</label>
                            <div class="col">{{$course->designation}}</div>
                        </div>
                        <div class="row"><label class="col-4 col-lg-3 mb-0">{{ __("Semester") }}</label>
                            <div class="col">{{$course->semester}}</div>
                        </div>
                        <div class="row"><label class="col-4 col-lg-3 mb-0">{{__("Year")}}
                            </label>
                            <div class="col">{{$course->year}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="rounded border shadow p-3 my-2 d-flex align-items-center justify-content-center">
                    <div class="form-group form-row my-auto py-3 mx-3">
                        @if($visibility == true)
                            <i class="far fa-eye fa-3x"></i>
                        @else
                            <i class="far fa-eye-slash fa-3x"></i>
                        @endif
                    </div>
                    <div class="form-group my-auto form-row mx-3">
                        <label for="visibilitySwitch"
                               class="col px-0 col-auto mb-0">{{__("Visibility")}}</label>
                        <div class="col">
                                    <span class="custom-control custom-switch custom-switch-lg" data-toggle="tooltip" title="{{__("Switch the toggle to change")}}">
                                    <input wire:click="visibility" class="custom-control-input"
                                           id="visibilitySwitch" name="visibility"
                                           type="checkbox" @if($visibility == true) checked @endif>
                                    <label class="custom-control-label" style="margin-top: 3px;"
                                           for="visibilitySwitch" ></label>
                                    </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="rounded border shadow p-3 my-2 d-flex align-items-center justify-content-center">
                    <div class="form-group form-row my-auto py-3 mx-3">
                        @if($downloadable == true)
                            <i class="fas fa-download fa-3x"></i>
                        @else
                            <i class="fas fa-times fa-3x"></i>
                        @endif
                    </div>
                    <div class="form-group my-auto form-row mx-3">
                        <label for="downloadSwitch"
                               class="col px-0 col-auto mb-0">{{__("Downloadable")}}</label>
                        <div class="col">
                                       <span class="custom-control custom-switch custom-switch-lg" data-toggle="tooltip" title="{{__("Switch the toggle to change")}}">
                                        <input wire:click="downloadable" class="custom-control-input"
                                               id="downloadSwitch" name="downloadable"
                                               type="checkbox" @if($downloadable == true) checked @endif>
                                        <label class="custom-control-label" style="margin-top: 3px;"
                                               for="downloadSwitch"></label>
                                    </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="rounded border shadow p-3 my-2">
                    <div class="row justify-content-between text-left">
                        <!--Video group permission settings-->
                        <div class="form-group col flex-column d-flex my-1">
                            <label class="form-control-label px-1"><i
                                        class="fas fa-play mr-2"></i>{{ __("Playback group permissions") }}
                            </label>
                            <div id="video_perm">
                                <select class="form-group form-control" name="course_permission" @if(!$visibility) readonly @endif
                                        style="margin: 5px 0px;">
                                    @foreach($permissions as $perm)
                                        @if(Lang::locale() == 'swe')
                                            <option value="{{$perm->id}}"
                                                    @if($permissonId == $perm->id) selected @elseif (!$visibility) disabled @endif >{{$perm->id}}
                                                : {{$perm->scope}}</option>
                                        @else
                                            <option value="{{$perm->id}}"
                                                    @if($permissonId == $perm->id) selected @elseif (!$visibility) disabled @endif >{{$perm->id}}
                                                : {{$perm->scope_en}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="rounded border shadow p-3 my-2">
                    <div class="row justify-content-between text-left">
                        <!-- Individual permissions -->
                        <div class="form-group col flex-column d-flex my-1">
                            <label class="form-control-label px-1"><i
                                        class="fas fa-user mr-2"></i>{{ __("Individual user permissions") }}
                                <span
                                        class="badge badge-light">{{$ipermissions ?? 0}} {{ __("Set") }}</span>
                                <span type="button" wire:click.prevent="add_individual_perm"
                                      class="btn btn-primary px-1 py-0">{{__("Add")}} <i
                                            class="fas fa-user-plus"></i></span>
                            </label>

                            @if (count($individuals)>0)
                                @foreach($individuals as $key => $name)
                                    <div class="d-inline">
                                        <div wire:ignore class="d-flex justify-content-between" id="perm-search">
                                            <input class="form-control mx-auto perm" id="perm-search-text-{{$key}}"
                                                   type="search" wire:model.debounce.100s="individuals.{{$key}}"
                                                   name="individual_permissions[]"
                                                   placeholder="Start typing name or username"
                                                   aria-haspopup="true" autocomplete="off"
                                                   aria-labelledby="perm-search" @if ($name) readonly @endif>
                                            @error('individuals.*') <span
                                                    class="error">{{ $message }}</span> @enderror
                                            <div class="p-1 col-auto">
                                                <select name="individual_perm_type[]" class="form-control">
                                                    <option value="read"
                                                            @if($individuals_permission[$key] == 'read') selected
                                                            @endif
                                                            @if ($user_permission != 'delete' && $individuals_permission[$key] == 'delete') disabled @endif>
                                                        Read
                                                    </option>
                                                    <option value="upload"
                                                            @if($individuals_permission[$key] == 'upload') selected
                                                            @endif
                                                            @if ($user_permission != 'delete' && $individuals_permission[$key] == 'delete') disabled @endif>
                                                        Upload
                                                    </option>
                                                    <option value="edit"
                                                            @if($individuals_permission[$key] == 'edit') selected
                                                            @endif
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
                                <div class="form-group my-1">
                                <div class="mx-1 my-2 font-1rem">{{ __("No individual user permissions added") }}</div>
                                </div>
                            @endif

                        </div>
                        <!-- end Individual permissions -->
                        <!-- -->
                    </div>
                </div>
            </div>

            @if(!$visibility)
                <div class="col">
                    <div class="alert alert-warning mt-3" role="alert">
                    <span class="font-1rem">
                        {{ __("All presentations are hidden and locked for playback. Accessible only by individual users with editing permissions") }}
                    </span>
                    </div>
                </div>
            @endif

            <div class="col-sm-12">
                <button type="submit"
                        class="btn btn-outline-primary mx-auto d-flex font-125rem m-3">{{ __("Save & Close") }}</button>
            </div>

        </div>
    </div>
</div>
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
                // Disable the input after Enter
                $(this).prop('readonly', true);
            }
        });
        /* end typeahead */
        $(document).on('click', '.tt-suggestion', function () {
            $(this).closest('.twitter-typeahead').find('input').prop('readonly', true);
        });
    }
</script>
