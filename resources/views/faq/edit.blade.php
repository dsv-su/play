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
    <div class="su-background__light pt-3 mb-4">
        <div class="su-theme-links-box h-100 d-flex flex-column">
            <div class="su-theme-links-box-header">
                {{__("Note")}}
            </div>
            <ul>
                <br>
                <li>
                    {{__("The Edit and Delete buttons will only appear if you have the authority to do so.")}}
                </li>
                <br>
                <li>
                    {{__("It is the course administrator who sets the authority.")}}
                </li>
                <br>
            </ul>
        </div>
    </div>
    <br>
    <p>{{__("Apart from the settings that were stored during the upload process, there are some extra settings to choose here:")}}</p>
    <ul>
        <li>{{__("Visibility: switch the button 'on' if you want the presentation to be visible and searchable and 'off' if you want it to be hidden and not playable.")}}</li>
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
