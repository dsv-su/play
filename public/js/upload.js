$(document).ready(function () {
    $('.datepicker').datepicker({
        language: 'sv',
        weekStart: 1,
        todayHighlight: true
    });
    /* Toggle video permissions settings */
    $(document).on('change', '#permission', function () {
        var bool = $("#video_perm").is(":hidden")
        $("#video_perm").toggleClass('hidden')
        $("#video_perm").attr('hidden', !bool)
    });

    var inputFormDiv = document.getElementById('presenter_table');
    var user = inputFormDiv.getElementsByTagName('input').length;
    for (var i = 1; i <= user; i++) {
        /* Restore autocomplete for failed validation */
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

        $("#user-search-text-" + i).typeahead({
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
                return item.uid;
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
        /* end failed validation restore */
    }
    var count = 2;

    $(document).on('click', '.presenteradd', function () {
        var html = '';
        html += '<div class="d-flex justify-content-between" id="user-search">';
        html += '<input class="form-control w-100 mx-auto" type="search" id="user-search-text-' + user + '" name="presenters[]" autocomplete="off" aria-haspopup="true" placeholder="Name or username" aria-labelledby="user-search">';
        html += '<a type="button" name="presenterremove" class="absolute cursor-pointer p-2 top-2 right-2 text-gray-500 presenterremove"><i class="fas fa-user-minus"></i></a>';
        html += '</div>';
        $('#presenter_table').append(html);
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

        $("#user-search-text-" + user).typeahead({
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
                // Disable the input after Enter
                $(this).prop('readonly', true);
            }
        });
        user++;
    });

    $(document).on('click', '.presenteradd .tt-suggestion', function () {
        $(this).closest('.twitter-typeahead').find('input').prop('readonly', true);
    });

    $(document).on('click', '.presenterremove', function () {
        $(this).closest('div').remove();
    });
});
