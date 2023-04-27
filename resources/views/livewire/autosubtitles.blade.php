<div>
    <div class="rounded border p-3 my-2">
        <span class="custom-control custom-switch custom-switch-lg" data-toggle="tooltip" title="{{__("Switch the toggle to change")}}">
            <input wire:click="autosubtitles" class="custom-control-input" id="autoSubSwitch" name="autosubtitles"
                   type="checkbox" @if($subtitles == true) checked @endif>
            <label class="custom-control-label"  style="margin-top: 3px;" for="autoSubSwitch">{{__('Automatic subtitling')}}: </label>
            @if(!$subtitles) <span class="badge badge-danger">{{__("off")}}</span> @else <span class="badge badge-primary">{{__("on")}} @endif </span>
        </span>
    </div>
    <!-- Subtitles file-->
    @if(!$subtitles)
        <label class="form-control-label px-1">{{ __("Add a subtitle file") }}</label>
        <!-- Subtitle -->
        <div wire:ignore id="subtitleHolder">
            <form action="{{ route('subtitle-upload') }}" class="dropzone" id="subtitleupload">
                <input type="file" name="subtitle"  style="display: none;">
                <input type="hidden" name="subtitledir"  id="subtitledir" value="{{ $presentation->local }}">
                @csrf
                <div class="dz-message" data-dz-message>
                    <span>{{ __("Drop a WebVTT (.vtt) file here or click to browse") }}</span>
                </div>
            </form>
        </div>
    @endif
</div>
