<div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-neutral-800 dark:bg-neutral-950">
        <div class="border-b border-gray-200 bg-gray-50/70 px-5 py-5 dark:border-neutral-800 dark:bg-neutral-900/60 sm:px-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-blue-700 dark:text-blue-400">{{ __('Step 1') }}</p>
                    <h1 class="mt-1 text-xl font-semibold text-gray-950 dark:text-white">{{ $editingId ? __('Edit channel') : __('Create a channel') }}</h1>
                    <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">{{ __('Set up the channel first, then add presentations.') }}</p>
                </div>
                @if($editingId)
                    <button type="button" wire:click="cancel" class="w-fit rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-neutral-700 dark:bg-neutral-950 dark:text-neutral-200">{{ __('Create another channel') }}</button>
                @endif
            </div>
            @if(session('status'))<div class="mt-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-900 dark:bg-green-950 dark:text-green-200">{{ session('status') }}</div>@endif
        </div>

        <form wire:submit="save" class="grid gap-5 p-5 sm:grid-cols-[minmax(0,1fr)_auto] sm:items-end sm:p-6">
            <div>
                <label for="channel-name" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">{{ __('Channel name') }}</label>
                <input id="channel-name" wire:model="name" type="text" class="mt-1.5 w-full rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white" required>
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                <label class="mt-4 flex items-center gap-3 text-sm text-gray-700 dark:text-neutral-300"><input wire:model="showOnHomepage" type="checkbox" class="rounded border-gray-300"><span>{{ __('Show this channel as a carousel') }}</span></label>
            </div>
            <button type="submit" class="inline-flex justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">{{ $editingId ? __('Save changes') : __('Create channel') }}</button>
        </form>

        <div class="border-t border-gray-200 px-5 py-5 dark:border-neutral-800 sm:px-6">
            <h2 class="text-sm font-semibold text-gray-900 dark:text-white">{{ __('Your channels') }}</h2>
            <div class="mt-3 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($channels as $channel)
                    <button type="button" wire:click="edit({{ $channel->id }})" wire:key="channel-{{ $channel->id }}" class="rounded-xl border p-4 text-left transition {{ $editingId === $channel->id ? 'border-blue-500 bg-blue-50 ring-2 ring-blue-500/20 dark:bg-blue-950/40' : 'border-gray-200 hover:border-blue-300 hover:bg-gray-50 dark:border-neutral-800 dark:hover:bg-neutral-900' }}">
                        <span class="flex items-start justify-between gap-2"><span class="truncate text-sm font-semibold text-gray-950 dark:text-white">{{ $channel->name }}</span><span class="rounded-full bg-white px-2 py-0.5 text-xs font-semibold text-gray-500 ring-1 ring-gray-200 dark:bg-neutral-950 dark:ring-neutral-700">{{ $channel->presentations_count }}</span></span>
                        <span class="mt-1 block truncate text-xs text-gray-500 dark:text-neutral-400">{{ $channel->show_on_homepage ? __('Shown on start page') : __('Hidden from start page') }}@if($isAdministrator) · {{ $channel->created_by }}@endif</span>
                    </button>
                @empty
                    <p class="col-span-full rounded-xl border border-dashed border-gray-300 px-4 py-8 text-center text-sm text-gray-500 dark:border-neutral-700">{{ __('No channels have been created yet.') }}</p>
                @endforelse
            </div>
        </div>
    </section>

    @if($editingChannel)
        <section class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-neutral-800 dark:bg-neutral-950">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-blue-700 dark:text-blue-400">{{ __('Step 2') }}</p>
                    <h2 class="mt-1 text-lg font-semibold text-gray-950 dark:text-white">{{ __('Add presentations to :channel', ['channel' => $editingChannel->name]) }}</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">{{ __('Add presentations you own or have individual permission to edit. Channel membership does not change their category.') }}</p>
                </div>
                <div class="flex shrink-0 flex-col items-stretch gap-2 sm:items-end">
                    <span class="self-end rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-950 dark:text-blue-300">{{ trans_choice(':count presentation|:count presentations', $assignedVideos->count(), ['count' => $assignedVideos->count()]) }}</span>
                    <a href="{{ route('channels.show', $editingChannel) }}" target="_blank" rel="noopener" class="inline-flex min-w-36 items-center justify-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-neutral-700 dark:bg-neutral-950 dark:text-neutral-200 dark:hover:bg-neutral-900">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M14 3h7v7"/><path d="m10 14 11-11"/><path d="M21 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5"/></svg>
                        {{ __('Open channel') }}
                    </a>
                    <button type="button" x-data="{ copied: false, url: @js(route('channels.show', $editingChannel)) }" @click="navigator.clipboard.writeText(url).then(() => { copied = true; setTimeout(() => copied = false, 2000) })" class="inline-flex min-w-36 items-center justify-center gap-1.5 rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-neutral-200" aria-label="{{ __('Copy channel link') }}">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="9" y="9" width="12" height="12" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                        <span x-text="copied ? @js(__('Copied!')) : @js(__('Share link'))">{{ __('Share link') }}</span>
                    </button>
                    <button type="button"
                            wire:click="deleteChannel({{ $editingChannel->id }})"
                            wire:confirm="{{ __('Delete this channel and remove all presentation assignments? This cannot be undone.') }}"
                            wire:loading.attr="disabled"
                            wire:target="deleteChannel({{ $editingChannel->id }})"
                            class="inline-flex min-w-36 items-center justify-center gap-1.5 rounded-lg border border-red-300 bg-white px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50 disabled:opacity-50 dark:border-red-900 dark:bg-neutral-950 dark:text-red-300 dark:hover:bg-red-950">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v5M14 11v5"/></svg>
                        {{ __('Delete channel') }}
                    </button>
                </div>
            </div>

            <div class="mt-5 grid gap-6 lg:grid-cols-2">
                <div class="min-w-0 rounded-xl border border-gray-200 dark:border-neutral-800">
                    <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 dark:border-neutral-800 dark:bg-neutral-900">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ __('In this channel') }}</h3>
                    </div>
                    <div class="max-h-[32rem] divide-y divide-gray-200 overflow-y-auto dark:divide-neutral-800">
                        @forelse($assignedVideos as $video)
                            <div class="flex items-center justify-between gap-3 px-4 py-3" wire:key="assigned-video-{{ $video->id }}">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-medium text-gray-900 dark:text-white">{{ $video->title }}</p>
                                    <p class="mt-0.5 text-xs text-gray-500 dark:text-neutral-400">{{ $video->getCreationDate() ?: __('No date') }}</p>
                                </div>
                                @if($manageableVideoIds->has($video->id))
                                    <button type="button" wire:click="removeVideo('{{ $video->id }}')" wire:loading.attr="disabled" wire:target="removeVideo('{{ $video->id }}')" class="shrink-0 rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50 disabled:opacity-50 dark:border-red-900 dark:text-red-300 dark:hover:bg-red-950">{{ __('Remove') }}</button>
                                @else
                                    <span class="shrink-0 text-xs text-gray-400" title="{{ __('You do not have permission to edit this presentation.') }}">{{ __('No edit access') }}</span>
                                @endif
                            </div>
                        @empty
                            <p class="px-4 py-10 text-center text-sm text-gray-500 dark:text-neutral-400">{{ __('This channel has no presentations yet.') }}</p>
                        @endforelse
                    </div>
                </div>

                <div class="min-w-0 rounded-xl border border-gray-200 dark:border-neutral-800">
                    <div class="border-b border-gray-200 bg-gray-50 p-3 dark:border-neutral-800 dark:bg-neutral-900">
                        <label for="video-search" class="sr-only">{{ __('Search presentations') }}</label>
                        <div class="relative">
                            <svg class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
                            <input id="video-search" type="search" wire:model.live.debounce.300ms="videoSearch" placeholder="{{ __('Search your editable presentations…') }}" class="w-full rounded-lg border-gray-300 py-2 pl-9 pr-3 text-sm dark:border-neutral-700 dark:bg-neutral-950 dark:text-white">
                        </div>
                    </div>
                    <div class="max-h-[32rem] overflow-y-auto" wire:loading.class="opacity-60" wire:target="videoSearch">
                        @forelse($availableVideosByCourse as $courseKey => $group)
                            <section wire:key="available-course-{{ $courseKey }}" class="border-b border-gray-200 last:border-b-0 dark:border-neutral-800">
                                <div class="sticky top-0 z-[1] flex items-center justify-between gap-3 border-b border-gray-100 bg-gray-50/95 px-4 py-2.5 backdrop-blur dark:border-neutral-800 dark:bg-neutral-900/95">
                                    <h4 class="truncate text-xs font-semibold uppercase tracking-wide text-gray-600 dark:text-neutral-300">{{ $group['label'] }}</h4>
                                    <span class="shrink-0 text-xs text-gray-400">{{ $group['videos']->count() }}</span>
                                </div>
                                <div class="divide-y divide-gray-100 dark:divide-neutral-800">
                                    @foreach($group['videos'] as $video)
                                        <div class="flex items-center justify-between gap-3 px-4 py-3" wire:key="available-video-{{ $courseKey }}-{{ $video->id }}">
                                            <div class="min-w-0">
                                                <p class="truncate text-sm font-medium text-gray-900 dark:text-white">{{ $video->title }}</p>
                                                <p class="mt-0.5 text-xs text-gray-500 dark:text-neutral-400">{{ $video->getCreationDate() ?: __('No date') }}</p>
                                            </div>
                                            <button type="button" wire:click="addVideo('{{ $video->id }}')" wire:loading.attr="disabled" wire:target="addVideo('{{ $video->id }}')" class="shrink-0 rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-700 disabled:opacity-50">{{ __('Add') }}</button>
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        @empty
                            <p class="px-4 py-10 text-center text-sm text-gray-500 dark:text-neutral-400">{{ $videoSearch !== '' ? __('No matching presentations found.') : __('No presentations are available to add.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>
