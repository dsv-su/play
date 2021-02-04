@extends('layouts.suplay')
@section('content')
    <div class="container">
        <div class="row">
            <h2>Redigering av presentation: <strong>{{$title}}</strong></h2>
        </div>
        <form method="post" action="{{route('download_store', $id)}}" enctype="multipart/form-data">
            @csrf
            <br>
            <div class="row">
                <div>
                    <!-- Section 1 -->
                    <div class="icon">1</div>
                    <br>
                    <h4 class="title">Redigera titel och datum</h4>
                    <p class="description">
                        Redigera presentationens titel och inspelningsdatum.
                    </p>
                    <div class="form-row">
                        <div class="col">
                            <label for="title">Titel:</label>
                            <input class="form-control form-control-sm" id="title" name="title" type="text" value="{{ old('title') ? old('title'): $title ?? '' }}">
                            <small class="text-danger">{{ $errors->first('title') }}</small>
                        </div>
                        <div class="col-4">
                            <label for="creationdate">Inspelningsdatum</label>
                            <input id="creationdate" class="form-control form-control-sm datepicker" name="created" type="text" value="{{ old('dat') ? old('date'): $date ?? '' }}">
                            <small class="text-danger">{{ $errors->first('created') }}</small>
                        </div>
                    </div>
                    <br>
                    <h4 class="title">Presentatör</h4>
                    <p class="description">
                        Redigera presentationens presentatörer.
                    </p>
                    <div class="col-4">
                    @foreach($presenters as $presenter)
                        <input class="form-control" type="text" name="presenters[]" value="{{$presenter->username}}">
                    @endforeach
                    </div>
                    <p>
                        Lägg till eventuellt ytterligare presentatörer.
                    </p>
                    <div class="col-4">
                        <button type="button" name="presenteradd" class="btn btn-outline-primary btn-sm presenteradd">Presentatör <i class="fas fa-user-plus"></i></button>
                        <table class="table table-sm" id="presenter_table">
                        </table>
                    </div>
                    <br>
                    <!-- Section 2 -->
                    <div class="icon">2</div>
                    <br>
                    <h4 class="title">Kurstillhörighet</h4>
                    <p class="description">
                        Redigera inspelningens association med en eller fler kurser.
                    </p>
                    <div class="col-4">
                        @foreach($courses as $course)
                            <input class="form-control" type="text" name="courses[]" value="{{$course->name}}">
                        @endforeach
                    </div>
                    <div class="col-4">
                        <button type="button" name="courseadd" class="btn btn-outline-primary btn-sm courseadd">Kurs <i class="fas fa-chalkboard"></i></button>
                        <table class="table table-sm" id="course_table">
                        </table>
                    </div>
                    <h4 class="title">Taggar</h4>
                    <p class="description">
                        Redigera inspelningens association med en eller fler taggar.
                    </p>
                    <div class="col-4">
                        @foreach($tags as $tag)
                            <input class="form-control" type="text" name="tags[]" value="{{$tag->name}}">
                        @endforeach
                    </div>
                    <div class="col-4">
                        <button type="button" name="tagadd" class="btn btn-outline-primary btn-sm tagadd">Tagg <i class="fas fa-tags"></i></button>
                        <table class="table table-sm" id="tag_table">
                        </table>
                    </div>

                    <br>
                    <!-- Section 3 -->
                    <div class="icon">3</div>
                    <br>
                    <h4 class="title">Uppspelningsrättigheter</h4>
                    <p class="description">
                        Alla uppladdade presentationer är publika om inte annat specificeras
                    </p>
                    <p>Entitlement:</p>
                    <select name="permission" class="form-control" id="permission">
                        <option value="false" selected>Public</option>
                        <option value="true">Private</option>
                    </select>
                    <div id="entitlement"></div>
                    <br>
                    <!-- Section 4 -->
                    <div class="icon">4</div>
                    <br>
                    <h4 class="title">Använd befintliga mediafiler eller ladda upp nya filer</h4>
                    <p class="description">
                        Upp till 4 mediafiler är möjliga att ladda upp.
                    </p>
                    <button type="button" id="existingMedia" class="btn btn-primary">Använd befintliga mediafiler</button>
                    <button type="button" id="newMedia" class="btn btn-primary">Ladda upp nya mediafiler</button>
                    <div id="new_media" style="display: none;">
                        <div class="col-12">
                            <button type="button" name="mediaadd" class="btn btn-outline-primary btn-sm mediaadd"><i class="fas fa-plus"></i> Lägg till</button>
                            <table class="table table-sm" id="media_table">
                                <tr>
                                    <td>Primärmedia</td>
                                    <td><input type="file" name="filenames[]" class="form-control"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="existing_media" style="display: none;">
                        <div class="col-12">
                            <table class="table table-sm" id="existing_media_table">
                                @foreach($download_files as $existing_file)
                                <tr>
                                    @if($loop->index == 0)
                                    <td>Primärmedia</td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td>{{$existing_file}}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <br>
                </div>

            </div>
            <button id="next" type="submit" class="btn btn-primary btn-lg float-right">Nästa <i class="fas fa-forward"></i></button>
        </form>
    </div>
    <!-- Modal for max upload-->
    <div class="modal fade" id="max" tabindex="-1" role="dialog" aria-labelledby="max" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="max">Maximala tillåtna videos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Maximalt antal tillåtna strömmar för uppladdning har nåtts.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                language:'sv'
            });
            var ent = 0;
            $(document).on('change', '#permission', function(){
                var data = $(this).val();
                if(data == 'true') {
                    var html = '';
                    html += '<input type="text" class="form-control" id="input_entitlement" name="entitlement"  value="urn:mace:swami.se:gmai:dsv-user:staff;urn:mace:swami.se:gmai:dsv-user:student">';
                    $('#entitlement').append(html);
                    ent++;
                }
                else if (data == 'false' && ent==1) {
                    $("#input_entitlement").remove();
                    ent = 0;
                }
            });

            var count = 2;
            $(document).on('click', '.presenteradd', function(){
                var html = '';
                html += '<tr>';
                html += '<td><input type="text" name="presenters[]" class="form-control form-control-sm" placeholder="SU Användarnamn" required></td>';
                html += '<td><button type="button" name="presenterremove" class="btn btn-outline-danger btn-sm presenterremove"><i class="fas fa-user-times"></i><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
                $('#presenter_table').append(html);
            });
            $(document).on('click', '.presenterremove', function(){
                $(this).closest('tr').remove();
            });
            $(document).on('click', '.courseadd', function(){
                var html = '';
                html += '<tr>';
                html += '<td><input type="text" name="courses[]" class="form-control form-control-sm" placeholder="Kursnamn" required></td>';
                html += '<td><button type="button" name="courseremove" class="btn btn-outline-danger btn-sm courseremove"><i class="fas fa-chalkboard"></i></button></td></tr>';
                $('#course_table').append(html);
            });
            $(document).on('click', '.courseremove', function(){
                $(this).closest('tr').remove();
            });
            $(document).on('click', '.tagadd', function(){
                var html = '';
                html += '<tr>';
                html += '<td><input type="text" name="tags[]" class="form-control form-control-sm" placeholder="Tagg" required></td>';
                html += '<td><button type="button" name="tagremove" class="btn btn-outline-danger btn-sm tagremove"><i class="fas fa-tags"></i></button></td></tr>';
                $('#tag_table').append(html);
            });
            $(document).on('click', '.tagremove', function(){
                $(this).closest('tr').remove();
            });
            $(document).on('click', '.mediaadd', function(){
                if (count<5){
                    var html = '';
                    html += '<tr>';
                    html += '<td>Sekundärmedia</td>';
                    html += '<td><input type="file" name="filenames[]" class="form-control form-control-sm"  required></td>';
                    html += '<td><button type="button" name="mediaremove" class="btn btn-outline-danger btn-sm mediaremove"><i class="far fa-file-video"></i></button></td></tr>';
                    count++;
                    $('#media_table').append(html);
                }
                else {
                    $('#max').modal('show');
                }
            });
            $(document).on('click', '#existingMedia', function(){
                var x = document.getElementById("existing_media");
                var y = document.getElementById("new_media");
                if (x.style.display === "block") {
                    x.style.display = "none";
                    $("#next").hide();
                } else {
                    x.style.display = "block";
                    var html ='<input type="hidden" name="media" value="existing_media">';
                    html += '<input type="hidden" name="validate" value="true">';
                    $('#existing_media_table').append(html);
                    $("#next").show();
                }
                if (y.style.display === "block") {
                    y.style.display = "none";
                    var html ='<input type="hidden" name="media" value="existing_media">';
                    html += '<input type="hidden" name="validate" value="true">';
                    $('#media_table').append(html);
                    $("#next").show();
                }
            });
            $(document).on('click', '#newMedia', function(){
                var x = document.getElementById("new_media");
                var y = document.getElementById("existing_media");
                if (x.style.display === "block") {
                    x.style.display = "none";
                    $("#next").hide();
                } else {
                    x.style.display = "block";
                    var html ='<input type="hidden" name="media" value="new_media">';
                    html += '<input type="hidden" name="validate" value="true">';
                    $('#media_table').append(html);
                    $("#next").show();
                }
                if (y.style.display === "block") {
                    y.style.display = "none";
                    var html ='<input type="hidden" name="media" value="new_media">';
                    html += '<input type="hidden" name="validate" value="true">';
                    $('#existing_media_table').append(html);
                    $("#next").show();
                }
            });
            $(document).on('click', '.mediaremove', function(){
                count--;
                $(this).closest('tr').remove();
            });
            $("#next").hide();
        });
    </script>
@endsection
