<div style="max-width: 520px; margin: 16px auto; padding: 12px; border: 1px solid #e5e7eb; border-radius: 12px; background: #ffffff; font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;">
    <form id="aiPromptForm" method="POST" action="{{ route('test.ai.prompt.submit') }}">
        @csrf

        <div style="display:flex; align-items:center; gap:10px;">
            <input
                id="aiPromptInput"
                name="prompt"
                type="text"
                placeholder="Ask…"
                aria-label="AI prompt"
                style="flex:1; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 10px; outline: none;"
                onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,.2)';"
                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';"
                required
            />
            <button
                type="submit"
                style="padding: 10px 14px; border: 1px solid #1d4ed8; background: #2563eb; color: #fff; border-radius: 10px; cursor: pointer; font-weight: 600;"
            >
                Send
            </button>
        </div>

        <div id="aiPromptHint" style="margin-top:8px; font-size:12px; color:#6b7280;">
            Sends to <code>/test/ai-prompt</code>
        </div>

        <div
            id="aiPromptResultBox"
            style="display:none; margin-top:10px; padding:10px 12px; border:1px solid #e5e7eb; border-radius:10px; background:#f9fafb;"
        >
            <div style="font-size:12px; color:#6b7280; margin-bottom:6px;">
                AI response
            </div>
            <div
                id="aiPromptResult"
                style="font-size:13px; color:#111827; white-space:pre-wrap;"
            ></div>
        </div>
    </form>
</div>

<script>
(function () {
    const form = document.getElementById('aiPromptForm');
    const resultBoxEl = document.getElementById('aiPromptResultBox');
    const resultEl = document.getElementById('aiPromptResult');

    if (!form || !resultBoxEl || !resultEl) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        resultBoxEl.style.display = 'block';
        resultEl.textContent = 'Play is Thinking...';

        try {
            const res = await fetch(form.action, {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: new FormData(form)
            });

            const payload = await res.json();

            if (!res.ok) {
                resultEl.textContent = payload?.message ?? 'Request failed.';
                return;
            }

            resultEl.textContent = payload?.answer ?? '';
        } catch (err) {
            resultEl.textContent = 'Network error.';
        }
    });
})();
</script>
