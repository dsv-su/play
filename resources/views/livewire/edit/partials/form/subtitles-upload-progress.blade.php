<!-- Subtitle Uploading Progress Form -->
@if(count($files ?? []))
    <div class="mb-2 flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <!-- Body -->
        <div class="p-4 md:p-5 space-y-7">

            @foreach($files as $file)
                <div>
                    <!-- Uploading File Content -->
                    <div class="mb-2 flex justify-between items-center">
                        <div class="flex items-center gap-x-3">
                          <span class="size-8 flex justify-center items-center border border-gray-200 text-gray-500 rounded-lg dark:border-neutral-700 dark:text-neutral-500">
                            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                              <polyline points="17 8 12 3 7 8"></polyline>
                              <line x1="12" x2="12" y1="3" y2="15"></line>
                            </svg>
                          </span>
                            <div>
                                <p class="text-sm font-medium text-gray-800 dark:text-white">{{$file->getClientOriginalName()}}</p>
                                <p class="text-xs text-gray-500 dark:text-neutral-500">{{round($file->getSize()/1000)}} KB</p>

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
                                        type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-none focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                    <!-- End Uploading File Content -->

                    <!-- Progress Bar -->

                    <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
                        <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500"
                             style="width: 100%">
                        </div>
                    </div>

                    <!-- End Progress Bar -->
                </div>
            @endforeach


        </div>
        <!-- End Body -->

        <!-- Footer -->
        <div class="bg-gray-50 border-t border-gray-200 rounded-b-xl py-2 px-4 md:px-5 dark:bg-white/10 dark:border-neutral-700">
            <div class="flex flex-wrap justify-between items-center gap-x-3">
                <div>
        <span class="text-sm font-semibold text-gray-800 dark:text-white">
            @if($stored)
                {{count($files)}} saved
            @else
                {{count($files)}} to be saved
            @endif
        </span>
                </div>
                <!-- End Col -->
                @if(!$stored)
                    <div class="-me-2.5">
                        {{--}}
                        <button type="button" wire:click.prevent="storefiles"
                                class="text-blue-500 bg-white hover:bg-gray-100 border border-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-100
                                font-medium rounded-lg text-sm px-3 py-1.5 text-center inline-flex items-center dark:focus:ring-blue-800
                                dark:bg-white dark:border-blue-400 dark:text-blue-400 dark:hover:bg-gray-200 me-2 mb-2">
                            <svg class="shrink-0 size-4 dark:text-white"
                                 aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            Save
                        </button>
                        {{--}}
                        <button type="button" wire:click.prevent="storefiles"
                                class="text-blue-600 bg-white hover:bg-gray-100 border border-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-100
                        font-medium rounded-lg text-sm px-3 py-1.5 text-center inline-flex items-center dark:focus:ring-blue-800
                        dark:bg-white dark:border-blue-400 dark:text-blue-400 dark:hover:bg-gray-200 me-2 mb-2">
                            <svg class="flex-shrink-0 size-4 animate-spin dark:text-white"
                                 aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            Save
                        </button>

                    </div>
            @endif
            <!-- End Col -->
            </div>
        </div>
        <!-- End Footer -->
    </div>
    <!-- End File Uploading Progress Form -->
@endif
