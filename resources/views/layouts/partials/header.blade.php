<div id="top-spacer" style="height: 110px;"></div>
<header aria-label="Sidhuvud" id="main-header" class="su-header-container__primary fixed-top">

    <!-- Navigation -->
    <div class="container d-flex h-100">


        <a href="{{route('home')}}" class="text-decoration-none logo d-sm-flex align-items-center">
            DSVPlay&nbsp;

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

        </a>


        <nav class="d-none d-lg-flex main-menu mega-menu__primary transition w-100" aria-hidden="true">
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
                                        <ul class="navbar-nav">
                                            @foreach($courses[0] as $course)
                                                <li class="nav-item"><a class="nav-link"
                                                                        href="/course/{{$course->id}}">{{$course->name}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                                <li class="mega-menu-collapse-col col">
                                    <div class="container pl-0 pr-0">
                                        <ul class="navbar-nav">
                                            @foreach($courses[1] as $course)
                                                <li class="nav-item"><a class="nav-link"
                                                                        href="/course/{{$course->id}}">{{$course->name}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                                <li class="mega-menu-collapse-col col">
                                    <div class="container pl-0 pr-0">
                                        <ul class="navbar-nav">
                                            @foreach($courses[2] as $course)
                                                <li class="nav-item"><a class="nav-link"
                                                                        href="/course/{{$course->id}}">{{$course->name}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                <li class="nav-item mega-menu-item" style="">
                    <div class="position-relative">
                        <a class="text-uppercase nav-link mega-menu-link level-1" aria-haspopup="true"
                           aria-expanded="false" href="/my">
                            My videos
                        </a>
                    </div>
                </li>

                <li class="nav-item mega-menu-item" style="">
                    <div class="position-relative">
                        <a class="text-uppercase nav-link mega-menu-link level-1" aria-haspopup="true"
                           aria-expanded="false" href="#">
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
                                    <a class="nav-link level-2" href="{{ route('manual_upload') }}">Manuell
                                        uppladdning</a>
                                    <a class="nav-link level-2" href="{{ route('manual_admin') }}">Only for
                                        administrators</a>
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
            </ul>
            <div class="align-middle ml-auto my-auto">
                {{$play_user ?? 'Not logged in'}}
            </div>
        </nav>

        <nav class="d-lg-none d-flex align-items-center ml-auto" aria-label="Huvudmeny">
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
                                               href="#">Catalogue</a>
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
                                                        @foreach($courses as $coursechunk)
                                                            @foreach($coursechunk as $course)
                                                                <li class="nav-item pl-3">
                                                                    <a href="/course/{{$course->id}}" class="nav-link">
                                                                        <span class="d-inline-block first-letter-capitalized level-2">{{$course->name}}</span>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase d-inline-block pr-0"
                                               href="/my">My videos</a>
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
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <span class="nav-link">
                                                {{$play_user ?? 'Not logged in'}}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-none d-md-flex">
            <!--
                <div class="collapse header-mega-menu-collapse__primary" id="primarySearchFormCollapse">
                    <div class="container">

                        <form class="form-inline form-main-search d-flex justify-content-between pt-10"
                              id="header-main-search-form" name="header-main-search-form"
                              action="{{ route('search') }}" method="POST" data-search="/s%C3%B6k"
                              role="search">
                            @csrf
                    <div>
                        <label for="header-main-search-text" class="sr-only">Sök på videos</label>
                        <input class="form-control form-control-main-search" type="search"
                               id="header-main-search-text" name="q" autocomplete="off"
                               aria-haspopup="true"
                               placeholder="Sök på videos"
                               aria-labelledby="header-main-search-form">
                    </div>
                    <button id="header-main-search-button" type="submit"
                            class="button-remove-style cursor-pointer mb-1"
                            aria-label="Utför sök">
                        <span class="toggler-icon__primary fas fa-search"></span>
                    </button>


                    <div class="search_autocomplete" id="search_autocomplete">
                        <ul>
                            <li><b>test</b>video - Polopolymanual</li>
                            <li><b>Test</b>ar - Polopolymanual</li>
                            <li><b>Test</b> - Polopolymanual</li>
                            <li><b>Test</b> Construction and Language Assessment - Stockholm University</li>
                            <li><b>Test</b> Academic Video Online - Department of Social Anthropology</li>
                        </ul>
                    </div>



                                                            <div class="searchtext">
                                                                <input type="text" id="query" name="query" placeholder="Sök" onfocus="changeOutput()"
                                                                       class="search-input" autocomplete="off">
                                                            </div>

                                                            <button type="submit" class="search-button">
                                                                <i class="fas fa-search"></i>
                                                            </button>
-->

                <!--
                                                        <div class="search-option">
                                                            <div id="filtrera" class="filtrera" style="color: blue">Filtrera din sökning</div>
                                                            <div class="filter">
                                                                <input name="type" type="radio" value="type-lectures" id="type-lectures"
                                                                       class="filter-radio">
                                                                <label for="type-lectures">
                                                                    <i class="far fa-user"></i>
                                                                    <span>Föreläsare</span>
                                                                </label>

                                                            </div>

                                                            <div class="filter">
                                                                <input name="type" type="radio" value="type-category" id="type-category"
                                                                       class="filter-radio">
                                                                       class="filter-radio">
                                                                <label for="type-category">
                                                                    <i class="fas fa-broadcast-tower"></i>
                                                                    <span>Kategori</span>
                                                                </label>
                                                            </div>
                                                            <div class="filter">
                                                                <input name="type" type="radio" value="type-course" id="type-course"
                                                                       class="filter-radio">
                                                                <label for="type-cource">
                                                                    <i class="fas fa-book-open"></i>
                                                                    <span>Kurser</span>
                                                                </label>
                                                            </div>
                                                            <div class="filter">
                                                                <input name="type" type="radio" value="type-latest" id="type-latest"
                                                                       class="filter-radio">
                                                                <label for="type-latest">
                                                                    <i class="far fa-clock"></i>
                                                                    <span>Senaste</span>
                                                                </label>
                                                            </div>
                                                        </div>


            </form>

        </div>
    </div>
      -->
            </div>
        </nav>
    </div>
</header>
