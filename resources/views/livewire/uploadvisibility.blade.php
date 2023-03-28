<div>

    <div class="row justify-content-between text-left">
        <div class="form-group col-sm-6 flex-column d-flex">
            <p class="px-1 font-1rem mb-0">
                {{ __("Specify the visibility of the presentation: visible, private or unlisted.") }}
            </p>
            <select wire:model="visibility" class="w-50form-group form-control" name="video_visibility" style="margin: 5px 0;">
                <option value="visible">{{__("Visible")}}</option>
                <option value="private">{{__("Private")}}</option>
                <option value="unlisted">{{__("Unlisted")}}</option>
            </select>

        </div>

        <!-- Status text -->
        <div class="form-group col-sm-6 flex-column d-flex">
            @if($visibility == 'visible')
                <br>
                <div class="rounded border su-background__light p-3 my-2">
                    {{__("The presentation is visible, searchable and playable.")}}
                </div>
            @endif
            @if($visibility == 'private')
                <br>
                <div class="rounded border p-3 my-2" style="background-color: rgba(255, 0, 0, 0.3);">
                    {{__("The presentation is hidden, not searchable or playable.")}}
                </div>
            @endif
            @if($visibility == 'unlisted')
                <br>
                <div class="rounded border su-background__light p-3 my-2" style="background-color:rgba(255,255,0,0.3);">
                    {{__("The presentation is hidden, not searchable but playable with a direct link.")}}
                </div>
            @endif
        </div>
        <!-- end status text -->
    </div>

</div>
