<h2 id="lang">{{__("Navigate and Play")}}</h2>
<span class="su-theme-anchor mb-4"></span>
<article class="main-article webb2021-article main-column-left js-anchor-links-headers-container col-12 col-lg-8 main-column-padding-right">
    <p class="lead-light txt-blok-3">{{__("First, there are tabs on the start page to help you find what you are looking for:")}}</p>
    <br>
    @if($role_staff)
        <!-- Staff -->
        @if(App::isLocale('en'))
            <!-- English -->
            <img src="{{asset('images/manual/nav1.png')}}" alt="Play Tabs on landing page">
        @else
            <!-- Swedish -->
            <img src="{{asset('images/manual/nav1swe.png')}}" alt="Play Tabs on landing page">
        @endif
    @else
        <!-- Student -->
        @if(App::isLocale('en'))
            <!-- English -->
            <img src="{{asset('images/manual/nav1s.png')}}" alt="Play Tabs on landing page">
        @else
            <!-- Swedish -->
            <img src="{{asset('images/manual/nav1s_swe.png')}}" alt="Play Tabs on landing page">
        @endif
    @endif
    <br><br>
    <ol class="lead-light txt-blok-3">
        @if($role_staff)
            <li>{{__("My presentations, showing all viewable presentations for courses you are involved in.")}}</li>
        @else
            <li>{{__("My courses, showing all viewable presentations for courses you are enrolled in.")}}</li>
        @endif
            <li>{{__("HT2022, showing all viewable presentations for all currently ongoing courses during this semester at DSV.")}}</li>
            <li>{{__("All presentations, showing all viewable presentations currently available on DSVPLAY.")}}</li>

    </ol>
    <br>
    <p class="lead-light txt-blok-3">{{__("There are different ways of searching for a specific presentation.")}}</p>
    <p class="lead-light txt-blok-3">{{__("At the top of the home page you can find the NAVIGATE menu.")}}</p>
    <br>
    <img src="{{asset('images/manual/nav2.png')}}" alt="Play Navigate menu">
    <br><br>
    <p class="lead-light txt-blok-3">{{__("In the NAVIGATE menu at the top of the page you can find presentations sorted by semester or by course. The navigation menu is tailored for you as a user and shows up to six semesters and courses for which you are registered or involved in.")}}</p>
    <p class="lead-light txt-blok-3">{{__("Click on the semester or course to see all related presentations.")}}</p>
    <br>
    <p class="lead-light txt-blok-3">{{__("Second, you can use the SEARCH function by writing either the presenter, the course, the title of the presentation or keywords (a keyword is a term that defines what your content is about) related to the presentation. You get suggestions for search results organized by courses, tags, presenters and presentations.")}}</p>
    <br>
    <img src="{{asset('images/manual/nav3.png')}}" alt="Play Search suggestions">
    <br><br>
    <p class="lead-light txt-blok-3">{{__("Once you’ve found the presentation you are looking for, click on the matching thumbnail to play it.")}}</p>
    <br>
    <img src="{{asset('images/manual/nav4.png')}}" alt="Play Search results">
    <br><br>
    <p class="lead-light txt-blok-3">{{__("See image below for a description of the different elements of the presentation thumbnail.")}}</p>
    <br>
    <img src="{{asset('images/manual/nav5.png')}}" alt="Play Search results">
    <br><br>
</article>
<br>
<br>
