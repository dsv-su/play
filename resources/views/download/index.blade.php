@extends('layouts.suplay_upload')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-11 col-sm-9 col-md-7 col-lg-6 col-xl-7 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
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
                @if(session('error'))
                        <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <h2 id="heading_download"><span class="far fa-edit fa-icon-border mr-2" aria-hidden="true"></span>Redigera presentation</h2>
                <p>Redigering av en befintlig presentation</p>
                    <!-- progressbar -->
                    <ul id="progressbar">
                        <li class="active" id="account"><strong>1. Presentationen</strong></li>
                        <li id="personal"><strong>2. Kursassociation</strong></li>
                        <li id="payment"><strong>3. Mediafiler</strong></li>
                        <li id="confirm"><strong>4. Miniatyr och Affischer</strong></li>
                    </ul>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <br>
                    @if(!$final == 1)
                   <form id="msform" method="post" action="{{route('download_store', $id)}}" enctype="multipart/form-data">
                        @csrf
                    <!-- fieldsets -->
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">1.) Information om presentationen:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps"><span class="blue-text">Steg 1</span>(4)</h2>
                                </div>
                            </div>
                            <p class="description">
                                Presentationens titel och inspelningsdatum. Om inspelningsdatumet är okänt kan du ange dagens datum.
                            </p>
                            <label class="fieldlabels">Ange titel: </label>
                            <input class="form-control form-control-sm" id="title" name="title" type="text" value="{{ old('title') ? old('title'): $title ?? '' }}">
                            <small class="text-danger">{{ $errors->first('title') }}</small>

                            <label class="fieldlabels">Inspelningsdatum: </label>
                            <input id="creationdate" class="form-control form-control-sm datepicker" name="created" type="text" value="{{ old('creationdate') ? old('creationdate'): $creationdate ?? '' }}">
                            <small class="text-danger">{{ $errors->first('created') }}</small>

                            <label class="fieldlabels">Presentatör: </label>
                            @if($owners)
                                @foreach($owners as $presenter)
                                    <input class="form-control form-control-sm"  name="presenter[]" type="text" value="{{ old('presenter') ? old('presenter'): $presenter->username ?? '' }}">
                                @endforeach
                            @else
                                Inga presentatör(er) <br>
                            @endif
                            <label class="fieldlabels">Ange eventuellt ytterligare presentatörer.</label>
                            <button type="button" name="presenteradd" class="btn btn-outline-primary btn-sm presenteradd">Presentatör <i class="fas fa-user-plus"></i></button>
                            <table class="table table-sm" id="presenter_table">
                            </table>

                        </div>
                        <input type="button" name="next" class="next btn action-button" value="Nästa" />
                    </fieldset>

                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Kursassociation:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps"><span class="blue-text">Steg 2</span>(4)</h2>
                                </div>
                            </div>
                            <p class="description">
                                Här anger du om inspelningen ska associeras med en eller fler kurser. Om du inte vill att inspelningen ska associeras med en kurs eller vill komplettera vid ett senare tillfälle lämnar du fältet tomt.
                            </p>
                            <label class="fieldlabels">Kursassociation: </label>
                            <br>
                            <button type="button" name="courseadd" class="btn btn-outline-primary btn-sm courseadd">Kurs <i class="fas fa-chalkboard"></i></button>
                            <table class="table table-sm" id="course_table">
                                @if($coursebindings)
                                    @foreach($coursebindings as $course)
                                        <input type="text" name="courses[]" class="form-control w-100 mx-auto" placeholder="Kursnamn" value="{{ old('course') ? old('course'): $course->designation ?? '' }}">
                                    @endforeach
                                @endif

                            </table>
                            <p class="description">
                                Gör även inspelningen sökbar genom att ange taggar.
                            </p>
                            <label class="fieldlabels">Taggar: </label>
                            <br>
                            <button type="button" name="tagadd" class="btn btn-outline-primary btn-sm tagadd">Tagg <i class="fas fa-tags"></i></button>
                            <table class="table table-sm" id="tag_table">
                            </table>
                            <p class="description">
                                Alla uppladdade presentationer är publika om inte annat specificeras
                            </p>
                            <label class="fieldlabels">Uppspelningsrättigheter</label>
                            <select name="permission" class="form-control" id="permission">
                                <option value="false" selected>Public</option>
                                <option value="true">Private</option>
                            </select>
                            <!--Video permission settings-->
                            <div id="video_perm" hidden>
                                <select class="form-control" name="video_permission">
                                    @foreach($permissions as $permission)
                                    <option value="{{$permission->id}}">{{$permission->id}}: {{$permission->scope}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <input type="button" name="next" class="next action-button" value="Nästa" /> <input type="button" name="previous" class="previous action-button-previous" value="Föregående" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Ladda upp media:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps"><span class="blue-text">Steg 3</span>(4)</h2>
                                </div>
                            </div>
                            <p class="description">
                                Ladda upp videomedia. Upp till 4 mediafiler är möjliga att ladda upp.
                            </p>
                            <div id="new_media" style="display: block;">
                                <label class="fieldlabels">Ladda upp filer:</label>
                                <button type="button" name="mediaadd" class="btn btn-outline-primary btn-sm mediaadd"><i class="fas fa-plus"></i> Lägg till</button>
                                <table class="table table-sm" id="media_table">
                                    <tr>
                                        <td>Primärmedia</td>
                                        <td><input id="primaryfile" type="file" name="filenames[]" class="form-control" required></td>
                                        <input type="hidden" name="media" value="new_media">
                                        <input type="hidden" name="validate" value="true">
                                    </tr>
                                </table>
                            </div>


                        </div>
                        <input id="upload" type="submit" name="next" class="next action-button" value="Nästa" disabled>
                        <input type="button" name="previous" class="previous action-button-previous" value="Föregående" />
                        <input type="button" id="existingMedia" name="existing" class="existing action-button-existing" value="Använd befintliga mediafiler" />
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
                    </fieldset>
                   </form>
                    @endif

                    <fieldset id="thumbfs">
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Thumb och Posters</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps"><span class="blue-text">Steg 4</span>(4)</h2>
                                </div>
                            </div>
                            <p class="description">
                                En miniatyr (thumb) har genererats för visning av presentationen på webbsidan.
                            </p>
                            <label class="fieldlabels">Thumb:</label>
                            <div class="card mb-3" style="max-width: 640px;">
                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        @if($thumb == null)
                                            <svg class="bd-placeholder-img" width="100%" height="250" xmlns="http://www.w3.org/2000/svg" aria-label="Placeholder: Image" preserveAspectRatio="xMidYMid slice" role="img"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"/><text x="50%" y="50%" fill="#dee2e6" dy=".3em">Ingen bild</text></svg>
                                        @else
                                            <img id="thumb" class="bd-placeholder-img" width="100%" height="250" src="{{asset($local.'/'.$thumb)}}">
                                        @endif

                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">Titel: {{$title}}</h5>
                                            <form method="post" action="{{route('gen_thumb_download', $id)}}">
                                                @csrf
                                                <p class="card-text">Längd på primärvideo: {{ $durationInSeconds }} sek.</p>
                                                <p class="card-text"><small class="text-muted">Antalet sekunder in i videon:</small></p>
                                                <input type="number" name="seconds"  min="1" max="{{$durationInSeconds}}">
                                                @if($thumb == null)
                                                    <button type="submit" class="btn btn-primary btn-sm">Generera</button>
                                                @else
                                                    <button type="submit" class="btn btn-primary btn-sm">Regenerera</button>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($thumb != null)
                                <div class="row">
                                    <div>
                                        <h4 class="title">Generera en affisch (poster) för varje video</h4>
                                        <p class="description">
                                            En affisch har skapats för varje uppladdad video. Affischen används av spelaren.
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach($sources as $source)
                                        <div class="card" style="width: 18rem;">
                                            @if($thumb == null)
                                                <svg class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" role="img"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"/><text x="50%" y="50%" fill="#dee2e6" dy=".3em">Ingen bild</text></svg>
                                            @else
                                                <img class="bd-placeholder-img" width="100%" height="180" src="{{'/storage/'.$local.'/poster/poster_'.($loop->index+1).'.png'}}">
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title">Poster {{($loop->index+1)}}</h5>
                                                <form method="post" action="{{route('gen_poster_download', $id)}}">
                                                    @csrf
                                                    <p class="card-text">Längd på primärvideo: {{ $durationInSeconds }} sek.</p>
                                                    <p class="card-text"><small class="text-muted">Antalet sekunder in i videon:</small></p>
                                                    <input type="number" name="seconds"  min="1" max="{{$durationInSeconds}}">
                                                    <input type="hidden" name="poster"  value="{{($loop->index+1)}}">
                                                    <button type="submit"  class="btn btn-primary btn-sm">Regenerera</button>
                                                </form>
                                            </div>
                                        </div>

                                    @endforeach
                                </div>
                                <br>

                                <a id="upload_server" href="{{route('download_step4', $id)}}" role="button" class="btn btn-primary btn-lg float-right">Ladda upp <i class="fas fa-forward"></i></a>
                            @endif

                            <div class="row justify-content-center">
                                <div class="col-7 text-center">
                                    <h5 class="blue-text text-center">Din presentation är klar för uppladdning</h5>
                                </div>
                            </div>
                        </div>
                    </fieldset>


            </div>
        </div>
    </div>
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
<!-- Modal spinners -->
<div class="modal fade" id="load" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="loader"></div>
                <div class="loader-txt">
                    <p>Bearbetning pågår <br><br><small>Mediafilerna kontrolleras</small></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="loadtoserver" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="loader"></div>
                <div class="loader-txt">
                    <p>Uppladdning pågår <br><br><small>Lagrar på play-store</small></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- js -->
<script src="{{ asset('./js/upload.js') }}"></script>
<!-- Typeahead.js Bundle -->
<script src="{{ asset('./js/typeahead/typeahead.bundle.js') }}"></script>
    <script>
    $(document).ready(function() {

        /* Fieldsets */
        var upload = '<?php echo $final; ?>';
        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;
        var current = 1;
        var steps = $("fieldset").length;
        if(upload == 1) {
            $("#load").modal("hide");
            next_fs = $(this).parent().next();
            $("#thumbfs").show();
            //Add Class Active to the previous steps
            $("#progressbar li").eq($("fieldset").index(next_fs)-1).addClass("active");
            $("#progressbar li").eq($("fieldset").index(next_fs)-2).addClass("active");
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        }

        setProgressBar(current);

        $(".next").click(function(){

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                    // for making fieldset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({'opacity': opacity});
                },
                duration: 500
            });
            setProgressBar(++current);
        });

        $(".previous").click(function(){

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({'opacity': opacity});
                },
                duration: 500
            });
            setProgressBar(--current);
        });

        function setProgressBar(curStep){
            var percent = parseFloat(100 / steps) * curStep;
            percent = percent.toFixed();
            $(".progress-bar")
                .css("width",percent+"%")
        }
        //
        $("#upload").click(function(){
            $("#load").modal({
                backdrop: "static", //remove ability to close modal with click
                keyboard: false, //remove option to close with keyboard
                show: true //Display loader!
            });
        });
        $("#upload_server").click(function(){
            $("#loadtoserver").modal({
                backdrop: "static", //remove ability to close modal with click
                keyboard: false, //remove option to close with keyboard
                show: true //Display loader!
            });
        });
        //Cache

        function remove_cache(url) {
            return url.replace(/\?cache=\d*/, "") + "?cache=" + new Date().getTime().toString();
        }
        $("img, input[type=image]").each(function() {
            this.src = remove_cache(this.src);
        });

        $('input#primaryfile').change(function(){
            $('input#upload').prop('disabled', false);
        });

        //Existing media
        $(document).on('click', '#existingMedia', function(){
            var x = document.getElementById("existing_media");
            var y = document.getElementById("new_media");
            if (x.style.display === "block") {
                x.style.display = "none";
                //$("#next").hide();
            } else {
                x.style.display = "block";
                var html ='<input type="hidden" name="media" value="existing_media">';
                html += '<input type="hidden" name="validate" value="true">';
                $('#existing_media_table').append(html);
                $('form#msform').submit();
                //$("#next").show();
            }
            if (y.style.display === "block") {
                y.style.display = "none";
                var html ='<input type="hidden" name="media" value="existing_media">';
                html += '<input type="hidden" name="validate" value="true">';
                $('#media_table').append(html);
                //$("#next").show();
            }
        });

    });
    </script>
@endsection
