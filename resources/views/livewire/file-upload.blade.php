<div>
    <div class="row">
        <div class="col-lg-12 my-2">
            <div class="rounded border shadow p-3 my-2">
                <div class="row text-left">
                    <div class="col-6 col-sm-6 my-2 d-flex align-items-center">
                        <div class="my-auto">
                        <label class="form-control-label px-1"><i
                                    class="fa-regular fa-image"></i> {{__("Upload custom thumb") }}</label>
                        <p class="font-1rem px-1">
                            {{ __("If you want, you can upload a custom image to represent your presentation.") }}
                        </p>
                        <input type="file" class="form-control-file" wire:model="custom">
                        @error('custom') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 my-2 d-flex align-items-center">
                        @if ($custom)
                            <img src="{{ $custom->temporaryUrl() }}" class="w-100"
                                 style="width: 100%; height: 150px; object-fit: contain; background-repeat: no-repeat; background-position: 50% 50%;">
                        @else
                            <div class="card d-inline-block mx-auto justify-content-center"
                                 style="border: .5vh solid blue;border-radius: 2vh;margin: auto">
                                <img src="{{asset('images/dsvplay.png')}}">
                            </div>

                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 my-2">
            <div class="rounded border shadow p-3 my-2">
                <label class="form-control-label px-1">{{ __("Mediafiles to be uploaded") }}</label>
                <p class="font-1rem px-1">
                    {{ __("Up to 4 media files per presentation can be uploaded.") }} {{ __("Each uploaded file should be the same length.") }}
                </p>
                <div class="row justify-content-between text-left">
                    <div class="form-group col-sm-6 flex-column d-flex">
                        <label class="form-control-label px-1">{{ __("Files to upload") }}<span
                                    class="text-danger"> *</span></label>
                        <p class="font-1rem px-1">
                            {{ __("Select one or drag and drop up to 4 files at a time into the box below") }}
                        </p>
                        <div class="form-group">
                            <input type="file" class="form-control-file" wire:model="files" id="{{ rand() }}" multiple/>

                            @error('files.*')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @error('files')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group col-sm-6 flex-column d-flex">
                        <!-- Subtitles file-->
                        <label class="form-control-label px-1">{{ __("Add a subtitle file") }} <span
                                    class="badge badge-warning">{{ __("Testing in progress") }}</span></label>
                        <p class="font-1rem px-1">
                            {{ __("Select one or drag and drop a WebVTT (.vtt) file into the box below") }}
                        </p>

                        @if(!$sub)

                            <div class="form-group">
                                <input type="file" class="form-control-file" wire:model="subtitle" accept="text/vtt"/>
                                @error('subtitle')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @else
                            <label class="form-control-label px-1">{{ __("A subtitle file has been added") }}</label>
                        @endif

                    </div>
                    {{--}}
                    <div class="form-group col-sm-6 flex-column d-flex">
                        <div class="row text-center mt-3 mt-lg-0">
                            <div class="col">
                                <div class="counter">
                                    <i class="far fa-file-video fa-2x"></i>
                                    <h2 class="timer count-title count-number" data-to="100" data-speed="1500">{{$uploaded_files}}</h2>
                                    <p class="count-text ">{{ __("Files") }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--}}
                </div>
                <div class="row justify-content-between text-left">
                    <div wire:loading.block wire:target="files">@include('layouts.partials.spinner')</div>
                </div>

                @if(session()->has('message'))
                    <div class="py-4">
                        {{ session('message') }} <span class="badge badge-primary">{{$uploaded_files}}</span>
                    </div>
                @endif

                @if($files)
                    @if($filethumbs)
                        <div class="row justify-content-left text-left">
                            <!-- Thumbs -->
                            @foreach($filethumbs as $key => $thumb)
                                <div class="col-xl-3 col-sm-6 my-2">
                                    <div class="card border-left-info rounded border shadow h-100 py-2"
                                         wire:key="{{$loop->index}}">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2 text-right">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        <button wire:click="remove({{$loop->index}})"
                                                                class="btn-outline-primary btn-sm fas fa-trash-alt"></button>
                                                    </div>
                                                    <div class="position-relative">
                                                        <img src="{{$thumb}}?{{ rand() }}" class="w-100">
                                                    </div>
                                                    <div class="custom-control custom-switch text-left">
                                                        <small>
                                                            <label class="footer-department-name">{{ __("Stream duration") }}
                                                                : {{$filesduration[$loop->index]}} sec.</label>

                                                            @if(!$custom or $key > 0)
                                                                <label class="footer-department-name">{{ __('Thumb generated after') }}
                                                                    : {{$genthumb[$loop->index]}} sec.</label>
                                                            @else
                                                                <label class="footer-department-name">{{ __('Custom uploaded thumb') }}</label>
                                                            @endif
                                                        </small>
                                                        @if(!$custom or $key > 0)
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control" placeholder="0"
                                                                       type="number"
                                                                       wire:model="sec.{{$key}}">
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-outline-secondary"
                                                                            type="button"
                                                                            wire:click="regenerate({{$loop->index}})">
                                                                        {{__("Regenerate")}}</button>
                                                                </div>
                                                                @error('sec') <span
                                                                        class="text-danger">{{ $message }}</span> @enderror
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                        <!-- end thumbs -->

                        </div>
                    @endif
                @endif
            </div>
            <div class="col-sm-12 mt-5">
                <button id="submit" type="submit"
                        class="btn btn-outline-primary mx-auto d-flex font-125rem m-3"
                        {{ $isDisabled ? '': 'disabled' }}
                >{{ __("Upload presentation") }}</button>
            </div>
        </div>
    </div>

</div>


<!-- Modal for max upload-->
<div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
<!-- Modal for diffs upload-->
<div wire:ignore.self class="modal fade" id="diffModal" tabindex="-1" role="dialog" aria-labelledby="diffModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                {{ __("The media files have different lengths and differ by more than +/- 3 sec. Check and reload!") }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close") }}</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal for out of range upload-->
<div wire:ignore.self class="modal fade" id="outofrangeModal" tabindex="-1" role="dialog"
     aria-labelledby="outofrangeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                {{ __("The value in seconds is beyond the scope of the stream") }}
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
    window.livewire.on('diffs', () => {
        $('#diffModal').modal('show');
    });
    window.livewire.on('outofrange', () => {
        $('#outofrangeModal').modal('show');
    });
</script>

