<header class="w-full border-b-4 border-susecondary" role="banner" aria-label="Site header">
    <!-- Mobile header -->
    <div class="grid grid-cols-4 md:hidden">
        <div class="flex items-center justify-center col-span-1 bg-suprimary">
            <img
                class="block h-12 max-w-full m-3"
                src="{{ asset('images/su_logo_no_text.svg') }}"
                alt="Stockholms universitet"
            />
        </div>

        <div class="col-span-3 inline-flex items-center px-5 bg-sudepartment min-w-0">
          <span class="-mt-4 self-center text-base font-normal font-sudepartment whitespace-pre-line text-white truncate">
            {{ __('Department of Computer and Systems Sciences') }}
          </span>
        </div>
    </div>

    <!-- Desktop / tablet header -->
    <div class="hidden md:grid grid-cols-4">
        <!-- Left: SU logo -->
        <div class="flex items-center justify-end col-span-1 bg-suprimary pr-3">
            <img
                class="w-44 max-w-full"
                src="{{ asset('images/su_swe.png') }}"
                alt="Stockholms universitet"
            />
        </div>

        <!-- Center: Department name -->
        <div class="hidden sm:flex items-center col-span-2 pl-5 bg-sudepartment min-w-0">
          <span class="text-2xl font-normal font-sudepartment text-white truncate">
            {{ __('Department of Computer and Systems Sciences') }}
          </span>
        </div>

        <!-- Right: user / actions -->
        <div class="flex items-center justify-end col-span-1 bg-sudepartment gap-3 pr-3">
            <!-- User name -->
            <div
                class="flex items-center h-7 px-3 justify-center text-xs text-white rounded-lg"
                title="{{ __('Profile settings') }}"
                data-tooltip-target="displayName-tooltip"
                aria-label="{{ __('Profile settings') }}">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <!-- Displayname from shibboleth -->
                {{ app()->make('play_user') }}
                <span class="ml-1 inline-flex items-center gap-x-1 py-0.3 px-1 rounded-[9px] text-[8px]
                            font-medium text-gray-300 border border-gray-300">
                    @if(in_array(app()->make('play_role'), ['Courseadmin', 'Uploader', 'Staff']))
                        {{__("DSV Staff")}}
                    @else
                        {{app()->make('play_role')}}
                    @endif
                </span>

            </div>

            <!-- Theme toggle -->
            <button
                type="button"
                class="theme-toggle flex items-center justify-center w-7 h-7 rounded-md
                   text-white bg-transparent border-none
                   hover:text-gray-700 dark:hover:text-blue-300
                   focus:ring-2 focus:ring-gray-400 dark:focus:ring-blue-600"
                data-tooltip-target="navbar-dropdown-toggle-dark-mode-tooltip"
                aria-label="{{ __('Toggle dark mode') }}"
                aria-pressed="false">

                <!-- Moon (show in light mode) -->
                <svg id="theme-toggle-dark-icon" data-toggle-icon="moon" class="w-4 h-4 dark:hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 20" fill="currentColor" aria-hidden="true">
                    <path d="M17.8 13.75a1 1 0 0 0-.859-.5A7.488 7.488 0 0 1 10.52 2a1 1 0 0 0 0-.969A1.035 1.035 0 0 0 9.687.5h-.113a9.5 9.5 0 1 0 8.222 14.247 1 1 0 0 0 .004-.997Z"></path>
                </svg>

                <!-- Sun (show in dark mode) -->
                <svg id="theme-toggle-light-icon" data-toggle-icon="sun" class="w-4 h-4 hidden dark:block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10 15a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0-11a1 1 0 0 0 1-1V1a1 1 0 0 0-2 0v2a1 1 0 0 0 1 1Zm0 12a1 1 0 0 0-1 1v2a1 1 0 1 0 2 0v-2a1 1 0 0 0-1-1ZM4.343 5.757a1 1 0 0 0 1.414-1.414L4.343 2.929a1 1 0 0 0-1.414 1.414l1.414 1.414Zm11.314 8.486a1 1 0 0 0-1.414 1.414l1.414 1.414a1 1 0 0 0 1.414-1.414l-1.414-1.414ZM4 10a1 1 0 0 0-1-1H1a1 1 0 0 0 0 2h2a1 1 0 0 0 1-1Zm15-1h-2a1 1 0 1 0 0 2h2a1 1 0 0 0 0-2ZM4.343 14.243l-1.414 1.414a1 1 0 1 0 1.414 1.414l1.414-1.414a1 1 0 0 0-1.414-1.414ZM14.95 6.05a1 1 0 0 0 .707-.293l1.414-1.414a1 1 0 1 0-1.414-1.414l-1.414 1.414a1 1 0 0 0 .707 1.707Z"></path>
                </svg>

                <span class="sr-only">{{ __('Toggle dark/light mode') }}</span>
            </button>

            <!-- Language switcher -->
            <div x-data="{ open: false }" class="relative">
                <button
                    type="button"
                    @click="open = !open"
                    :aria-expanded="open.toString()"
                    aria-haspopup="menu"
                    aria-controls="language-dropdown-menu"
                    data-tooltip-target="language-switch-tooltip"
                    class="flex items-center w-24 h-7 rounded px-3 text-xs text-white cursor-pointer dark:hover:bg-gray-700"
                >
                    @php($isSv = Illuminate\Support\Facades\App::currentLocale() === 'sv')
                    <img
                        src="{{ asset($isSv ? 'images/globallinks-lang-sv.gif' : 'images/globallinks-lang-en.gif') }}"
                        alt="{{ $isSv ? 'Svenska' : 'English' }}"
                        class="w-4 h-4 mr-2 opacity-80"
                    />
                    {{ $isSv ? 'Svenska' : 'English' }}
                </button>

                <div
                    id="language-dropdown-menu"
                    x-cloak
                    x-show="open"
                    x-transition.origin.top.right
                    @click.outside="open = false"
                    @keydown.escape.window="open = false"
                    role="menu"
                    aria-label="{{ __('Language menu') }}"
                    class="absolute right-0 z-50 mt-2 w-40 rounded-md shadow bg-white dark:bg-gray-700 divide-y divide-gray-100 dark:divide-gray-600"
                >
                    <ul class="py-2 text-sm">
                        @foreach (['en' => 'English', 'sv' => 'Svenska'] as $lang => $label)
                            @if ($lang !== Illuminate\Support\Facades\App::currentLocale())
                                <li>
                                    <a href="{{ route('locale.switch', $lang) }}"
                                        class="flex items-center px-2 py-1 text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600"
                                        role="menuitem">
                                        <img src="{{ asset($lang === 'sv' ? 'images/globallinks-lang-sv.gif' : 'images/globallinks-lang-en.gif') }}"
                                            alt="{{ $label }}"
                                            class="w-4 h-4 mr-2 opacity-80" />
                                        {{ $label }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div> <!-- end lang -->

        </div>
    </div>
</header>

<!-- Tooltips -->
<div id="displayName-tooltip" role="tooltip"
     class="absolute z-30 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
     style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);"
     data-popper-placement="top">{{__('Profile settings')}}
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
<div id="navbar-dropdown-toggle-dark-mode-tooltip" role="tooltip"
     class="absolute z-30 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
     style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);" data-popper-placement="top">{{__('Toggle dark mode')}}
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
<div id="language-switch-tooltip" role="tooltip"
     class="absolute z-30 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
     style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);" data-popper-placement="top">{{ __('Change language') }}
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
