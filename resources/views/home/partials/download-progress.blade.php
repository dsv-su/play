<div
    id="download-status"
    data-status-url="{{ route('presentation.download.status', $video) }}"
    data-download-url="{{ route('zip.download', $video) }}"
    class="max-w-xl space-y-3"
>
    <div class="flex items-center justify-between">
        <span class="text-sm font-medium text-gray-700">Preparation status</span>
        <span id="status-text" class="text-xs text-gray-500">Starting…</span>
    </div>

    <!-- Progress bar -->
    <div class="w-full bg-gray-200/80 dark:bg-gray-800/60 rounded-full h-3 overflow-hidden">
        <div id="progress-bar" class="h-3 bg-blue-600 transition-[width] duration-500 ease-out" style="width: 0%"></div>
    </div>

    <p id="status-detail" class="text-xs text-gray-500"></p>
</div>

<script>
    (function () {
        const container = document.getElementById('download-status');
        const url = container.dataset.statusUrl;
        const downloadUrl = container.dataset.downloadUrl;
        const bar = document.getElementById('progress-bar');
        const text = document.getElementById('status-text');
        const detail = document.getElementById('status-detail');

        let timer = null;
        const intervalMs = 1500; // poll every 1.5s
        let backoffMs = 0;

        async function poll() {
            try {
                const res = await fetch(url, { headers: { 'Accept': 'application/json' }, cache: 'no-store' });
                if (!res.ok) throw new Error('Status ' + res.status);
                const data = await res.json();

                const exists = !!data.exists;
                const status = data.status ?? 'pending';
                const progress = Number.isFinite(+data.progress) ? Math.max(0, Math.min(100, +data.progress)) : 0;

                // Update UI
                bar.style.width = progress + '%';
                text.textContent = exists ? `${status} (${progress}%)` : 'Not created yet';
                detail.textContent = exists
                    ? (progress >= 100 ? 'Download starting…' : 'Working… keep this tab open.')
                    : 'Waiting for the file to be prepared.';

                // When ready -> trigger download automatically
                if (exists && (status === 'stored' || progress >= 100)) {
                    stop();
                    startDownload();
                    return;
                }

                scheduleNext(intervalMs);
            } catch (err) {
                console.error(err);
                detail.textContent = 'Having trouble reaching the server… retrying.';
                backoffMs = Math.min((backoffMs || 1000) * 2, 10000);
                scheduleNext(backoffMs);
            }
        }

        function startDownload() {
            // Create a hidden <a> element to trigger the download
            const link = document.createElement('a');
            link.href = downloadUrl;
            link.download = ''; // optional, lets browser infer filename
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            detail.textContent = 'Download should start automatically.';
        }

        function scheduleNext(ms) {
            clearTimeout(timer);
            timer = setTimeout(poll, ms);
        }

        function stop() {
            clearTimeout(timer);
            timer = null;
        }

        poll();
    })();
</script>
