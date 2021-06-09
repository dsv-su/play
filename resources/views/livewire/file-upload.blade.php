
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
                                        @foreach($filethumbs as  $thumb)

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
                                                <input class="col-2 form-control form-control-sm" placeholder="10" type="number" wire:model="sec">
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
<!-- Modal for diffs upload-->
<div wire:ignore.self class="modal fade" id="diffModal" tabindex="-1" role="dialog" aria-labelledby="diffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
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

