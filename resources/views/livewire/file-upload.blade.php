<div class="container bootstrap snippet">
    <form wire:submit.prevent="submit">
        <div class="w-7/12 mx-2 rounded border p-2">
            <div class="row">
                <div class="col-sm-10"><h1>{{ __("Upload presentation") }}</h1></div>
            </div>
            <div class="row">
                <div class="col-sm-7">
                    <div class="rounded border shadow p-3 my-2">
                        <div class="rounded border shadow p-3 my-2">
                            <p class="font-bold text-lg">1.) {{ __("Information about the presentation") }}:</p>
                            <small>
                                {{ __("Enter the title of the presentation and the date of recording. If the recording date is unknown, you can enter today's date.") }}
                            </small>
                            <br>
                            <!-- Title -->
                            <label class="fieldlabels">{{ __("Enter title") }}: </label>
                            <input class="form-control form-control-sm" id="title"  wire:model="title" type="text" value="{{ old('title') ? old('title'): $title ?? '' }}">
                            <div><small class="text-danger">{{ $errors->first('title') }}</small></div>
                            <!-- Date -->
                            <label class="fieldlabels">{{ __("Recording date") }}: </label>
                            <input id="creationdate" class="form-control form-control-sm datepicker"
                                   wire:model="created" type="text" autocomplete="off" data-provide="datepicker"
                                   data-date-autoclose="true" data-date-today-highlight="true"
                                   onchange="this.dispatchEvent(new InputEvent('input'))">
                            <div><small class="text-danger">{{ $errors->first('created') }}</small></div>
                        </div>

                    <!-- Presenters -->
                        <label class="fieldlabels">{{ __("Presenter") }}: </label>
                        <p><small><strong>{{app()->make('play_user')}} ({{app()->make('play_username')}})</strong></small></p>

                        <label class="fieldlabels">{{ __("Additional presenters.") }}</label>
                        <button type="button" name="presenteradd" class="btn btn-outline-primary btn-sm presenteradd">{{ __("Presenter") }} <i class="fas fa-user-plus"></i></button>
                        <table class="table table-sm" id="presenter_table">
                        </table>

                        <div class="rounded border shadow p-3 my-2">
                            <p class="font-bold text-lg">2.) {{ __("Course association") }}:</p>
                            <small>
                                {{ __("Here you specify whether the recording should be associated with one or more courses. If you do not want the recording to be associated with a course or want to complete at a later time, leave the field blank.") }}
                            </small>
                        </div>
                        <label class="fieldlabels">{{ __("Course association") }}: </label>
                        <br>
                        <button type="button" name="courseadd" class="btn btn-outline-primary btn-sm courseadd">@lang('lang.course') <i class="fas fa-chalkboard"></i></button>
                        <table class="table table-sm" id="course_table">

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

                    <div class="form-group">
                        <div class="col-xs-12">
                            <br>
                            <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                            <button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
                        </div>
                    </div>
                </div>

                <!--/col-9-->

                <div class="col-sm-5">
                    <div class="col-7">
                        <h3 class="fs-title">{{ __("Upload media") }}:</h3>
                    </div>
                    <p class="description">
                        {{ __("Upload video media. Up to 4 media files can be uploaded.") }}
                    </p>

                    <div class="rounded border shadow p-3 my-2">
                        <h4>{{ __("Media") }}</h4>

                        <!-- Right -->
                        <div class="card-body">
                            <div>
                                @if(session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session('message') }}
                                    </div>
                                @endif
                            </div>

                            <div x-data="{ isUploading: false, progress: 0 }"
                                x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <input type="file" class="form-control" wire:model="files" multiple>
                                @error('files.*') <span class="text-danger">{{ $message }}</span> @enderror
                                @error('files') <span class="text-danger">{{ $message }}</span> @enderror
                            <!-- Progress Bar -->
                                <div x-show="isUploading">
                                    <progress max="100" x-bind:value="progress"></progress>
                                </div>
                            </div>

                                @if($files)
                                    @if($filethumbs)
                                        @foreach($filethumbs as $thumb)

                                            <div class="p-4 my-3 rounded-lg shadow-lg transition-all duration-500"
                                                 style="background-image: radial-gradient( circle farthest-corner at 14.2% 27.5%,  rgba(104,199,255,1) 0%, rgba(255,255,255,1) 90% );"
                                                 wire:key="{{$loop->index}}">
                                                <i class="fas fa-times-circle text-gray-700 text-2xl float-right cursor-pointer"
                                                   wire:click="remove({{$loop->index}})"></i>
                                                <!-- Thumb -->
                                                <div class="flex justify-center">
                                                    <img src="{{$thumb}}?{{ rand() }}" width="90%">
                                                </div>

                                            </div>
                                            <div class="form-inline my-3">
                                                <input class="col-4 form-control form-control-sm" placeholder="10" type="number" wire:model="sec">
                                                <button class="btn btn-outline-primary btn-sm" wire:click="regenerate({{$loop->index}})">Regenerate</button>
                                                @error('sec') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>

                                        @endforeach
                                    @endif
                                @endif

                            <!-- Loading Message for Images -->
                            <div wire:loading wire:target="files">Uploading Media...</div>
                        </div>
                    </div>
                </div>
                <!-- end right -->

            </div>

        </div>
    </form>


</div>
<!-- Modal for max upload-->
<div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true close-btn">×</span>
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

<script type="text/javascript">

    window.livewire.on('show', () => {
        $('#exampleModal').modal('show');
    });

</script>

