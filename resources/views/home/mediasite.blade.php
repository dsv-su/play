@extends('layouts.suplay')
@section('content')
    <form action="{{ route('mediasiteCourseDownload') }}" method="POST">
        @csrf
        Choose a course folder to download:<br/><br/>
        Course: <select id="course">
            @foreach($mediasitecourses as $folder)
                <option value="{{$folder['id']}}">{{$folder['name']}}</option>
            @endforeach
        </select><br/><br/>
        <input type="submit" class="btn btn-sm btn-primary" value="Download"/><br/><br/>
    </form>

    <form action="{{ route('mediasiteUserDownload') }}" method="POST">
        @csrf
        Choose a user folder to download:<br/><br/>
        Username: <select id="user">
            @foreach($users as $folder)
                <option value="{{$folder['id']}}">{{$folder['name']}}</option>
            @endforeach
        </select><br/><br/>
        <input type="submit" class="btn btn-sm btn-primary" value="Download"/><br/><br/>
    </form>

    <form action="{{ route('mediasiteRecordingDownload') }}" method="POST">
        @csrf
        Choose a separate folder to download:<br/><br/>
        Folder: <select id="recording">
            @foreach($recordings as $folder)
                <option value="{{$folder['id']}}">{{$folder['name']}}</option>
            @endforeach
        </select><br/><br/>
        <input type="submit" class="btn btn-sm btn-primary" value="Download"/><br/><br/>
    </form>

    <form action="{{ route('mediasiteOtherDownload') }}" method="POST">
        @csrf
        Choose other folders to download:<br/><br/>
        Folder: <select id="other">
            @foreach($other as $folder)
                <option value="{{$folder['id']}}">{{$folder['name']}}</option>
            @endforeach
        </select><br/><br/>
        <input type="submit" class="btn btn-sm btn-primary" value="Download"/><br/><br/>
    </form>

    <script>
        $(document).ready(function () {
            $(document).on('change', '#course', function (e) {
                e.preventDefault();
                const id = $(this).children(":selected").val();
                name = $(this).children(":selected").text();
                let html = '<input type="hidden" name="folderid" value=' + id + '>';
                html += '<input type="hidden" name="coursename" value="' + name + '">';
                $('#course').append(html);
            });
            $(document).on('change', '#user', function (e) {
                e.preventDefault();
                const id = $(this).children(":selected").val();
                name = $(this).children(":selected").text();
                let html = '<input type="hidden" name="folderid" value=' + id + '>';
                html += '<input type="hidden" name="username" value="' + name + '">';
                $('#user').append(html);
            });
            $(document).on('change', '#recording', function (e) {
                e.preventDefault();
                const id = $(this).children(":selected").val();
                name = $(this).children(":selected").text();
                let html = '<input type="hidden" name="folderid" value=' + id + '>';
                html += '<input type="hidden" name="foldername" value="' + name + '">';
                $('#recording').append(html);
            });
            $(document).on('change', '#other', function (e) {
                e.preventDefault();
                const id = $(this).children(":selected").val();
                name = $(this).children(":selected").text();
                let html = '<input type="hidden" name="folderid" value=' + id + '>';
                html += '<input type="hidden" name="foldername" value="' + name + '">';
                $('#other').append(html);
            });
        });
    </script>
@endsection
