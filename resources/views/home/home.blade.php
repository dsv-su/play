@extends('layouts.suplay')
@section('content')

    <div id="top-spacer" style="height: 110px;"></div>
    <header aria-label="Sidhuvud" id="main-header" class="su-header-container__primary fixed-top">

        <!-- Navigation -->
        <div class="container d-flex h-100">

            <div class="header-logo d-flex justify-content-center">
                <a href="{{route('home')}}" class="text-decoration-none logo d-sm-flex align-items-center">
                    <div class="text-uppercase">DSVPlay&nbsp;</div>
                    <div class="svglogo">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve">
                                <g>
                                    <path fill="#fff" d="M45.563,29.174l-22-15c-0.307-0.208-0.703-0.231-1.031-0.058C22.205,14.289,22,14.629,22,15v30
                                        c0,0.371,0.205,0.711,0.533,0.884C22.679,45.962,22.84,46,23,46c0.197,0,0.394-0.059,0.563-0.174l22-15
                                        C45.836,30.64,46,30.331,46,30S45.836,29.36,45.563,29.174z M24,43.107V16.893L43.225,30L24,43.107z"/>
                                    <path fill="#fff" d="M30,0C13.458,0,0,13.458,0,30s13.458,30,30,30s30-13.458,30-30S46.542,0,30,0z M30,58C14.561,58,2,45.439,2,30
                                        S14.561,2,30,2s28,12.561,28,28S45.439,58,30,58z"/>
                                </g>
                            </svg>
                    </div>
                </a>
            </div>

            <nav class="d-none d-xl-flex main-menu mega-menu__primary transition" aria-hidden="true">
                <ul class="nav not-list-styled">
                    <li class="nav-item mega-menu-item" style="">
                        <div class="position-relative">
                            <a class="text-uppercase nav-link mega-menu-link level-1" aria-haspopup="true"
                               aria-expanded="false" href="#">
                                Catalogue
                            </a>
                        </div>
                        <div class="mega-menu-collapse">
                            <div class="container">
                                <ul class="list-unstyled row no-gutters">
                                    <li class="mega-menu-collapse-col col">
                                        <div class="container pl-0 pr-0">
                                            <a class="nav-link d-flex align-items-center nav-link__border-bottom"
                                               href="/utbildning#Vill-studera">
                                                <span class="fas fa-street-view fa-icon-border mr-2"
                                                      aria-hidden="true"></span>
                                                <span class="d-inline-block first-letter-capitalized level-2">Vill studera</span></a>
                                            <ul class="navbar-nav">
                                                <li class="nav-item"><a class="nav-link" href="#">Link 1</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="mega-menu-collapse-col col">
                                        <div class="container pl-0 pr-0">
                                            <a class="nav-link d-flex align-items-center nav-link__border-bottom"
                                               href="/utbildning#Ny-student">
                                                <span class="fas fa-walking fa-icon-border mr-2"
                                                      aria-hidden="true"></span>
                                                <span class="d-inline-block first-letter-capitalized level-2">Ny student</span></a>
                                            <ul class="navbar-nav">
                                                <li class="nav-item"><a class="nav-link" href="#">Link 1</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="mega-menu-collapse-col col">
                                        <div class="container pl-0 pr-0">
                                            <a class="nav-link d-flex align-items-center nav-link__border-bottom"
                                               href="/utbildning#Under-utbildningen">
                                                <span class="fas fa-address-card fa-icon-border mr-2"
                                                      aria-hidden="true"></span>
                                                <span class="d-inline-block first-letter-capitalized level-2">Under utbildningen</span></a>
                                            <ul class="navbar-nav">
                                                <li class="nav-item"><a class="nav-link" href="#">Link 1</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="mega-menu-collapse-col col">
                                        <div class="container pl-0 pr-0">
                                            <a class="nav-link d-flex align-items-center nav-link__border-bottom"
                                               href="/utbildning#Examen-och-karriär">
                                                <span class="fas fa-user-graduate fa-icon-border mr-2"
                                                      aria-hidden="true"></span>
                                                <span class="d-inline-block first-letter-capitalized level-2">Examen och karriär</span></a>
                                            <ul class="navbar-nav">
                                                <li class="nav-item"><a class="nav-link" href="#">Link 1</a></li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="mega-menu-collapse-col col">

                                        <ul class="navbar-nav">
                                            <li class="nav-item">
                                                <a href="/nyheter" class="pb-3 nav-link d-flex align-items-center">
                                                    <span class="fas fa-newspaper fa-icon-border mr-2"
                                                          aria-hidden="true"></span>
                                                    <span class="d-inline-block first-letter-capitalized level-2">Nyheter</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="/kalender" class="pb-3 nav-link d-flex align-items-center">
                                                    <span class="fas fa-calendar fa-icon-border mr-2"
                                                          aria-hidden="true"></span>
                                                    <span class="d-inline-block first-letter-capitalized level-2">Kalender</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="/sok-kurser-och-program"
                                                   class="pb-3 nav-link d-flex align-items-center">
                                                    <span class="fas fa-search fa-icon-border mr-2"
                                                          aria-hidden="true"></span>
                                                    <span class="d-inline-block first-letter-capitalized level-2">Sök kurser och program</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="/utbildning/alla-amnen"
                                                   class="pb-3 nav-link d-flex align-items-center">
                                                    <span class="fas fa-book-reader fa-icon-border mr-2"
                                                          aria-hidden="true"></span>
                                                    <span class="d-inline-block first-letter-capitalized level-2">Alla ämnen</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="/utbildning/it-f%C3%B6r-studenter/digitala-verktyg-och-tj%C3%A4nster"
                                                   class="pb-3 nav-link d-flex align-items-center">
                                                    <span class="fas fa-sign-in-alt fa-icon-border mr-2"
                                                          aria-hidden="true"></span>
                                                    <span class="d-inline-block first-letter-capitalized level-2">Digitala verktyg och tjänster</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>


                                </ul>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item mega-menu-item" style="">
                        <div class="position-relative">
                            <a class="text-uppercase nav-link mega-menu-link level-1" aria-haspopup="true"
                               aria-expanded="false" href="{{route('manage')}}">
                                Manage
                            </a>
                        </div>
                        <div class="mega-menu-collapse">
                            <div class="container">
                                <ul class="list-unstyled row no-gutters">
                                    <li class="mega-menu-collapse-col col">
                                    </li>
                                    <li class="mega-menu-collapse-col col">
                                        <a class="nav-link level-2" href="#">Hantera uppspelning</a>
                                        <a class="nav-link level-2" href="{{ route('manage') }}">Manage videos</a>
                                        <a class="nav-link level-2" href="{{ route('mediasiteFetch') }}">Sync items from
                                            Mediasite</a>
                                        <a class="nav-link level-2" href="{{ route('mediasite') }}">Retrive from
                                            Mediasite</a>
                                    </li>
                                    <li class="mega-menu-collapse-col col">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item mega-menu-item" style="">

                        <div class="position-relative">
                            <a class="text-uppercase nav-link mega-menu-link level-1" aria-haspopup="true"
                               aria-expanded="false" href="#">
                                Profile
                            </a>
                        </div>

                        <div class="mega-menu-collapse">
                            <div class="container">

                                <ul class="list-unstyled row no-gutters">

                                    <li class="mega-menu-collapse-col col">
                                        <span class="level-1 text-uppercase d-block mb-3">Om universitetet</span>
                                        <span>Stockholms universitet erbjuder ett brett utbildningsutbud i nära samspel med forskning. Samarbeten och partnerskap främjar utbildningens kvalitet och det livslånga lärandet.
Här hittar du information om universitetets organisation, samarbeten och annan fakta om Stockholms universitet.</span>
                                    </li>
                                    <li class="mega-menu-collapse-col col">
                                        <a class="nav-link level-2" href="/om-universitetet/forskningsfinansiering">
                                            Forskningsfinansiering</a>
                                        <a class="nav-link level-2" href="/om-universitetet/information-om-covid-19">
                                            Information om covid-19</a>
                                        <a class="nav-link level-2" href="/om-universitetet/jobba-p%C3%A5-su">
                                            Jobba på SU</a>
                                        <a class="nav-link level-2" href="/om-universitetet/kontakt">
                                            Kontakt</a>
                                        <a class="nav-link level-2" href="/om-universitetet/kultur-och-historia">
                                            Kultur och historia</a>
                                        <a class="nav-link level-2"
                                           href="/om-universitetet/milj%C3%B6-klimat-och-h%C3%A5llbarhet">
                                            Miljö, klimat och hållbarhet</a>
                                        <a class="nav-link level-2" href="/om-universitetet/om-v%C3%A5ra-campus">
                                            Om våra campus</a>
                                        <a class="nav-link level-2" href="/om-universitetet/organisation">
                                            Organisation</a>
                                        <a class="nav-link level-2"
                                           href="/om-universitetet/priser-och-akademiska-h%C3%B6gtider">
                                            Priser och akademiska högtider</a>
                                        <a class="nav-link level-2"
                                           href="/om-universitetet/samarbeten-och-samh%C3%A4llsutveckling">
                                            Samarbeten och samhällsutveckling </a>
                                        <a class="nav-link level-2" href="/om-universitetet/strategier">
                                            Strategier</a>
                                        <a class="nav-link level-2" href="/om-universitetet/universitetsfakta">
                                            Universitetsfakta</a>
                                    </li>

                                    <li class="mega-menu-collapse-col col">
                                        <ul class="navbar-nav">
                                            <li class="nav-item">
                                                <a href="/nyheter" class="pb-3 nav-link d-flex align-items-center">
                                                    <span class="fas fa-newspaper fa-icon-border mr-2"
                                                          aria-hidden="true"></span>
                                                    <span class="d-inline-block first-letter-capitalized level-2">Nyheter</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="/kalender" class="pb-3 nav-link d-flex align-items-center">
                                                    <span class="fas fa-calendar-alt fa-icon-border mr-2"
                                                          aria-hidden="true"></span>
                                                    <span class="d-inline-block first-letter-capitalized level-2">Kalender</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="/om-universitetet/kontakt/press-och-media"
                                                   class="pb-3 nav-link d-flex align-items-center">
                                                    <span class="fas fa-user-edit fa-icon-border mr-2"
                                                          aria-hidden="true"></span>
                                                    <span class="d-inline-block first-letter-capitalized level-2">Press och media</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="https://www.su.se/biblioteket/"
                                                   class="pb-3 nav-link d-flex align-items-center">
                                                    <span class="fas fa-book-reader fa-icon-border mr-2"
                                                          aria-hidden="true"></span>
                                                    <span class="d-inline-block first-letter-capitalized level-2">Bibliotek</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="/om-universitetet/kontakt/institutioner-och-centra"
                                                   class="pb-3 nav-link d-flex align-items-center">
                                                    <span class="fas fa-hotel fa-icon-border mr-2"
                                                          aria-hidden="true"></span>
                                                    <span class="d-inline-block first-letter-capitalized level-2">Institutioner och centra</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="/om-universitetet/om-v%C3%A5ra-campus/%C3%B6ppettider"
                                                   class="pb-3 nav-link d-flex align-items-center">
                                                    <span class="fas fa-door-open fa-icon-border mr-2"
                                                          aria-hidden="true"></span>
                                                    <span class="d-inline-block first-letter-capitalized level-2">Öppettider</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>

            <nav class="d-flex align-items-center ml-auto" aria-label="Huvudmeny">
                <button id="togglerSearch_desktop" class="navbar-toggler collapsed d-none d-md-flex"
                        data-toggle="collapse" data-target="#primarySearchFormCollapse"
                        aria-controls="primarySearchFormCollapse" aria-expanded="false" aria-pressed="false"
                        aria-label="Visa och dölj sök på webbplatsen">
                    <span id="navbar-search_desktop" class="toggler-icon__primary fas fa-search"></span>
                    <span id="navbar-search-close_desktop" class="d-none toggler-icon__primary fas fa-times"></span>
                </button>
                <button id="togglerSearch" class="navbar-toggler collapsed d-flex d-md-none"
                        onclick="javascript:window.location.href='/s%C3%B6k'">
                    <span id="navbar-search" class="toggler-icon__primary fas fa-search"></span>
                </button>
                <button id="togglerHamburger_desktop" class="navbar-toggler collapsed" data-toggle="collapse"
                        data-target="#primaryHamburgerCollapse" aria-controls="primaryHamburgerCollapse"
                        aria-expanded="false" aria-pressed="false" aria-label="Visa och dölj huvudmeny">
                    <span id="navbar-hamburger_desktop" class="toggler-icon__primary fas fa-bars"></span>
                    <span id="navbar-hamburger-close_desktop" class="d-none toggler-icon__primary fas fa-times"></span>
                </button>

                <div class="d-flex">
                    <div class="collapse main-menu header-mega-menu-collapse__primary" id="primaryHamburgerCollapse">
                        <div class="container pb-5 pt-5">
                            <div class="row no-gutters">
                                <div id="hamburgerMenuColumn1"
                                     class="col-12 pr-0 col-md-6 col-lg-7 text-lg-right text-md-right pt-3 pt-md-0 pr-md-5 order-xs-2 order-sm-2 order-md-1 order-lg-1">
                                    <ul class="list-unstyled">
                                        <li><a href="#">Link 1</a></li>
                                        <li><a href="#">Link 2</a></li>
                                        <li><a href="#">Link 3</a></li>
                                        <li><a href="#">Link 4</a></li>
                                        <li><a href="#">Link 5</a></li>
                                    </ul>
                                </div>

                                <div id="hamburgerMenuColumn2"
                                     class="col-12 col-md-6 col-lg-5 pb-3 text-left pl-md-5 order-first order-sm-last order-sm-1 order-md-2 order-lg-2">
                                    <div id="accordionMenu">
                                        <ul class="navbar-nav top main-menu not-list-styled">
                                            <li class="nav-item">
                                                <a class="nav-link text-uppercase d-inline-block pr-0"
                                                   href="/utbildning">Catalogue</a>
                                                <div class="float-right pt-1 pr-2">
                                                    <button type="button" data-toggle="collapse"
                                                            data-target="#sub-level-menu1" aria-expanded="false"
                                                            aria-controls="sub-level-menu1" aria-pressed="false"
                                                            aria-label="Visa mer"
                                                            class="button-remove-style su-js-toggle-btn">
                                                        <span class="not-pressed"></span>
                                                        <span class="pressed"></span>
                                                    </button>
                                                </div>
                                                <div class="su-js-has-toggle-btn collapse" id="sub-level-menu1"
                                                     data-parent="#accordionMenu">
                                                    <div id="accordionSubMenu_Utbildning">
                                                        <ul class="main-menu-sub navbar-nav pb-4">
                                                            <li class="nav-item pl-3">
                                                                <a href="/nyheter" class="nav-link">
                                                                    <span class="d-inline-block first-letter-capitalized level-2">Nyheter</span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item pl-3">
                                                                <a href="/kalender" class="nav-link">
                                                                    <span class="d-inline-block first-letter-capitalized level-2">Kalender</span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item pl-3">
                                                                <a href="/sok-kurser-och-program" class="nav-link">
                                                                    <span class="d-inline-block first-letter-capitalized level-2">Sök kurser och program</span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item pl-3">
                                                                <a href="/utbildning/alla-amnen" class="nav-link">
                                                                    <span class="d-inline-block first-letter-capitalized level-2">Alla ämnen</span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item pl-3">
                                                                <a href="/utbildning/it-f%C3%B6r-studenter/digitala-verktyg-och-tj%C3%A4nster"
                                                                   class="nav-link">
                                                                    <span class="d-inline-block first-letter-capitalized level-2">Digitala verktyg och tjänster</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-uppercase d-inline-block pr-0"
                                                   href="#">Manage</a>

                                                <div class="float-right pt-1 pr-2">
                                                    <button type="button" data-toggle="collapse"
                                                            data-target="#sub-level-menu2" aria-expanded="false"
                                                            aria-controls="sub-level-menu2" aria-pressed="false"
                                                            aria-label="Visa mer"
                                                            class="button-remove-style su-js-toggle-btn">
                                                        <span class="not-pressed"></span>
                                                        <span class="pressed"></span>
                                                    </button>
                                                </div>
                                                <div class="su-js-has-toggle-btn collapse" id="sub-level-menu2"
                                                     data-parent="#accordionMenu">
                                                    <div id="accordionSubMenu_Forskning">
                                                        <ul class="main-menu-sub navbar-nav pb-4">
                                                            <li class="mega-menu-collapse-col col">
                                                            <li class="nav-item pl-3"><a class="nav-link level-2"
                                                                                         href="#">Hantera
                                                                    uppspelning</a></li>
                                                            <li class="nav-item pl-3"><a class="nav-link level-2"
                                                                                         href="{{ route('manage') }}">Manage
                                                                    videos</a></li>
                                                            <li class="nav-item pl-3"><a class="nav-link level-2"
                                                                                         href="{{ route('mediasiteFetch') }}">Sync
                                                                    items from
                                                                    Mediasite</a></li>
                                                            <li class="nav-item pl-3"><a class="nav-link level-2"
                                                                                         href="{{ route('mediasite') }}">Retrive
                                                                    from
                                                                    Mediasite</a></li>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-uppercase d-inline-block pr-0"
                                                   href="/om-universitetet">Profile</a>

                                                <div class="float-right pt-1 pr-2">
                                                    <button type="button" data-toggle="collapse"
                                                            data-target="#sub-level-menu3" aria-expanded="false"
                                                            aria-controls="sub-level-menu3" aria-pressed="false"
                                                            aria-label="Visa mer"
                                                            class="button-remove-style su-js-toggle-btn">
                                                        <span class="not-pressed"></span>
                                                        <span class="pressed"></span>
                                                    </button>
                                                </div>
                                                <div class="su-js-has-toggle-btn collapse" id="sub-level-menu3"
                                                     data-parent="#accordionMenu">
                                                    <div id="accordionSubMenu_Omuniversitetet">
                                                        <ul class="main-menu-sub navbar-nav pb-4">
                                                            <li class="nav-item pl-3">
                                                                <a class="nav-link d-inline-block pr-0"
                                                                   href="#">Link 1</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-none d-md-flex">
                    <div class="collapse header-mega-menu-collapse__primary" id="primarySearchFormCollapse">
                        <div class="container">
                            <form class="form-inline form-main-search d-flex justify-content-between pt-10"
                                  id="header-main-search-form" name="header-main-search-form" action="/s%C3%B6k"
                                  method="get" data-search="/s%C3%B6k" role="search">
                                <div>
                                    <label for="header-main-search-text" class="sr-only">Sök på webbplatsen</label>
                                    <input class="form-control form-control-main-search" type="search"
                                           id="header-main-search-text" name="q" autocomplete="off" aria-haspopup="true"
                                           placeholder="Sök på hela su.se" aria-labelledby="header-main-search-form">
                                </div>
                                <button id="header-main-search-button" type="submit"
                                        class="button-remove-style cursor-pointer mb-1" aria-label="Utför sök">
                                    <span class="toggler-icon__primary fas fa-search"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main id="main-content" class="pl-pr-sm-down-0">
        <div class="container-fluid pl-pr-sm-down-0 my-5 pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">

                        <div class="d-flex mb-3 flex-wrap flex-fill justify-content-center">
                            @foreach ($latest as $video)
                                <div class="card video m-3" style="width: 18rem;">
                                    <a href="{{ route('player', ['video' => $video]) }}">
                                    <div class="card-header position-relative"
                                         style="background-image: url({{ asset($video->thumb) }}); height:200px;">
                                        <div class="title">{{ $video->title }}</div>
                                        <i class="fas fa-play-circle"></i>
                                        <p> {{$video->duration}} </p>
                                    </div></a>
                                    <div class="card-body">
                                        <p class="card-text">
                                            <a href="/course/{{$video->course->id}}">
                                                Kurs: {{$video->course->course_name}} {{$video->course->semester}} {{$video->course->year}}
                                                <br>
                                                Kategori: {{$video->category->category_name}}
                                            </a></p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container -->
        </div><!-- /.container-fluid -->

    </main>


    <footer class="footer" aria-label="Sidfot" id="main-footer">
        <!--Fixed width container for primary footer content-->
        <div class="container">
            <div class="row">
                <div class="footer-section col-12 col-md-6 col-lg-5" aria-labelledby="footerContactInfo">
                    <h2 id="footerContactInfo">DSV</h2>
                    <p>SE-106 91 Stockholm</p>
                    <p class="mb-4">Telefon: 08-16 20 00</p>
                    <ul>
                        <li><a href="/om-universitetet/kontakt">Kontakt</a></li>
                        <li><a href="/om-universitetet/om-v%C3%A5ra-campus/%C3%B6ppettider">Öppettider</a></li>
                        <li><a href="/om-webbplatsen-1.517562">Om webbplatsen</a></li>
                    </ul>
                </div>

                <div class="footer-section col-12 col-md-6 col-lg-4" aria-labelledby="footerShortCuts">
                    <h2 id="footerShortCuts">Genvägar</h2>
                    <ul class="list-two-columns">
                        <li><a href="#">Link 1</a></li>
                        <li><a href="#">Link 1</a></li>
                        <li><a href="#">Link 1</a></li>
                        <li><a href="#">Link 1</a></li>
                        <li><a href="#">Link 1</a></li>
                        <li><a href="#">Link 1</a></li>
                    </ul>
                </div>

                <div class="footer-section col-12 col-lg-3" aria-labelledby="footerSocialMediaLinks">
                    <h2 id="footerSocialMediaLinks">Social media</h2>
                    <ul class="footer-social-media-links">
                        <li>
                            <a href="http://www.facebook.com/stockholmuniversity"
                               aria-label="Besök Stockholms universitet på Facebook">
                                <span class="fa-icon-white-link fab fa-facebook-f"></span></a></li>
                        <li><a href="http://www.instagram.com/stockholmuniversity"
                               aria-label="Besök Stockholms universitet på Instagram">
                                <span class="fa-icon-white-link fab fa-instagram"></span></a></li>
                        <li><a href="http://www.youtube.com/Stockholmsuniv"
                               aria-label="Besök Stockholms universitet på YouTube">
                                <span class="fa-icon-white-link fab fa-youtube"></span></a></li>
                        <li><a href="http://twitter.com/stockholms_univ"
                               aria-label="Besök Stockholms universitet på Twitter">
                                <span class="fa-icon-white-link fab fa-twitter"></span></a></li>
                        <li><a href="https://www.linkedin.com/company/166164"
                               aria-label="Besök Stockholms universitet på LinkedIn">
                                <span class="fa-icon-white-link fab fa-linkedin-in"></span></a></li>
                    </ul>
                </div>
            </div>
            <a class="button-rounded-small su-js-link-to-top-button" aria-label="Tillbaka till toppen" href="#"
               style="display: inline;"><span class="fas fa-lg fa-arrow-up"></span></a></div>
    </footer>

@endsection