@once
    <script>
        /* ---- make accordionGroup global so any blade can use x-data="accordionGroup()" ---- */
        window.accordionGroup = function () {
            return {
                activeAccordion: null,
                init() {
                    const params = new URLSearchParams(window.location.search);
                    const open = params.get('open');
                    if (open != null && open !== '') this.activeAccordion = String(open);

                    window.addEventListener('popstate', () => {
                        const p = new URLSearchParams(location.search);
                        const v = p.get('open');
                        this.activeAccordion = (v != null && v !== '') ? String(v) : null;
                    });
                },
                setActiveAccordion(id) {
                    const next = String(id);
                    this.activeAccordion = (this.activeAccordion === next) ? null : next;

                    const url = new URL(window.location.href);
                    if (this.activeAccordion) url.searchParams.set('open', this.activeAccordion);
                    else url.searchParams.delete('open');
                    history.pushState({}, '', url);

                }
            }
        };

        /* ---- everything below can stay as-is from your script (HS init, URL sync, Livewire hooks) ---- */
        (function () {
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
                        sel.value = '';
                    }
                    Promise.resolve().then(() => {
                        try { sel.dispatchEvent(new Event('input',  { bubbles: true })); } catch (e) {}
                        try { sel.dispatchEvent(new Event('change', { bubbles: true })); } catch (e) {}
                    });
                });
            }
            var scheduled = false;
            function scheduleEnsure() { if (scheduled) return; scheduled = true; setTimeout(function () { scheduled = false; ensureOnPage(); }, 0); }
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
            var ID_FALLBACK = { 'courses-select':'course', 'presenters-select':'presenter', 'terms-select':'semester' };
            function enc(v){ return encodeURIComponent(String(v)); }
            function uniq(arr){ var m={}, out=[], i; for(i=0;i<arr.length;i++){ if(!m[arr[i]]){ m[arr[i]]=1; out.push(arr[i]); } } return out; }
            function getParamName(el){
                if (!el) return null;
                var p = el.getAttribute('data-url-param');
                if (p) return p;
                var id = el.id || '';
                return ID_FALLBACK[id] || null;
            }
            function readSelected(el){
                var vals=[], i, o; if (!el) return vals;
                for (i=0;i<el.options.length;i++){ o = el.options[i]; if (o.selected && o.value !== '') vals.push(String(o.value)); }
                return vals;
            }
            function parseQueryPairs(search){
                var s = (search || '').replace(/^\?/, ''); if (!s) return [];
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
                var out=[], i; for (i=0;i<pairs.length;i++) out.push(enc(pairs[i][0]) + '=' + enc(pairs[i][1]));
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
                for (i=0;i<pairs.length;i++) if (!drop[pairs[i][0]]) keep.push(pairs[i]);
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
                            var url = new URL(window.location.href);
                            url.search = qs;
                            history.replaceState(null, '', url);
                        }
                    }
                } catch(e){}
            }
            function wireURLListeners() {
                if (document._delegatedURLSync) return;
                document._delegatedURLSync = true;
                document.addEventListener('change', function(e){
                    var el = e.target;
                    if (el && el.matches && el.matches('select[data-hs-select]')) updateURLFromDOM();
                }, true);
            }
            function bootURL(){ wireURLListeners(); updateURLFromDOM(); }
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
            function bootstrap() {
                wireClearButtons();
                hookLivewire();
                ensureOnPage();
                bootURL();
                watchForSelects();
            }
            if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', bootstrap);
            else bootstrap();
        })();
    </script>
@endonce
