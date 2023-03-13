<div class="container-lg">
    <div class="row">
        <div class="col-lg-12">
            <h2 id="upload">{{__("Upload presentation")}}</h2>
            <span class="su-theme-anchor mb-4"></span>

            <!-- Note -->
            <section class="py-2">
                <div class="container">
                    <div class="col-lg-14 mx-auto">
                        <blockquote class="bg-white p-5 shadow rounded">
                            <div class="shadow-sm" style="background-color: #002f5f"><span style="color: white; padding-left: 10px;">{{__('Note!')}}</span> </div>
                                <ul class="list-unstyled">
                                    <li>
                                        {{__("Lectures and seminars recorded in lecture halls at DSV will be uploaded to DSVPLAY automatically.")}}
                                    </li>
                                    <li>
                                        {{__("If you want to import an existing recording from old play2 (Mediasite) you should contact helpdesk.")}}
                                    </li>
                                    <li>
                                        {{__("Only users with upload privileges (primarily teachers and staff) will be able to use this feature.")}}
                                    </li>
                                </ul>
                        </blockquote>
                    </div>
                </div>
            </section>

            <!-- Upload -->
            <article class="main-article webb2021-article main-column-left js-anchor-links-headers-container col-12 col-lg-8 main-column-padding-right">
                <p>{{__("To upload a recorded presentation, click on MANAGE at the top of the page and choose MANUAL UPLOAD.")}}</p>
                <br>
                @if(App::isLocale('en'))
                    <img class="w-25" src="{{asset('images/manual/upload1.png')}}" alt="Upload form" style="border: 1px solid #000; padding: 0;">
                @else
                    <img class="w-25" src="{{asset('images/manual/upload1_swe.png')}}" alt="Upload form" style="border: 1px solid #000; padding: 0;">
                @endif
                <br><br>
                <p>{{__("In the form that appears next, fill in the fields as preferred:")}}</p>
                <br>
                @if(App::isLocale('en'))
                    <img class="w-75" src="{{asset('images/manual/upload2.png')}}" alt="Upload form" style="border: 1px solid #000; padding: 0;">
                @else
                    <img class="w-75" src="{{asset('images/manual/upload2_swe.png')}}" alt="Upload form" style="border: 1px solid #000; padding: 0;">
                @endif
                <br><br>

                <!-- Accordian -->
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="clearfix mb-0">
                                <a class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fa fa-chevron-circle-down"></i>
                                    {{__('Title')}}</a>
                            </h2>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">{{__("Title (required field): fill in a descriptive title for the presentation")}}</div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h2 class="mb-0">
                                <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><i class="fa fa-chevron-circle-down"></i>
                                    {{__('Recording date')}}</a>
                            </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">{{__("Recording date (required field): date for today is pre-filled, adjust if necessary")}}</div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h2 class="mb-0">
                                <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"><i class="fa fa-chevron-circle-down"></i>
                                    {{__('Description')}}</a>
                            </h2>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                            <div class="card-body">{{__("Description (optional field): add a short description for the presentation if you want")}}</div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingFour">
                            <h2 class="mb-0">
                                <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"><i class="fa fa-chevron-circle-down"></i>
                                    {{__('Course association')}}</a>
                            </h2>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                            <div class="card-body">{{__("Course association (optional field): choose one or more courses to which the presentation is associated from the list. You can write (part of) the course name to find it more easily")}}</div>
                        </div>
                    </div>
                </div>
                <!-- end Accordian -->

            </article>
            <!-- Note -->
            <section class="py-2">
                <div class="container">
                    <div class="col-lg-12 mx-auto">
                        <blockquote class="bg-white p-5 shadow rounded">
                            <div class="shadow-sm" style="background-color: #002f5f"><span style="color: white; padding-left: 10px;">{{__('Note!')}}</span> </div>
                            <ul class="list-unstyled">
                                <li>
                                    {{__("Only courses for which you are authorized to upload presentations are included in the course list. It is the course administrator for each course who can grant you permission to upload presentations.")}}
                                </li>
                            </ul>
                        </blockquote>
                    </div>
                </div>
            </section>
            <div class="accordion" id="accordionPresenters">
                <div class="card">
                    <div class="card-header" id="headingFive">
                        <h2 class="mb-0">
                            <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive"><i class="fa fa-chevron-circle-down"></i>
                                {{__('Presenters')}}</a>
                        </h2>
                    </div>
                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionPresenters">
                        <div class="card-body">{{__("Presenters: fill in the name for the presenter of the presentation. The uploader’s name is filled in by default, additional presenters can be added by clicking the 'add' button. When you start writing the name, suggestions from the SUKAT catalog will appear. Either choose one of the suggested names or write the name if the person is not in the list. Confirm with 'enter'.")}}</div>
                    </div>
                </div>
                <br>
                @if(App::isLocale('en'))
                    <img class="w-75" src="{{asset('images/manual/upload3.png')}}" alt="Upload form" style="border: 1px solid #000; padding: 0;">
                @else
                    <img class="w-75" src="{{asset('images/manual/upload3_swe.png')}}" alt="Upload form" style="border: 1px solid #000; padding: 0;">
                @endif

                <div class="card">
                    <div class="card-header" id="headingSix">
                        <h2 class="mb-0">
                            <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix"><i class="fa fa-chevron-circle-down"></i>
                                {{__('Tags')}}</a>
                        </h2>
                    </div>
                    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionPresenters">
                        <div class="card-body">{{__("Tags: Choose one or more keywords that describe the presentations from the list.")}}</div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingSeven">
                        <h2 class="mb-0">
                            <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven"><i class="fa fa-chevron-circle-down"></i>
                                {{__('Permissions')}}</a>
                        </h2>
                    </div>
                    <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionPresenters">
                        <div class="card-body">{{__("Playback permissions: Choose who is allowed to see and play the presentation from the list. DSV student and staff is selected by default, adjust if necessary.")}}</div>
                    </div>
                </div>
            </div>


            <!-- Note -->
            <section class="py-2">
                <div class="container">
                    <div class="col-lg-12 mx-auto">
                        <blockquote class="bg-white p-5 shadow rounded">
                            <div class="shadow-sm" style="background-color: #002f5f"><span style="color: white; padding-left: 10px;">{{__('Note!')}}</span> </div>
                            <ul class="list-unstyled">
                                <li>
                                    {{__("Public means that anyone, both inside and outside SU can see and watch the presentation. No login is required. This setting should be used if the presentation is to be played by people outside SU.")}}
                                </li>
                            </ul>
                        </blockquote>
                    </div>
                </div>
            </section>

            <article class="main-article webb2021-article main-column-left js-anchor-links-headers-container col-12 col-lg-8 main-column-padding-right">
                <p>{{__("If you want to upload your own image to represent your presentation you can do this in the next section, otherwise one will be generated automatically.")}}</p>
                <br>
                @if(App::isLocale('en'))
                    <img class="w-75" src="{{asset('images/manual/upload4.png')}}" alt="Upload form" style="border: 1px solid #000; padding: 0;">
                @else
                    <img class="w-75" src="{{asset('images/manual/upload4_swe.png')}}" alt="Upload form" style="border: 1px solid #000; padding: 0;">
                @endif

                <br><br>
                <p>{{__("In the following section you can choose the files to upload for the current presentation. Take note of the specification requirements:")}}</p>
                <br>
                @if(App::isLocale('en'))
                    <img class="w-75" src="{{asset('images/manual/upload5.png')}}" alt="Upload form" style="border: 1px solid #000; padding: 0;">
                @else
                    <img class="w-75" src="{{asset('images/manual/upload5_swe.png')}}" alt="Upload form" style="border: 1px solid #000; padding: 0;">
                @endif

                <br><br>
                <ul>
                    <li>
                        {{__("Maximum 4 files, representing the various streams, can be uploaded for each individual presentation. Currently the following formats are allowed:")}}
                    </li>
                    <div class="su-background__light pt-3 mb-4">
                        <br>
                        <p>{{__("MP4 video, MPEG Video, WEBM video, AVI: Audio Video Interleave, Video Quicktime")}}</p>
                        <br>
                    </div>
                    <li>
                        {{__("All files uploaded for one and the same presentation should be equally long.")}}
                    </li>
                    <li>
                        {{__("A thumbnail for each file will be automatically generated and can be regenerated or custom uploaded if necessary in the previous step.")}}
                    </li>
                    <li>
                        {{__("Add a subtitle file for the presentation")}}
                    </li>
                </ul>
                <p>{{__("Click “browse” to choose the files you want to upload. In the window that pops up, select the files and click “open” or drag and drop them into the upload box.")}}</p>
                <p>{{__("In the upload box you will see the automatically generated thumbnails for each of the files. Under each thumbnail the timecode in seconds for the image used for the thumbnail is displayed. To edit, change the timecode to the image you want to use for the thumbnail and click “regenerate”.")}}</p>
                <br>
                <p>{{__("When all files are chosen and thumbnails are finished, confirm by clicking the “upload” button at the bottom. You will receive a confirmation email informing you that the upload is in progress. Once the upload is complete you will receive another email.")}}</p>
                <p>{{__("To keep a check on the status you can click on the icon for the conversion progress queue which you find in the header.")}}</p>
                <br>
                <img class="w-10" src="{{asset('images/manual/upload8.png')}}" alt="Upload form" style="border: 1px solid #000; padding: 0;">
                <br><br>
            </article>

        </div>
    </div>
</div>
