// Delegate events so cards added or replaced by Livewire work immediately.
const selector = '[data-presentation-card] [data-tooltip-target]';
let activeTrigger;
let tooltip;
let previousDescription;

function hideTooltip() {
    if (activeTrigger) {
        if (previousDescription === null) activeTrigger.removeAttribute('aria-describedby');
        else activeTrigger.setAttribute('aria-describedby', previousDescription);
    }
    tooltip?.remove();
    tooltip = activeTrigger = null;
}

function showTooltip(trigger) {
    if (activeTrigger === trigger) return;
    hideTooltip();
    const source = document.getElementById(trigger.dataset.tooltipTarget);
    if (!source) return;

    activeTrigger = trigger;
    previousDescription = trigger.getAttribute('aria-describedby');
    tooltip = document.createElement('div');
    tooltip.id = 'presentation-active-tooltip';
    tooltip.setAttribute('role', 'tooltip');
    tooltip.className = 'fixed pointer-events-none rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white shadow-sm dark:bg-gray-700';
    tooltip.style.zIndex = '1000';
    tooltip.style.maxWidth = 'calc(100vw - 16px)';
    tooltip.textContent = source.textContent.trim();
    document.body.append(tooltip);
    trigger.setAttribute('aria-describedby', [previousDescription, tooltip.id].filter(Boolean).join(' '));

    const rect = trigger.getBoundingClientRect();
    const bounds = tooltip.getBoundingClientRect();
    const left = Math.max(8, Math.min(rect.left + (rect.width - bounds.width) / 2, window.innerWidth - bounds.width - 8));
    const top = rect.top >= bounds.height + 8 ? rect.top - bounds.height - 8 : rect.bottom + 8;
    tooltip.style.left = `${left}px`;
    tooltip.style.top = `${top}px`;
}

document.addEventListener('mouseover', event => {
    const trigger = event.target.closest(selector);
    if (trigger) showTooltip(trigger);
});
document.addEventListener('mouseout', event => {
    if (activeTrigger && activeTrigger.contains(event.target) && !activeTrigger.contains(event.relatedTarget)) hideTooltip();
});
document.addEventListener('focusin', event => {
    const trigger = event.target.closest(selector);
    if (trigger) showTooltip(trigger);
});
document.addEventListener('focusout', hideTooltip);
document.addEventListener('keydown', event => {
    if (event.key === 'Escape') hideTooltip();
});
document.addEventListener('click', hideTooltip);
document.addEventListener('scroll', hideTooltip, true);
window.addEventListener('resize', hideTooltip);
document.addEventListener('livewire:navigating', hideTooltip);
new MutationObserver(() => {
    if (activeTrigger && !activeTrigger.isConnected) hideTooltip();
}).observe(document.documentElement, { childList: true, subtree: true });
