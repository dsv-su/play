// Delegation covers cards inserted, paginated, or replaced by Livewire.
const selector = ':is([data-presentation-card], .library-recording) [data-tooltip-target]';
let activeTrigger;
let tooltip;
let previousDescription;
let hideTimer;

function hideTooltip() {
    clearTimeout(hideTimer);
    if (activeTrigger) {
        if (previousDescription === null) activeTrigger.removeAttribute('aria-describedby');
        else activeTrigger.setAttribute('aria-describedby', previousDescription);
    }
    tooltip?.remove();
    tooltip = activeTrigger = null;
}

function scheduleHide() {
    clearTimeout(hideTimer);
    // Allow the pointer to cross the gap from the trigger to the tooltip.
    hideTimer = setTimeout(() => {
        if (activeTrigger?.matches(':hover, :focus-within') || tooltip?.matches(':hover')) return;
        hideTooltip();
    }, 150);
}

function showTooltip(trigger) {
    clearTimeout(hideTimer);
    if (activeTrigger === trigger) return;
    hideTooltip();
    const source = document.getElementById(trigger.dataset.tooltipTarget);
    if (!source) return;

    activeTrigger = trigger;
    previousDescription = trigger.getAttribute('aria-describedby');
    tooltip = document.createElement('div');
    tooltip.id = 'presentation-active-tooltip';
    tooltip.setAttribute('role', 'tooltip');
    tooltip.className = 'fixed rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white shadow-sm dark:bg-gray-700';
    Object.assign(tooltip.style, {
        zIndex: '1000', maxWidth: 'calc(100vw - 16px)',
        maxHeight: 'calc(100vh - 16px)', overflowY: 'auto',
    });
    tooltip.textContent = source.textContent.trim();
    tooltip.addEventListener('mouseenter', () => clearTimeout(hideTimer));
    tooltip.addEventListener('mouseleave', scheduleHide);
    document.body.append(tooltip);
    trigger.setAttribute('aria-describedby', [previousDescription, tooltip.id].filter(Boolean).join(' '));

    const rect = trigger.getBoundingClientRect();
    const bounds = tooltip.getBoundingClientRect();
    const left = Math.max(8, Math.min(rect.left + (rect.width - bounds.width) / 2, window.innerWidth - bounds.width - 8));
    const preferredTop = rect.top >= bounds.height + 8 ? rect.top - bounds.height - 8 : rect.bottom + 8;
    const top = Math.max(8, Math.min(preferredTop, window.innerHeight - bounds.height - 8));
    tooltip.style.left = `${left}px`;
    tooltip.style.top = `${top}px`;
}

function findTrigger(target) {
    if (!(target instanceof Element)) return null;
    return target.closest(selector);
}

document.addEventListener('mouseover', event => {
    const trigger = findTrigger(event.target);
    if (trigger && !trigger.contains(event.relatedTarget)) showTooltip(trigger);
});
document.addEventListener('mouseout', event => {
    if (activeTrigger?.contains(event.target) && !activeTrigger.contains(event.relatedTarget)) scheduleHide();
});
document.addEventListener('focusin', event => {
    const trigger = findTrigger(event.target);
    if (trigger) showTooltip(trigger);
    else if (activeTrigger && !tooltip?.contains(event.target)) scheduleHide();
});
document.addEventListener('focusout', event => {
    scheduleHide();
});
document.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
        hideTooltip();
    }
});
document.addEventListener('click', hideTooltip);
document.addEventListener('scroll', event => {
    if (event.target !== tooltip) hideTooltip();
}, true);
window.addEventListener('resize', hideTooltip);
document.addEventListener('livewire:navigating', hideTooltip);
new MutationObserver(() => {
    if (activeTrigger && !activeTrigger.isConnected) hideTooltip();
}).observe(document.documentElement, { childList: true, subtree: true });
