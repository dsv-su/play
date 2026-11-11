@script
<script>
    (() => {
        // Keep shareable CSV filter URLs without installing global listeners.
        const libraryFilters = {
            selectedCourses: 'course',
            selectedPresenters: 'presenter',
            selectedSemesters: 'semester',
            selectedTags: 'tag',
        };
        let libraryUrlQueued = false;
        function syncLibraryFilters() {
            if (libraryUrlQueued) return;
            libraryUrlQueued = true;
            queueMicrotask(() => {
                libraryUrlQueued = false;
                const url = new URL(window.location.href);
                for (const [property, parameter] of Object.entries(libraryFilters)) {
                    const values = $wire.$get(property) || [];
                    if (values.length) url.searchParams.set(parameter, values.join(','));
                    else url.searchParams.delete(parameter);
                }
                history.replaceState(history.state, '', url);
            });
        }
        for (const property of Object.keys(libraryFilters)) {
            $wire.$watch(property, syncLibraryFilters);
        }
    })();
</script>
@endscript
