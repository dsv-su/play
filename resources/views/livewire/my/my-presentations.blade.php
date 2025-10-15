<div class="max-w-screen-xl mx-auto px-4 py-6 sm:px-6 lg:px-6 md:pt-8 md:pb-8 space-y-8">
    @include('home.partials.flashmessage-section')
    <livewire:search.index />
    <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between border-b border-gray-200 rounded-t-xl py-3 px-4 md:px-5 dark:border-neutral-700">
            <!-- Filters -->
            @include('livewire.search.partials.filter')
        </div>
        <br>

<div class="p-2 md:p-3">
    <!-- Accordian -->
    <div
        x-data="accordionGroup()"
        x-init="init()"
        class="mt-4 relative w-full mx-auto overflow-hidden
         text-base sm:text-lg md:text-xl font-normal bg-white
         border border-gray-200 divide-y divide-gray-200 rounded-md
         dark:text-white dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">

        @foreach ($videos as $courseId => $group)
            <div x-data="{ id: 'course-{{ $courseId }}' }" class="group">
                <!-- Accordion Button -->
                <button
                    @click="setActiveAccordion(id)"
                    @keydown.enter.prevent="setActiveAccordion(id)"
                    @keydown.space.prevent="setActiveAccordion(id)"
                    :aria-expanded="(activeAccordion === id).toString()"
                    :aria-controls="'panel-${id}'"
                    class="w-full p-3 sm:p-4 text-left select-none
                   flex items-center justify-between gap-3 sm:gap-4
                   hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600
                   dark:focus-visible:ring-blue-500">
                    <!-- Left: arrow + title (wrapping) -->
                    <span class="flex items-start sm:items-center gap-2 sm:gap-3 min-w-0 flex-1 flex-wrap">
                  <!-- Arrow -->
                  <svg class="w-4 h-4 sm:w-5 sm:h-5 duration-200 ease-out transform -rotate-90 mt-1 sm:mt-0"
                       :class="{ 'rotate-0': activeAccordion==id }"
                       viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                       fill="none" stroke="currentColor" stroke-width="2"
                       stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <polyline points="6 9 12 15 18 9"></polyline>
                  </svg>
                  <span class="leading-snug break-words hyphens-auto min-w-0">
                      {{ $this->courseTitles[$courseId] ?? __('Unknown course') }}
                  </span>

                  <a @click.stop href="#"
                     data-tooltip-target="playAll-tooltip"
                     class="shrink-0 inline-flex items-center gap-1
                           ml-0 sm:ml-2 mt-2 sm:mt-0
                           bg-blue-800 hover:bg-blue-900 text-white
                           text-sm sm:text-base font-semibold
                           px-2 sm:px-2.5 py-0.5 rounded border border-blue-900
                           dark:bg-blue-950 dark:text-white dark:border-blue-800">
                        {{ count($group) }}
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                          <path fill-rule="evenodd" d="M8.6 5.2A1 1 0 0 0 7 6v12a1 1 0 0 0 1.6.8l8-6a1 1 0 0 0 0-1.6l-8-6Z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                </span>
                </button>

                <!-- Accordion lazy Content -->
                <template x-if="activeAccordion === id">
                    <div
                        :id="'panel-${id}'"
                        tabindex="-1"
                        class="px-3 sm:px-4 pb-3 sm:pb-4">
                        <div x-data="{ switchOn: @entangle('switchOn') }">
                            <template x-if="!switchOn">
                                @include('livewire.search.partials.table')
                            </template>
                            <template x-if="switchOn">
                                @include('livewire.search.partials.grid')
                            </template>
                        </div>
                    </div>
                </template>

            </div>
        @endforeach
    </div>
    <!-- end accordian -->

</div>

<!-- Tooltips -->
@include('home.partials.tooltips')
@include('livewire.search.partials.tooltips')
</div>

</div>

<script>
/* ==========================================================================
HS + Livewire + URL sync  ⟺  Accordion with history support
- Safe accordion state (uses null sentinel, normalized string IDs)
- HS selects: robust init, delegated listeners, clear → native events (deferred)
- URL sync: replaceState for filters, pushState for accordion; preserves other params
- Livewire/DOM swaps covered via hooks + MutationObserver
========================================================================== */

/* ---------------------------
Accordion (global for Alpine)
--------------------------- */
function accordionGroup() {
return {
    // Use null as the “closed” sentinel to avoid falsy-string bugs like "0"
    activeAccordion: null,

    init() {
        const params = new URLSearchParams(window.location.search);
        const open = params.get('open');
        if (open != null && open !== '') this.activeAccordion = String(open);

        // Back/Forward → reflect URL into state
        window.addEventListener('popstate', () => {
            const p = new URLSearchParams(location.search);
            const v = p.get('open');
            this.activeAccordion = (v != null && v !== '') ? String(v) : null;
        });
    },

    setActiveAccordion(id) {
        const next = String(id);
        this.activeAccordion = (this.activeAccordion === next) ? null : next;

        // Write ?open=... (preserve other params and hash); push a history entry
        const url = new URL(window.location.href);
        if (this.activeAccordion) url.searchParams.set('open', this.activeAccordion);
        else url.searchParams.delete('open');
        history.pushState({}, '', url);

        // a11y focus after DOM updates
        this.$nextTick(() => {
            if (this.activeAccordion) {
                document.getElementById(`panel-${this.activeAccordion}`)?.focus({ preventScroll: true });
            }
        });
    }
}
}

/* ---------------------------
HS + Livewire + URL sync
--------------------------- */
(function () {
/* =========================
   HS INIT (KEEP STABLE UI)
   ========================= */
function hasHS(el) {
    try { return !!(window.HSSelect && window.HSSelect.getInstance && window.HSSelect.getInstance(el, true)); }
    catch (e) { return false; }
}
function createHS(el) {
    if (!el || hasHS(el)) return;
    try {
        if (window.HSSelect && window.HSSelect.getOrCreateInstance) {
            window.HSSelect.getOrCreateInstance(el);
        } else if (window.HSSelect) {
            new window.HSSelect(el);
        }
    } catch (e) {}
}
function ensureOnPage() {
    var nodes = document.querySelectorAll('select[data-hs-select]');
    for (var i = 0; i < nodes.length; i++) createHS(nodes[i]);
}

// Clear buttons: use HS API if present; always emit native events (deferred)
function wireClearButtons() {
    if (document._hsClearWired) return;
    document._hsClearWired = true;

    document.addEventListener('click', function (evt) {
        var t = evt.target;
        while (t && t !== document && !(t.classList && t.classList.contains('js-clear') && t.hasAttribute('data-target'))) {
            t = t.parentNode;
        }
        if (!t || t === document) return;

        var sel = document.querySelector(t.getAttribute('data-target'));
        if (!sel) return;

        var used = false;
        try {
            if (window.HSSelect && window.HSSelect.getInstance) {
                var inst = window.HSSelect.getInstance(sel, true);
                if (inst && typeof inst.clear === 'function') { inst.clear(); used = true; }
            }
        } catch (e) {}

        if (!used) {
            for (var i = 0; i < sel.options.length; i++) sel.options[i].selected = false;
            sel.value = ''; // ensure native value resets too
        }

        // Defer to next microtask so HS internal state settles before syncing
        Promise.resolve().then(() => {
            try { sel.dispatchEvent(new Event('input',  { bubbles: true })); } catch (e) {}
            try { sel.dispatchEvent(new Event('change', { bubbles: true })); } catch (e) {}
        });
    });
}

// Livewire hooks: init HS after patches and re-sync URL
var scheduled = false;
function scheduleEnsure() {
    if (scheduled) return;
    scheduled = true;
    setTimeout(function () { scheduled = false; ensureOnPage(); }, 0);
}

function hookLivewire() {
    try {
        if (window.Livewire && typeof Livewire.hook === 'function') {
            var isV3 = !!Livewire.__instanceManager || !!Livewire.router || !!Livewire.directive;
            if (isV3) {
                Livewire.hook('commit', function (payload) {
                    try { payload.succeed(function () { scheduleEnsure(); bootURL(); }); } catch (e) {}
                });
                window.addEventListener('livewire:navigated', function () { scheduleEnsure(); bootURL(); });
            } else {
                Livewire.hook('message.processed', function () { scheduleEnsure(); bootURL(); });
            }
        }
    } catch (e) {}
}

/* =========================
   URL SYNC (READ-ONLY for HS)
   ========================= */
var ID_FALLBACK = {
    'courses-select':    'course',
    'presenters-select': 'presenter',
    'terms-select':      'semester'
};
function enc(v){ return encodeURIComponent(String(v)); }
function uniq(arr){ var m={}, out=[], i; for(i=0;i<arr.length;i++){ if(!m[arr[i]]){ m[arr[i]]=1; out.push(arr[i]); } } return out; }
function getParamName(el){
    if (!el) return null;
    var p = el.getAttribute('data-url-param'); // safe custom attribute
    if (p) return p;
    var id = el.id || '';
    return ID_FALLBACK[id] || null;
}
// IMPORTANT: read native <select>
function readSelected(el){
    var vals=[], i, o;
    if (!el) return vals;
    for (i=0;i<el.options.length;i++){
        o = el.options[i];
        if (o.selected && o.value !== '') vals.push(String(o.value));
    }
    return vals;
}
function parseQueryPairs(search){
    var s = (search || '').replace(/^\?/, '');
    if (!s) return [];
    var parts = s.split('&'), pairs = [], i, eq, k, v;
    for (i=0;i<parts.length;i++){
        if (!parts[i]) continue;
        eq = parts[i].indexOf('=');
        k  = eq >= 0 ? parts[i].slice(0,eq) : parts[i];
        v  = eq >= 0 ? parts[i].slice(eq+1) : '';
        try { k = decodeURIComponent(k); } catch(e){}
        try { v = decodeURIComponent(v); } catch(e){}
        pairs.push([k,v]);
    }
    return pairs;
}
function stringifyPairs(pairs){
    if (!pairs || !pairs.length) return '';
    var out=[], i;
    for (i=0;i<pairs.length;i++) out.push(enc(pairs[i][0]) + '=' + enc(pairs[i][1]));
    return '?' + out.join('&');
}
function managedKeys(){
    var keys={}, out=[], nodes=document.querySelectorAll('select[data-hs-select]');
    for (var i=0;i<nodes.length;i++){
        var k = getParamName(nodes[i]);
        if (k && !keys[k]) { keys[k]=1; out.push(k); }
    }
    return out;
}
function buildQS(){
    var selects = document.querySelectorAll('select[data-hs-select]'), i, el, key;
    var keep = [], pairs = parseQueryPairs(window.location.search);
    var drop = {}, m = managedKeys(); for (i=0;i<m.length;i++) drop[m[i]] = 1;

    // Keep unrelated params (e.g. ?open=...) so accordion stays in sync
    for (i=0;i<pairs.length;i++) if (!drop[pairs[i][0]]) keep.push(pairs[i]);

    // Add managed params (CSV)
    for (i=0;i<selects.length;i++){
        el  = selects[i];
        key = getParamName(el);
        if (!key) continue;
        var vals = uniq(readSelected(el));
        if (vals.length) keep.push([key, vals.join(',')]);
    }
    return stringifyPairs(keep);
}

var lastQS = null;
function updateURLFromDOM(){
    try {
        var qs = buildQS();
        if (qs !== lastQS){
            lastQS = qs;
            if (window.history && window.history.replaceState){
                // Replace (not push) for filter changes to avoid clutter
                var url = new URL(window.location.href);
                url.search = qs; // preserves hash automatically
                history.replaceState(null, '', url);
            }
        }
    } catch(e){}
}

// Delegated listener so dynamically-inserted selects also trigger URL sync
function wireURLListeners() {
    if (document._delegatedURLSync) return;
    document._delegatedURLSync = true;

    document.addEventListener('change', function(e){
        var el = e.target;
        if (el && el.matches && el.matches('select[data-hs-select]')) {
            updateURLFromDOM();
        }
    }, true);
}

function bootURL(){
    wireURLListeners();
    // Reflect current selections (server defaults or HS-changed)
    updateURLFromDOM();
}

// MutationObserver: catch late-added selects; init HS then sync URL
function watchForSelects() {
    if (window._hsWatcher) return;
    window._hsWatcher = true;

    var mo = new MutationObserver(function(muts){
        var needsInit = false;
        for (var i=0;i<muts.length;i++){
            var m = muts[i];
            if (m.addedNodes) {
                for (var j=0;j<m.addedNodes.length;j++){
                    var n = m.addedNodes[j];
                    if (n.nodeType === 1) {
                        if (n.matches && n.matches('select[data-hs-select]')) { needsInit = true; }
                        var found = n.querySelectorAll ? n.querySelectorAll('select[data-hs-select]') : [];
                        if (found.length) { needsInit = true; }
                    }
                }
            }
        }
        if (needsInit) {
            ensureOnPage();
            setTimeout(updateURLFromDOM, 0);
        }
    });

    mo.observe(document.documentElement, { childList: true, subtree: true });
}

/* =========================
   BOOT
   ========================= */
function bootstrap() {
    wireClearButtons();   // clear → native change (deferred)
    hookLivewire();       // HS init after Livewire patches
    ensureOnPage();       // init existing selects on first paint
    bootURL();            // URL sync (non-destructive; preserves ?open)
    watchForSelects();    // cover Livewire swaps / late DOM
}

if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', bootstrap);
else bootstrap();
})();
</script>

