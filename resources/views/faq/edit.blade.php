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
                <h3>{{__("Add or generate subtitles for the presentation")}}</h3>
                <p>{{__("You can automatically generate subtitles for your presentation by switching the toggle switch on. Subtitles will be generated with Whisper released by OpenAI, an automatic speech recognition system to generate subtitles. If you would rather upload your own subtitle file, you can leave the toggle switch off and upload the subtitle file in the box.")}}</p>
                <br>
                <h4>{{__("Download a transcribed subtitle file")}}</h4>
                <p>{{__("In the first section besides ‘subtitles’ there will appear a button for downloading the transcribed subtitle file. Click on the button to download the transcribed subtitle file.")}}</p>
                <br>
                <img class="w-75" src="{{asset('images/manual/subtitlefile.png')}}" alt="Edit presentation" style="border: 1px solid #000; padding: 0;">
                <br><br>
                <p>{{__("The transcribed file will download and you can now edit it.")}}</p>
                <br>
                <h4>{{__("Delete a transcribed subtitle file")}}</h4>
                <p>{{__("To remove a transcribed file from the presentation, click on the delete icon and then save the change")}}</p>
                <br><br>
                <h4>{{__("Upload an edited subtitle file")}}</h4>
                <p>{{__("Upload an edited subtitle file by dropping it in the upload box along the bottom of the edit view. Also select language.")}}</p>
                <br>
                <img class="w-75" src="{{asset('images/manual/editsubtitle.png')}}" alt="Edit presentation" style="border: 1px solid #000; padding: 0;">
                <br><br>
                <h4>{{__("How to edit an existing subtitle")}}</h4>
                <p>{{__("If you want to edit existing subtitles from a presentation, hoover over the presentation’s thumbnail. Buttons will appear in the upper right corner of the thumbnail.")}}</p>
                <p>{{__("Click on the edit-button to edit the presentation.")}}</p>
                <p>{{__("In the first section besides ‘subtitles’ there will appear a button for downloading the transcribed subtitle file. Click on the button to download the transcribed subtitle file.")}}</p>
                <p>{{__("You can now edit the text, make sure you only edit the text, do not change the time codes in the file. The file will contain the transcript of the audio track as well as the time codes that sync the captions to the presentation.")}}</p>
                <p>{{__("Once you have edited the transcribed file (make sure the saved file has the .vtt suffix), you can upload the edited transcribed file in the upload box in the edit-page of the presentation. Don’t forget to click on the ‘Save’ button. The process of replacing the transcribed file begins. Once it is done you will receive and email.")}}</p>
                <br><br>
                <p><strong>{{__("Save your settings and edits by clicking the 'save' button on the bottom of the page.")}}</strong></p>
            </article>

        </div>
    </div>
</div>
