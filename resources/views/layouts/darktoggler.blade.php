<script>
    (function () {
        const storageKey = 'color-theme';
        const root = document.documentElement;
        const buttons = Array.from(document.querySelectorAll('.theme-toggle'));
        if (!buttons.length) return;

        const getStored = () => { try { return localStorage.getItem(storageKey); } catch { return null; } };
        const setStored = (val) => { try { localStorage.setItem(storageKey, val); } catch {} };

        const isDark = () => root.classList.contains('dark');

        const applyTheme = (dark, { persist = false } = {}) => {
            root.classList.toggle('dark', dark);
            if (persist) setStored(dark ? 'dark' : 'light');
            syncButtons();
        };

        const syncButtons = () => {
            const dark = isDark();
            for (const btn of buttons) {
                const moon = btn.querySelector('[data-toggle-icon="moon"]');
                const sun  = btn.querySelector('[data-toggle-icon="sun"]');
                if (moon) moon.classList.toggle('hidden', dark);   // show moon when light
                if (sun)  sun.classList.toggle('hidden', !dark);   // show sun when dark
                btn.setAttribute('aria-pressed', String(dark));
                const label = dark ? 'Switch to light theme' : 'Switch to dark theme';
                btn.setAttribute('aria-label', label);
                btn.title = label;
            }
        };

        // Initial state: respect saved pref or OS
        const stored = getStored();
        if (stored === 'dark' || stored === 'light') {
            applyTheme(stored === 'dark');
        } else {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            applyTheme(prefersDark);
        }

        // Click handlers (all buttons)
        buttons.forEach(btn => btn.addEventListener('click', () => {
            applyTheme(!isDark(), { persist: true });
        }));

        // Follow system changes only if user hasn't chosen
        const mql = window.matchMedia('(prefers-color-scheme: dark)');
        (mql.addEventListener ? mql.addEventListener : mql.addListener).call(mql, 'change', (e) => {
            if (getStored()) return;
            applyTheme(e.matches);
        });
    })();
</script>
