<div id="course-select-root" wire:key="course-select" wire:ignore>
    <!-- Select -->
    <select id="course-select"
            name="selected-courses" multiple="" data-hs-select='{
  "placeholder": "Select",
  "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
  "optionClasses": "py-2 px-2 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
  "mode": "tags",
  "wrapperClasses": "relative pe-9 min-h-11.5 flex items-start flex-wrap w-full border border-gray-200 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400",
  "tagsItemTemplate": "<div class=\"flex flex-nowrap items-center relative z-10 bg-white border border-susecondary rounded-full p-1 m-2 dark:bg-neutral-900 dark:border-neutral-700\" tabindex=\"0\" ><div class=\"size-6 me-1\" data-icon></div><div class=\"whitespace-nowrap text-blue-800 dark:text-neutral-200\" data-title></div><div class=\"inline-flex shrink-0 justify-center items-center size-5 ms-2 rounded-full text-gray-800 bg-gray-200 hover:bg-gray-300 focus:outline-hidden focus:ring-2 focus:ring-gray-400 text-sm dark:bg-neutral-700/50 dark:hover:bg-neutral-700 dark:text-neutral-400 cursor-pointer\" data-remove><svg class=\"shrink-0 size-3\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M18 6 6 18\"/><path d=\"m6 6 12 12\"/></svg></div></div>",
    "tagsInputId": "hs-tags-input",
    "tagsInputClasses": "py-2.5 sm:py-3 px-2 min-w-36 rounded-lg order-1 border-transparent focus:ring-0 sm:text-sm outline-hidden dark:bg-neutral-900 dark:placeholder-neutral-500 dark:text-neutral-400",
    "optionTemplate": "<div class=\"flex items-center\"><div class=\"size-8 me-2\" data-icon></div><div><div class=\"text-sm font-semibold text-gray-800 dark:text-neutral-200 \" tabindex=\"0\" data-title></div><div class=\"text-xs text-gray-500 dark:text-neutral-500 \" data-description></div></div><div class=\"ms-auto\"><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-4 text-blue-600\" xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" viewBox=\"0 0 16 16\"><path d=\"M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z\"/></svg></span></div></div>",
    "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
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
    <!-- End Select -->
</div>
@once
    @push('scripts')
        <script>
            /**
             * - Normalizes root param (component -> component.el)
             * - Strips legacy data-tooltip-target/data-tooltip/title
             * - Creates per-chip tooltip, hides others, and avoids duplicates
             * - Adds hidden #courseName-tooltip as a safety net
             */

            (function () {
                // ---- utils ---------------------------------------------------------------
                const isNode = (v) => v && (v.nodeType === 1 || v.nodeType === 9);
                const normRoot = (raw) => {
                    if (isNode(raw)) return raw;
                    if (raw && isNode(raw.el)) return raw.el; // Livewire component
                    return document;
                };

                let fbInitQueued = false;
                function queueFlowbiteInit(root) {
                    if (!window.initFlowbite) return;
                    if (fbInitQueued) return;
                    fbInitQueued = true;
                    requestAnimationFrame(() => {
                        fbInitQueued = false;
                        try { initFlowbite(normRoot(root)); } catch { initFlowbite(); }
                    });
                }

                function sweepBrokenTooltipTargets(root) {
                    const scope = root && (root.nodeType ? root : root.el) ? normRoot(root) : document;
                    scope.querySelectorAll('[data-tooltip-target]').forEach(el => {
                        const id = el.getAttribute('data-tooltip-target');
                        if (!id) return;
                        if (!document.getElementById(id)) {
                            // Remove the broken attribute so Flowbite won't throw
                            el.removeAttribute('data-tooltip-target');
                        }
                    });
                }

                // Modify queueFlowbiteInit to sweep before initializing:
                function queueFlowbiteInit(root) {
                    if (!window.initFlowbite) return;
                    if (fbInitQueued) return;
                    fbInitQueued = true;
                    requestAnimationFrame(() => {
                        fbInitQueued = false;
                        try {
                            // Ensure no element points to a missing tooltip before Flowbite scans
                            sweepBrokenTooltipTargets(root);
                            initFlowbite(normRoot(root));
                        } catch {
                            sweepBrokenTooltipTargets(document);
                            initFlowbite();
                        }
                    });
                }

                function ensureLegacyPlaceholder() {
                    // If any element still references #courseName-tooltip, ensure it exists so Flowbite won't throw.
                    if (!document.getElementById('courseName-tooltip')) {
                        const ghost = document.createElement('div');
                        ghost.id = 'courseName-tooltip';
                        ghost.setAttribute('role', 'tooltip');
                        ghost.style.display = 'none';
                        document.body.appendChild(ghost);
                    }
                }

                function sanitizeLegacyAttrs(root) {
                    const scope = normRoot(root);
                    // Remove hard-coded target so Flowbite doesn't bind to a missing tooltip
                    scope.querySelectorAll('[data-tooltip-target="courseName-tooltip"]').forEach(el => {
                        el.removeAttribute('data-tooltip-target');
                    });
                    // Remove string-tooltip mode & native title inside hs-select UIs
                    scope.querySelectorAll('.hs-select [data-tooltip]').forEach(el => el.removeAttribute('data-tooltip'));
                    scope.querySelectorAll('.hs-select [title]').forEach(el => el.removeAttribute('title'));
                }

                function hideAllTooltips() {
                    document.querySelectorAll('.tooltip').forEach(t => {
                        t.classList.remove('opacity-100');
                        t.classList.add('opacity-0', 'invisible');
                    });
                }

                // ---- main ---------------------------------------------------------------
                function boot(root) {
                    const scope = normRoot(root);

                    // Safety first: prevent Flowbite from erroring even if legacy triggers exist
                    ensureLegacyPlaceholder();
                    // Then strip legacy attributes inside this scope
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

                    /*const textForTag = (tagEl) => {
                        const label = tagEl.querySelector('[data-title]')?.textContent?.trim() || '';
                        if (!label) return '';
                        const selected = Array.from(select.selectedOptions);
                        const opt = selected.find(o => o.text.trim() === label)
                            || Array.from(select.options).find(o => o.text.trim() === label);
                        return (opt?.dataset?.tooltip || label || '').trim();
                    };*/
                    const textForTag = (tagEl) => {
                        const label = tagEl.querySelector('[data-title]')?.textContent?.trim() || '';
                        if (!label) return '';

                        const selected = Array.from(select.selectedOptions);
                        const opt = selected.find(o => o.text.trim() === label)
                            || Array.from(select.options).find(o => o.text.trim() === label);

                        // Example: use description instead of data-tooltip
                        return (opt?.dataset?.description || opt?.dataset?.tooltip || label || '').trim();
                    };

                    function ensureTooltip(tagEl) {
                        if (!isNode(tagEl) || tagEl.__hasTooltip) return;

                        // Clean anything that causes doubles
                        if (tagEl.getAttribute('data-tooltip-target') === 'courseName-tooltip') {
                            tagEl.removeAttribute('data-tooltip-target');
                        }
                        tagEl.removeAttribute('data-tooltip');
                        tagEl.removeAttribute('title');

                        // Reuse if exists, else create
                        let tipId = tagEl.getAttribute('data-tooltip-target');
                        let tip = tipId ? document.getElementById(tipId) : null;

                        if (!tip) {
                            tipId = `tag-tip-${Math.random().toString(36).slice(2,9)}`;
                            tip = document.createElement('div');
                            tip.id = tipId;
                            tip.setAttribute('role', 'tooltip');
                            tip.className = 'absolute z-30 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700';
                            tip.innerHTML = '<span data-dynamic></span><div class="tooltip-arrow" data-popper-arrow></div>';
                            document.body.appendChild(tip);
                            tagEl.setAttribute('data-tooltip-target', tipId);
                        }

                        // JIT content + hide others
                        const setText = () => {
                            hideAllTooltips();
                            const span = tip.querySelector('[data-dynamic]');
                            if (span) span.textContent = textForTag(tagEl);
                        };
                        tagEl.addEventListener('mouseenter', setText, { passive: true });
                        tagEl.addEventListener('touchstart', setText, { passive: true });

                        tagEl.__hasTooltip = true;
                        queueFlowbiteInit(tagEl);
                    }

                    // Initial pass after hs-select paints tags
                    requestAnimationFrame(() => {
                        if (!wrapper) return;
                        // Find tag roots by their [data-title] child
                        wrapper.querySelectorAll('[data-title]').forEach(node => {
                            const tag = node.closest('[tabindex]') || node;
                            ensureTooltip(tag);
                        });
                        // Back-compat: anything already with data-tooltip-target
                        wrapper.querySelectorAll('[data-tooltip-target]').forEach(ensureTooltip);
                    });

                    // Watch for added/removed chips
                    if (wrapper) {
                        new MutationObserver((mutations) => {
                            for (const m of mutations) {
                                m.addedNodes?.forEach(n => {
                                    if (!isNode(n)) return;
                                    // Tag-like nodes
                                    if (n.querySelector?.('[data-title]')) {
                                        const tag = n.closest?.('[tabindex]') || n;
                                        ensureTooltip(tag);
                                    }
                                    n.querySelectorAll?.('[data-title]').forEach(ch => {
                                        const tag = ch.closest('[tabindex]') || ch;
                                        ensureTooltip(tag);
                                    });
                                    // Legacy attributes on new nodes
                                    if (n.hasAttribute?.('data-tooltip-target')) ensureTooltip(n);
                                    n.querySelectorAll?.('[data-tooltip-target]').forEach(ensureTooltip);
                                });
                                m.removedNodes?.forEach(n => {
                                    if (!isNode(n)) return;

                                    // IMPORTANT: don't remove the tooltip node anymore (leave it in the DOM, hidden).
                                    // Instead, clear the attribute on the removed element (and its descendants) so
                                    // there are no lingering references.
                                    const clearAttr = el => {
                                        if (el?.removeAttribute) el.removeAttribute('data-tooltip-target');
                                    };

                                    // Clear on the removed node itself
                                    if (n.hasAttribute?.('data-tooltip-target')) clearAttr(n);

                                    // Clear on any descendants that had it
                                    n.querySelectorAll?.('[data-tooltip-target]').forEach(clearAttr);
                                });
                            }
                        }).observe(wrapper, { childList: true, subtree: true });
                    }
                }

                // Livewire v3
                document.addEventListener('livewire:navigated', () => boot(document));
            })();
        </script>
        <script>
            // Rebuild HS Select without tripping on missing wrappers
            function cleanAndInitHSSelectById(id) {
                const select = document.getElementById(id);
                if (!select) return;

                // 1) If a previous wrapper exists, unwrap the select back into the DOM
                const wrapper = select.closest('.hs-select');
                if (wrapper) {
                    try { wrapper.parentNode.insertBefore(select, wrapper); } catch {}
                    try { wrapper.remove(); } catch {}
                }

                // 2) Make sure it's visible before init (HS will hide it itself)
                select.classList.remove('hidden');

                // 3) Create a fresh instance
                try {
                    // Preline’s documented constructor
                    new window.HSSelect(select);
                } catch (e) {
                    console.error('HSSelect init failed', e);
                }
            }

            function reinitCoursesSelect() {
                // Run *after* Livewire patches the DOM
                requestAnimationFrame(() => cleanAndInitHSSelectById('course-select'));
            }

            // Livewire v3
            document.addEventListener('livewire:init', () => {
                reinitCoursesSelect();                      // first paint
                Livewire.hook('morph.updated', reinitCoursesSelect); // after any update
            });

            // Livewire v2 fallback (ignore if you’re on v3)
            document.addEventListener('livewire:load', () => {
                reinitCoursesSelect();
                Livewire.hook?.('message.processed', reinitCoursesSelect);
            });

            // Manual trigger from PHP if you refetch courses etc.
            // v3: $this->dispatch('reinit-courses-select');
            // v2: $this->dispatchBrowserEvent('reinit-courses-select');
            window.addEventListener('reinit-courses-select', reinitCoursesSelect);
        </script>
        <script>
            // Rebuild HS Select without tripping on missing wrappers
            function cleanAndInitHSSelectById(id) {
                const select = document.getElementById(id);
                if (!select) return;

                // 1) If a previous wrapper exists, unwrap the select back into the DOM
                const wrapper = select.closest('.hs-select');
                if (wrapper) {
                    try { wrapper.parentNode.insertBefore(select, wrapper); } catch {}
                    try { wrapper.remove(); } catch {}
                }

                // 2) Make sure it's visible before init (HS will hide it itself)
                select.classList.remove('hidden');

                // 3) Create a fresh instance
                try {
                    // Preline’s documented constructor
                    new window.HSSelect(select);
                } catch (e) {
                    console.error('HSSelect init failed', e);
                }
            }

            function reinitCoursesSelect() {
                // Run *after* Livewire patches the DOM
                requestAnimationFrame(() => cleanAndInitHSSelectById('course-select'));
            }

            // Livewire v3
            document.addEventListener('livewire:init', () => {
                reinitCoursesSelect();                      // first paint
                Livewire.hook('morph.updated', reinitCoursesSelect); // after any update
            });

            // Livewire v2 fallback (ignore if you’re on v3)
            document.addEventListener('livewire:load', () => {
                reinitCoursesSelect();
                Livewire.hook?.('message.processed', reinitCoursesSelect);
            });

            // Manual trigger from PHP if you refetch courses etc.
            // v3: $this->dispatch('reinit-courses-select');
            // v2: $this->dispatchBrowserEvent('reinit-courses-select');
            window.addEventListener('reinit-courses-select', reinitCoursesSelect);
        </script>




    @endpush
@endonce
