<div>
    <style>
        .modal-content {
            border-radius: 1rem
        }

        .modal-content:hover {
            box-shadow: 2px 2px 2px black
        }
    </style>
    <div class="modal fade show" id="loadModal"
         style="display:block;"
         tabindex="-1"
         role="dialog"
         aria-labelledby="loadModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content py-md-5 px-md-4 p-sm-3 p-4">

                <div class="modal-body">
                    <div class="modal-body text-center">
                        <div class="loader"></div>
                        <div class="loader-txt">
                            <p>{{ __("Loading - please wait") }}<br></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Backdrop / overlay -->
    <div class="modal-backdrop fade show" id="backdrop" style="display: block;"></div>
</div>
