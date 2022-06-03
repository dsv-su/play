<form wire:submit.prevent="selectfilters" class="form-inline d-flex justify-content-start mx-3">
    <label class="col-form-label mr-1 font-weight-light">{{__('Filter by')}}: </label>
    <div id="for-picker" wire:ignore>
        <select wire:model="course" @if (empty($videocourses)) disabled
                @endif class="form-control mx-1 selectpicker"
                data-none-selected-text="{{ __('Course') }}" data-live-search="true" multiple
                style="width: 400px">
            @foreach($videocourses as $designation => $video_course)
                @if(Lang::locale() == 'swe')
                    <option value="{{$video_course->course->designation}}">{{$video_course->course->name}}
                        ({{$video_course->course->designation}})
                    </option>
                @else
                    <option value="{{$video_course->course->designation}}">{{$video_course->course->name_en}}
                        ({{$video_course->course->designation}})
                    </option>
                @endif
            @endforeach
        </select>

        <select wire:model="presenter" @if (empty($videopresenters)) disabled
                @endif class="form-control mx-1 selectpicker"
                data-none-selected-text="{{ __('Presenter') }}" data-live-search="true" multiple
                style="width: 200px;">
            @foreach($videopresenters as $username => $name)
                <option value="{{$username}}">{{$name}}</option>
            @endforeach
        </select>

        <select wire:model="semester" @if (empty($videoterms)) disabled
                @endif class="form-control mx-1 selectpicker" data-none-selected-text="{{ __('Term')}}"
                data-live-search="true"
                multiple style="width: 200px">
            @foreach($videoterms as $term => $semester)
                <option value="{{$term}}">{{$semester}}</option>
            @endforeach
        </select>

        <select wire:model="tag" @if (empty($videotags)) disabled
                @endif class="form-control mx-1 selectpicker"
                data-none-selected-text="{{ __('Tag') }}" data-live-search="true" multiple
                style="width: 200px;">
            @foreach($videotags as $tag)
                <option value="{{$tag}}">{{$tag}}</option>
            @endforeach
        </select>
        <button type="button" class="mb-2 btn btn-outline-secondary"
                onclick="$('.selectpicker').selectpicker('deselectAll'); $('.selectpicker').selectpicker('refresh');">
            {{ __("Clear selection") }}
        </button>
    </div>
</form>
<form wire:submit.prevent="selectfilters" class="form-inline d-flex mx-3" method="post">
    <label class="my-1 mr-2" for="videoformat">{{__('Display')}}:</label>
    <div wire:ignore>
        <select wire:model="videoformat" class="form-control my-1 mr-sm-2 selectpicker">
            <option @if(Cookie::get('videoformat') == 'grid') selected @endif value="grid">{{__('Grid')}}</option>
            <option @if(Cookie::get('videoformat') == 'list') selected @endif value="list">{{__('List')}}</option>
            <option @if(Cookie::get('videoformat') == 'table') selected @endif value="table">{{__('Table')}}</option>
        </select>
    </div>
</form>
