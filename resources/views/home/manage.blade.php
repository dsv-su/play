@section('content')

    <h2>Video management</h2>
    <div class="container">
        @foreach($videos as $video)
            <div class="card" id="{{$video->id}}">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <img src="{{$video->image}}" alt="image alt">
                <h5>{{$video->title}} ({{$video->length}})</h5>
                <p class="card-text">Category: {{$video->category->category_name}}</p>
                <p class="card-text">Course: {{$video->course->course_name}}</p>
                <p class="card-text">Tags: {{$video->tags}}</p>
                <p class="card-text">
                    <button class="delete" type="submit">Delete</button>
                    <button class="edit" type="submit">Edit</button>
                </p>
            </div>
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
                let video_id = this.closest('div').id;
                formData.append("video_id", video_id);
                for (let key of formData.entries()) {
                    // Debug output
                    console.log(key[0] + ': ' + key[1]);
                }
                $.ajax({
                    type: 'POST',
                    url: "{{ route('manage.deleteVideo') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        alert('File has been uploaded successfully');
                        $("#" + video_id).hide();
                    },
                    error: function (data) {
                        alert('There was an error in uploading the file.');
                        $("#" + video_id).hide();
                    }
                });
            });
        });
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
    </style>