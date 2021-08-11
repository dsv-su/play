<script>
    $(document).ajaxStop(function() {
        $('a.delete').on('click', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let formData = new FormData();
            let video_id = $(this).closest('div.video').attr('id');
            formData.append("video_id", video_id);
            $.ajax({
                type: 'POST',
                url: "{{ route('manage.deleteVideo') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: () => {
                    alert('The video has been deleted');
                    $("#" + video_id).closest('.col').hide();
                },
                error: function () {
                    alert('There was an error in deleting the video. Please check the logs for more info.');
                }
            });
        });
    });
    $(document).ready(function () {
        $(document).ready(function () {
            $('.selectpicker').selectpicker();
        });

        $('a.delete').on('click', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let formData = new FormData();
            let video_id = $(this).closest('div.video').attr('id');
            formData.append("video_id", video_id);
            $.ajax({
                type: 'POST',
                url: "{{ route('manage.deleteVideo') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: () => {
                    alert('The video has been deleted');
                    $("#" + video_id).closest('.col').hide();
                },
                error: function () {
                    alert('There was an error in deleting the video. Please check the logs for more info.');
                }
            });
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
                    return 'Video: ' + item.title;
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
