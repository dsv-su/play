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

            limit: 7,
            // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
            name: 'autocomplete-items',
            displayKey: 'tags',
            // the key from the array we want to display
            templates: {
                empty: [
                    ''
                ],
                header: [
                    ''
                ],
                suggestion: function (data) {
                    if (data.tags == null) {
                        return '<li><a href="/player/' + data.id + '"> ' + 'Titel: ' + data.title + ', ' + 'Kategori: ' + data.category.category_name + '</a></li>';
                    } else
                        return '<li><a href="/player/' + data.id + '"> ' + data.tags + ', Titel: ' + data.title + ', ' + 'Kategori: ' + data.category.category_name + '</a></li>';
                }
            }
        });
    });
</script>