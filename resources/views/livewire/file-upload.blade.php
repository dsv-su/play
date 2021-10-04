<div class="col-sm-4 my-2">
<!-- <label>{{ __("Source files") }}</label>-->

    <div class="row text-center">
        <div class="col">
            <div class="counter">
                <i class="far fa-file-video fa-2x"></i>
                <h2 class="timer count-title count-number" data-to="100" data-speed="1500">{{$uploaded_files}}</h2>
                <p class="count-text ">{{ __("Uploaded media files") }}</p>
            </div>
        </div>
    </div>

    <div class="rounded border shadow p-3 my-2">
        <ul>
            <li><span class="font-1rem">{{ __("Up to 4 media files can be uploaded.") }}</span></li>
            <li>
                <span class="font-1rem">{{ __("Each uploaded file should be the same length as the primary file") }}</span>
            </li>
            <li><span class="font-1rem">{{ __("When uploading, a default thumbnail is generated") }}</span></li>
        </ul>
    </div>

    <div class="rounded border shadow p-3 my-2">
        <h4>{{ __("Upload media") }}</h4>

        <!-- Right -->
        <div class="card-body">
            <div>
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
            <input type="file" class="form-control" wire:model="files" multiple>
            @error('files.*') <span class="text-danger">{{ $message }}</span> @enderror
            @error('files') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    @if($files)
        @if($filethumbs)
            <!-- Upload Custom thumb -->
                <h4>{{ __("Upload Custom Thumb") }}</h4>
                <input type="file" class="form-control" wire:model="custom">
                @error('custom') <span class="text-danger">{{ $message }}</span> @enderror
                @foreach($filethumbs as $key => $thumb)

                    <div class="p-4 my-3 rounded-lg shadow-lg transition-all duration-500"
                         style="background-image: radial-gradient( circle farthest-corner at 14.2% 27.5%,  rgba(104,199,255,1) 0%, rgba(255,255,255,1) 90% );"
                         wire:key="{{$loop->index}}">
                        <i class="fas fa-times-circle text-gray-700 text-2xl float-right cursor-pointer"
                           wire:click="remove({{$loop->index}})"></i>
                        <!-- Thumb -->
                        <div class="flex justify-center">
                            <img src="{{$thumb}}?{{ rand() }}" width="90%" style="width: 250px; height: 150px;">
                        </div>
                        <div style="font-family: 'Source Sans Pro', 'Arial', sans-serif; width: 90%;">
                            <small>
                                {{ __('Stream Duration') }}: {{$presentation->duration}} sec.
                                <br>
                                @if(!$custom or $key > 0)
                                    {{ __('Thumb generated after') }}: {{$genthumb}} sec.
                                @else
                                    {{ __('Custom uploaded thumb') }}
                                @endif
                            </small>
                        </div>
                    </div>
                    <!--<div class="form-inline my-3">-->
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-4 flex-column d-flex">
                            <input class="form-control form-control-sm" placeholder="10" type="number" wire:model="sec">
                        </div>
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <button class="btn btn-outline-primary btn-sm" wire:click="regenerate({{$loop->index}})">
                                Regenerate
                            </button>
                        </div>
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


<script type="text/javascript">
    window.livewire.on('show', () => {
        $('#exampleModal').modal('show');
    });
    window.livewire.on('diffs', () => {
        $('#diffModal').modal('show');
    });
</script>

