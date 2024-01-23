<style>
    .whisper-cursor {
        margin-left: 5px;
        animation: blink 1s infinite;
    }
    @keyframes blink {
        0%, 50% {
            opacity: 1;
        }
        50.1%, 100% {
            opacity: 0;
        }
    }
</style>
<section class="global-alert-banner js-banner-type-message p-2 alert alert-info alert-dismissible fade m-0 show"
         role="dialog" aria-label="Play2">
    <div class="container">
        <div class="row no-gutters">
            <div class="col d-flex align-items-center justify-content-center">
                <div id="whisper" class="webb2021-article p-0 p-lg-2 d-inline-block">
                    {{--}}
                    {{__("Operational disruption: We have temporarily turned off the ability to generate subtitles.")}}
                    {{--}}
                </div>
                {{--}}
                <div class="h-100 d-flex align-items-center">
                    <button class="button-remove-style js-alert-banner-dismiss-btn h-100 p-1" type="button" data-dismiss="alert"  aria-label="{{__('Close')}}">
                        <span class="far fa-times-circle" aria-hidden="true"> </span>
                    </button>
                </div>
                {{--}}
            </div>
        </div>
    </div>
    {{--}}
    @if (in_array(app()->make('play_role'), ['Administrator', 'Staff', 'Uploader', 'Courseadmin']) && !Request::is('queue'))
        <div class="container mt-1">
            <div class="row no-gutters">
                <div class="col d-flex align-items-center justify-content-center">
                    <div class="webb2021-article p-0 p-lg-2 d-inline-block">
                        <a href={{route('conversion.queue')}}>{{__("Recordings that are currently queued for the conversion can be found here")}}</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{--}}
</section>

@include('home.partials.whisper_instructions')

<script>
    const text = "Shyssss....Whisper is activated...Read more";

    const whisper = document.getElementById('whisper');
    let index = 0;
    function type() {
        if (index < text.length) {
            whisper.innerHTML = text.slice(0, index) + '<span class="whisper-cursor"><i class="fa-solid fa-circle"></i></span>';
            index++;
            setTimeout(type, Math.random() * 100);
        } else {
            whisper.innerHTML = text.slice(0, index) + '<a role="button" data-toggle="modal" data-target="#form"> <i class="fa-solid fa-arrow-right"></i>' + '</a>';
            //whisper.innerHTML = text.slice(0, index);
        }
    }
    // start typing
    type();
</script>
