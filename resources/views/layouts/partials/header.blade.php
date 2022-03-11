<div id="top-spacer" style="height: 110px;"></div>
<header aria-label="Sidhuvud" id="main-header" class="su-header-container__primary fixed-top">
    <!-- Navigation -->
    <div class="container d-flex h-100">
        <a href="{{route('home')}}" class="text-decoration-none logo d-sm-flex align-items-center">
            DSVPlay
        </a>
        <nav class="d-none d-lg-flex main-menu mega-menu__primary transition w-100" aria-hidden="true">
            <ul class="nav not-list-styled">
                <li class="nav-item mega-menu-item" style="">
                    <div class="position-relative">
                        <a class="text-uppercase nav-link mega-menu-link level-1 preventdefault" aria-haspopup="true"
                           aria-expanded="false" href="#">
                            @lang('lang.navigate')
                        </a>
                    </div>
                    <div class="mega-menu-collapse">
                        <div class="container">
                            <ul class="list-unstyled row no-gutters">
                                <li class="mega-menu-collapse-col col">
                                    <span class="level-1 text-uppercase d-block mb-3">@lang('lang.navigate')</span>
                                    <span>{{ __("Here you can navigate among presentations from your teaching activities by semester, course or category.") }}</span>
                                </li>
                                <li class="mega-menu-collapse-col col">
                                    <a class="nav-link d-flex align-items-center nav-link__border-bottom" href="/semester/all">
                                        <span class="fas fa-layer-group fa-icon-border mr-2" aria-hidden="true"></span>
                                        <span class="d-inline-block first-letter-capitalized level-2">@lang('lang.semester')</span>
                                    </a>
                                    @if($semesters ?? '')
                                        @foreach($semesters as $semester)
                                            <a class="nav-link"
                                               href="{{route('semester', $semester)}}">{{$semester}}</a>
                                        @endforeach
                                    @else
                                        {{ __("No presentations from your registered Semesters were found.") }}
                                    @endif
                                </li>
                                <li class="mega-menu-collapse-col col">
                                    <a class="nav-link d-flex align-items-center nav-link__border-bottom" href="/course/all">
                                        <span class="fas fa-address-card fa-icon-border mr-2" aria-hidden="true"></span>
                                        <span class="d-inline-block first-letter-capitalized level-2">@lang('lang.course')</span>
                                    </a>
                                    @if($designations ?? '')
                                        @if(count($designations)>0)
                                            @foreach($designations as $key => $designation)
                                                <a class="nav-link"
                                                   href="{{route('designation', $key)}}">{{$designation}}</a>
                                            @endforeach
                                        @else
                                            {{ __("No active courses found.") }}
                                        @endif
                                    @else
                                        {{ __("No active courses found.") }}
                                    @endif
                                </li>
                                @if($nav_categories ?? '')
                                    <li class="mega-menu-collapse-col col">
                                        <a class="nav-link d-flex align-items-center nav-link__border-bottom" href="">
                                            <span class="fas fa-book fa-icon-border mr-2" aria-hidden="true"></span>
                                            <span class="d-inline-block first-letter-capitalized level-2">@lang('lang.category')</span>
                                        </a>
                                        @if($category ?? '')
                                            @foreach($nav_categories as $category)
                                                <a class="nav-link"
                                                   href="{{route('category', $category)}}">{{$category}}</a>
                                            @endforeach
                                        @else
                                            {{ __("No active categories found.") }}
                                        @endif
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
                @if(app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Administrator')
                    <li class="nav-item mega-menu-item" style="">
                        <div class="position-relative">
                            <a class="text-uppercase nav-link mega-menu-link level-1 preventdefault"
                               aria-haspopup="true"
                               aria-expanded="false" href="#">
                                @lang('lang.manage')
                            </a>
                        </div>
                        <div class="mega-menu-collapse">
                            <div class="container">
                                <ul class="list-unstyled row no-gutters">
                                    <li class="mega-menu-collapse-col col">
                                        <span class="level-1 text-uppercase d-block mb-3">@lang('lang.manage')</span>
                                        <span>{{ __("Here you can manage your presentations. Upload, download, change playback rights and change course association etc.") }}</span>
                                    </li>
                                    <li class="mega-menu-collapse-col col">
                                        <a class="nav-link level-2 d-flex align-content-center"
                                           href="{{ route('manage') }}"><span
                                                    class="fas fa-video fa-icon-border mr-2"
                                                    aria-hidden="true"></span>@lang('lang.manage_recording')</a>

                                        @if(app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Administrator')
                                        <a class="nav-link level-2 d-flex align-content-center"
                                           href="{{ route('manage_course') }}"><span
                                                class="fas fa-address-card fa-icon-border mr-2"
                                                aria-hidden="true"></span>@lang('lang.manage_course')</a>
                                        @endif
                                        <a class="nav-link level-2 d-flex align-content-center"
                                           href="{{ route('user_upload') }}"><span
                                                    class="fas fa-upload fa-icon-border mr-2"
                                                    aria-hidden="true"></span>@lang('lang.manual_upload')</a>
                                    </li>
                                    <li class="mega-menu-collapse-col col">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif
                @if(app()->make('play_role') == 'Administrator')
                    <li class="nav-item mega-menu-item" style="">
                        <div class="position-relative">
                            <a class="text-uppercase nav-link mega-menu-link level-1 preventdefault"
                               aria-haspopup="true"
                               aria-expanded="false" href="#">
                                @lang('lang.admin')
                            </a>
                        </div>
                        <div class="mega-menu-collapse">
                            <div class="container">
                                <ul class="list-unstyled row no-gutters">
                                    <li class="mega-menu-collapse-col col">
                                        <span class="level-1 text-uppercase d-block mb-3">{{__('Administrate')}}</span>
                                    </li>
                                    <li class="mega-menu-collapse-col col">
                                        <a class="nav-link level-2 d-flex align-content-center"
                                           href="{{route('admin')}}"><span
                                                    class="fas fa-user-cog fa-icon-border mr-2"
                                                    aria-hidden="true"></span>Admin stats and settings</a>
                                        <a class="nav-link level-2 d-flex align-content-center"
                                           href="{{route('log-viewer::logs.list')}}"><span
                                                    class="fas fa-bug fa-icon-border mr-2" aria-hidden="true"></span>Logs</a>
                                        <a class="nav-link level-2 d-flex align-content-center"
                                           href="{{ route('mediasiteFetch') }}"><i
                                                    class="fas fa-sync-alt fa-icon-border mr-2"></i>Sync items from
                                            Mediasite</a>
                                        <a class="nav-link level-2 d-flex align-content-center"
                                           href="{{ route('mediasite') }}"><i
                                                    class="fas fa-file-download fa-icon-border mr-2"></i>Retrive from
                                            Mediasite</a>
                                    </li>
                                    <li class="mega-menu-collapse-col col">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif
            </ul>
            <div class="align-middle ml-auto my-auto">
                @if(!app()->make('play_auth') == 'Administrator')
                    {{app()->make('play_user') ?? 'Not logged in'}}
                @else
                    @if(app()->make('play_auth') == 'Administrator')
                        @include('layouts.partials.role_emulate')
                    @else
                        {{app()->make('play_user') ?? 'Not logged in'}}
                    @endif
                @endif
            </div>
            <!-- Lang localization -->

            <div class="align-middle ml-auto my-auto">
                <nav class="navbar navbar-expand-lg container">
                    <div class="collapse navbar-collapse" id="navbarToggler">
                        <ul class="navbar-nav ml-auto">
                            @php $locale = session()->get('locale'); @endphp
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @switch($locale)
                                        @case('eng')
                                        <img src="{{asset('images/globallinks-lang-en.gif')}}" alt="English"> English
                                        @break
                                        @case('swe')
                                        <img src="{{asset('images/globallinks-lang-sv.gif')}}" alt="Swedish"> Svenska
                                        @break
                                        @default
                                        <img src="{{asset('images/globallinks-lang-en.gif')}}" alt="English"> English
                                    @endswitch
                                    <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" style="background-color: #002f5f;"
                                     aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('language', 'en')}}"><img src="{{asset('images/globallinks-lang-en.gif')}}" alt="English"> English</a>
                                    {{--}}<a class="dropdown-item" href="lang/swe"><img src="{{asset('images/globallinks-lang-sv.gif')}}"> Svenska</a>{{--}}
                                    <a class="dropdown-item" href="{{route('language', 'swe')}}"><img src="{{asset('images/globallinks-lang-sv.gif')}}" alt="Swedish"> Svenska</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- end Lang localization -->
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
                                               href="/semester/all">
                                                <span class="fas fa-layer-group fa-icon-border mr-2"
                                                      aria-hidden="true"></span>
                                                <span class="d-inline-block first-letter-capitalized level-3">@lang('lang.semester')</span>
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
                                                                    <a class="nav-link"
                                                                       href="{{route('semester', $semester)}}">
                                                                        <span class="d-inline-block text-capitalize level-2">{{$semester}}</span>
                                                                    </a>
                                                                @endforeach
                                                            @else
                                                                <a class="nav-link" href="">
                                                                    {{ __("No presentations from your registered Semesters were found.") }}
                                                                </a>
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase d-inline-block pr-0"
                                               href="/course/all">
                                                <span class="fas fa-address-card fa-icon-border mr-2"
                                                      aria-hidden="true"></span>
                                                <span class="d-inline-block text-capitalize level-2">@lang('lang.course')</span>
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
                                                                @if(count($designations)>0)
                                                                    @foreach($designations as $key => $designation)
                                                                        <a class="nav-link"
                                                                           href="{{route('designation', $key)}}">
                                                                            <span class="d-inline-block text-capitalize level-2">{{$designation}}</span>
                                                                        </a>
                                                                    @endforeach
                                                                @else
                                                                    {{ __("No active courses found.") }}
                                                                @endif
                                                            @else
                                                                {{ __("No active courses found.") }}
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        @if($nav_categories ?? '')
                                            <li class="nav-item">
                                                <a class="nav-link text-uppercase d-inline-block pr-0"
                                                   href="#">
                                                    <span class="fas fa-book fa-icon-border mr-2"
                                                          aria-hidden="true"></span>
                                                    <span class="d-inline-block first-letter-capitalized level-2">@lang('lang.category')</span>
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
                                                                @if($category ?? '')
                                                                    @foreach($nav_categories as $category)
                                                                        <a class="nav-link"
                                                                           href="{{route('category', $category)}}">
                                                                            <span class="d-inline-block first-letter-capitalized level-2">{{$category}}</span>
                                                                        </a>
                                                                    @endforeach
                                                                @else
                                                                    {{ __("No active categories found.") }}
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                        @if ($hasmycourses ?? '')
                                            <li class="nav-item">
                                                <a class="nav-link text-uppercase d-inline-block pr-0"
                                                   href="/my">Mina videor</a>
                                            </li>
                                        @endif

                                        <li class="nav-item">
                                            <a class="nav-link text-capitalize d-inline-block pr-0 preventdefault"
                                               href="">
                                                <i class="fas fa-edit fa-icon-border mr-2"></i> @lang('lang.manage')
                                            </a>
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
                                                                <span class="fas fa-video fa-icon-border mr-2"
                                                                      aria-hidden="true"></span>@lang('lang.manage_recording')
                                                            </a>
                                                            @if(app()->make('play_role') == 'Courseadmin')
                                                                <a class="nav-link level-2"
                                                                   href="{{ route('manage_course') }}"><span
                                                                            class="fas fa-address-card fa-icon-border mr-2"
                                                                            aria-hidden="true"></span>@lang('lang.manage_course')</a>
                                                            @endif
                                                            <a class="nav-link level-2"
                                                               href="{{ route('user_upload') }}">
                                                                <span class="fas fa-upload fa-icon-border mr-2"
                                                                      aria-hidden="true"></span>@lang('lang.manual_upload')
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>

                                        @if(app()->make('play_role') == 'Administrator')
                                            <li class="nav-item" style="">
                                                <a class="nav-link text-capitalize d-inline-block pr-0 preventdefault"
                                                   href="">
                                                    <i class="fas fa-edit fa-icon-border mr-2"></i> @lang('lang.admin')
                                                </a>
                                                <div class="float-right pt-1 pr-2">
                                                    <button type="button" data-toggle="collapse"
                                                            data-target="#sub-level-menu5" aria-expanded="false"
                                                            aria-controls="sub-level-menu5" aria-pressed="false"
                                                            aria-label="Visa mer"
                                                            class="button-remove-style su-js-toggle-btn">
                                                        <span class="not-pressed"></span>
                                                        <span class="pressed"></span>
                                                    </button>
                                                </div>
                                                <div class="su-js-has-toggle-btn collapse" id="sub-level-menu5"
                                                     data-parent="#accordionMenu">
                                                    <div id="accordionSubMenu_Forskning">
                                                        <ul class="main-menu-sub navbar-nav pb-4">
                                                            <li class="nav-item pl-3">
                                                                <a class="nav-link level-2"
                                                                   href="{{route('admin')}}"><span
                                                                            class="fas fa-user-cog fa-icon-border mr-2"
                                                                            aria-hidden="true"></span>Admin stats and
                                                                    settings</a>
                                                                <a class="nav-link level-2"
                                                                   href="{{route('log-viewer::logs.list')}}"><span
                                                                            class="fas fa-bug fa-icon-border mr-2"
                                                                            aria-hidden="true"></span>Logs</a>
                                                                <a class="nav-link level-2"
                                                                   href="{{ route('mediasiteFetch') }}"><i
                                                                            class="fas fa-sync-alt fa-icon-border mr-2"></i>Sync
                                                                    items from
                                                                    Mediasite</a>
                                                                <a class="nav-link level-2"
                                                                   href="{{ route('mediasite') }}"><i
                                                                            class="fas fa-file-download fa-icon-border mr-2"></i>Retrive
                                                                    from
                                                                    Mediasite</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                        <li class="nav-item">
                                            <span class="nav-link">{{app()->make('play_user') ?? 'Not logged in'}}</span>
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
@include('layouts.partials.redirect_play2')
