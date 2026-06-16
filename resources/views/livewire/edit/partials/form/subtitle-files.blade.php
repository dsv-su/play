<div class="space-y-5">
    <div>
        <div class="mb-3 flex items-center justify-between gap-3">
            <h4 class="text-sm font-medium text-slate-900 dark:text-white">{{__("Existing subtitle files")}}</h4>
            <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-xs font-semibold text-slate-700 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300">{{count($subtitles)}}</span>
        </div>

        <div class="space-y-2">
            @forelse($subtitles as $key => $subtitle)
                @if($subtitle)
                    <div class="flex items-start justify-between gap-3 rounded-lg border border-slate-200 bg-white p-3 dark:border-neutral-700 dark:bg-neutral-900">
                        <div class="flex min-w-0 items-start gap-3">
                            <span class="inline-flex size-9 shrink-0 items-center justify-center rounded-lg border border-blue-200 bg-blue-50 text-blue-700 dark:border-blue-900/70 dark:bg-blue-950 dark:text-blue-300">
                                <svg class="size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="M10.855 14.322a2.475 2.475 0 1 1 .133-4.241m6.053 4.241a2.475 2.475 0 1 1 .133-4.241M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-slate-900 dark:text-white">{{ $subtitle }}</p>
                                <p class="text-xs text-slate-500 dark:text-neutral-400">
                                    @if((string)$key === 'Generated')
                                        {{__("Whisper (DSV local)") }}
                                    @else
                                        {{__("Language:")}} <span class="font-medium text-blue-700 dark:text-blue-300">{{$key}}</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="inline-flex shrink-0 items-center gap-1">
                            <button wire:click.prevent="downloadExistingFile('{{$key}}')"
                                    type="button"
                                    class="inline-flex size-9 items-center justify-center rounded-lg text-blue-700 hover:bg-blue-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 dark:text-blue-300 dark:hover:bg-blue-950"
                                    aria-label="{{ __('Download subtitle file') }}">
                                <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 13V4"></path>
                                    <path d="M8 14l4 4 4-4"></path>
                                    <path d="M5 20h14"></path>
                                </svg>
                            </button>

                            <button wire:click.prevent="removeExistingFile('{{$key}}')"
                                    type="button"
                                    class="inline-flex size-9 items-center justify-center rounded-lg text-red-700 hover:bg-red-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 dark:text-red-300 dark:hover:bg-red-950"
                                    aria-label="{{ __('Delete subtitle file') }}">
                                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18"></path>
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                    <line x1="10" x2="10" y1="11" y2="17"></line>
                                    <line x1="14" x2="14" y1="11" y2="17"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                @else
                    <div class="rounded-lg border border-dashed border-slate-300 bg-white px-4 py-3 text-sm text-slate-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-400">{{__("No file")}}</div>
                @endif
            @empty
                <div class="rounded-lg border border-dashed border-slate-300 bg-white px-4 py-3 text-sm text-slate-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-400">{{__("No existing subtitles")}}</div>
            @endforelse
        </div>
    </div>

    <div>
        <div class="mb-3 flex items-center justify-between gap-3">
            <h4 class="text-sm font-medium text-slate-900 dark:text-white">{{__("Uploaded subtitle files")}}</h4>
            <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-xs font-semibold text-slate-700 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300">{{count($savedfiles)}}</span>
        </div>

        <div class="space-y-2">
            @forelse($savedfiles as $key => $pp_file)
                <div class="rounded-lg border border-slate-200 bg-white p-3 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex flex-col gap-3 xl:flex-row xl:items-start xl:justify-between">
                        <div class="flex min-w-0 items-start gap-3">
                            <span class="inline-flex size-9 shrink-0 items-center justify-center rounded-lg border
                                @if($pp_file['type'] == 'subtitle') border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-900/70 dark:bg-emerald-950 dark:text-emerald-300
                                @else border-slate-200 bg-slate-50 text-slate-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-400
                                @endif">
                                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" x2="12" y1="3" y2="15"></line>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-slate-900 dark:text-white">{{$key}}</p>
                                <p class="text-xs text-slate-500 dark:text-neutral-400">{{$pp_file['size']}} KB | {{__("Date:")}} {{$pp_file['date']}}</p>
                                <p class="text-xs text-slate-500 dark:text-neutral-400">{{__("Language:")}} {{$uploadedSubLanguage[$loop->index] ?? __('Not set') }}</p>
                            </div>
                        </div>

                        <div class="flex shrink-0 flex-wrap items-center gap-2">
                            @if(empty($uploadedSubLanguage[$loop->index]))
                                <select wire:model="sub_language"
                                        wire:change="setLanguagetoSubtitle($event.target.value)"
                                        class="w-full rounded-lg border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-950 dark:text-white sm:w-44">
                                    <option value="">-- {{__("Select a language")}} --</option>
                                    <option value="english">{{__("English")}}</option>
                                    <option value="swedish">{{__("Swedish")}}</option>
                                    <option value="danish">{{__("Danish")}}</option>
                                    <option value="dutch">{{__("Dutch")}}</option>
                                    <option value="finnish">{{__("Finnish")}}</option>
                                    <option value="french">{{__("French")}}</option>
                                    <option value="icelandic">{{__("Icelandic")}}</option>
                                    <option value="italian">{{__("Italian")}}</option>
                                    <option value="german">{{__("German")}}</option>
                                    <option value="norwegian">{{__("Norwegian")}}</option>
                                    <option value="spanish">{{__("Spanish")}}</option>
                                </select>
                            @endif

                            <button wire:click.prevent="removefile('{{$key}}')"
                                    type="button"
                                    class="inline-flex size-9 items-center justify-center rounded-lg text-red-700 hover:bg-red-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 dark:text-red-300 dark:hover:bg-red-950"
                                    aria-label="{{ __('Delete uploaded subtitle') }}">
                                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18"></path>
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                    <line x1="10" x2="10" y1="11" y2="17"></line>
                                    <line x1="14" x2="14" y1="11" y2="17"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-lg border border-dashed border-slate-300 bg-white px-4 py-3 text-sm text-slate-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-400">{{__("No uploaded subtitles")}}</div>
            @endforelse
        </div>
    </div>

    @if(count($subtitles) < 1)
        @include('livewire.edit.partials.form.autosubtitle-switch')
    @endif

    @foreach($remove_existing_sub as $key => $sub)
        <input type="hidden" name="remove_existing_sub[{{$key}}]"  value="{{$sub}}" >
    @endforeach
    @foreach($savedfiles as $key => $sub)
        <input type="hidden" name="add_sub[{{$key}}]"  value="{{$sub['path']}}" >
        <input type="hidden" name="uploadedSubLanguage[{{$loop->index}}]"  value="{{$uploadedSubLanguage[$loop->index] ?? ''}}" >
    @endforeach
</div>
