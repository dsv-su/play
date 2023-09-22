<div>
    <div class="rounded border p-3 my-2">
        <span class="custom-control custom-switch custom-switch-lg" data-toggle="tooltip" title="{{__("Switch the toggle to change")}}">
            <!-- disabled subtitling 2023-09-04 -->
            @if(app()->make('play_role') == 'Administrator')
                <input wire:click="autosubtitles" class="custom-control-input" id="autoSubSwitch" name="autosubtitles"
                       type="checkbox" @if($subtitles == true) checked @endif>
            @else
                <input wire:click="autosubtitles" class="custom-control-input" id="autoSubSwitch" name="autosubtitles"
                       type="checkbox" disabled>
            @endif
            <label class="custom-control-label"  style="margin-top: 3px;" for="autoSubSwitch">{{__('Generate subtitling')}}: </label>
            @if(!$subtitles) <span class="badge badge-danger">{{__("off")}}</span> @else <span class="badge badge-primary">{{__("on")}} @endif </span>
        </span>
    </div>
</div>
