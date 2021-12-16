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
        /* end typeahead */
    });

    $(document).on('click', '.tt-suggestion', function () {
        $(this).closest('.twitter-typeahead').find('input').prop('readonly', true);
    });

    $(document).on('click', '.presenterremove', function () {
        $(this).closest('div').remove();
    });
    var course = 1;
    $(document).on('click', '.courseadd', function () {
        var html = '';
        html += '<tr>';
        html += '<td>';
        html += '<div class="d-flex justify-content-between" id="course-search">';
        html += '<label for="course-search-text" class="sr-only">Kurs</label>';
        html += '<input type="text" name="courses[]" id="course-search-text-' + course + '" class="form-control w-100 mx-auto" autocomplete="off" aria-haspopup="true" placeholder="Kursnamn" aria-labelledby="course-search" required>';
        html += '</div>';
        html += '</td>';
        html += '<td><button type="button" name="courseremove" class="btn btn-outline-danger btn-sm courseremove">X</button></td></tr>';
        $('#course_table').append(html);
        /* */
        /* Typeahead course name */
        // Set the Options for "Bloodhound" suggestion engine
        var engine = new Bloodhound({
            remote: {
                url: '/course_search?course=%QUERY%',
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.whitespace('query'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });

        $("#course-search-text-" + course).typeahead({
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
                return item.designation;
            },
            templates: {
                empty: [
                    '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                ],
                header: [
                    '<div class="list-group search-results-dropdown">'
                ],
                suggestion: function (data) {

                    return '<li>' + data.name + ' (' + data.designation + ' ' + data.semester + data.year + ')' + '</li>';

                }
            }
        }).on('keyup', function (e) {
            $(".tt-suggestion:first-child").addClass('tt-cursor');
            let selected = $("#course-search-text-" + course).attr('aria-activedescendant');
            if (e.which == 13) {
                if (selected) {

                } else {
                    $(".tt-suggestion:first-child").addClass('tt-cursor');
                }
            }
        });
        course++;
        /* end typeahead */
        /* */
    });
    $(document).on('click', '.courseremove', function () {
        $(this).closest('tr').remove();
    });
    var tag = 1;
    $(document).on('click', '.tagadd', function () {
        var html = '';
        html += '<tr>';
        html += '<td>';
        html += '<div class="d-flex justify-content-between" id="course-search">';
        html += '<input type="text" name="tags[]" id="tag-search-text-' + tag + '" class="form-control w-100 mx-auto" autocomplete="off" aria-haspopup="true" placeholder="Tags" aria-labelledby="tag-search" required></td>';
        html += '</div>';
        html += '</td>';
        html += '<td>';
        html += '<button type="button" name="tagremove" class="btn btn-outline-danger btn-sm tagremove">X</button></td></tr>';
        $('#tag_table').append(html);
        /* Typeahead tags */
        // Set the Options for "Bloodhound" suggestion engine
        var engine = new Bloodhound({
            remote: {
                url: '/tag_search?tag=%QUERY%',
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.whitespace('query'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });

        $("#tag-search-text-" + tag).typeahead({
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
                return item.name;
            },
            templates: {
                empty: [
                    '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                ],
                header: [
                    '<div class="list-group search-results-dropdown">'
                ],
                suggestion: function (data) {

                    return '<li>' + data.name + '</li>';

                }
            }
        }).on('keyup', function (e) {
            $(".tt-suggestion:first-child").addClass('tt-cursor');
            let selected = $("#tag-search-text-" + tag).attr('aria-activedescendant');
            if (e.which == 13) {
                if (selected) {

                } else {
                    $(".tt-suggestion:first-child").addClass('tt-cursor');
                }
            }
        });
        tag++;
        /* end typeahead */
    });
    $(document).on('click', '.tagremove', function () {
        $(this).closest('tr').remove();
    });
    $(document).on('click', '.mediaadd', function () {
        if (count < 5) {
            var html = '';
            html += '<div class="text-center">';
            html += '<img src="/images/dsvplay.png" class="img-thumbnail" alt="thumb">';
            html += '<input type="file" class="text-center center-block file-upload" name="filenames[]">';
            html += '<button type="button" name="mediaremove" class="btn btn-outline-danger btn-sm mediaremove"><i class="far fa-file-video"></i></button>';
            html += '</div>';


            count++;
            $('#media').append(html);
        } else {
            $('#max').modal('show');
        }
    });
    $(document).on('click', '.mediaremove', function () {
        count--;
        $(this).closest('.text-center').remove();
    });
});
