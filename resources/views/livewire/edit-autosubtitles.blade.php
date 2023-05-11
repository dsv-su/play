<div>
    <!--AutoSubtitles toggle-->
    <div class="form-group col-md-6 flex-column d-flex">
        <span class="custom-control custom-switch custom-switch-lg" data-toggle="tooltip" title="{{__("Switch the toggle to change")}}">
            <input wire:click="autosubtitles" class="custom-control-input" id="autoSubSwitch" name="autosubtitles"
                   type="checkbox" @if($subtitles == true) checked @endif>
            <label class="custom-control-label"  style="margin-top: 3px;" for="autoSubSwitch">{{__('Automatic subtitling')}}: </label>
            @if(!$subtitles) <span class="badge badge-danger">{{__("off")}}</span> @else <span class="badge badge-primary">{{__("on")}} @endif </span>
        </span>
    </div>
</div>
