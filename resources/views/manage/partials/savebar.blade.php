<!-- Save bar -->
<style>
    .save-btn:disabled {
        position: relative;
        cursor: not-allowed;
        opacity: 0.7;
    }

    .save-btn:disabled::after {
        content: "";
        position: absolute;
        left: 10%;
        right: 10%;
        top: 50%;
        height: 2px;
        background-color: white; /* or any color */
    }

</style>
<div class="fixed bottom-0 left-0 w-full px-2 z-50 bg-suprimary shadow-md">
    <div class="p-3">
        <div class="flex flex-wrap justify-end">
            <!-- Left section -->
            {{--}}
            <div class="w-full md:w-1/3 md:border-r border-gray-600">
                <div class="flex flex-col items-center">
                    <span class="block" id="bulk">{{ __("Save") }}</span>
                </div>
            </div>
            {{--}}
            <!-- Right section -->
            <div class="w-full md:w-1/3">
                <div class="flex">
                    <!-- Cancel button -->
                    <button type="button"
                            data-tooltip-target="edit-cancel-tooltip"
                            onclick="window.history.back()"
                            class="m-auto px-6 py-3 text-white border border-white rounded-lg text-lg hover:bg-white hover:text-gray-800 transition">
                        {{ __("Cancel") }}
                    </button>
                    <button type="submit"
                            data-tooltip-target="edit-save-tooltip"
                            @if($type == 'edit')
                                form="presentation-edit-Form"
                            @else
                                id="submit"
                                form="presentation-upload-Form"
                                disabled
                            @endif
                            class="save-btn m-auto px-6 py-3 text-white border border-white rounded-lg text-lg hover:bg-white hover:text-gray-800 transition">
                        {{ __("Save") }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="edit-cancel-tooltip" role="tooltip"
     class="absolute z-30 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
     style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);"
     data-popper-placement="top">{{__("Cancel edit")}}
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
<div id="edit-save-tooltip" role="tooltip"
     class="absolute z-30 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
     style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);"
     data-popper-placement="top">{{__("Save presentation")}}
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
