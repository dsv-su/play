<!-- Typeahead.js Bundle -->
<script src="{{ asset('./js/typeahead/typeahead.bundle.js') }}"></script>
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
            autoselect: true,
            highlight: true,
            minLength: 1
        }, {
            source: engine.ttAdapter(),
            limit: 10,
            // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
            name: 'autocomplete-items',
            display: function (item) {
                if (item.type == 'course' || item.type == 'tag') {
                    return item.name;
                } else {
                    return item.title;
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
                    if (data.type == 'course') {
                        return '<li><a href="/course/' + data.id + '">Course: ' + data.name + ' (' + data.designation + ')</a></li>';
                    } else if (data.type == 'tag') {
                        return '<li><a href="/tag/' + data.id + '">Tag: ' + data.name + '</a></li>';
                    } else {
                        return '<li><a href="/player/' + data.id + '">Video: ' + data.title + '</a></li>';
                    }
                }
            }
        }).on('keyup', function (e) {
            //$(".tt-suggestion:first-child").addClass('tt-cursor');
            let selected = $("#header-main-search-text").attr('aria-activedescendant');
            if (e.which == 13) {
                if (selected) {
                    window.location.href = $("#" + selected).find('a').prop('href');
                } else {
                    $(".tt-suggestion:first-child").addClass('tt-cursor');
                    window.location.href = $(".tt-suggestion:first-child").find('a').prop('href');
                }
            }
        });
    });
</script>