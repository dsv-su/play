<script>
    /* Nav bar */
    let mainNav = document.getElementById("js-menu");
    let navBarToggle = document.getElementById("js-navbar-toggle");

    navBarToggle.addEventListener("click", function() {
        mainNav.classList.toggle("active");
    });

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
            highlight: true,
            minLength: 1
        }, {
            source: engine.ttAdapter(),
            limit: 4,
            // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
            name: 'autocomplete-items',

            // the key from the array we want to display (name,id,email,etc...)
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

