<div class="md:hidden">
    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" aria-label="Toggle mobile menu"
            class="inline-flex items-center justify-center p-2 rounded-md focus:outline-none dark:text-white">
        <svg x-show="!mobileMenuOpen" class="block h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <svg x-show="mobileMenuOpen" class="block h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
