<script>
    (function () {
        const storageKey = 'color-theme';
        const root = document.documentElement;
        const btn = document.getElementById('theme-toggle');
        if (!btn) return; // graceful no-op if button not found

        const iconDark = document.getElementById('theme-toggle-dark-icon');
        const iconLight = document.getElementById('theme-toggle-light-icon');

        const mql = window.matchMedia('(prefers-color-scheme: dark)');

        const getStored = () => {
            try { return localStorage.getItem(storageKey); } catch (_) { return null; }
        };
        const setStored = (val) => {
            try { localStorage.setItem(storageKey, val); } catch (_) {}
        };

        const currentTheme = () => root.classList.contains('dark') ? 'dark' : 'light';

        const applyTheme = (theme, { persist = false } = {}) => {
            if (theme === 'dark') root.classList.add('dark'); else root.classList.remove('dark');
            if (persist) setStored(theme);
            updateUI();
        };

        const updateUI = () => {
            const dark = currentTheme() === 'dark';
            // icons (optional elements)
            if (iconDark && iconLight) {
                iconDark.classList.toggle('hidden', dark);   // show moon when light
                iconLight.classList.toggle('hidden', !dark); // show sun when dark
            }
            // accessibility
            btn.setAttribute('aria-pressed', String(dark));
            btn.setAttribute('aria-label', dark ? 'Switch to light theme' : 'Switch to dark theme');
            btn.title = btn.getAttribute('aria-label');
        };

        // Initialize UI based on current class set in HEAD script
        updateUI();

        // Click toggles and persists preference
        btn.addEventListener('click', () => {
            const next = currentTheme() === 'dark' ? 'light' : 'dark';
            applyTheme(next, { persist: true });
        });

        // If user has NOT set a preference, follow system changes live
        mql.addEventListener?.('change', (e) => {
            if (getStored()) return; // user preference wins
            applyTheme(e.matches ? 'dark' : 'light', { persist: false });
        });
    })();
</script>
