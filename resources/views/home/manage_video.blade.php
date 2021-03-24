<!-- ManageVideo - child view - will inherit all data available in the parent view-->

<div class="col my-3">
    <!--<style>.btn-sm { height: 3vh; width: 5vh; }</style>-->
    <p style="font-size: 75%; color: blue">{{$video->id}}</p>
    <div class="card video m-auto" id="{{$video->id}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <a href="{{ route('player', ['video' => $video]) }}">
            <div class="card-header position-relative"
                 style="background-image: url({{ asset($video->thumb)}}); height:200px;">
                <div class="title">{{ $video->title }}</div>
                <p class="p-1"> {{$video->duration}} </p>
            </div>
        </a>
        <div class="card-body p-1">
            <p class="card-text" id="courses">
                @foreach($video->video_course as $vc) <a
                    href="/course/{{$vc->course_id}}"
                    class="badge badge-primary">{{\App\Course::find($vc->course_id)->designation}}</a> @endforeach
            </p>
            <p class="card-text" id="category">
                <span class="badge badge-light">{{$video->category->category_name}}</span>
            </p>
            <p class="card-text">
                @foreach($video->presenters() as $presenter) <span
                    class="badge badge-light">{{$presenter->name}}</span> @endforeach</p>
            <p class="card-text" id="tags">@foreach($video->tags() as $tag) <a
                        href="/tag/{{$tag->id}}"
                        class="badge badge-secondary">{{$tag->name}}</a> @endforeach</p>
            <p class="card-text">
            <p class="card-text">
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Redigera presentation">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-{{$video->id}}"><i class="far fa-edit"></i></button>
                </span>

                <button class="delete btn btn-danger btn-sm" type="submit" data-toggle="tooltip" data-placement="top" title="Radera presentation"><i class="far fa-trash-alt"></i></button>
                <a href="{{route('download', $video->id)}}" type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Ladda ner presentation"><i class="fas fa-download"></i></a>
                <a href="{{route('set_permission', $video->id)}}" type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Ändra rättigheter för presentation"><i class="far fa-hand-paper"></i></a>
            </p>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal fade" id="modal-{{$video->id}}" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <!-- Modal content -->
            <div class="modal-content">
                <form>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{$video->title}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                        <label class="col-form-label" for="video_category_{{$video->id}}">Category:</label>
                        <select class="col form-control" name="video_category[]" id="video_category_{{$video->id}}" required>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}"
                                        @if ($category->id == $video->category_id) selected @endif>{{$category->category_name}}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="form-row">
                        <label class="col-form-label" for="video_course_{{$video->id}}">Courses:</label>
                        <select class="selectpicker col" multiple data-live-search="true" name="video_course[]" id="video_course_{{$video->id}}" required>
                        <!--<select name="video_course[]" id="video_course_{{$video->id}}" required>-->
                            @foreach($allcourses as $course)
                                <option value="{{$course->id}}"
                                        @if ($video->has_course($course->id)) selected @endif>{{$course->designation}}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="form-row">
                            <label class="col-form-label" for="video_tag_{{$video->id}}">Tags:</label>
                            <select class="selectpicker col" multiple data-live-search="true" name="video_tags[]" id="video_tag_{{$video->id}}" required>
                                @foreach($alltags as $tag)
                                    <option value="{{$tag->id}}" @if ($video->has_tag($tag->id)) selected @endif>{{$tag->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                        </button>
                        <button type="button" class="btn btn-primary save" id="{{$video->id}}">
                            Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $(document).ready(function () {
        $('.selectpicker').selectpicker();
    });
</script>
