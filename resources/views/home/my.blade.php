@extends('layouts.suplay')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="container align-self-center">
        <form class="form-inline form-main-search d-flex justify-content-between"
              id="header-main-search-form" name="header-main-search-form"
              action="{{ route('search') }}" method="POST" data-search="/s%C3%B6k"
              role="search">
            @csrf
            <label for="header-main-search-text" class="sr-only">Sök på videos</label>
            <input class="form-control w-100 mx-auto" type="search"
                   id="header-main-search-text" name="q" autocomplete="off"
                   aria-haspopup="true"
                   placeholder="Sök på videos"
                   aria-labelledby="header-main-search-form">
        </form>
    </div>

    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <div>
                    <h1 class="word-wrap_xs-only">My videos</h1>
                </div>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>

    <div class="container">
        <div class="form-row">
            <div class="col-12 col-md-6 col-lg-3 mb-1">
                <label for="filter_text">Title:</label>
                <input class="form-control" type="text" name="filter_text" id="filter_text"
                       placeholder="Type your request">
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-1">
                <label for="filter_course">Course:</label>
                <select class="custom-select" name="filter_course" id="filter_course">
                    <option value="0">Choose course</option>
                    @foreach($mycourses as $course)
                        <option value="{{$course->id}}">{{$course->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-1">
                <label for="filter_tag">Tag:</label>
                <select class="custom-select" name="filter_tag" id="filter_tag">
                    <option value="0">Choose tag</option>
                    @foreach($tags as $tag)
                        <option value="{{$tag->id}}">{{$tag->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-1">
                <label for="daterange">Dates:</label>
                <div id="daterange" class="form-control"
                     style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span><i class="fa fa-caret-down ml-1"></i>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col my-1 d-inline-flex">
                <p class="card-text" id="course_list"></p>
                <p class="card-text" id="tag_list"></p>
                <form id="filter">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>

    <div id="mycourses">
        @include('home.videolist', $mycourses)
    </div>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

    <script>
        $(document).ready(function () {
            var start = 1000;
            var end = moment();

            function cb(start, end) {
                if (start < 30000) {
                    $('#daterange span').html('All');
                } else {
                    $('#daterange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
                }
            }

            $('#daterange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'Last 365 Days': [moment().subtract(365, 'days'), moment()],
                    'All': [1000, end]
                }
            }, cb);
            cb(start, end);
            $('#filter').append('<input type=hidden id="datestart" value=' + Math.ceil(start / 1000) + '>');
            $('#filter').append('<input type=hidden id="dateend" value=' + Math.ceil(end / 1000) + '>');
            submit_form();

            $('select#filter_tag').on('change', function () {
                $('#tag_list').append('<span class="badge badge-dark mr-1"><span onclick="remove_tag(this)" data-id=' + $(this).val() + '><i class="fas fa-times mr-1"></i></span>' + $(this).find("option:selected").text() + '</span>');
                $('#filter').append('<input type=hidden id="tag_list[]" value=' + $(this).val() + '>');
                $(this).find("option:selected").hide();
                submit_form();
                $(this).val(0);
            });
            $('select#filter_course').on('change', function () {
                $('#course_list').append('<span class="badge badge-dark mr-1"><span onclick="remove_course(this)" data-id=' + $(this).val() + '><i class="fas fa-times mr-1"></i></span>' + $(this).find("option:selected").text() + '</span>');
                $('#filter').append('<input type=hidden id="course_list[]" value=' + $(this).val() + '>');
                $(this).find("option:selected").hide();
                submit_form();
                $(this).val(0);
            });
            $('input#filter_text').on('change', function (e) {
                $('#filter').children("input[id$='text']").remove();
                if ($(this).val()) {
                    $('#filter').append('<input type=hidden id="text" value="' + $(this).val() + '">');
                }
                submit_form();
            });
            $('#daterange').on('apply.daterangepicker', function (ev, picker) {
                $('#filter').children("input[id$='datestart']").remove();
                $('#filter').children("input[id$='dateend']").remove();
                console.log(Math.ceil(picker.startDate / 1000));
                console.log(Math.ceil(picker.endDate / 1000));
                $('#filter').append('<input type=hidden id="datestart" value=' + Math.ceil(picker.startDate / 1000) + '>');
                $('#filter').append('<input type=hidden id="dateend" value=' + Math.ceil(picker.endDate / 1000) + '>');
                submit_form();
            });
            $('#filter_text').tooltip({'trigger': 'focus', 'title': 'Press Enter or leave the field to apply'});
        });

        function submit_form() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let formData = new FormData();
            $.each($('#filter input'), function () {
                formData.append($(this).attr('id'), $(this).val());
            });
            $.ajax({
                type: 'POST',
                url: "{{ route('my.filter') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $('#mycourses').html(data);
                },
                error: function () {
                    alert('There was an error in filtering.');
                }
            });
            for (let value of formData.values()) {
                console.log(value);
            }
        }

        function remove_tag(item) {
            item.closest('span.badge').remove();
            let id = $(item).attr('data-id');
            $('#filter_tag').children("option[value^=" + id + "]").show();
            $('#filter').children("input[id$='tag_list[]'][value^=" + id + "]").remove();
            submit_form();
        }

        function remove_course(item) {
            item.closest('span.badge').remove();
            let id = $(item).attr('data-id');
            $('#filter_course').children("option[value^=" + id + "]").show();
            $('#filter').children("input[id$='course_list[]'][value^=" + id + "]").remove();
            submit_form();
        }
    </script>

@endsection
