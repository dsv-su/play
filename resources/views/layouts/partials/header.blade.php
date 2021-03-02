<div id="top-spacer" style="height: 110px;"></div>
<header aria-label="Sidhuvud" id="main-header" class="su-header-container__primary fixed-top">
    <!-- Navigation -->
    <div class="container d-flex h-100">
        <a href="{{route('home')}}" class="text-decoration-none logo d-sm-flex align-items-center">
            DSVPlay&nbsp;
        </a>
        <nav class="d-none d-lg-flex main-menu mega-menu__primary transition w-100" aria-hidden="true">
            <ul class="nav not-list-styled">
                <li class="nav-item mega-menu-item" style="">
                    <div class="position-relative">
                        <a class="text-uppercase nav-link mega-menu-link level-1" aria-haspopup="true"
                           aria-expanded="false" href="#">
                            Navigera
                        </a>
                    </div>
                    <div class="mega-menu-collapse">
                        <div class="container">
                            <ul class="list-unstyled row no-gutters">
                                <li class="mega-menu-collapse-col col">
                                    <span class="level-1 text-uppercase d-block mb-3">Navigera</span>
                                    <span>Här kan du navigera bland inspelningar från undervisningsmoment efter termin, kurs eller kategori.</span>

                                </li>
                                <li class="mega-menu-collapse-col col">
                                    <a class="nav-link d-flex align-items-center nav-link__border-bottom" href="">
                                        <span class="fas fa-layer-group fa-icon-border mr-2" aria-hidden="true"></span>
                                        <span class="d-inline-block first-letter-capitalized level-2">Termin</span>
                                    </a>
                                    @if($semesters ?? '')
                                        @foreach($semesters as $semester)
                                            <a class="nav-link" href="{{route('semester', $semester)}}">{{$semester}}</a>
                                        @endforeach
                                            <a class="nav-link" href="">[Alla]</a>
                                    @endif
                                </li>
                                <li class="mega-menu-collapse-col col">
                                    <a class="nav-link d-flex align-items-center nav-link__border-bottom" href="">
                                        <span class="fas fa-address-card fa-icon-border mr-2" aria-hidden="true"></span>
                                        <span class="d-inline-block first-letter-capitalized level-2">Kurs</span>
                                    </a>
                                    @if($designations ?? '')
                                        @foreach($designations as $designation)
                                            <a class="nav-link" href="{{route('designation', $designation)}}">{{$designation}}</a>
                                        @endforeach
                                        <a class="nav-link" href="">[Alla]</a>
                                    @endif
                                </li>
                                @if($nav_categories ?? '')
                                <li class="mega-menu-collapse-col col">
                                    <a class="nav-link d-flex align-items-center nav-link__border-bottom" href="">
                                        <span class="fas fa-book fa-icon-border mr-2" aria-hidden="true"></span>
                                        <span class="d-inline-block first-letter-capitalized level-2">Kategori</span>
                                    </a>
                                        @foreach($nav_categories as $category)
                                            <a class="nav-link" href="{{route('category', $category)}}">{{$category}}</a>
                                        @endforeach
                                        <a class="nav-link" href="">[Alla]</a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </li>

                @if ($hasmycourses ?? '')
                <li class="nav-item mega-menu-item" style="">
                    <div class="position-relative">
                        <a class="text-uppercase nav-link mega-menu-link level-1" aria-haspopup="true"
                           aria-expanded="false" href="/my">
                            Mina videor
                        </a>
                    </div>
                </li>
                @endif

                <li class="nav-item mega-menu-item" style="">
                    <div class="position-relative">
                        <a class="text-uppercase nav-link mega-menu-link level-1" aria-haspopup="true"
                           aria-expanded="false" href="#">
                            Hantera
                        </a>
                    </div>
                    <div class="mega-menu-collapse">
                        <div class="container">
                            <ul class="list-unstyled row no-gutters">
                                <li class="mega-menu-collapse-col col">
                                    <span class="level-1 text-uppercase d-block mb-3">Hantera</span>
                                    <span>Här kan du hantera dina inspelningar. Ladda upp, ladda ner, ändra uppspelningsrättigheter och byta kursassociation mm.</span>

                                </li>
                                <li class="mega-menu-collapse-col col">
                                    <a class="nav-link level-2" href="{{ route('manage') }}"><span class="fas fa-video fa-icon-border mr-2" aria-hidden="true"></span> Hantera inspelningar</a>
                                    <a class="nav-link level-2" href="{{ route('user_upload') }}"><span class="fas fa-upload fa-icon-border mr-2" aria-hidden="true"></span> Manuell
                                        uppladdning</a>
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
                            Admin
                        </a>
                    </div>
                    <div class="mega-menu-collapse">
                        <div class="container">
                            <ul class="list-unstyled row no-gutters">
                                <li class="mega-menu-collapse-col col">
                                    <span class="level-1 text-uppercase d-block mb-3">Administrator</span>
                                </li>
                                <li class="mega-menu-collapse-col col">
                                    <a class="nav-link level-2" href="{{route('log-viewer::logs.list')}}"><span class="fas fa-bug fa-icon-border mr-2" aria-hidden="true"></span>Status and Logs</a>
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
                {{app()->make('play_user') ?? 'Not logged in'}}
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
                            <!--
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
                            -->
                            <div id="hamburgerMenuColumn1"
                                 class="col-12 col-md-6 col-lg-5 pb-3 text-left pl-md-5 order-first order-sm-last order-sm-1 order-md-2 order-lg-2">
                                <div id="accordionMenu">
                                    <ul class="navbar-nav top main-menu not-list-styled">
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase d-inline-block pr-0"
                                               href="#">
                                                <span class="fas fa-layer-group fa-icon-border mr-2" aria-hidden="true"></span>
                                                <span class="d-inline-block first-letter-capitalized level-3">Termin</span>
                                            </a>
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
                                                            @if($semesters ?? '')
                                                                @foreach($semesters as $semester)
                                                                    <a class="nav-link" href="{{route('semester', $semester)}}">
                                                                        <span class="d-inline-block first-letter-capitalized level-2">{{$semester}}</span>
                                                                    </a>
                                                                @endforeach
                                                                    <a class="nav-link" href="">
                                                                        <span class="d-inline-block first-letter-capitalized level-2">[Alla]</span>
                                                                    </a>
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase d-inline-block pr-0"
                                               href="#">
                                                <span class="fas fa-address-card fa-icon-border mr-2" aria-hidden="true"></span>
                                                <span class="d-inline-block first-letter-capitalized level-2">Kurs</span>
                                            </a>
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
                                                <div id="accordionSubMenu_Utbildning">
                                                    <ul class="main-menu-sub navbar-nav pb-4">
                                                        <li class="nav-item pl-3">
                                                            @if($designations ?? '')
                                                                @foreach($designations as $designation)
                                                                    <a class="nav-link" href="{{route('designation', $designation)}}">
                                                                        <span class="d-inline-block first-letter-capitalized level-2">{{$designation}}</span>
                                                                    </a>
                                                                @endforeach
                                                                <a class="nav-link" href="">[Alla]</a>
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase d-inline-block pr-0"
                                               href="#">
                                                <span class="fas fa-book fa-icon-border mr-2" aria-hidden="true"></span>
                                                <span class="d-inline-block first-letter-capitalized level-2">Kategori</span>
                                            </a>
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
                                                <div id="accordionSubMenu_Utbildning">
                                                    <ul class="main-menu-sub navbar-nav pb-4">
                                                        <li class="nav-item pl-3">
                                                            @if($nav_categories ?? '')
                                                                @foreach($nav_categories as $category)
                                                                    <a class="nav-link" href="{{route('category', $category)}}">
                                                                        <span class="d-inline-block first-letter-capitalized level-2">{{$category}}</span>
                                                                    </a>
                                                                @endforeach
                                                                <a class="nav-link" href="">[Alla]</a>
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        @if ($hasmycourses ?? '')
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase d-inline-block pr-0"
                                               href="/my">Mina videor</a>
                                        </li>
                                        @endif

                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase d-inline-block pr-0"
                                               href="#">Hantera</a>

                                            <div class="float-right pt-1 pr-2">
                                                <button type="button" data-toggle="collapse"
                                                        data-target="#sub-level-menu4" aria-expanded="false"
                                                        aria-controls="sub-level-menu4" aria-pressed="false"
                                                        aria-label="Visa mer"
                                                        class="button-remove-style su-js-toggle-btn">
                                                    <span class="not-pressed"></span>
                                                    <span class="pressed"></span>
                                                </button>
                                            </div>
                                            <div class="su-js-has-toggle-btn collapse" id="sub-level-menu4"
                                                 data-parent="#accordionMenu">
                                                <div id="accordionSubMenu_Forskning">
                                                    <ul class="main-menu-sub navbar-nav pb-4">
                                                        <li class="nav-item pl-3">
                                                            <a class="nav-link level-2" href="{{ route('manage') }}">
                                                                <span class="fas fa-video fa-icon-border mr-2" aria-hidden="true"></span> Hantera inspelningar</a>
                                                            <a class="nav-link level-2" href="{{ route('user_upload') }}">
                                                                <span class="fas fa-upload fa-icon-border mr-2" aria-hidden="true"></span> Manuell
                                                                uppladdning</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <span class="nav-link">
                                                {{app()->make('play_user') ?? 'Not logged in'}}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </nav>
    </div>
</header>
