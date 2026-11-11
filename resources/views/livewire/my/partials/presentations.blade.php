@php
    $bulkForm = 'library-bulk-'.$courseId;
    $bulkEnabled = $allowBulkEdit && in_array((string) app('play_role'), ['Administrator', 'Courseadmin', 'Staff']);
@endphp
<div x-data="{ selectedVideos: [], allIds: @js($group->filter(fn ($video) => $video->edit && $video->state)->pluck('id')->map(fn ($id) => (string) $id)->values()) }">
    @if($bulkEnabled)
        <form id="{{ $bulkForm }}" method="post" action="{{ route('bulk.edit') }}" class="library-bulk">
            @csrf
            <button type="button" class="library-button" @click="selectedVideos = selectedVideos.length === allIds.length ? [] : [...allIds]">{{ __('Toggle selection on this page') }}</button>
            <button type="submit" class="library-button library-button-primary" :disabled="selectedVideos.length === 0">{{ __('Edit selected') }} <span x-text="selectedVideos.length" aria-hidden="true"></span></button>
            <span role="status" class="library-selection" x-text="@js(__(':count selected')).replace(':count', selectedVideos.length)"></span>
        </form>
    @endif
    <div class="library-recordings {{ $switchOn ? 'library-recordings-grid' : '' }}">
        @foreach($group as $video)
            <article class="library-recording" wire:key="library-video-{{ $courseId }}-{{ $video->id }}">
                <div class="library-recording-image">
                    <img src="{{ asset($video->thumb) }}" alt="" loading="lazy" decoding="async" width="480" height="270">
                    <span class="library-duration">{{ $video->duration }}</span>
                </div>
                <div class="library-recording-body">
                    <div class="library-recording-topline">
                        <span class="library-date">{{ $video->creation ? \Illuminate\Support\Carbon::createFromTimestamp((int) $video->creation)->locale(app()->getLocale())->translatedFormat('j F Y') : '' }}</span>
                        @if($video->edit && $video->state && $bulkEnabled)
                            <label class="library-select">
                                <input type="checkbox" form="{{ $bulkForm }}" name="videos[]" value="{{ $video->id }}" x-model="selectedVideos">
                                <span class="sr-only">{{ __('Select :title', ['title' => $video->LangTitle]) }}</span>
                            </label>
                        @endif
                    </div>
                    <h4><a href="{{ route('player.show', ['video' => $video]) }}">{{ $video->LangTitle }}</a></h4>
                    <div class="library-metadata">
                        @include('home.partials.courses')
                        @include('home.partials.presenters')
                        @include('livewire.search.partials.tag-table')
                        @include('home.partials.studyadmin')
                    </div>
                    <div class="library-recording-footer">
                        <div class="library-permissions">@include('home.partials.permission-buttons')</div>
                        <div class="library-actions">@include('livewire.search.partials.edit-tabel')</div>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
    @include('partials.download-poller-script')
</div>
