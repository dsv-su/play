<div {{--}}wire:poll.visible{{--}}>
    <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
    @if ($this->hasMy)
        <!-- My courses tab -->
            <li class="nav-item pb-0">
                <a class="nav-link" href="#my" data-toggle="tab" role="tab" aria-controls="my"
                   title="{{ in_array(app()->make('play_role'), ['Courseadmin', 'Uploader', 'Staff']) ? __('lang.my_presentations') : __('lang.my_courses') }}">
                    {{ in_array(app()->make('play_role'), ['Courseadmin', 'Uploader', 'Staff']) ? __('lang.my_presentations') : __('lang.my_courses') }}
                    <span class="count-label">{{ $mypaginated->total() }}</span>
                </a>
            </li>
    @endif

    @if ($this->hasStudieadmin)
        <!-- Studieadmin tab -->
            <li class="nav-item pb-0">
                <a class="nav-link" href="#studyinfo" data-toggle="tab" role="tab" aria-controls="studyadmin"
                   title="{{ __('lang.studyinfo') }}">
                    {{ __('lang.studyinfo') }}
                    <span class="count-label">{{ $this->studyinfo->total() }}</span>
                </a>
            </li>
    @endif

    @if ($this->hasActiveHT)
        <!-- HT 2024 -->
            <li class="nav-item pb-0">
                <a class="nav-link" href="#active_ht" data-toggle="tab" role="tab" aria-controls="active_ht"
                   title="{{ __('lang.active_courses_ht') }}">
                    {{ __('lang.active_courses_ht') }}
                    <span class="count-label">{{ $activepaginated_ht->total() }}</span>
                </a>
            </li>
    @endif

    @if ($this->hasActiveVT)
        <!-- VT 2024 -->
            <li class="nav-item pb-0">
                <a class="nav-link" href="#active_vt" data-toggle="tab" role="tab" aria-controls="active_vt"
                   title="{{ __('lang.active_courses_vt') }}">
                    {{ __('lang.active_courses_vt') }}
                    <span class="count-label">{{ $activepaginated_vt->total() }}</span>
                </a>
            </li>
    @endif

    @if ($this->hasPreviousHT)
        <!-- HT 2023 -->
            <li class="nav-item pb-0">
                <a class="nav-link" href="#previous_ht" data-toggle="tab" role="tab" aria-controls="previous_ht"
                   title="{{ __('lang.previous_courses_ht') }}">
                    {{ __('lang.previous_courses_ht') }}
                    <span class="count-label">{{ $this->previouspaginated_ht->total() }}</span>
                </a>
            </li>
    @endif

    @if ($this->hasLatest)
        <!-- All Paginated tab -->
            <li class="nav-item pb-0">
                <a class="nav-link" href="#all" data-toggle="tab" role="tab" aria-controls="all"
                   title="{{ __('lang.latest') }}">
                    {{ __('lang.latest') }}
                    <span class="count-label">{{ $this->allpaginated->total() }}
                        @livewire('pending-presentations')
                    </span>
                </a>
            </li>
    @endif

    @if ($this->hasQueued)
        <!-- Incoming Queue tab -->
            <li class="nav-item pb-0">
                <a class="nav-link" href="#queue" data-toggle="tab" role="tab" aria-controls="queue"
                   title="{{ __('lang.queue') }}">
                    {{ __('lang.queue') }}
                    <span class="count-label">{{$pending->count()}}
                        @livewire('pending-presentations')
                    </span>
                </a>
            </li>
        @endif

    </ul>
</div>
