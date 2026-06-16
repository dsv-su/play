<!-- Subtitle Uploading Progress Form -->
@if(count($files ?? []))
    <div class="mb-4 flex flex-col rounded-lg border border-slate-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
        <div class="space-y-4 p-4">

            @foreach($files as $file)
                <div>
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-x-3">
                          <span class="flex size-9 items-center justify-center rounded-lg border border-blue-200 bg-blue-50 text-blue-700 dark:border-blue-900/70 dark:bg-blue-950 dark:text-blue-300">
                            <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                              <polyline points="17 8 12 3 7 8"></polyline>
                              <line x1="12" x2="12" y1="3" y2="15"></line>
                            </svg>
                          </span>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-slate-900 dark:text-white">{{$file->getClientOriginalName()}}</p>
                                <p class="text-xs text-slate-500 dark:text-neutral-400">{{round($file->getSize()/1000)}} KB</p>

                            </div>
                        </div>
                        <div class="inline-flex items-center gap-x-2">
                            @if($stored)
                                <span class="relative">
                                    <svg class="shrink-0 size-4 text-teal-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
                                    </svg>
                                    <span class="sr-only">Success</span>
                              </span>
                            @else
                                <button @click="removeUpload('{{$file->getFilename()}}')"
                                        type="button" class="inline-flex size-9 items-center justify-center rounded-lg text-red-700 hover:bg-red-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 disabled:pointer-events-none disabled:opacity-50 dark:text-red-300 dark:hover:bg-red-950">
                                    <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 6h18"></path>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                        <line x1="10" x2="10" y1="11" y2="17"></line>
                                        <line x1="14" x2="14" y1="11" y2="17"></line>
                                    </svg>
                                    <span class="sr-only">Delete</span>
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="flex h-2 w-full overflow-hidden rounded-full bg-slate-200 dark:bg-neutral-700" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
                        <div class="flex flex-col justify-center overflow-hidden rounded-full bg-blue-600 text-center text-xs text-white transition duration-500 dark:bg-blue-500"
                             style="width: 100%">
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
        <div class="rounded-b-lg border-t border-slate-200 bg-slate-50 px-4 py-3 dark:border-neutral-700 dark:bg-neutral-950">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
        <span class="text-sm font-semibold text-slate-900 dark:text-white">
            @if($stored)
                {{count($files)}} {{__("saved")}}
            @else
                {{count($files)}} {{__("to be saved")}}
            @endif
        </span>
                </div>
                @if(!$stored)
                    <div>
                        <button type="button" wire:click.prevent="storefiles"
                                class="inline-flex items-center gap-2 rounded-lg border border-blue-600 bg-white px-3 py-2 text-sm font-semibold text-blue-700 hover:bg-blue-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 dark:border-blue-500 dark:bg-neutral-900 dark:text-blue-300 dark:hover:bg-blue-950">
                            <svg class="size-4 shrink-0 animate-spin"
                                 aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            {{__("Save")}}
                        </button>

                    </div>
            @endif
            </div>
        </div>
    </div>
@endif
