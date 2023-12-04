<div>
    <div class="rounded border p-3 my-2">
        <span class="custom-control custom-switch custom-switch-lg" data-toggle="tooltip" title="{{__("Switch the toggle to change")}}">
            <input wire:click="subtitleslanguage" class="custom-control-input" id="langSubSwitch" name="langsubtitles"
                   type="checkbox" @if($lang == true) checked @endif>
            <label class="custom-control-label"  style="margin-top: 3px;" for="langSubSwitch">{{__('Subtitling language')}}: </label>
            @if(!$lang) <span class="badge badge-primary">{{__("autodetect")}}</span> @else <span class="badge badge-danger">{{__("manual")}} @endif </span>
        </span>
    </div>
    @if($lang)
        <div class="form-group col-sm-6 flex-column d-flex">
            <p class="px-1 font-1rem mb-0">
                {{ __("Specify the generated language") }}
            </p>
            <select wire:model="whisper" class="w-auto form-group form-control" name="whisper_language" style="margin: 5px 0;">
                <option value="">{{__("Choose a language")}}</option>
                <option value="en">{{__("English")}}</option>
                <option value="sv">{{__("Swedish")}}</option>
                <option value="fi">{{__("Finnish")}}</option>
            </select>
        </div>
    @endif
</div>
