@extends('layouts.suplay_upload')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-11 col-sm-9 col-md-7 col-lg-6 col-xl-7 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        {{ __("Error entering data") }}!<br><br>
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
                <h2 id="heading"><span class="fas fa-upload fa-icon-border mr-2" aria-hidden="true"></span>{{ __("Upload presentation") }}</h2>
                <p>{{ __("Fill in all the steps in the form to upload your presentation") }}</p>
                    <!-- progressbar -->
                    <ul id="progressbar">
                        <li class="active" id="account"><strong>1. Presentationen</strong></li>
                        <li id="personal"><strong>2. {{ __("Course association") }}</strong></li>
                        <li id="payment"><strong>3. {{ __("Media files") }}</strong></li>
                        <li id="confirm"><strong>4. {{ __("Thumbnails and Posters") }}</strong></li>
                    </ul>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <br>
                    @if(!$final ?? '' == 1)
                   <form id="msform" method="post" action="{{route('upload_step1', $id)}}" enctype="multipart/form-data">
                        @csrf
                    <!-- fieldsets -->
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">1.) {{ __("Information about the presentation") }}:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps"><span class="blue-text">{{ __("Step") }} 1</span>(4)</h2>
                                </div>
                            </div>
                            <p class="description">
                                {{ __("Enter the title of the presentation and the date of recording. If the recording date is unknown, you can enter today's date.") }}
                            </p>
                            <label class="fieldlabels">{{ __("Enter title") }}: </label>
                            <input class="form-control form-control-sm" id="title" name="title" type="text" value="{{ old('title') ? old('title'): $title ?? '' }}">
                            <small class="text-danger">{{ $errors->first('title') }}</small>

                            <label class="fieldlabels">{{ __("Recording date") }}: </label>
                            <input id="creationdate" class="form-control form-control-sm datepicker" name="created" type="text" value="{{ old('created') ? old('created'): $created ?? '' }}">
                            <small class="text-danger">{{ $errors->first('created') }}</small>

                            <label class="fieldlabels">{{ __("Presenter") }}: </label>
                            <p><small><strong>{{app()->make('play_user')}} ({{app()->make('play_username')}})</strong></small></p>

                            <label class="fieldlabels">{{ __("Additional presenters.") }}</label>
                            <button type="button" name="presenteradd" class="btn btn-outline-primary btn-sm presenteradd">{{ __("Presenter") }} <i class="fas fa-user-plus"></i></button>
                            <table class="table table-sm" id="presenter_table">
                            </table>

                        </div>
                        <input type="button" name="next" class="next btn action-button" value="{{ __("Next") }}" />
                    </fieldset>

                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">{{ __("Course association") }}:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps"><span class="blue-text">{{ __("Step") }} 2</span>(4)</h2>
                                </div>
                            </div>
                            <p class="description">
                                {{ __("Here you specify whether the recording should be associated with one or more courses. If you do not want the recording to be associated with a course or want to complete at a later time, leave the field blank.") }}
                            </p>
                            <label class="fieldlabels">{{ __("Course association") }}: </label>
                            <br>
                            <button type="button" name="courseadd" class="btn btn-outline-primary btn-sm courseadd">@lang('lang.course') <i class="fas fa-chalkboard"></i></button>
                            <table class="table table-sm" id="course_table">
                                @if(count($courses) > 0)
                                H
                                @endif

                            </table>
                            <p class="description">
                                {{ __("Also make the recording searchable by entering tags.") }}
                            </p>
                            <label class="fieldlabels">{{ __("Tags") }}: </label>
                            <br>
                            <button type="button" name="tagadd" class="btn btn-outline-primary btn-sm tagadd">@lang('lang.tag') <i class="fas fa-tags"></i></button>
                            <table class="table table-sm" id="tag_table">
                            </table>
                            <p class="description">
                                {{ __("All uploaded presentations are public unless otherwise specified") }}
                            </p>
                            <label class="fieldlabels">{{ __("Playback permissions") }}</label>
                            <select name="permission" class="form-control" id="permission">
                                <option value="false" selected>@lang('lang.public')</option>
                                <option value="true">@lang('lang.private')</option>
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
                        <input type="button" name="next" class="next action-button" value="{{ __("Next") }}" /> <input type="button" name="previous" class="previous action-button-previous" value="{{ __("Previous") }}" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">{{ __("Upload media") }}:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps"><span class="blue-text">{{ __("Step") }} 3</span>(4)</h2>
                                </div>
                            </div>
                            <p class="description">
                                {{ __("Upload video media. Up to 4 media files can be uploaded.") }}
                            </p>
                            <label class="fieldlabels">{{ __("Upload files") }}:</label>
                            <button type="button" name="mediaadd" class="btn btn-outline-primary btn-sm mediaadd"><i class="fas fa-plus"></i> {{ __("Add") }}</button>
                            <table class="table table-sm" id="media_table">
                                <tr>
                                    <td>{{ __("Primary media") }}</td>
                                    <td><input type="file" name="filenames[]" class="form-control"></td>
                                </tr>
                            </table>

                        </div>
                        <input id="upload" type="submit" name="next" class="next action-button" value="{{ __("Next") }}" />
                        <input type="button" name="previous" class="previous action-button-previous" value="{{ __("Previous") }}" />
                    </fieldset>
                   </form>
                    @endif

                    <fieldset id="thumbfs">
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">{{ __("Thumbnails and Posters") }}</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps"><span class="blue-text">{{ __("Step") }} 4</span>(4)</h2>
                                </div>
                            </div>
                            <p class="description">
                                {{ __("A thumbnail has been generated to display the presentation on the web page.") }}
                            </p>
                            <label class="fieldlabels">{{ __("Thumbnail") }}:</label>
                            <div class="card mb-3" style="max-width: 640px;">
                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        @if($thumb == null)
                                            <svg class="bd-placeholder-img" width="100%" height="250" xmlns="http://www.w3.org/2000/svg" aria-label="Placeholder: Image" preserveAspectRatio="xMidYMid slice" role="img"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"/><text x="50%" y="50%" fill="#dee2e6" dy=".3em">{{ __("No image") }}</text></svg>
                                        @else
                                            <img id="thumb" class="bd-placeholder-img" width="100%" height="250" src="{{'/storage/'.$local.'/'.$thumb}}">
                                        @endif

                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ __("Title") }}: {{$title}}</h5>
                                            <form method="post" action="{{route('thumb', $id)}}">
                                                @csrf
                                                <p class="card-text">{{ __("Length") }}: {{ $durationInSeconds }} sek.</p>
                                                <p class="card-text"><small class="text-muted">{{ __("The number of seconds into the presentation") }}:</small></p>
                                                <input type="number" name="seconds"  min="1" max="{{$durationInSeconds}}">
                                                @if($thumb == null)
                                                    <button type="submit" class="btn btn-primary btn-sm">{{ __("Generate") }}</button>
                                                @else
                                                    <button type="submit" class="btn btn-primary btn-sm">{{ __("Regenerate") }}</button>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($thumb != null)
                                <div class="row">
                                    <div>
                                        <h4 class="title">{{ __("Generate a poster for each presentation") }}</h4>
                                        <p class="description">
                                            {{ __("A poster has been created for each uploaded presentation. The poster is used by the player.") }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach($sources as $source)
                                        <div class="card" style="width: 18rem;">
                                            @if($thumb == null)
                                                <svg class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" role="img"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"/><text x="50%" y="50%" fill="#dee2e6" dy=".3em">{{ __("No image") }}</text></svg>
                                            @else
                                                <img class="bd-placeholder-img" width="100%" height="180" src="{{'/storage/'.$local.'/poster/poster_'.($loop->index+1).'.png'}}">
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title">Poster {{($loop->index+1)}}</h5>
                                                <form method="post" action="{{route('poster', $id)}}">
                                                    @csrf
                                                    <p class="card-text">{{ __("Length") }}: {{ $durationInSeconds }} sek.</p>
                                                    <p class="card-text"><small class="text-muted">{{ __("The number of seconds into the presentation") }}:</small></p>
                                                    <input type="number" name="seconds"  min="1" max="{{$durationInSeconds}}">
                                                    <input type="hidden" name="poster"  value="{{($loop->index+1)}}">
                                                    <button type="submit"  class="btn btn-primary btn-sm">{{ __("Regenerate") }}</button>
                                                </form>
                                            </div>
                                        </div>

                                    @endforeach
                                </div>
                                <br>

                                <a id="upload_server" href="{{route('upload_store', $id)}}" role="button" class="btn btn-primary btn-lg float-right">{{ __("Upload") }} <i class="fas fa-forward"></i></a>
                            @endif

                            <div class="row justify-content-center">
                                <div class="col-7 text-center">
                                    <h5 class="blue-text text-center">{{ __("Your presentation is ready for upload") }}</h5>
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
                <h5 class="modal-title" id="max">{{ __("Maximum allowed videos") }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ __("Maximum number of allowed streams for upload has been reached.") }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close") }}</button>
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
                    <p>{{ __("Work in progress") }} <br><br><small>{{ __("The media files are checked") }}</small></p>
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
                    <p>{{ __("Upload in progress") }} <br><br><small>{{ __("Storing media on play-store") }}</small></p>
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


    });
    </script>
@endsection
