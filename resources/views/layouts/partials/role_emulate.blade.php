<!-- Role Emulate for Admins - child view - will inherit all data available in the parent view-->
<style>
    .custom-select {
        color: #FFFFFF;
        background-color: #002f5f;
        -webkit-appearance: button;
    }
    #presenter-search-form {

    }

</style>
<form id="roleform" class="form-inline" method="post" action="{{route('emulateUser')}}">
    @csrf
    <label class="my-1 mr-2" for="role">{{app()->make('play_user') ?? 'Not logged in'}}</label>
    <select class="custom-select my-1 mr-sm-2" id="role" name="role">
        <option @if(app()->make('play_role') == 'Administrator') selected @endif value="Administrator">Administrator
        </option>
        <option @if(app()->make('play_role') == 'Courseadmin') selected @endif value="Courseadmin">CourseAdmin</option>
        <option @if(app()->make('play_role') == 'Uploader') selected @endif value="Uploader">Uploader</option>
        <option @if(app()->make('play_role') == 'Staff') selected @endif value="Staff">Staff</option>
        <option @if(app()->make('play_role') == 'Student1') selected @endif value="Student1">Student 1</option>
        <option @if(app()->make('play_role') == 'Student2') selected @endif value="Student2">Student 2</option>
        <option @if(app()->make('play_role') == 'Student3') selected @endif value="Student3">Student 3</option>
        <option @if(app()->make('play_role') == 'custom') selected @endif value="custom">Custom</option>
    </select>
    <div id="customuser" style="display: none;">

        <div class="form-group form-group-sm">
            <div id="presenter-search-form" class="flex-column d-flex">
                <input class="mx-1 w-100" type="search"
                       id="custom-user" name="custom" autocomplete="off"
                       aria-haspopup="true"
                       placeholder="{{ __("Custom user") }}"
                       aria-labelledby="presenter-search">
            </div>
            <div class="flex-column" style="margin-left: 10px !important;">
                <button type="button" onclick="submit()" class="btn btn-sm btn-outline-light">Change</button>
            </div>


        </div>

    </div>
</form>

<script>
    /* Typeahead SUKAT for user emulation */
    // Options for "Bloodhound" suggestion engine
    var engine3 = new Bloodhound({
        remote: {
            url: '/finduser?custom=%QUERY%',
            wildcard: '%QUERY%'
        },
        datumTokenizer: Bloodhound.tokenizers.whitespace('query'),
        queryTokenizer: Bloodhound.tokenizers.whitespace
    });

    $('#custom-user').typeahead({
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
            return item.uid;
        },
        templates: {
            empty: [
                ''
            ],
            header: [
                ''
            ],
            suggestion: function (data) {
                if (!data.uid) {
                    var string = (!data.local ? '{{__('New external')}}: ' : '');
                    return '<a class="badge badge-secondary d-inline-block m-1 cursor-pointer" data-id=0 data-name="' + data.name + '">' + string + data.name + ' <i class="fa-solid fa-plus"></i></a>';

                } else {
                    var label = (data.role == 'DSV' ? '<span class="bagde badge-primary ml-2 px-1" style="border-radius: 4px;">DSV</span>' : (data.role == 'Student' ? '<span class="bagde badge-success mx-1 px-1" style="border-radius: 4px;">Student</span>' : ''));
                    return '<a class="badge badge-secondary d-inline-block m-1 cursor-pointer" data-toggle="tooltip" data-title="SU username: ' + data.uid + '" data-name="' + data.name + '" data-id="' + data.uid + '">' + data.name + label + ' </a>';
                }
            }
        }
    }).on('keyup', function (e) {
        let selected = $("#custom-user").attr('aria-activedescendant');
        if (e.which === 13) {
            if (selected) {
            } else {
                $(".tt-suggestion:first-child").addClass('tt-cursor');
            }
        }
    });
    /* end typeahead */


</script>
