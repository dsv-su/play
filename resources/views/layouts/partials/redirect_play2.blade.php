<section class="global-alert-banner js-banner-type-message p-2 alert alert-info alert-dismissible fade m-0 show" role="dialog" aria-label="Play2">
    <div class="container">
        <div class="row no-gutters">
            <div class="col d-flex align-items-center justify-content-center">
                <div class="webb2021-article p-0 p-lg-2 d-inline-block">
                    <a href="https://play2.dsv.su.se"><i class="fa-solid fa-share-from-square"></i> {{__("If you are missing presentations, click here to reach the old site!")}}</a>
                </div>
                <!--
                <div class="h-100 d-flex align-items-center">
                    <button class="button-remove-style js-alert-banner-dismiss-btn h-100 p-1" type="button" data-dismiss="alert"  aria-label="{{__('Close')}}">
                        <span class="far fa-times-circle" aria-hidden="true"> </span>
                    </button>
                </div>
                -->
            </div>
        </div>
    </div>
    @if (in_array(app()->make('play_role'), ['Administrator', 'Staff', 'Uploader', 'Courseadmin']) && !Request::is('queue'))
    <div class="container mt-1">
        <div class="row no-gutters">
            <div class="col d-flex align-items-center justify-content-center">
                <div class="webb2021-article p-0 p-lg-2 d-inline-block">
                    <a href={{route('mediasite.pending')}}>{{__("Mediasite (Play2) presentations that are currently queued for the import can be found here")}}</a>
                </div>
            <!--
                <div class="h-100 d-flex align-items-center">
                    <button class="button-remove-style js-alert-banner-dismiss-btn h-100 p-1" type="button" data-dismiss="alert"  aria-label="{{__('Close')}}">
                        <span class="far fa-times-circle" aria-hidden="true"> </span>
                    </button>
                </div>
                -->
            </div>
        </div>
    </div>
    @endif
</section>
