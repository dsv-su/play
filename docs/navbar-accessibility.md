# Navbar and banner accessibility review

Reviewed 17 November 2026 against WCAG 2.2 Level AA. Scope: the updated navbar, logo, desktop and mobile navigation, theme control, pending indicator, and attached announcement banner. This review does not establish whole-site conformance.

## Fixes

- Keyboard-focused dropdowns remain open when the pointer leaves (1.4.13, 2.1.1).
- Mobile navigation follows its toggle in the tab order, before banner actions (2.4.3).
- Escape dismisses menus and returns focus to their trigger. Banner dismissal returns focus to the home link. Crossing responsive breakpoints restores focus to a visible control (2.4.3, 2.4.7).
- Dark focus rings on the light banner override the dark theme's pale focus color (1.4.11, 2.4.7).
- Navigation wraps with enlarged text and increased text spacing (1.4.4, 1.4.10, 1.4.12).
- Tooltips remain available while hovered or keyboard-focused, and Escape dismisses them (1.4.13).
- Removed the indefinitely animated notification ping (2.2.2).
- Pending counts have a high-contrast badge, an accessible link label, and a polite status region (1.4.3, 4.1.2, 4.1.3).
- Current links use an underline as well as color. Controls retain native link/button semantics, accessible names, expanded states, and controlled-element references (1.4.1, 4.1.2).
- Added Swedish translations for new accessible labels and a stable name for the pressed-state theme toggle (3.1.2, 4.1.2).
- Increased glass opacity and darkened secondary text to maintain contrast over variable page backgrounds (1.4.3).

## Verification

Tested the local Laravel-rendered page in Chrome with the built production stylesheet injected: the configured Vite development endpoint was unavailable to the browser. This also resulted in unrelated share-modal JavaScript errors, so the entire page was not validated.

- Keyboard opening, arrow-down entry, Escape, focus return, and visible target sizes: passed at 320, 390, 768, 1024, and 1440 CSS pixels.
- Navbar interactive targets were at least 24 × 24 CSS pixels in the tested states (2.5.8). Main icon buttons are 44 × 44 pixels.
- 200% text size combined with WCAG text-spacing overrides: no navbar controls extended beyond the viewport at 320, 1024, and 1440 CSS pixels.
- axe-core 4.10.3, WCAG A/AA tags through WCAG 2.2: no automatic violations in the navbar in open desktop/mobile menu states, in both themes.
- axe flagged some gradient and overlapping/translucent backgrounds for manual contrast review. Automatic results alone are insufficient for these elements.
- Production build and whitespace validation passed.

Calculated conservative contrast ratios, compositing the glass over black in the light theme and white in the dark theme, including hover backgrounds:

| Content | Light | Dark | AA minimum |
| --- | --- | --- | --- |
| Main text | 10.67:1 | 8.22:1 | 4.5:1 |
| Secondary text | 6.15:1 | 4.96:1 | 4.5:1 |
| Accent text | 4.70:1 | 5.45:1 | 4.5:1 |
| Banner message | 10.58:1 | 10.58:1 | 4.5:1 |
| Banner link | 7.26:1 | 7.26:1 | 4.5:1 |

The pale DSV logo border is decorative; the readable DSV/Play text and accessible home-link name identify the control.

## Remaining manual verification

Before claiming WCAG 2.2 AA conformance, verify VoiceOver/Safari and NVDA/Firefox announcements and navigation; actual browser zoom to 400%; focus visibility and obscuration through every tab stop, including scrolling with long banner content; forced-colors rendering; touch and magnification; and all supported role, language, and banner-content combinations. These have not all been verified in this review. Review other page components separately for whole-page and complete-process conformance.
