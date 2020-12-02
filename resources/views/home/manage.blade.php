<h2>Video management</h2>
<p>Category:
    <!-- Filtering -->
    <select name="filter_category" id="filter_category">
        <option value="0" @if(!app('request')->input('category')) selected @endif
        >Choose category
        </option>
        @foreach($categories as $category)
            <option value="{{$category->id}}"
                    @if(app('request')->input('category') == $category->id) selected @endif>{{$category->category_name}}</option>
        @endforeach
    </select></p>
<p>Course:
    <!-- Filtering -->
    <select name="filter_course" id="filter_course">
        <option value="0" @if(!app('request')->input('course')) selected @endif
        >Choose course
        </option>
        @foreach($courses as $course)
            <option value="{{$course->id}}"
                    @if(app('request')->input('course') == $course->id) selected @endif>{{$course->course}}</option>
        @endforeach
    </select></p>
<div class="container">
    @foreach($videos as $video)
        @if(!app('request')->input('course') || ($video->course_id == app('request')->input('course')))
        <div class="card" id="{{$video->id}}">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <img src="{{$video->image}}" alt="image alt">
            <h5>{{$video->title}} ({{$video->duration}})</h5>
            <p class="card-text" id="category">Category: {{$video->category->category_name}}</p>
            <p class="card-text" id="course">Course: {{$video->course->course}}</p>
            <p class="card-text" id="tags">Tags: {{$video->tags}}</p>
            <p class="card-text">
                <button class="delete" type="submit">Delete</button>
                <button class="edit" type="submit">Edit</button>
            </p>
        </div>
        <!-- The Modal -->
        <div id="modal-{{$video->id}}" class="modal" style="display: none;">
            <!-- Modal content -->
            <div class="modal-content">
                <form>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <span class="close">&times;</span>
                    <h4>{{$video->title}}</h4>
                    <p>Category:
                        <select name="video_category[]" id="video_category" required>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}"
                                        @if ($category->id == $video->category_id) selected @endif>{{$category->category_name}}</option>
                            @endforeach
                        </select></p>
                    <p>Course:
                        <select name="video_course[]" id="video_course" required>
                            @foreach($courses as $course)
                                <option value="{{$course->id}}"
                                        @if ($course->id == $video->course_id) selected @endif>{{$course->course}}</option>
                            @endforeach
                        </select></p>
                    <button class="save" type="submit" id="{{$video->id}}">Save</button>
                </form>
            </div>
        </div>
        @endif
    @endforeach
</div>

<script src="{{asset('./js/jquery-3.5.1.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('button.delete').on('click', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let formData = new FormData();
            let video_id = $(this).closest('div').attr('id');
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
                    $("#" + video_id).hide();
                },
                error: function () {
                    alert('There was an error in deleting the video.');
                }
            });
        });

        $('button.edit').on('click', function () {
            $('#modal-' + $(this).closest('div').attr('id')).show();
        });
        $('span.close').on('click', function () {
            $(this).closest('div.modal').hide();
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
            formData.append('category_id', $(this).closest('form').find('#video_category').val());
            formData.append('course_id', $(this).closest('form').find('#video_course').val());

            $.ajax({
                type: 'POST',
                url: "{{ route('manage.editVideo') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    alert('Changed saved.');
                    $("#" + video_id).find('#course').text(data.course);
                    $("#" + video_id).find('#category').text(data.category);
                    $(this).closest('div.modal').hide();
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
        var search_params = url.searchParams;
        search_params.set(subject, value);
        url.search = search_params.toString();
        let new_url = url.toString();
        document.location.href = new_url;
    }
</script>

<style>
    .container {
        display: flex; /* or inline-flex */
        flex-wrap: wrap;
    }

    .card {
        margin: auto;
        max-width: 200px;
        padding: 25px;
    }

    img {
        width: 100%;
    }

    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0, 0, 0); /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
    }

    /* Modal Content/Box */
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Could be more or less, depending on screen size */
    }

    /* The Close Button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>