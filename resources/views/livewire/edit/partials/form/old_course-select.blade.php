<!-- Select -->
<select multiple="" data-hs-select='{
  "placeholder": "Select",
  "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
  "optionClasses": "py-2 px-2 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
  "mode": "tags",
  "wrapperClasses": "relative pe-9 min-h-11.5 flex items-start flex-wrap w-full border border-gray-200 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400",
  "tagsItemTemplate": "<div class=\"flex flex-nowrap items-center relative z-10 bg-white border border-susecondary rounded-full p-1 m-2 dark:bg-neutral-900 dark:border-neutral-700\" data-tooltip-target=\"courseName-tooltip\" tabindex=\"0\" data-tooltip><div class=\"size-6 me-1\" data-icon></div><div class=\"whitespace-nowrap text-blue-800 dark:text-neutral-200\" data-title></div><div class=\"inline-flex shrink-0 justify-center items-center size-5 ms-2 rounded-full text-gray-800 bg-gray-200 hover:bg-gray-300 focus:outline-hidden focus:ring-2 focus:ring-gray-400 text-sm dark:bg-neutral-700/50 dark:hover:bg-neutral-700 dark:text-neutral-400 cursor-pointer\" data-remove><svg class=\"shrink-0 size-3\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M18 6 6 18\"/><path d=\"m6 6 12 12\"/></svg></div></div>",
    "tagsInputId": "hs-tags-input",
    "tagsInputClasses": "py-2.5 sm:py-3 px-2 min-w-36 rounded-lg order-1 border-transparent focus:ring-0 sm:text-sm outline-hidden dark:bg-neutral-900 dark:placeholder-neutral-500 dark:text-neutral-400",
    "optionTemplate": "<div class=\"flex items-center\"><div class=\"size-8 me-2\" data-icon></div><div><div class=\"text-sm font-semibold text-gray-800 dark:text-neutral-200 \" data-title></div><div class=\"text-xs text-gray-500 dark:text-neutral-500 \" data-description></div></div><div class=\"ms-auto\"><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-4 text-blue-600\" xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" viewBox=\"0 0 16 16\"><path d=\"M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z\"/></svg></span></div></div>",
    "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
  }' class="hidden">
    @foreach($courses as $course)
        <option value="">Choose</option>
        <option @if(isset($associatedCourseIds) && in_array($course->id, $associatedCourseIds, true)) selected @endif
                value="{{$course->id}}" data-tooltip="{{ $course->designation }} {{ $course->semester }}{{ $course->year }} | {{ $course->name }}" data-hs-select-option='{
          "description":  "{{ $course->designation }} {{ $course->semester }}{{ $course->year }} | {{ $course->name }}" }'>
            {{ $course->designation }} {{ $course->semester }}{{ $course->year }}</option>

    @endforeach
</select>
<!-- End Select -->

<!-- Tooltip holder -->
<div id="courseName-tooltip" role="tooltip"
     class="absolute z-30 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
     data-popper-placement="top">
    <span data-dynamic></span>
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>

<script>
    // Flowbite + hs-select: dynamic tooltip text per tag
    document.addEventListener('DOMContentLoaded', () => {
        const select = document.querySelector('select[data-hs-select]');
        if (!select) return;

        // The Flowbite tooltip element that tags point to
        const tooltipEl = document.getElementById('courseName-tooltip');
        if (!tooltipEl) return;

        // span
        const contentNode = tooltipEl.querySelector('[data-dynamic]');
        if (!contentNode) return;

        // (1) Matching <option> for a tag's visible label
        function findOptionForTag(tagEl) {
            const label = tagEl.querySelector('[data-title]')?.textContent?.trim();
            if (!label) return null;

            // Prefer currently selected options first
            const selected = Array.from(select.selectedOptions);
            let match = selected.find(o => o.text.trim() === label);
            if (match) return match;

            // Fallback: scan all options
            return Array.from(select.options).find(o => o.text.trim() === label) || null;
        }

        // (2) Attach listeners to a tag to update tooltip text on show
        function wireTag(tagEl) {
            // Skip if already wired
            if (tagEl.__flowbiteWired) return;
            tagEl.__flowbiteWired = true;

            const setText = () => {
                const opt = findOptionForTag(tagEl);
                const txt = opt?.dataset?.tooltip || tagEl.querySelector('[data-title]')?.textContent?.trim() || '';
                contentNode.textContent = txt;           // <- update Flowbite tooltip content
                tagEl.setAttribute('title', txt);        // optional: native tooltip fallback
                tagEl.setAttribute('data-tooltip', txt); // optional: useful for debugging
            };

            tagEl.addEventListener('mouseenter', setText, { passive: true });
            tagEl.addEventListener('focus', setText, true);
        }

        // (3) Bind all current tags and keep them in sync
        function bindAllTags() {
            const wrapper = select.closest('.hs-select') || select.parentElement;
            if (!wrapper) return;
            wrapper.querySelectorAll('[data-tooltip-target="courseName-tooltip"]').forEach(wireTag);
        }

        // Initial bind + rebind on selection change
        bindAllTags();
        select.addEventListener('change', bindAllTags);

        // Optional: observe DOM changes inside wrapper (tags added/removed)
        const wrapper = select.closest('.hs-select') || select.parentElement;
        if (wrapper) {
            new MutationObserver(() => bindAllTags()).observe(wrapper, { childList: true, subtree: true });
        }

        // Make sure Flowbite is initialized once
        if (window.initFlowbite) initFlowbite();
    });
</script>
