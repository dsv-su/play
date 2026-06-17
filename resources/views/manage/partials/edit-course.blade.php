<!-- Select -->
<select id="course-select"
        name="selected-courses[]"
        multiple
        aria-label="{{ __('Associated course(s)') }}"
        aria-describedby="course-select-description"
        data-hs-select='{
"placeholder": "Select",
"dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
"optionClasses": "py-2 px-2 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
"mode": "tags",
"wrapperClasses": "relative pe-9 min-h-11.5 flex items-start flex-wrap w-full bg-gray-50 border border-gray-200 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400",
"tagsItemTemplate": "<div class=\"flex flex-nowrap items-center relative z-10 bg-white border border-susecondary rounded-full p-1 m-2 dark:bg-neutral-900 dark:border-neutral-700\" tabindex=\"0\" ><div class=\"size-6 me-1\" data-icon aria-hidden=\"true\"></div><div class=\"whitespace-nowrap text-blue-800 dark:text-neutral-200\" data-title></div><div class=\"inline-flex shrink-0 justify-center items-center size-6 ms-2 rounded-full text-gray-800 bg-gray-200 hover:bg-gray-300 focus:outline-hidden focus:ring-2 focus:ring-gray-400 text-sm dark:bg-neutral-700/50 dark:hover:bg-neutral-700 dark:text-neutral-400 cursor-pointer\" role=\"button\" tabindex=\"0\" aria-label=\"Remove course\" onkeydown=\"if (event.keyCode === 13 || event.keyCode === 32) { event.preventDefault(); this.click(); }\" data-remove><svg class=\"shrink-0 size-3\" aria-hidden=\"true\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M18 6 6 18\"/><path d=\"m6 6 12 12\"/></svg></div></div>",
"tagsInputId": "hs-tags-input",
"tagsInputClasses": "py-2.5 sm:py-3 px-2 min-w-28 md:min-w-56 bg-gray-50 rounded-lg order-1 border-transparent focus:ring-0 sm:text-sm outline-hidden dark:bg-neutral-900 dark:placeholder-neutral-500 dark:text-neutral-400",
"optionTemplate": "<div class=\"flex items-center\"><div class=\"size-8 me-2\" data-icon aria-hidden=\"true\"></div><div><div class=\"text-sm font-semibold text-gray-800 dark:text-neutral-200 \" tabindex=\"0\" data-title></div><div class=\"text-xs text-gray-500 dark:text-neutral-500 \" data-description></div></div><div class=\"ms-auto\"><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-4 text-blue-600\" aria-hidden=\"true\" xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" viewBox=\"0 0 16 16\"><path d=\"M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z\"/></svg></span></div></div>",
"extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" aria-hidden=\"true\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
}' class="hidden">
    @foreach($courses as $course)
    <option @if(isset($associatedCourseIds) && in_array($course->id, $associatedCourseIds, true)) selected @endif
        value="{{$course->id}}"
        data-description="{{ $course->designation }} {{ $course->semester }}{{ $course->year }} | {{ $course->name }}"
        data-hs-select-option='{
        "description":  "{{ $course->designation }} {{ $course->semester }}{{ $course->year }} | {{ $course->name }}" }'>
        {{ $course->designation }} {{ $course->semester }}{{ $course->year }}</option>

    @endforeach
</select>
<script>
    (function () {
        // --- helpers --
        const onDOMReady = (fn) =>
            (document.readyState === 'loading')
                ? document.addEventListener('DOMContentLoaded', fn, { once: true })
                : fn();

        const onLivewireReady = (fn) => {
            // Livewire v3
            if (window.Livewire && typeof window.Livewire.onLoad === 'function') {
                window.Livewire.onLoad(fn);
                return;
            }

            setTimeout(fn, 0);
        };

        const onAlpineReady = (fn) => {
            if (window.Alpine && window.Alpine.version) {
                // Alpine already booted
                queueMicrotask(fn);
            } else {
                window.addEventListener('alpine:init', () => fn(), { once: true });
                // Fallback after full window load just in case
                window.addEventListener('load', () => fn(), { once: true });
            }
        };

        const raf = (n, fn) => {
            // run after n animation frames
            let c = 0;
            const step = () => (++c >= n) ? fn() : requestAnimationFrame(step);
            requestAnimationFrame(step);
        };

        // --- main ---
        onDOMReady(() => {
            const sel = document.getElementById('course-select');
            if (!sel) return;

            const toIds = () => Array.from(sel.selectedOptions).map(o => o.value);

            const send = () => {
                window.dispatchEvent(new CustomEvent('courses-selected', {
                    detail: { ids: toIds() }
                }));
            };

            // keep changes streaming
            sel.addEventListener('change', send);

            // send initial ONCE after everything is mounted
            let sent = false;
            const sendInitialOnce = () => {
                if (sent) return;
                sent = true;
                send();
            };

            // 1) wait for Livewire
            onLivewireReady(() => {
                // 2) wait a couple frames for hs-select/DOM to settle
                raf(2, () => {
                    // 3) if Alpine is used for the listener, ensure it's ready too
                    onAlpineReady(() => {
                        // 4) final small tick to be extra safe
                        setTimeout(sendInitialOnce, 0);
                    });
                });
            });

            // ultimate fallback in case no Livewire hooks fire (defensive)
            setTimeout(() => { if (!sent) sendInitialOnce(); }, 1000);
        });
    })();
</script>
<script>
    (function () {
        const isNode = (v) => v && (v.nodeType === 1 || v.nodeType === 9);
        const normRoot = (raw) => (isNode(raw) ? raw : document);

        function hideAllTooltips() {
            document.querySelectorAll('.tooltip[data-hs-tags-tip="1"]').forEach(t => {
                t.classList.remove('opacity-100');
                t.classList.add('opacity-0', 'invisible');
            });
        }

        function sweepBrokenTooltipTargets(scope) {
            scope.querySelectorAll('[data-tooltip-target]').forEach(el => {
                const id = el.getAttribute('data-tooltip-target');
                if (id && !document.getElementById(id)) el.removeAttribute('data-tooltip-target');
            });
        }

        let fbInitQueued = false;
        function queueFlowbiteInit(root) {
            if (typeof window.initFlowbite !== 'function') return;
            if (fbInitQueued) return;
            fbInitQueued = true;
            requestAnimationFrame(() => {
                fbInitQueued = false;
                const scope = normRoot(root);
                try { sweepBrokenTooltipTargets(scope); window.initFlowbite(scope); }
                catch { sweepBrokenTooltipTargets(document); window.initFlowbite(); }
            });
        }

        function ensureLegacyPlaceholder() {
            if (!document.getElementById('courseName-tooltip')) {
                const ghost = document.createElement('div');
                ghost.id = 'courseName-tooltip';
                ghost.setAttribute('role', 'tooltip');
                ghost.style.display = 'none';
                document.body.appendChild(ghost);
            }
        }

        function sanitizeLegacyAttrs(scope) {
            scope.querySelectorAll('[data-tooltip-target="courseName-tooltip"]').forEach(el => {
                el.removeAttribute('data-tooltip-target');
            });
            scope.querySelectorAll('.hs-select [data-tooltip]').forEach(el => el.removeAttribute('data-tooltip'));
            scope.querySelectorAll('.hs-select [title]').forEach(el => el.removeAttribute('title'));
        }

        function boot(root) {
            const scope = normRoot(root);
            ensureLegacyPlaceholder();
            sanitizeLegacyAttrs(scope);
            const selects = Array.from(scope.querySelectorAll('select[data-hs-select]'));
            for (const select of selects) {
                if (select.__hsTagsTooltipsInit) continue;
                select.__hsTagsTooltipsInit = true;
                setupSelect(select);
            }
        }

        function setupSelect(select) {
            const wrapper = select.closest('.hs-select') || select.parentElement;
            const ownerId = select.id || 'hs-tags-' + Math.random().toString(36).slice(2, 9);

            const getOptDescription = (opt) =>
                (opt?.dataset?.description || opt?.dataset?.tooltip || (opt?.text || '').trim() || '').trim();

            function ensureTooltip(tagEl) {
                if (!isNode(tagEl) || tagEl.__hasTooltip) return;

                // strip legacy attrs
                if (tagEl.getAttribute('data-tooltip-target') === 'courseName-tooltip') {
                    tagEl.removeAttribute('data-tooltip-target');
                }
                tagEl.removeAttribute('data-tooltip');
                tagEl.removeAttribute('title');

                // map value onto the tag (so duplicates are fine)
                if (!tagEl.dataset.value) {
                    const label = tagEl.querySelector('[data-title]')?.textContent?.trim() || '';
                    const selected = Array.from(select.selectedOptions);
                    const viaSelected = selected.find(o => o.text.trim() === label);
                    const viaAll = viaSelected || Array.from(select.options).find(o => o.text.trim() === label);
                    if (viaAll) tagEl.dataset.value = viaAll.value;
                }

                // --- LAZY CREATION ---
                let tip = null; // not created yet

                const getOrCreateTip = () => {
                    if (tip && document.body.contains(tip)) return tip;
                    const tipId = `tag-tip-${Math.random().toString(36).slice(2, 9)}`;
                    tip = document.createElement('div');
                    tip.id = tipId;
                    tip.setAttribute('role', 'tooltip');
                    tip.className = 'absolute z-30 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700';
                    tip.dataset.hsTagsTip = '1';
                    tip.dataset.hsTagsOwner = ownerId;
                    tip.style.maxWidth = 'min(80vw, 40rem)';
                    tip.style.wordBreak = 'break-word';
                    tip.innerHTML = '<span data-dynamic aria-live="polite"></span><div class="tooltip-arrow" data-popper-arrow></div>';
                    document.body.appendChild(tip);
                    tagEl.setAttribute('data-tooltip-target', tipId);
                    return tip;
                };

                const setText = () => {
                    const t = getOrCreateTip();
                    const val = tagEl.dataset.value;
                    const opt = val != null ? Array.from(select.options).find(o => o.value === val) : null;
                    const text = getOptDescription(opt) || (tagEl.querySelector('[data-title]')?.textContent?.trim() || '');
                    const span = t.querySelector('[data-dynamic]');
                    if (span) span.textContent = text;
                    return t;
                };

                const show = () => {
                    hideAllTooltips();
                    const t = setText();
                    tagEl.setAttribute('aria-describedby', t.id);
                    queueFlowbiteInit(tagEl);
                };
                const hide = () => {
                    tagEl.removeAttribute('aria-describedby');
                };

                tagEl.addEventListener('mouseenter', show, { passive: true });
                tagEl.addEventListener('mouseleave', hide, { passive: true });
                tagEl.addEventListener('touchstart', show, { passive: true });
                tagEl.addEventListener('focus', show, { passive: true });
                tagEl.addEventListener('blur', hide, { passive: true });
                tagEl.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') hideAllTooltips();
                }, { passive: true });

                tagEl.__hasTooltip = true;
            }

            // First paint — only tags that exist (i.e., selections) get lightweight listeners; no tooltips created yet
            requestAnimationFrame(() => {
                if (!wrapper) return;
                wrapper.querySelectorAll('[data-title]').forEach(node => {
                    const tag = node.closest('[tabindex]') || node;
                    ensureTooltip(tag);
                });
                wrapper.querySelectorAll('[data-tooltip-target]').forEach(ensureTooltip);
            });

            // Observe dynamic chip add/remove (again: no tooltip nodes until interaction)
            const mo = new MutationObserver((mutations) => {
                for (const m of mutations) {
                    m.addedNodes?.forEach(n => {
                        if (!isNode(n)) return;
                        if (n.querySelector?.('[data-title]')) {
                            const tag = n.closest?.('[tabindex]') || n;
                            ensureTooltip(tag);
                        }
                        n.querySelectorAll?.('[data-title]').forEach(ch => {
                            const tag = ch.closest('[tabindex]') || ch;
                            ensureTooltip(tag);
                        });
                        if (n.hasAttribute?.('data-tooltip-target')) ensureTooltip(n);
                        n.querySelectorAll?.('[data-tooltip-target]').forEach(ensureTooltip);
                    });
                    m.removedNodes?.forEach(n => {
                        if (!isNode(n)) return;
                        const clearAttr = el => { if (el?.removeAttribute) el.removeAttribute('data-tooltip-target'); };
                        if (n.hasAttribute?.('data-tooltip-target')) clearAttr(n);
                        n.querySelectorAll?.('[data-tooltip-target]').forEach(clearAttr);
                    });
                }
            });
            if (wrapper) mo.observe(wrapper, { childList: true, subtree: true });

            // Cleanup on unmount: remove only tooltips that were actually created for this select
            const parentForUnmount = wrapper?.parentNode || document;
            const ro = new MutationObserver((muts) => {
                muts.forEach(m => {
                    m.removedNodes?.forEach(n => {
                        if (n === wrapper) {
                            try { mo.disconnect(); } catch {}
                            document.querySelectorAll('[data-hs-tags-owner="' + ownerId + '"]').forEach(t => t.remove());
                            try { ro.disconnect(); } catch {}
                        }
                    });
                });
            });
            ro.observe(parentForUnmount, { childList: true });
        }

        // public API
        window.hsTagsTooltipsInit = boot;

        // Auto-boot
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => boot(document));
        } else {
            boot(document);
        }
    })();
</script>
