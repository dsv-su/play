$(document).ready(function() {
    $('.datepicker').datepicker({
        language:'sv',
        weekStart: 1,
        todayHighlight: true
    });
    var ent = 0;
    $(document).on('change', '#permission', function(){
        var data = $(this).val();
        if(data == 'true') {
            var html = '';
            html += '<input type="text" class="form-control" id="input_entitlement" name="entitlement"  value="urn:mace:swami.se:gmai:dsv-user:staff;urn:mace:swami.se:gmai:dsv-user:student">';
            $('#entitlement').append(html);
            ent++;
        }
        else if (data == 'false' && ent==1) {
            $("#input_entitlement").remove();
            ent = 0;
        }
    });

    var count = 2;
    var user = 1;
    $(document).on('click', '.presenteradd', function(){
        var html = '';
        html += '<tr>';
        html += '<td>';
        html += '<div class="d-flex justify-content-between" id="user-search">';
        html += '<label for="user-search-text" class="sr-only">Presentatör</label>';
        html += '<input class="form-control w-100 mx-auto" type="search" id="user-search-text-'+user+'" name="presenters[]"  autocomplete="off" aria-haspopup="true" placeholder="Namn på presentatör" aria-labelledby="user-search">';
        html += '</div>';
        html += '</td>';
        html += '<td><button type="button" name="presenterremove" class="btn btn-outline-danger btn-sm presenterremove"><i class="fas fa-user-times"></i><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
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

        $("#user-search-text-"+user).typeahead({
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
    user++;
        /* end typeahead */
    });
    $(document).on('click', '.presenterremove', function(){
        $(this).closest('tr').remove();
    });
    var course = 1;
    $(document).on('click', '.courseadd', function(){
        var html = '';
        html += '<tr>';
        html += '<td>';
        html += '<div class="d-flex justify-content-between" id="course-search">';
        html += '<label for="course-search-text" class="sr-only">Kurs</label>';
        html += '<input type="text" name="courses[]" id="course-search-text-'+course+'" class="form-control w-100 mx-auto" autocomplete="off" aria-haspopup="true" placeholder="Kursnamn" aria-labelledby="course-search" required>';
        html += '</div>';
        html += '</td>';
        html += '<td><button type="button" name="courseremove" class="btn btn-outline-danger btn-sm courseremove"><i class="fas fa-chalkboard"></i></button></td></tr>';
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

        $("#course-search-text-"+course).typeahead({
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

                    return '<li>' + data.name + ' (' + data.designation + ')' + '</li>';

                }
            }
        }).on('keyup', function (e) {
            $(".tt-suggestion:first-child").addClass('tt-cursor');
            let selected = $("#course-search-text-"+course).attr('aria-activedescendant');
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
    $(document).on('click', '.courseremove', function(){
        $(this).closest('tr').remove();
    });
    $(document).on('click', '.tagadd', function(){
        var html = '';
        html += '<tr>';
        html += '<td><input type="text" name="tags[]" class="form-control form-control-sm" placeholder="Tagg" required></td>';
        html += '<td><button type="button" name="tagremove" class="btn btn-outline-danger btn-sm tagremove"><i class="fas fa-tags"></i></button></td></tr>';
        $('#tag_table').append(html);
    });
    $(document).on('click', '.tagremove', function(){
        $(this).closest('tr').remove();
    });
    $(document).on('click', '.mediaadd', function(){
        if (count<5){
            var html = '';
            html += '<tr>';
            html += '<td>Sekundärmedia</td>';
            html += '<td><input type="file" name="filenames[]" class="form-control form-control-sm"  required></td>';
            html += '<td><button type="button" name="mediaremove" class="btn btn-outline-danger btn-sm mediaremove"><i class="far fa-file-video"></i></button></td></tr>';
            count++;
            $('#media_table').append(html);
        }
        else {
            $('#max').modal('show');
        }
    });
    $(document).on('click', '.mediaremove', function(){
        count--;
        $(this).closest('tr').remove();
    });

});
