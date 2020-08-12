<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('./images/favicon.ico') }}">
    <title>Document</title>
</head>
<body>

<form action="{{ route('search') }}" method="POST">
    @csrf
    <input type="text" name="query" />
    <input type="submit" class="btn btn-sm btn-primary" value="Search" />
</form>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">

                        <table class="table">
                            <thead>
                            <tr>
                                <th>Video</th>
                                <th>Category</th>
                                <th>Course</th>
                                <th>Added on</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($videos as $video)
                                <tr>
                                    <td>{{ $video->title }}</td>
                                    <td>{{ $video->category->category_name }}</td>
                                    <td>{{ $video->course->course_name }}</td>
                                    <td>{{ $video->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

