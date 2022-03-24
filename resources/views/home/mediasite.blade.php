@extends('layouts.suplay')
@section('content')
    <form action="{{ route('mediasiteCourseDownload') }}" method="POST">
        @csrf
        @method('POST')
        Choose a course folder to download:<br/><br/>
        Course: <select id="course" name="course">
            <option disabled selected value> -- select an option --</option>
            @foreach($mediasitecourses as $folder)
                <option value="{{$folder['id']}}">{{$folder['name']}}</option>
            @endforeach
        </select><br>
        Dates: <input type="text" name="daterange" class="w-50"/><br/>
        Designation: <input type="text" class="col-3" id="designation" name="designation" placeholder="Designation"
                            required>
        <br><input type="checkbox" name="onlyfetch"> Only fetch</input><br>
        <div id="todownload" class="alert alert-info w-50 font-1rem" role="alert" style="display: none;">No presentations to fetch</div>
        <input type="submit" class="btn btn-sm btn-primary" value="Download"/><br/><br/>
    </form>

    <form action="{{ route('mediasiteUserDownload') }}" method="POST">
        @csrf
        Choose a user folder to download:<br/><br/>
        Username: <select id="user" name="user">
            <option disabled selected value> -- select an option --</option>
            @foreach($users as $folder)
                <option value="{{$folder['id']}}">{{$folder['name']}}</option>
            @endforeach
        </select><br/>
        Dates: <input type="text" name="daterange" class="w-50"/><br/>
        <br><input type="checkbox" name="onlyfetch"> Only fetch</input><br>
        <div id="todownload" class="alert alert-info w-50 font-1rem" role="alert" style="display: none;">No presentations to fetch</div>
        <input type="submit" class="btn btn-sm btn-primary" value="Download"/><br/><br/>
    </form>

    <form action="{{ route('mediasiteRecordingDownload') }}" method="POST">
        @csrf
        Choose a separate folder to download:<br/><br/>
        Folder: <select id="recording" name="recording">
            <option disabled selected value> -- select an option --</option>
            @foreach($recordings as $folder)
                <option value="{{$folder['id']}}">{{$folder['name']}}</option>
            @endforeach
        </select><br/>
        Dates: <input type="text" name="daterange" class="w-50"/><br/>
        <br><input type="checkbox" name="onlyfetch"> Only fetch</input><br>
        <div id="todownload" class="alert alert-info w-50 font-1rem" role="alert" style="display: none;">No presentations to fetch</div>
        <input type="submit" class="btn btn-sm btn-primary" value="Download"/><br/><br/>
    </form>

    <form action="{{ route('mediasiteOtherDownload') }}" method="POST">
        @csrf
        Choose other folders to download:<br/><br/>
        Folder: <select id="other" name="other">
            <option disabled selected value> -- select an option --</option>
            @foreach($other as $folder)
                <option value="{{$folder['id']}}">{{$folder['name']}}</option>
            @endforeach
        </select><br/>
        Dates: <input type="text" name="daterange" class="w-50"/><br/>
        <br><input type="checkbox" name="onlyfetch"> Only fetch</input><br>
        <div id="todownload" class="alert alert-info w-50 font-1rem" role="alert" style="display: none;">No presentations to fetch</div>
        <input type="submit" class="btn btn-sm btn-primary" value="Download"/><br/><br/>
    </form>

    <script>
        $('input[name="daterange"]').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY',
                daysOfWeek: [
                    "Mo",
                    "Tu",
                    "We",
                    "Th",
                    "Fr",
                    "Sa",
                    "Su"
                ]
            }
        });
        $('form').on('change', function (e) {
            var todownload = $(this).find('#todownload');
            todownload.show();
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: '{{route('mediasite.prefetchPresentationDownload')}}',
                data: $(this).serialize(),
                success: function (data) {
                    var html = 'Presentations to be downloaded: <br>';
                    $.each(JSON.parse(data.presentations), function (i, p) {
                        html += p.name + ' (id: ' + p.id + ')</br>';
                    });
                    todownload.html(html);
                }
            });
        });
    </script>

@endsection
