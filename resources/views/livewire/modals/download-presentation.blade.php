<div>
    <style>
        .modal-content {
            border-radius: 1rem
        }

        .modal-content:hover {
            box-shadow: 2px 2px 2px black
        }
    </style>
    <div class="modal fade @if($show === true) show @endif" id="downloadModal"
         @if($show === true)
            style="display:block;"
         @else
            style="display:none;"
         @endif
         tabindex="-1"
         role="dialog"
         aria-labelledby="downloadModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content py-md-5 px-md-4 p-sm-3 p-4">
                <div class="modal-header">
                    <h4 class="modal-title" id="downloadModalLabel">{{$title}}</h4>
                    <button class="close" type="button" aria-label="Close" wire:click.prevent="doClose()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-body text-center">
                        <div class="loader"></div>
                        <div class="loader-txt">
                            <p>{{__("Download in progress")}}<br></p>
                        </div>
                    </div>
                    <br>
                    {{--}}<div class="text-center">{{$status}}</div>{{--}}
                </div>
                {{--}}<div class="text-center mb-3"><small>{{__('Close to download in background')}}</small></div>{{--}}
                <div class="modal-footer">
                    <button class="btn btn-outline-primary btn-sm" type="button" wire:click.prevent="doClose()">{{__('Close')}}</button>
                </div>
            </div>
        </div>

    </div>
    <!-- Backdrop / overlay -->
    <div class="modal-backdrop fade show" id="backdrop" style="display: @if($show === true)
             block
         @else
             none
         @endif;"></div>
</div>
