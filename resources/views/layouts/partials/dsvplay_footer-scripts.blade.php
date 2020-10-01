<script>
    function changeOutput(){
        filter = document.getElementById('filtrera');
        filter.classList.toggle('filtrera');
    }

</script>
<!-- Navbar -->
<script src="{{ asset('./js/jquery-resizer.js') }}"></script>
<script>
    Play.initialize();
</script>

<script>
    /* New Search */
    $('.search-input').focus(function(){
        $(this).parent().addClass('focus');
    }).blur(function(){
        $(this).parent().removeClass('focus');
    })

</script>
<!-- Typeahead.js Bundle -->
<script src="{{ asset('./js/typeahead/typeahead.bundle.js') }}"></script>
<script>
    jQuery(document).ready(function($) {
        //Radio button toggle
        $(".filter").click(function(event) {
            var radio_selector = 'input[type="radio"]',
                $radio;

            if (!$(event.target).is(radio_selector)) {
                $radio = $(this).find(radio_selector);

                event.stopImmediatePropagation();

                event.preventDefault();
                $radio.prop('checked', !$radio.is(':checked'));
            }
        });
        $(".filter-radio").on('change click', function(event) {

            this.checked = !this.checked;
        })

        // Set the Options for "Bloodhound" suggestion engine
        var engine = new Bloodhound({
            remote: {
                url: '/find?query=%QUERY%',
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.whitespace('query'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });

        $(".search-input").typeahead({
            classNames: {
             menu: 'automenu',
             dataset: 'autoc'
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
                    '<div>Inget hittat.</div>'
                ],
                header: [
                    ''
                ],
                suggestion: function (data) {
                    if(data.tags == null){
                        return '<div><a href="/player/' + data.id  +'"> '+ '<small>Titel:</small> ' + data.title + ',<small> ' + 'Kategori:</small> ' + data.category.category_name + '</a></div>';
                    }
                    else
                    return '<div><a href="/player/' + data.id  +'"> '+ data.tags + ', <small>Titel:</small> ' + data.title + ',<small> ' + 'Kategori:</small> ' + data.category.category_name + '</a></div>';
                }
            }
        });
    });
</script>


