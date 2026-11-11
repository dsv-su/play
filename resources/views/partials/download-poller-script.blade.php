<script>
    (function () {
        if (window.__downloadStatusBooted) return; window.__downloadStatusBooted = true;

        const initialized = new WeakSet();
        function show(el){ if(el){ el.classList.remove('hidden'); el.setAttribute('aria-hidden','false'); } }
        function hide(el){ if(el){ el.classList.add('hidden');    el.setAttribute('aria-hidden','true');  } }
        function bootstrap() {
            document.querySelectorAll('[data-widget="download-status"]').forEach((container) => {
                if (initialized.has(container)) return;
                initialized.add(container);
                wireWidget(container);
            });
        }

        function wireWidget(container) {
            const vid        = container.dataset.videoId;
            const startUrl   = container.dataset.startUrl;
            const statusUrl  = container.dataset.statusUrl;
            const downloadUrl= container.dataset.downloadUrl;
            const autostart  = container.dataset.autostart === '1';

            const bar    = container.querySelector('[data-role="progress-bar"]');
            const barC   = container.querySelector('[data-role="bar-container"]');
            const text   = container.querySelector('[data-role="status-text"]');
            const detail = container.querySelector('[data-role="status-detail"]');

            // Try in-widget button first, otherwise fallback
            const btn = container.querySelector('[data-role="start-btn"]')
                || document.getElementById(`downloadBtn-${vid}`);

            let timer = null;
            let polling = false;
            let finished = false;
            let backoffMs = 0;
            const baseInterval = 1500 + Math.floor(Math.random() * 500);

            if (btn) {
                btn.addEventListener('click', start);
            } else if (autostart) {
                start(); //No button, but autostart requested
            } else {
                //No start control and no autostart — stay idle
                detail.textContent ||= @js(__('Click the prepare button to begin.'));
            }

            async function start() {
                try {
                    show(detail);
                    if (btn) btn.disabled = true;
                    text.textContent = @js(__('Starting…'));
                    detail.textContent = @js(__('Queuing download…'));

                    // Enqueue via GET; accept 2xx/3xx/empty. Include cookies if needed.
                    const res = await fetch(startUrl, {
                        method: 'GET',
                        headers: { 'Accept': 'application/json,*/*' },
                        redirect: 'follow',
                        credentials: 'include',
                        cache: 'no-store'
                    });
                    if (res.status >= 400) throw new Error(`enqueue failed with HTTP ${res.status}`);
                    await res.text().catch(() => null);
                    show(text);

                    show(barC);
                    startPolling();

                    // Optional: failsafe if nothing ever starts
                    setTimeout(() => {
                        if (!finished && polling) {
                            stopPolling();
                            if (btn) btn.disabled = false;
                            text.textContent = @js(__('Idle'));
                            detail.textContent = @js(__('Didn’t start. Try again.'));
                        }
                    }, 120000);
                } catch (e) {
                    console.error(e);
                    if (btn) btn.disabled = false;
                    text.textContent = @js(__('Idle'));
                    detail.textContent = @js(__('Could not start. Check network and try again.'));
                }
            }

            function startPolling() {
                if (polling || finished) return;
                polling = true;
                text.textContent = @js(__('Pending (0%)'));
                detail.textContent = @js(__('Working…'));
                scheduleNext(0);
            }

            async function poll() {
                if (!polling || finished || !document.body.contains(container)) return;

                try {
                    const res = await fetch(statusUrl, { headers: { 'Accept': 'application/json' }, cache: 'no-store' });
                    if (!res.ok) throw new Error('Status ' + res.status);
                    const data = await res.json();

                    const exists   = !!data.exists;
                    const status   = data.status ?? 'pending';
                    const statusLabels = {
                        pending: @js(__('Pending')),
                        stored: @js(__('Stored')),
                        processing: @js(__('Processing')),
                        failed: @js(__('Failed')),
                    };
                    const progress = Number.isFinite(+data.progress) ? Math.max(0, Math.min(100, +data.progress)) : 0;

                    bar.style.width = progress + '%';
                    bar.setAttribute('aria-valuenow', String(progress));
                    text.textContent = exists ? `${statusLabels[status] ?? status} (${progress}%)` : @js(__('Queued…'));
                    detail.textContent = exists
                        ? ((progress >= 100 || status === 'stored') ? @js(__('Finalizing…')) : @js(__('Working…')))
                        : @js(__('Waiting for preparation to begin…'));

                    if (exists && (status === 'stored' || progress >= 100)) {
                        stopPolling();
                        triggerDownload(downloadUrl);
                        detail.textContent = @js(__('Download started.'));
                        return;
                    }

                    backoffMs = 0;
                    scheduleNext(baseInterval);
                } catch (err) {
                    console.error('[download-status]', err);
                    detail.textContent = @js(__('Network issue… retrying.'));
                    backoffMs = Math.min((backoffMs || 1000) * 2, 10000);
                    scheduleNext(backoffMs);
                }
            }

            function scheduleNext(ms) {
                clearTimeout(timer);
                timer = setTimeout(poll, ms);
            }

            function stopPolling() {
                clearTimeout(timer);
                polling = false;
                finished = true;
            }
        }

        function triggerDownload(url) {
            const a = document.createElement('a');
            a.href = url;
            a.download = ''; // remove for inline open
            document.body.appendChild(a);
            a.click();
            a.remove();
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', bootstrap, { once: true });
        } else {
            bootstrap();
        }
        new MutationObserver(bootstrap).observe(document.body, { childList: true, subtree: true });
    })();
</script>
