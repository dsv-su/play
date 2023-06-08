<div class="container-lg">
    <div class="row">
        <div class="col-lg-12">
            <h2 id="edit">{{__("Edit presentation")}}</h2>
            <span class="su-theme-anchor mb-4"></span>
            <article class="main-article webb2021-article main-column-left js-anchor-links-headers-container col-12 col-lg-8 main-column-padding-right">
                <p>{{__("To edit a presentation, hoover over the matching thumbnail. Buttons will appear in the upper right corner of the thumbnail. Click on the bin-button if you want to delete the presentation. Click on the edit-button to edit the presentation.")}}</p>
                <br>
                @if(App::isLocale('en'))
                    <img class="w-75" src="{{asset('images/manual/edit.png')}}" alt="Edit presentation" style="border: 1px solid #000; padding: 0;">
                @else
                    <img class="w-75" src="{{asset('images/manual/edit_swe.png')}}" alt="Edit presentation" style="border: 1px solid #000; padding: 0;">
                @endif
                <br><br>
                <!-- Note -->
                <section class="py-2">
                    <div class="container">
                        <div class="col-lg-12 mx-auto">
                            <blockquote class="bg-white p-5 shadow rounded">
                                <div class="shadow-sm" style="background-color: #002f5f"><span style="color: white; padding-left: 10px;">{{__('Note!')}}</span> </div>
                                <ul class="list-unstyled">
                                    <li>
                                        {{__("The Edit and Delete buttons will only appear if you have the authority to do so.")}}
                                    </li>
                                    <li>
                                        {{__("It is the course administrator who sets the authority.")}}
                                    </li>
                                </ul>
                            </blockquote>
                        </div>
                    </div>
                </section>

                <br>
                <p>{{__("Apart from the settings that were stored during the upload process, there are some extra settings to choose here:")}}</p>
                <ul>
                    <li>{{__("Visible: When the presentation is set to visible, it is visible in the platform, it can be found via a search and played by users (depending on the rights setting that has been set).")}}</li>
                    <li>{{__("Private: When the presentation is set to private, it is not visible in the platform, it cannot be found via a search and cannot be played by users, only you as the owner can play the presentation.")}}</li>
                    <li>{{__("Unlisted: When the presentation is set to unlisted, it is not visible in the platform, it cannot be found through a search, but it can be played by users who have a direct link to the presentation.")}}</li>
                    <li>{{__("Downloadable: switch the button 'on' if you want users to be able to download the presentation and 'off' if you do not want the presentation to be downloadable.")}}</li>
                </ul>
                <br>
                @if(App::isLocale('en'))
                    <img class="w-75" src="{{asset('images/manual/edit2.png')}}" alt="Edit presentation" style="border: 1px solid #000; padding: 0;">
                @else
                    <img class="w-75" src="{{asset('images/manual/edit2_swe.png')}}" alt="Edit presentation" style="border: 1px solid #000; padding: 0;">
                @endif
                <br><br>
                <p>
                    {{__("At the bottom of the page you will see the different files/streams you uploaded for the presentation.")}}
                    {{__("By switching the buttons for 'audio' you can choose which of the audio streams should be used for the entire presentation.")}}
                    <b>{{__("Only one audio stream ")}}</b>{{__("can be chosen.")}}
                    {{__("By default the audio with the best sound quality will be selected.")}}
                    {{__("The buttons called 'hidden' can be used to hide streams that should not be visible.")}}
                </p>
                <br>
                @if(App::isLocale('en'))
                    <img class="w-75" src="{{asset('images/manual/edit3.png')}}" alt="Edit presentation" style="border: 1px solid #000; padding: 0;">
                @else
                    <img class="w-75" src="{{asset('images/manual/edit3_swe.png')}}" alt="Edit presentation" style="border: 1px solid #000; padding: 0;">
                @endif
                <br><br>
                <p>{{__("Save your settings and edits by clicking the 'save' button on the bottom of the page.")}}</p>
            </article>

        </div>
    </div>
</div>
