<nav x-data="{
        mobileMenuOpen: false,
        activeMobileMenu: '',
        navigationMenuOpen: false,
        navigationMenu: '',
        navigationMenuCloseDelay: 200,
        navigationMenuCloseTimeout: null,
        navigationMenuLeave() {
            let that = this;
            this.navigationMenuCloseTimeout = setTimeout(() => {
                that.navigationMenuClose();
            }, this.navigationMenuCloseDelay);
        },
        navigationMenuReposition(navElement) {
            this.navigationMenuClearCloseTimeout();
            this.$refs.navigationDropdown.style.left = navElement.offsetLeft + 'px';
            this.$refs.navigationDropdown.style.marginLeft = (navElement.offsetWidth/2) + 'px';
        },
        navigationMenuClearCloseTimeout(){
            clearTimeout(this.navigationMenuCloseTimeout);
        },
        navigationMenuClose(){
            this.navigationMenuOpen = false;
            this.navigationMenu = '';
        }
    }"
     class="relative z-20 w-full bg-white dark:bg-gray-800">

    <!-- Header with Logo, Desktop Nav, and Mobile Toggle -->
    <div class="flex items-center justify-between bg-dsv border-b border-susecondary px-4 py-2 dark:bg-gray-800">
        <!-- Logo -->
        @include('navbar.partials.logo')

        <!-- Desktop Navigation -->
        @include('navbar.partials.desktopmenu')

        <!-- Mobile Menu Toggle Button -->
        @include('navbar.partials.mobile_menu_toggle')
    </div>

    <!-- Mobile Navigation Menu -->
    @include('navbar.partials.mobilemenu')


    <!-- Desktop Dropdown Menu (only visible on md and up) -->
    @include('navbar.partials.desktop_dropdown')
</nav>

