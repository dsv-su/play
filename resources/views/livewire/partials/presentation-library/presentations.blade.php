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
                    @if($video->relationLoaded('channels') && $video->channels->isNotEmpty())
                        <div class="library-channel-badges" role="group" aria-label="{{ __('Channels') }}">
                            <span class="library-channel-label">{{ __('Channels') }}:</span>
                            @foreach($video->channels as $connectedChannel)
                                <a class="library-channel-badge" href="{{ route('channels.show', $connectedChannel) }}">
                                    <svg aria-hidden="true" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 4 4L19 6"/></svg>
                                    {{ $connectedChannel->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                    <div class="library-recording-footer">
                        <div class="library-permissions">@include('home.partials.permission-buttons')</div>
                        <div class="library-actions">
                            @include('livewire.search.partials.edit-tabel')
                            @if(isset($customChannels) && $customChannels->isNotEmpty() && $channelAddableVideoIds->has($video->id))
                                <div class="library-channel-action" x-data="{ open: false, channelId: '' }">
                                    <button type="button" class="library-button library-channel-button" @click="open = !open" :aria-expanded="open" aria-controls="channel-picker-{{ $courseId }}-{{ $video->id }}">
                                        <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h6l2 2h10v11H3Z"/><path d="M15 12v5m-2.5-2.5h5"/></svg>
                                        {{ __('Add to channel') }}
                                    </button>
                                    <form id="channel-picker-{{ $courseId }}-{{ $video->id }}" x-show="open" x-cloak
                                          x-on:submit.prevent="await $wire.addToChannel(@js((string) $video->id), channelId); open = false; channelId = ''">
                                        <label for="channel-select-{{ $courseId }}-{{ $video->id }}" class="sr-only">{{ __('Choose a channel') }}</label>
                                        <select id="channel-select-{{ $courseId }}-{{ $video->id }}" x-model="channelId" required class="library-button library-channel-select">
                                            <option value="">{{ __('Choose a channel') }}</option>
                                            @foreach($customChannels as $customChannel)
                                                @php($alreadyConnected = $video->channels->contains('id', $customChannel->id))
                                                <option value="{{ $customChannel->id }}" @disabled($alreadyConnected)>{{ $customChannel->name }}{{ $alreadyConnected ? ' — '.__('Already added') : '' }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="library-button library-button-primary library-channel-button" :disabled="!channelId" wire:loading.attr="disabled" wire:target="addToChannel">{{ __('Add') }}</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
    @include('partials.download-poller-script')
</div>
