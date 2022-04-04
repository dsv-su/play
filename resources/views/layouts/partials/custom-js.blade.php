<script>
    $(document).ready(function () {
        $('.preventdefault').on('click', function(e) {
            e.preventDefault();
        });

        // Refresh selectpicker on each update so it re-renders the dropdown
        // Also moves selected to the top
        $("select").on("changed.bs.select",
            function(e, clickedIndex, newValue, oldValue) {
                $(this).find('option:selected').prependTo($(this));
                $(this).selectpicker('refresh');
            });

        $(".datepicker").datepicker({
            format: "dd/mm/yyyy",
            weekStart: 1,
            todayHighlight: true
        });
    });

    function filter_search(subject, value) {
        let url = new URL(location.href);
        let search_params = url.searchParams;
        search_params.set(subject, value);
        url.search = search_params.toString();
        document.location.href = url.toString();
    }
</script>

<script>
    jQuery(document).ready(function ($) {
        // Set the Options for "Bloodhound" suggestion engine
        var engine = new Bloodhound({
            remote: {
                url: '/find?query=%QUERY%',
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.whitespace('query'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });

        $("#header-main-search-text").typeahead({
            classNames: {
                menu: 'search_autocomplete'
            },
            hint: false,
            autoselect: false,
            highlight: true,
            minLength: 1
        }, {
            source: engine.ttAdapter(),
            limit: 15,
            // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
            name: 'autocomplete-items',
            display: function (item) {
                if (item.type === 'course') {
                    return 'Course: ' + item.name + ' (' + item.designation + ')';
                } else if (item.type === 'tag') {
                    console.log(item);
                    return 'Tag: ' + item.name;
                } else if (item.type === 'presenter') {
                    return 'Presenter: ' + item.name;
                } else {
                    return 'Presentation: ' + item.title;
                }
            },
            templates: {
                empty: [
                    ''
                ],
                header: [
                    ''
                ],
                suggestion: function (data) {
                    if (data.type === 'course') {
                        return '<li><a class="d-block w-100" href="/designation/' + data.designation + '">{{ __('Course') }}: ' + data.name + ' (' + data.designation + ')</a></li>';
                    } else if (data.type === 'tag') {
                        return '<li><a class="d-block w-100" href="/tag/' + data.name + '">{{ __('Tag') }}: ' + data.name + '</a></li>';
                    } else if (data.type === 'presenter') {
                        return '<li><a class="d-block w-100" href="/presenter/' + data.username + '">{{ __('Presenter') }}: ' + data.name + '</a></li>';
                    } else {
                        return '<li><a class="d-block w-100" href="/player/' + data.id + '">Video: ' + data.title + '</a></li>';
                    }
                }
            }
        }).on('keyup', function (e) {
            //$(".tt-suggestion:first-child").addClass('tt-cursor');
            let selected = $("#header-main-search-text").attr('aria-activedescendant');
            if (e.which === 13) {
                if (selected) {
                    window.location.href = $("#" + selected).find('a').prop('href');
                } else {
              //      $(".tt-suggestion:first-child").addClass('tt-cursor');
             //       window.location.href = $(".tt-suggestion:first-child").find('a').prop('href');
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#role').on('change', function() {
            document.forms['roleform'].submit();
        });
    });

</script>
