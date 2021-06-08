<form wire:submit.prevent="submit" enctype="multipart/form-data">


    <!-- Right -->
    <div>
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <div class="rounded border shadow p-3 my-2">
        @if($files)
            @if($filethumbs)
                @foreach($filethumbs as $thumb)

                    <div class="flex justify-start my-2">
                        {{$loop->index + 1}}:<img src="{{$thumb}}?{{ rand() }}" width="200">
                    </div>
                    <input type="number" wire:model="sec">
                    <button wire:click="regenerate({{$loop->index}})">Regenerate</button>
                @endforeach
            @endif
        @endif

        <input type="file" class="form-control" wire:model="files" multiple>
            @error('files.*') <span class="text-danger">{{ $message }}</span> @enderror
            @error('files') <span class="text-danger">{{ $message }}</span> @enderror

    </div>
    <!-- Loading Message for Images -->
    <div wire:loading wire:target="file">Uploading Media...</div>
    <!-- end right -->
</form>
