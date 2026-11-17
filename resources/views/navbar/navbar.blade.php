@php
    // Share destinations and permission checks across desktop and mobile navigation.
    $presentationDescription = in_array(app()->make('play_auth'), ['Administrator', 'Staff'])
        ? __('Here you can navigate among presentations from your teaching activities sorted after course.')
        : __('Here you can navigate among presentations from your registed course sorted after course.');
    $navigationItems = [
        ['label' => __('Navigation'), 'key' => 'presentations', 'children' => [
            ['label' => __('My Presentations'), 'route' => 'my.presentations', 'description' => $presentationDescription],
        ]],
    ];
    if (\Illuminate\Support\Facades\Gate::allows('manage-content')) {
        $navigationItems[] = ['label' => __('Manage'), 'key' => 'manage', 'children' => [
            ['label' => __('Manual Upload'), 'route' => 'presentation.upload', 'description' => __('Upload a presentation and associate it with a course.')],
            ['label' => __('Manage channel'), 'route' => 'channels.manage', 'description' => __('Here you can add or manage a custom channel')],
        ]];
    }
    $navigationItems[] = ['label' => __('Recorders'), 'route' => 'admin.recorders'];
    $navigationItems[] = ['label' => __('FAQ'), 'route' => 'faq'];
    if (\Illuminate\Support\Facades\Gate::allows('admin-content')) {
        $navigationItems[] = ['label' => __('Admin'), 'route' => 'admin.settings'];
    }
@endphp

<nav x-data="{
        mobileMenuOpen: false,
        activeMobileMenu: '',
        navigationMenuOpen: false,
        navigationMenu: '',
        navigationMenuCloseDelay: 200,
        navigationMenuCloseTimeout: null,
        navigationMenuTrigger: null,
        navigationMenuLeave() {
            this.navigationMenuClearCloseTimeout();
            if (this.$refs.navigationDropdown.contains(document.activeElement)
                || this.navigationMenuTrigger === document.activeElement) return;
            let that = this;
            this.navigationMenuCloseTimeout = setTimeout(() => {
                that.navigationMenuClose();
            }, this.navigationMenuCloseDelay);
        },
        navigationMenuOpenFor(navElement, menu, focusFirstItem = false) {
            this.navigationMenuClearCloseTimeout();
            this.navigationMenuTrigger = navElement;
            this.navigationMenu = menu;
            this.navigationMenuOpen = true;

            if (focusFirstItem) {
                this.$nextTick(() => {
                    this.$refs.navigationDropdown
                        .querySelector(`[data-navigation-panel='${menu}'] a`)
                        ?.focus();
                });
            }
        },
        navigationMenuToggle(navElement, menu) {
            if (this.navigationMenuOpen && this.navigationMenu === menu) {
                this.navigationMenuClose();
                return;
            }

            this.navigationMenuOpenFor(navElement, menu);
        },
        navigationMenuClearCloseTimeout(){
            clearTimeout(this.navigationMenuCloseTimeout);
        },
        navigationMenuClose(returnFocus = false){
            this.navigationMenuClearCloseTimeout();
            this.navigationMenuOpen = false;
            this.navigationMenu = '';

            if (returnFocus) {
                this.navigationMenuTrigger?.focus();
            }
        }
    }"
     @keydown.escape.window="if (mobileMenuOpen) { mobileMenuOpen = false; activeMobileMenu = ''; $refs.mobileMenuToggle.focus(); } else if (navigationMenuOpen) { navigationMenuClose(true); }"
     @click.outside="navigationMenuClose(); mobileMenuOpen = false"
     @focusout="if (!$el.contains($event.relatedTarget)) { navigationMenuClose(); mobileMenuOpen = false; }"
     @resize.window="if (window.innerWidth >= 1024 && mobileMenuOpen) { mobileMenuOpen = false; activeMobileMenu = ''; $refs.navigationHome.focus(); } else if (window.innerWidth < 1024 && navigationMenuOpen) { navigationMenuClose(); $refs.mobileMenuToggle.focus(); }"
     class="glass-nav" aria-label="{{ __('Main navigation') }}">
    <div class="glass-nav-frame">
        <div class="glass-nav-bar">
            @include('navbar.partials.logo')
            @include('navbar.partials.desktopmenu', ['navigationItems' => $navigationItems])
            <div class="glass-nav-actions">
                @include('navbar.partials.dark_toggle')
                <livewire:home.pending-indicator />
                @include('navbar.partials.mobile_menu_toggle')
            </div>
        </div>
        @include('navbar.partials.mobilemenu', ['navigationItems' => $navigationItems])
        @include('navbar.partials.banner')
    </div>
    @include('navbar.partials.desktop_dropdown', ['navigationItems' => $navigationItems])
</nav>
