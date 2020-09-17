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
        <input type="submit" class="btn btn-sm btn-primary" value="Download"/><br/><br/>
    </form>

    <form action="{{ route('mediasiteUserDownload') }}" method="POST">
    @csrf
        Choose a user folder to download:<br/><br/>
        Username: <select id="user">
            @foreach($users as $folderid => $username)
                <option value="{{$folderid}}">{{$username}}</option>
            @endforeach
        </select><br/><br/>
        <input type="submit" class="btn btn-sm btn-primary" value="Download"/><br/><br/>
    </form>

    <form action="{{ route('mediasiteRecordingDownload') }}" method="POST">
        @csrf
        Choose a separate folder to download:<br/><br/>
        Folder: <select id="recording">
            @foreach($recordings as $folderid => $foldername)
                <option value="{{$folderid}}">{{$foldername}}</option>
            @endforeach
        </select><br/><br/>
        <input type="submit" class="btn btn-sm btn-primary" value="Download"/><br/><br/>
    </form>

    <form action="{{ route('mediasiteOtherDownload') }}" method="POST">
        @csrf
        Choose other folders to download:<br/><br/>
        Folder: <select id="other">
            @foreach($other as $folderid => $foldername)
                <option value="{{$folderid}}">{{$foldername}}</option>
            @endforeach
        </select><br/><br/>
        <input type="submit" class="btn btn-sm btn-primary" value="Download"/><br/><br/>
    </form>

    <script>
        $(document).ready(function () {
            $(document).on('change', '#course', function (e) {
                e.preventDefault();
                id = $(this).children(":selected").val();
                name = $(this).children(":selected").text();
                html = '<input type="hidden" name="folderid" value=' + id + '>';
                html += '<input type="hidden" name="coursename" value="' + name + '">';
                $('#course').append(html);
            });
            $(document).on('change', '#user', function (e) {
                e.preventDefault();
                id = $(this).children(":selected").val();
                name = $(this).children(":selected").text();
                html = '<input type="hidden" name="folderid" value=' + id + '>';
                html += '<input type="hidden" name="username" value="' + name + '">';
                $('#user').append(html);
            });
            $(document).on('change', '#recording', function (e) {
                e.preventDefault();
                id = $(this).children(":selected").val();
                name = $(this).children(":selected").text();
                html = '<input type="hidden" name="folderid" value=' + id + '>';
                html += '<input type="hidden" name="foldername" value="' + name + '">';
                $('#recording').append(html);
            });
            $(document).on('change', '#other', function (e) {
                e.preventDefault();
                id = $(this).children(":selected").val();
                name = $(this).children(":selected").text();
                html = '<input type="hidden" name="folderid" value=' + id + '>';
                html += '<input type="hidden" name="foldername" value="' + name + '">';
                $('#other').append(html);
            });
        });
    </script>
@endsection
