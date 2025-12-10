<!-- Existing subtitles -->
<h3 class="mb-4 text-blue-600 font-semibold dark:font-medium dark:text-white">{{__("Existing subtitles files")}}: {{count($subtitles)}}</h3>
<div class="mb-2 flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
    @foreach($subtitles as $key => $subtitle)
        <!-- Body -->
        @if($subtitle)
            <div class="p-4 md:p-5 space-y-7">
                <div>
                    <!-- Existing Files -->

                    <div class="mb-2 flex justify-between items-center">
                        <div class="flex items-center gap-x-3">
                              <span class="inline-block px-2 py-1 text-xs text-blue-600 border border-blue-600 rounded-lg text-center dark:border-neutral-700 dark:text-neutral-500">
                                  <svg class="shrink-0 size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M10.855 14.322a2.475 2.475 0 1 1 .133-4.241m6.053 4.241a2.475 2.475 0 1 1 .133-4.241M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/>
                                  </svg>

                                  {{ strtoupper('Existing') }}
                              </span>
                            <div>
                                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $subtitle }}</p>
                                <p class="text-xs text-gray-500 dark:text-neutral-500">
                                    @if((string)$key === 'Generated')
                                        {{__("Whisper (DSV local)") }}
                                    @else
                                        {{__("Language:")}} | <span class="text-blue-600">{{$key}}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="inline-flex items-center gap-x-2">

                            <button wire:click.prevent="removeExistingFile('{{$key}}')"
                                    type="button"
                                    class="relative text-red-600 hover:text-red-800 focus:outline-none focus:text-red-800 disabled:opacity-50 disabled:pointer-events-none dark:text-red-400 dark:hover:text-red-500 dark:focus:text-red-500">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18"></path>
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                    <line x1="10" x2="10" y1="11" y2="17"></line>
                                    <line x1="14" x2="14" y1="11" y2="17"></line>
                                </svg>
                                <span class="sr-only">{{__("Delete")}}</span>
                            </button>

                            <button wire:click.prevent="downloadExistingFile('{{$key}}')"
                                    type="button"
                                    class="relative text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-400 dark:hover:text-blue-500 dark:focus:text-blue-500 px-4 py-2 text-base">
                                <svg class="shrink-0 size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 13V4"></path>
                                    <path d="M8 14l4 4 4-4"></path>
                                    <path d="M5 20h14"></path>
                                </svg>
                                <span class="sr-only">{{__("Download All")}}</span>
                            </button>
                        </div>
                    </div>

                    <!-- End Uploading File Content -->
                </div>
            </div>
        @else
            {{__("No File")}}
        @endif
            <!-- End Body -->
    @endforeach

</div>
<!-- Uploaded subtitles -->
<h3 class="mb-4 text-blue-600 font-semibold dark:font-medium dark:text-white">{{__("Uploaded subtitles files")}}: {{count($savedfiles)}}</h3>
<!-- File card -->
<div class="mb-2 flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
    @foreach($savedfiles as $key => $pp_file)
            <!-- Body -->
            <div class="p-4 md:p-5 space-y-7">
                <div>
                    <!-- Uploading File Content -->
                    <div class="mb-2 flex justify-between items-center">
                        <div class="flex items-center gap-x-3">
                              <span class="inline-block px-2 py-1 text-xs
                                    @if($pp_file['type'] == 'subtitle') text-green-600
                                    @else text-gray-500
                                    @endif
                                  border
                                    @if($pp_file['type'] == 'subtitle') border-green-600
                                    @else  border-gray-200
                                    @endif

                                  rounded-lg text-center dark:border-neutral-700 dark:text-neutral-500">
                                  <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                      <polyline points="17 8 12 3 7 8"></polyline>
                                      <line x1="12" x2="12" y1="3" y2="15"></line>
                                    </svg>
                                  {{ strtoupper($pp_file['type']) }}
                              </span>
                            <div>
                                <p class="text-sm font-medium text-gray-800 dark:text-white">{{$key}}</p>
                                <p class="text-xs text-gray-500 dark:text-neutral-500">
                                    {{$pp_file['size']}} KB | Date: {{$pp_file['date']}}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-neutral-500">
                                    {{__("Language:")}} {{$uploadedSubLanguage[$loop->index] ?? 'Not set' }}
                                </p>
                            </div>
                        </div>
                        <div class="inline-flex items-center gap-x-2">
                            @if(empty($uploadedSubLanguage[$loop->index]))
                                <!-- Language -->
                            <select wire:model.="sub_language"
                                    wire:change="setLanguagetoSubtitle($event.target.value)"
                                    class="w-40 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm
                                            focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
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


                            <!-- end language -->
                                <button wire:click.prevent="removefile('{{$key}}')"
                                        type="button"
                                        class="relative text-red-600 hover:text-red-800 focus:outline-none focus:text-red-800 disabled:opacity-50 disabled:pointer-events-none dark:text-red-400 dark:hover:text-red-500 dark:focus:text-red-500">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 6h18"></path>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                        <line x1="10" x2="10" y1="11" y2="17"></line>
                                        <line x1="14" x2="14" y1="11" y2="17"></line>
                                    </svg>
                                    <span class="sr-only">Delete</span>
                                </button>

                        </div>
                    </div>
                    <!-- End Uploading File Content -->
                </div>
            </div>
            <!-- End Body -->
    @endforeach

</div>
@if(count($subtitles) < 1)
    @include('livewire.edit.partials.form.autosubtitle-switch')
@endif
<!-- End File Uploading Progress Form -->
@foreach($remove_existing_sub as $key => $sub)
    <input type="hidden" name="remove_existing_sub[{{$key}}]"  value="{{$sub}}" >
@endforeach
@foreach($savedfiles as $key => $sub)
    <input type="hidden" name="add_sub[{{$key}}]"  value="{{$sub['path']}}" >
    <input type="hidden" name="uploadedSubLanguage[{{$loop->index}}]"  value="{{$uploadedSubLanguage[$loop->index] ?? ''}}" >
@endforeach
