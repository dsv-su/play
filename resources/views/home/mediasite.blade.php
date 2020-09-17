@extends('layouts.dsvplay')
@section('content')
    <form action="{{ route('mediasiteCourseDownload') }}" method="POST">
    @csrf
        Choose a course folder to download:<br/><br/>
        Course: <select id="course">
            @foreach($courses as $folderid => $coursename)
                <option value="{{$folderid}}">{{$coursename}}</option>
            @endforeach
        </select><br/><br/>
        <input type="submit" class="btn btn-sm btn-primary" value="Download"/>
    </form>

    <form action="{{ route('mediasiteUserDownload') }}" method="POST">
    @csrf
        Choose a user folder to download:<br/><br/>
        Username: <select id="user">
            @foreach($users as $folderid => $username)
                <option value="{{$folderid}}">{{$username}}</option>
            @endforeach
        </select><br/><br/>
        <input type="submit" class="btn btn-sm btn-primary" value="Download"/>
    </form>

    <script>
        $(document).ready(function () {
            $(document).on('change', '#course', function (e) {
                e.preventDefault();
                id = $(this).children(":selected").val();
                name = $(this).children(":selected").text();
                console.log(name);
                html = '<input type="hidden" name="folderid" value=' + id + '>';
                html += '<input type="hidden" name="coursename" value="' + name + '">';
                $('#course').append(html);
            });
            $(document).on('change', '#user', function (e) {
                e.preventDefault();
                id = $(this).children(":selected").val();
                name = $(this).children(":selected").text();
                console.log(name);
                html = '<input type="hidden" name="folderid" value=' + id + '>';
                html += '<input type="hidden" name="username" value="' + name + '">';
                $('#user').append(html);
            });
        });
    </script>
@endsection
