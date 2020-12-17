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
            hint: true,
            autoselect: true,
            highlight: true,
            minLength: 1
        }, {
            source: engine.ttAdapter(),
            limit: 10,
            // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
            name: 'autocomplete-items',
            templates: {
                empty: [
                    ''
                ],
                header: [
                    ''
                ],
                suggestion: function (data) {
                    console.log(data);
                    if (data.type == 'course') {
                        return '<li>Course: ' + data.name + ' (' + data.designation + ')</li>';
                    } else if (data.type == 'tag') {
                        return '<li>Tag: ' + data.name + '</li>';
                    } else {
                        return '<li><a href="/player/' + data.id + '">Video: ' + data.title + '</a></li>';
                    }
                }
            }
        }).on('keyup', function(e) {
            if(e.which == 13) {
                console.log($(".tt-suggestion:first-child", this).find('a'));
                return false;
            }
        });
    });
</script>