<button x-ref="mobileMenuToggle" @click="mobileMenuOpen = !mobileMenuOpen; activeMobileMenu = ''; navigationMenuClose()"
        type="button" class="glass-nav-icon glass-nav-mobile-toggle"
        aria-label="{{ __('Toggle mobile menu') }}" aria-controls="mobile-navigation" :aria-expanded="mobileMenuOpen">
    <svg x-show="!mobileMenuOpen" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-width="1.7" d="M4 8h16M4 16h16" />
    </svg>
    <svg x-show="mobileMenuOpen" x-cloak width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-width="1.7" d="m6 6 12 12M6 18 18 6" />
    </svg>
</button>
