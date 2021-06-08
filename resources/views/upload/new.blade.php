@extends('layouts.suplay_upload')
@section('content')

        @livewire('file-upload', [
        'presentation' => $presentation,
        'permissions' => $permissions
        ])

        <!-- Modal spinners -->
        <div class="modal fade" id="load" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="loader"></div>
                        <div class="loader-txt">
                            <p>{{ __("Work in progress") }} <br><br><small>{{ __("The media files are checked") }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="loadtoserver" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="loader"></div>
                        <div class="loader-txt">
                            <p>{{ __("Upload in progress") }} <br><br><small>{{ __("Storing media on play-store") }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<script src="{{ asset('./js/upload2.js') }}"></script>
<!-- Typeahead.js Bundle -->
<script src="{{ asset('./js/typeahead/typeahead.bundle.js') }}"></script>

@endsection
