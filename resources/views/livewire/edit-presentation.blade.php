<div>

    <style>
        .datepicker {
            padding: 8px 15px;
            border-radius: 5px !important;
            margin: 5px 0px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            font-size: 18px !important;
            font-weight: 300
        }
    </style>
    <div class="container px-1 py-5 mx-auto">
        <div class="w-7/12 mx-2 rounded  p-2">
            <div class="row">
                <div class="col-sm-10"><h1>{{ __("Edit presentation") }} - Work in progress</h1></div>
            </div>
            <form>
            <div class="row">

                <div class="col-sm-8">

                        <div class="rounded border shadow p-3 my-2">
                            <label class="blue-text form-control-label px-3">{{ __("Presentation") }}</label>
                            <p>
                                {{ __("Title of the presentation and the date of recording.") }}
                            </p>
                            <!-- Title -->
                            <div class="row justify-content-between text-left">
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">{{ __("Title") }}<span class="text-danger"> *</span></label>
                                    <input  wire:model="title"  name="title" type="text">
                                    <div>
                                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <!-- CreationDate -->
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">{{ __("Original Recording date") }}<span class="text-danger"> *</span></label>
                                    <input id="creationdate" class="datepicker" wire:model="date" type="text" autocomplete="off" data-provide="datepicker" data-date-autoclose="true" data-date-today-highlight="true">
                                    <div><small class="text-danger">{{ $errors->first('created') }}</small></div>
                                </div>
                            </div>
                            <!-- Presenters -->
                            <div class="row justify-content-between text-left">
                                <div class="form-group col-sm-6 flex-column d-flex">
                                    @if(count($presenters) == 0) <label class="form-control-label px-3">{{ __("No registered presenters") }}</label>
                                    @else
                                        <label class="form-control-label px-3">{{ __("Presenter") }}</label>
                                        @foreach($presenters as $key => $name)
                                            <div class="d-inline">
                                                <input  type="text" wire:model="presenters.{{$key}}">
                                                <a class="absolute cursor-pointer top-2 right-2 text-gray-500" wire:click="remove_presenter({{$key}})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </a>
                                            </div>

                                        @endforeach
                                    @endif
                                </div>

                            </div>

                            <div class="row justify-content-between text-left">
                                <div class="form-group col-sm-6 flex-column d-flex"><label class="form-control-label px-3">{{ __("Add presenters") }}</label>
                                    <button type="button" wire:click.prevent="presenteradd" class="btn btn-outline-primary btn-sm presenteradd">{{ __("Presenter") }} <i class="fas fa-user-plus"></i></button>
                                </div>
                            </div>
                            <!-- Course -->
                            <div class="row justify-content-between text-left">
                                <div class="form-group col-sm-12 flex-column d-flex">
                                    <label class="form-control-label px-3">{{ __("Associated course") }}</label>
                                    <div class="d-inline">
                                        <input  type="text" wire:model="course" placeholder="{{ $course }}"type="search" autocomplete="off" aria-haspopup="true" aria-labelledby="course">
                                        <a class="absolute cursor-pointer top-2 right-2 text-gray-500" wire:click="remove_course">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Test -->
                            <div wire:ignore>
                                <select class="form-control" id="select2">
                                    <option value="">Choose Song</option>
                                    @foreach($songs as $data)
                                        <option value="{{ $data }}">{{ $data }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- end Test -->

                            <!-- Save -->
                            <div class="row justify-content-end">
                                <div class="form-group col-sm-4"> <button wire:click.prevent="video" class="btn-block btn btn-outline-primary">{{ __("Update") }}</button> </div>
                            </div>


                        </div>

                </div>
                <div class="col-sm-4">
                    <div class="rounded border shadow p-3 my-2">
                        <div class="flex justify-center">
                            <img src="{{$thumb}}?{{ rand() }}" width="90%">
                        </div>
                    </div>
                    <div class="rounded border shadow p-3 my-2">
                        <div class="flex justify-center small">
                            <table>
                                <tr><th>Origin:</th><td>@if($origin == 'mediasite') Migrated from Mediasite
                                                        @elseif($origin == 'cattura') Recorded at DSV
                                                        @elseif($origin == 'manual') Uploaded by user
                                                        @endif
                                                    </td></tr>
                                <tr><th>Recording date:</th><td>{{$date}}</td></tr>
                                <tr><th>Duration:</th><td>{{$duration}}</td></tr>
                                <tr><th>@if(empty($course))
                                            Not associated to a course
                                        @else
                                        Associated to course:
                                        @endif
                                    </th><td>{{$course}}</td></tr>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
            </form>
        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            language: 'sv',
            weekStart: 1,
            todayHighlight: true
        });

        $('#select2').select2();
        $('#select2').on('change', function (e) {
            var item = $('#select2').select2("val");
        @this.set('viralSongs', item);
        });


    });


</script>
