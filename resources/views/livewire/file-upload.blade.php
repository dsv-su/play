<div class="col-lg-4 my-2">

<!-- <label>{{ __("Source files") }}</label>-->

    <div class="row text-center mt-3 mt-lg-0">
        <div class="col">
            <div class="counter">
                <i class="far fa-file-video fa-2x"></i>
                <h2 class="timer count-title count-number" data-to="100" data-speed="1500">{{$uploaded_files}}</h2>
                <p class="count-text ">{{ __("Mediafiles to be uploaded") }}</p>
            </div>
        </div>
    </div>

    <div class="rounded border shadow p-3 my-2">
        <ul>
            <li><span class="font-1rem">{{ __("Up to 4 media files per presentation can be uploaded.") }}</span></li>
            <li>
                <span class="font-1rem">{{ __("Each uploaded file should be the same length.") }}</span>
            </li>
            <li><span class="font-1rem">{{ __("When uploading, a default thumbnail is generated.") }}</span></li>
        </ul>
    </div>

    <div class="rounded border shadow p-3 my-2">
        <h4>{{ __("Files to upload") }}</h4>

        <!-- Right -->
        <div class="card-body">
            <div>
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
            <input type="file" class="form-control" wire:model="files" id="{{ rand() }}" multiple>
            @error('files.*') <span class="text-danger">{{ $message }}</span> @enderror
            @error('files') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    @if($files)
        @if($filethumbs)
            <!-- Upload Custom thumb -->
                <h4>{{ __("Upload Custom Thumb") }}</h4>
                <input type="file" class="form-control" wire:model="custom">
                @error('custom') <span class="text-danger">{{ $message }}</span> @enderror
                <div class="row">
                    @foreach($filethumbs as $key => $thumb)
                        <div class="col-12 col-sm-6 col-lg-12">
                            <div class="p-4 my-3 rounded-lg shadow-lg transition-all duration-500 bg-light"
                                 wire:key="{{$loop->index}}">
                                <!-- Thumb -->
                                <div class="flex justify-center w-100 position-relative">
                                    <i class="fas fa-times-circle text-danger text-2xl float-right cursor-pointer"
                                       wire:click="remove({{$loop->index}})"
                                       style="position: absolute; top: 0; right: 0;"></i>
                                    <img src="{{$thumb}}?{{ rand() }}" class="w-100">
                                </div>
                                <div style="font-family: 'Source Sans Pro', 'Arial', sans-serif; width: 90%; line-height: 1.15">
                                    <small>
                                        {{ __('Stream duration') }}: {{$filesduration[$loop->index]}} sec.
                                        <br>
                                        @if(!$custom or $key > 0)
                                            {{ __('Thumb generated after') }}: {{$genthumb[$loop->index]}} sec.
                                        @else
                                            {{ __('Custom uploaded thumb') }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                            <!--<div class="form-inline my-3">-->
                            <div class="row justify-content-between text-left">
                                <div class="form-group col d-flex">
                                    <input class="form-control form-control-sm" placeholder="10" type="number"
                                           wire:model="sec.{{$key}}" style="max-width: 90px; text-align: right;">
                                </div>
                                <div class="form-group col-auto d-flex pull-right">
                                    <button class="btn btn-outline-secondary btn-sm"
                                            wire:click="regenerate({{$loop->index}})">
                                        Regenerate
                                    </button>
                                </div>
                                @error('sec') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif

        <!-- Loading Message for Images -->

        <div wire:loading.block wire:target="files">@include('layouts.partials.spinner')</div>
    </div>

    <div class="col-sm-12">
        <button id="submit" type="submit"
                class="btn btn-outline-primary mx-auto d-flex font-125rem m-3"
                {{ $isDisabled ? '': 'disabled' }}
        >{{ __("Upload presentation") }}</button>
    </div>

</div>
<!-- end right -->

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

