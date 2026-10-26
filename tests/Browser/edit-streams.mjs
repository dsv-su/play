import assert from 'node:assert/strict';
import { readFile } from 'node:fs/promises';
import puppeteer from 'puppeteer';

// Run with: CHROME_PATH=/path/to/chrome node tests/Browser/edit-streams.mjs
const blade = await readFile(new URL('../../resources/views/livewire/edit/edit-streams.blade.php', import.meta.url), 'utf8');
const script = blade.split('<script>')[1].split('</script>')[0]
    .replace(/@js\(__\((.*?)\)\)/g, '$1');
const browser = await puppeteer.launch({ headless: true, ...(process.env.CHROME_PATH ? { executablePath: process.env.CHROME_PATH } : {}) });
try {
    const page = await browser.newPage();
    const errors = [];
    page.on('pageerror', (error) => errors.push(error.message));
    const uploader = (id) => `
        <div data-stream-poster="${id}"><img data-stream-poster-image><span class="hidden" data-stream-replaced-overlay></span></div>
        <div data-edit-stream-uploader data-stream-id="${id}">
          <span data-stream-file-name></span><input data-uploaded-stream-path value="">
          <div data-stream-upload-status class="hidden"></div><span data-stream-upload-spinner></span>
          <span data-stream-upload-label></span><span data-stream-upload-percent></span>
          <span data-stream-upload-bar></span><span data-stream-upload-error class="hidden"></span>
          <button type="button" data-stream-replacement-cancel class="hidden">Cancel</button>
        </div>`;
    await page.setContent(`<form id="presentation-edit-Form">${uploader(1)}${uploader(2)}</form>
        <button id="presentation-save-button"></button><p id="edit-stream-upload-status" class="hidden"></p>`);
    await page.evaluate(() => {
        window.testZones = [...document.querySelectorAll('[data-edit-stream-uploader]')].map((element) => {
            const handlers = {};
            const zone = {
                files: [], on: (event, callback) => (handlers[event] ??= []).push(callback),
                emit(event, ...args) { (handlers[event] ?? []).forEach((callback) => callback(...args)); },
                removeFile(file) { this.files = this.files.filter((value) => value !== file); this.emit('removedfile', file); },
                removeAllFiles() { [...this.files].forEach((file) => this.removeFile(file)); },
                add(file) { this.files.push(file); this.emit('addedfile', file); },
            };
            element.testZone = zone;
            return zone;
        });
        window.HSFileUpload = { getInstance: (element) => ({ element: { dropzone: element.testZone } }) };
    });
    await page.addScriptTag({ content: script });
    await page.evaluate(() => window.dispatchEvent(new Event('load')));
    await page.waitForFunction(() => [...document.querySelectorAll('[data-edit-stream-uploader]')].every((node) => node.dataset.streamUploaderBound === 'true'));
    const disabled = () => page.$eval('#presentation-save-button', (node) => node.disabled);
    const paths = () => page.$$eval('[data-uploaded-stream-path]', (nodes) => nodes.map((node) => node.value));

    await page.evaluate(() => {
        testZones[0].add({ name: 'same.mp4' });
        testZones[1].add({ name: 'same.mp4' });
    });
    assert.equal(await disabled(), true, 'queued uploads must block saving');
    await page.evaluate(() => {
        testZones[0].emit('processing');
        testZones[1].emit('processing');
        testZones[0].emit('success', {}, { video: 'video/main.mp4' });
    });
    assert.equal(await disabled(), true, 'one completed upload must not enable saving while another runs');
    assert.deepEqual(await paths(), ['video/main.mp4', '']);
    await page.evaluate(() => testZones[1].emit('error', {}, 'Upload failed'));
    assert.equal(await disabled(), true, 'failed replacement must be retried or canceled');
    await page.click('[data-stream-id="2"] [data-stream-replacement-cancel]');
    assert.equal(await disabled(), false);
    assert.deepEqual(await paths(), ['video/main.mp4', ''], 'canceling one stream must preserve the other replacement');

    await page.evaluate(() => {
        testZones[1].add({ name: 'retry.mp4' });
        testZones[1].emit('processing');
        const file = { status: 'success', upload: { chunks: [{ response: '{"done":50}' }, { response: '{"video":"video/slides.mp4"}' }] } };
        testZones[1].emit('complete', file);
    });
    assert.equal(await disabled(), false);
    assert.deepEqual(await paths(), ['video/main.mp4', 'video/slides.mp4']);
    await page.click('[data-stream-id="1"] [data-stream-replacement-cancel]');
    assert.deepEqual(await paths(), ['', 'video/slides.mp4']);
    await page.evaluate(() => document.dispatchEvent(new CustomEvent('edit-stream-replacements:reset')));
    assert.deepEqual(await paths(), ['', '']);
    assert.equal(await disabled(), false);
    assert.deepEqual(errors, []);
    console.log('Uploader browser checks passed: concurrent uploads, failure, cancel, retry, chunk responses, independent stream paths.');
} finally {
    await browser.close();
}
