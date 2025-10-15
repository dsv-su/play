import 'flowbite';
import 'flowbite/dist/datepicker';
//import '../css/site.css'
import 'preline'
import '@preline/carousel'

// site.js
import _ from 'lodash';
import Dropzone from 'dropzone';
window._ = _;
window.Dropzone = Dropzone;
import '@preline/file-upload';

/* ---------- Helpers ---------- */

function readOptions(el) {
    try { return JSON.parse(el.getAttribute('data-hs-file-upload') || '{}'); }
    catch { return {}; }
}

function writeOptions(el, opts) {
    el.setAttribute('data-hs-file-upload', JSON.stringify(opts));
}

function parseUploadUrl(el) {
    // Prefer the URL from data-attr options instead of inst.options
    const opts = readOptions(el);
    const raw = opts.url || '';
    try { return new URL(raw, window.location.origin); }
    catch { return null; }
}

/* ---------- Global init (once) ---------- */
document.addEventListener('DOMContentLoaded', () => {
    try { window.HSStaticMethods?.autoInit?.(); } catch (e) { console.error(e); }
});

/* =======================================================================
   1) MAIN CHUNK UPLOADER (single, id="hs-file-upload")
   ======================================================================= */
document.addEventListener('DOMContentLoaded', () => {
    const el = document.getElementById('hs-file-upload');
    if (!el) return;

    // patch options on the element first
    const opts = readOptions(el);
    opts.paramName = 'file';
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    if (csrf) {
        opts.headers = { ...(opts.headers || {}), 'X-CSRF-TOKEN': csrf };
    }
    writeOptions(el, opts);

    // initialize and get instance
    window.HSFileUpload?.autoInit?.();
    const inst = window.HSFileUpload.getInstance(el);
    if (!inst) return;

    const dz = inst.dropzone;
    if (!dz) return;

    // derive localdir from data-attr
    const localdir = el.dataset.localdir;
    const bt = document.getElementById('submit');

    dz.on('addedfile', (file) => {
        file._clientName = file.name;
    });

    dz.on('sending', (file) => {
        file._dzFilename = file.upload?.filename || file.name;
    });

    dz.on('success', (file, resp) => {
        let data = resp;
        if (typeof resp === 'string') { try { data = JSON.parse(resp); } catch { data = {}; } }

        file._serverId   = data?.id   ?? null;
        file._serverPath = data?.path ?? null;
        file._serverName = data?.name ?? data?.filename ?? file._dzFilename ?? file.name;

        // border green
        const box = file.previewElement;
        if (box) {
            box.classList.remove('border-gray-200', 'dark:border-neutral-700', 'border-red-500');
            box.classList.add('border-green-500', 'dark:border-green-500');
        }

        // inline video preview
        const vid = file.previewElement?.querySelector('[data-preview-video]');
        // To set this, set file._playUrl before (server or blob).
        // const serverUrl = data?.playback_url || data?.url || null;
        // file._playUrl = serverUrl || URL.createObjectURL(file);
        if (vid && file._playUrl) {
            vid.src = file._playUrl;
            vid.classList.remove('hidden');
            vid.load?.();
        }

        //Submit button
        bt.disabled = false;
    });

    dz.on('error', (file) => {
        const box = file.previewElement;
        if (box) {
            box.classList.remove('border-gray-200', 'dark:border-neutral-700', 'border-green-500');
            box.classList.add('border-red-500');
        }
    });

    dz.on('removedfile', async (file) => {
        const payload = {
            localdir,
            id:   file._serverId ?? null,
            path: file._serverPath ?? null,
            name: file._serverName ?? file._dzFilename ?? file._clientName ?? file.name ?? null,
            uuid: file.upload?.uuid ?? null,
            size: file.size ?? null,
            type: file.type ?? null
        };

        try {
            await fetch('/chunk/delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    ...(csrf ? { 'X-CSRF-TOKEN': csrf } : {})
                },
                body: JSON.stringify(payload)
            });
        } catch (e) {
            console.error('chunk delete failed', e);
        }
    });
});

/* =======================================================================
   2) THUMB UPLOADER(S) (one or many, marked with data-module="thumb-uploader")
   ======================================================================= */
const wired = new WeakSet();

function initThumbUploader(el) {
    if (wired.has(el)) return;
    wired.add(el);

    // Ensure options on element (don’t rely on inst.options)
    const opts = readOptions(el);
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    if (csrf) {
        opts.headers = { ...(opts.headers || {}), 'X-CSRF-TOKEN': csrf };
    }
    writeOptions(el, opts);

    window.HSFileUpload?.autoInit?.();
    const inst = window.HSFileUpload.getInstance(el);
    if (!inst) return;

    const dz = inst.dropzone;
    if (!dz || dz.__thumbWired) return;
    dz.__thumbWired = true;

    // derive thumbdir from attribute or from the URL in the data-opts
    const urlObj = parseUploadUrl(el);
    const thumbdir = el.dataset.thumbdir || urlObj?.searchParams.get('thumbdir') || null;

    const deleteBtn = el.querySelector('[data-hs-file-upload-clear]');
    if (deleteBtn) deleteBtn.disabled = true;

    dz.on('success', (file, resp) => {
        let data = resp;
        if (typeof resp === 'string') { try { data = JSON.parse(resp); } catch { data = {}; } }
        file._serverId   = data?.id   ?? null;
        file._serverPath = data?.path ?? null;
        file._serverName = data?.name ?? data?.filename ?? file.name;

        if (deleteBtn) deleteBtn.disabled = false;
    });

    dz.on('removedfile', async (file) => {
        if (deleteBtn) deleteBtn.disabled = true;
        if (!file._serverId && !file._serverPath && !file._serverName) return;

        try {
            await fetch('/thumb/delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    ...(csrf ? { 'X-CSRF-TOKEN': csrf } : {})
                },
                body: JSON.stringify({
                    thumbdir,
                    id:   file._serverId,
                    path: file._serverPath,
                    name: file._serverName
                })
            });
        } catch (e) {
            console.error('thumb delete failed', e);
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-module="thumb-uploader"]').forEach(initThumbUploader);
});

