<div wire:loading wire:target="videoformat">
    @include('livewire.modals.loading_spinner')
</div>

<form class="form-inline d-flex justify-content-start mx-3">
    <label class="col-form-label mr-1 font-weight-light">{{__('Filter by')}}: </label>
    <div id="for-picker">
        @if($view == 'courses')
        <select wire:model="course" @if (empty($videocourses)) disabled
                @endif class="form-control mx-1"
                style="width: 200px">
            <option value=''>{{ __('Course') }}</option>
            @foreach($videocourses as $designation => $name)
                <option value="{{$designation}}">{{$name}}
                </option>
            @endforeach
        </select>
        @endif
        <select wire:model="presenter" @if (empty($videopresenters)) disabled
                @endif class="form-control mx-1"
                style="width: 200px;">
            <option value=''>{{ __('Presenter') }}</option>
            @foreach($videopresenters as $username => $name)
                <option value="{{$username}}">{{$name}}</option>
            @endforeach
        </select>

        <select wire:model="semester" @if (empty($videoterms)) disabled
                @endif class="form-control mx-1"
                style="width: 200px">
            {{krsort($videoterms)}}
            <option value=''>{{ __('Term')}}</option>
            @foreach($videoterms as $key => $semester)
                <option value="{{$semester}}">{{$semester}}</option>
            @endforeach
        </select>

        <select wire:model="tag" @if (empty($videotags)) disabled
                @endif class="form-control mx-1"
                style="width: 200px;">
            <option value=''>{{ __('Tag') }}</option>
            @foreach($videotags as $tag)
                <option value="{{$tag}}">{{$tag}}</option>
            @endforeach
        </select>

        <button wire:click="resetFilter" class="form-control mx-1 mb-2 btn btn-outline-secondary">
            {{ __("Clear selection") }}
        </button>

    </div>
</form>
