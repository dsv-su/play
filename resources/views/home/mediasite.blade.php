@extends('layouts.suplay')
@section('content')
    <form action="{{ route('mediasiteCourseDownload') }}" method="POST">
        @csrf
        @method('POST')
        Choose a course folder to download:<br/><br/>
        Course: <select id="course" name="course">
            <option disabled selected value> -- select an option -- </option>
            @foreach($mediasitecourses as $folder)
                <option value="{{$folder['id']}}">{{$folder['name']}}</option>
            @endforeach
        </select><br>
        Designation: <input type="text" class="col-3" id="designation" name="designation" placeholder="Designation">
        <br>
        <input type="submit" class="btn btn-sm btn-primary" value="Download"/><br/><br/>
    </form>

    <form action="{{ route('mediasiteUserDownload') }}" method="POST">
        @csrf
        Choose a user folder to download:<br/><br/>
        Username: <select id="user" name="user">
            <option disabled selected value> -- select an option -- </option>
            @foreach($users as $folder)
                <option value="{{$folder['id']}}">{{$folder['name']}}</option>
            @endforeach
        </select><br/><br/>
        <input type="submit" class="btn btn-sm btn-primary" value="Download"/><br/><br/>
    </form>

    <form action="{{ route('mediasiteRecordingDownload') }}" method="POST">
        @csrf
        Choose a separate folder to download:<br/><br/>
        Folder: <select id="recording" name="recording">
            <option disabled selected value> -- select an option -- </option>
            @foreach($recordings as $folder)
                <option value="{{$folder['id']}}">{{$folder['name']}}</option>
            @endforeach
        </select><br/><br/>
        <input type="submit" class="btn btn-sm btn-primary" value="Download"/><br/><br/>
    </form>

    <form action="{{ route('mediasiteOtherDownload') }}" method="POST">
        @csrf
        Choose other folders to download:<br/><br/>
        Folder: <select id="other" name="other">
            <option disabled selected value> -- select an option -- </option>
            @foreach($other as $folder)
                <option value="{{$folder['id']}}">{{$folder['name']}}</option>
            @endforeach
        </select><br/><br/>
        <input type="submit" class="btn btn-sm btn-primary" value="Download"/><br/><br/>
    </form>

@endsection
