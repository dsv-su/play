<script>
    $(document).ready(function () {
        $(document).ready(function () {
            $('.selectpicker').selectpicker();
        });

        $('button.delete').on('click', function (e) {
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

        $('button.save').on('click', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let formData = new FormData();
            let video_id = $(this).attr('id');
            formData.append("video_id", video_id);
            formData.append('category_id', $(this).closest('form').find('#video_category_'+video_id).val());
            formData.append('course_ids', JSON.stringify($(this).closest('form').find('#video_course_'+video_id).val()));
            formData.append('tag_ids', JSON.stringify($(this).closest('form').find('#video_tag_'+video_id).val()));

            $.ajax({
                type: 'POST',
                url: "{{ route('manage.editVideo') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    alert(data.message);
                    $("#" + video_id).find('#courses').html(data.courses);
                    $("#" + video_id).find('#tags').html(data.tags);
                    $("#" + video_id).find('#category').html(data.category);
                    $(this).closest('div.modal').modal('hide');
                },
                error: function () {
                    alert('There was an error in editing the video.');
                }
            });
        });
        $("#filter_category").change(function () {
            filter_search('category', this.value)
        });
        $("#filter_course").change(function () {
            filter_search('course', this.value);
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
            autoselect: true,
            highlight: true,
            minLength: 1
        }, {
            source: engine.ttAdapter(),
            limit: 10,
            // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
            name: 'autocomplete-items',
            display: function (item) {
                if (item.type == 'course' || item.type == 'tag' || item.type == 'presenter') {
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
                        return '<li><a href="/course/' + data.id + '">Course: ' + data.name + ' (' + data.designation + ') ' + data.semester + data.year + '</a></li>';
                    } else if (data.type == 'tag') {
                        return '<li><a href="/tag/' + data.id + '">Tag: ' + data.name + '</a></li>';
                    } else if (data.type == 'presenter') {
                        return '<li><a href="/presenter/' + data.id + '">Presenter: ' + data.name + '</a></li>';
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
<script>
    $(document).ready(function() {
        $('#role').on('change', function() {
            document.forms['roleform'].submit();
        });
    });

</script>
