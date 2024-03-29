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
            datumTokenizer: Bloodhound.tokenizers.whitespace('query'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '/find?query=%QUERY%',
                wildcard: '%QUERY%'
            }
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
                    return item.name + ' (' + item.designation + ')';
                } else if (item.type === 'tag') {
                    return item.name;
                } else if (item.type === 'category') {
                    return item.category_name;
                } else if (item.type === 'presenter') {
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
                    if (data.type === 'course') {
                        return '<li><a class="d-block w-100" href="/designation/' + data.designation + '">{{ __('Course') }}: ' + data.name + ' (' + data.designation + ')</a></li>';
                    } else if (data.type === 'tag') {
                        return '<li><a class="d-block w-100" href="/tag/' + data.name + '">{{ __('Tag') }}: ' + data.name + '</a></li>';
                    } else if (data.type === 'category') {
                        return '<li><a class="d-block w-100" href="/category/' + data.category_name + '">{{ __('Category') }}: ' + data.category_name + '</a></li>';
                    } else if (data.type === 'presenter') {
                        return '<li><a class="d-block w-100" href="/presenter/' + data.username + '">{{ __('Presenter') }}: ' + data.name + '</a></li>';
                    } else {
                        return '<li><a target="_blank" rel="noopener noreferrer" class="d-block w-100" href="/player/' + data.id + '">Presentation: ' + data.title + '</a></li>';
                    }
                }
            }
        }).on('keyup', function (e) {
            //$(".tt-suggestion:first-child").addClass('tt-cursor');
            let selected = $("#header-main-search-text").attr('aria-activedescendant');
            if (e.which === 13) {
                if (selected) {
                    window.location.href = $("#" + selected).find('a').prop('href');
                    // or open a new window:
                    //window.open($("#" + selected).find('a').prop('href'));
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
        /*
        $('#role').on('change', function() {
            document.forms['roleform'].submit();
        });
        */
        $('#role').on('change', function() {
            if($(this).val()==="custom") {
                $("#customuser").show()
            }
            else {
                document.forms['roleform'].submit();
            }

        });
        $('#videoformat').on('change', function() {
            document.forms['videoformat'].submit();
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("input[type='checkbox'][name='bulkedit']:checked").each(function () {
            handleSelected($(this));
        });

        $("input[type='checkbox'][name='bulkedit']").on('change', function () {
            handleSelected($(this));
        });

        function handleSelected(checkbox) {
            let checked = checkbox.prop('checked');
            let id = checkbox.attr('data-id');
            if (checked) {
                if (!$('#bulkediting').find('input[name="bulkids[]"][value="'+id+'"]').length) {
                    $('#bulkediting').append('<input type="hidden" name="bulkids[]" value=' + id + '>');
                }
            } else {
                $('#bulkediting').find('input[value="' + id + '"]').remove();
            }
            let n = $('#bulkediting').find('input[name="bulkids[]"]').length;
            if (n) {
                $('#bulkediting input[type="submit"]').val("{{__("Edit")}}" + ' ' + n + ' ' + "{{__("selected presentations")}}");
                $('#bulkcontainer').show();
            } else {
                $('#bulkcontainer').hide();
            }
        }
    });
</script>
