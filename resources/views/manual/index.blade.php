@extends('layouts.suplay_upload')
@section('content')
    <div class="container">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                Fel på inmatningen!.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
            <div class="row">
            <h2>Manuell uppladdning - steg 1</h2>
            </div>
            <form method="post" action="{{route('manual_step1')}}" enctype="multipart/form-data">
                @csrf
                <br>
            <div class="row">
                <div>
                    <!-- Section 1 -->
                    <div class="icon">1</div>
                    <br>
                    <h4 class="title">Ange titel och datum</h4>
                    <p class="description">
                        Ange presentationens titel och inspelningsdatum. Om inspelningsdatumet är okänt kan du ange dagens datum.
                    </p>
                    <div class="form-row">
                        <div class="col">
                            <label for="title">Titel:</label>
                            <input class="form-control form-control-sm" id="title" name="title" type="text" value="{{ old('title') ? old('title'): $title ?? '' }}">
                            <small class="text-danger">{{ $errors->first('title') }}</small>
                        </div>
                        <div class="col-4">
                            <label for="creationdate">Inspelningsdatum</label>
                            <input id="creationdate" class="form-control form-control-sm datepicker" name="created" type="text" value="{{ old('created') ? old('created'): $created ?? '' }}">
                            <small class="text-danger">{{ $errors->first('created') }}</small>
                        </div>
                    </div>
                    <br>
                    <h4 class="title">Presentatör</h4>
                    <p><small><strong>{{app()->make('play_user')}} ({{app()->make('presenter')}})</strong></small></p>
                    <input type="hidden" name="presenters[]" value="{{app()->make('presenter')}}">
                    <p>
                        Ange eventuellt ytterligare presentatörer.
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
                        Här anger du om inspelningen ska associeras med en eller fler kurser. Om du inte vill att inspelningen ska associeras med en kurs eller vill komplettera vid ett senare tillfälle lämnar du fältet tomt.
                    </p>
                    <div class="col-4">
                        <button type="button" name="courseadd" class="btn btn-outline-primary btn-sm courseadd">Kurs <i class="fas fa-chalkboard"></i></button>
                        <table class="table table-sm" id="course_table">
                        </table>
                    </div>
                    <h4 class="title">Taggar</h4>
                    <p class="description">
                        Gör även inspelningen sökbar genom att ange taggar.
                    </p>
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
                    <h4 class="title">Ladda upp media</h4>
                    <p class="description">
                        Ladda upp videomedia. Upp till 4 mediafiler är möjliga att ladda upp.
                    </p>
                    <div class="col-12">
                    <button type="button" name="mediaadd" class="btn btn-outline-primary btn-sm mediaadd"><i class="fas fa-plus"></i> Lägg till</button>
                    <table class="table table-sm" id="media_table">
                        <tr>
                            <td>Primärmedia</td>
                            <td><input type="file" name="filenames[]" class="form-control"></td>
                        </tr>
                    </table>
                    </div>
                    <br>
                </div>

            </div>
                <button type="submit" class="btn btn-primary btn-lg float-right">Nästa <i class="fas fa-forward"></i></button>
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
                language:'sv',
                weekStart: 1,
                todayHighlight: true
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
            $(document).on('click', '.mediaremove', function(){
                count--;
                $(this).closest('tr').remove();
            });

        });
    </script>

@endsection

