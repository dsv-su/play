import assert from 'node:assert/strict';
import { execFileSync } from 'node:child_process';
import { readFile } from 'node:fs/promises';
import puppeteer from 'puppeteer';

const root = new URL('../../', import.meta.url);
const html = execFileSync('php', [], {
    cwd: root,
    input: `<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\\Contracts\\Console\\Kernel::class)->bootstrap();
$video = new App\\Models\\Video;
$video->forceFill(['id' => 'example', 'title' => 'Example talk', 'thumb' => 'thumb.jpg', 'subtitles' => '{"English":"en.vtt","Svenska":"sv.vtt"}']);
echo view('livewire.search.partials.share-modal', ['video' => $video])->render();`,
    encoding: 'utf8',
});
const manifest = JSON.parse(await readFile(new URL('../../public/build/manifest.json', import.meta.url), 'utf8'));
const cssPath = Object.values(manifest).find(entry => entry.file.endsWith('.css')).file;
const css = await readFile(new URL(`../../public/build/${cssPath}`, import.meta.url), 'utf8');
const browser = await puppeteer.launch({ headless: true, ...(process.env.CHROME_PATH ? { executablePath: process.env.CHROME_PATH } : {}) });
try {
    const page = await browser.newPage();
    const errors = [];
    page.on('pageerror', error => errors.push(error.message));
    await page.setContent(`<style>${css}[x-cloak]{display:none!important}</style><main class="presentation-library"><div id="cards"></div></main>`);
    await page.addScriptTag({ content: await readFile(new URL('../../resources/js/share-modal.js', import.meta.url), 'utf8') });
    await page.evaluate(() => { window.livewireScriptConfig = {}; });
    await page.addScriptTag({ content: await readFile(new URL('../../vendor/livewire/livewire/dist/livewire.js', import.meta.url), 'utf8') });
    await page.evaluate(() => window.Livewire.start());
    for (const viewport of [{ width: 1280, height: 900 }, { width: 375, height: 480 }]) {
        await page.setViewport(viewport);
        // Insert the actual partial after Alpine has started, as when a course opens.
        await page.evaluate(markup => {
            window.Alpine.morph(document.querySelector('#cards'), `<div id="cards">${markup}${markup}</div>`);
        }, html);
        await page.waitForSelector('[aria-haspopup="dialog"]');
        const triggers = await page.$$('[aria-haspopup="dialog"]');
        const dialogSelector = '#' + await triggers[1].evaluate(node => node.getAttribute('aria-controls'));
        await triggers[1].click();
        await page.waitForSelector(dialogSelector, { visible: true });
        await page.waitForFunction(() => document.activeElement?.closest('[role="dialog"]'));
        await page.$eval(dialogSelector, async node => { await Promise.all(node.getAnimations().map(animation => animation.finished)); });
        const geometry = await page.$eval(dialogSelector, node => {
            const r = node.getBoundingClientRect();
            return { left: r.left, right: r.right, top: r.top, bottom: r.bottom, scrollable: node.scrollHeight > node.clientHeight, overflow: getComputedStyle(node).overflowY };
        });
        assert.ok(geometry.left >= 0 && geometry.right <= viewport.width);
        assert.ok(geometry.top >= 0 && geometry.bottom <= viewport.height);
        if (viewport.width === 375) {
            assert.ok(geometry.scrollable);
            assert.equal(geometry.overflow, 'auto');
        }
        const ids = await page.$$eval('[id]', nodes => nodes.map(node => node.id));
        assert.equal(new Set(ids).size, ids.length, 'Repeated presentations must have unique dialog and subtitle IDs');
        await page.click(`${dialogSelector} input[value="Svenska"] + label`);
        await page.$eval(`${dialogSelector} button`, node => {
            const dialog = node.closest('[role="dialog"]');
            [...dialog.querySelectorAll('button')].find(button => button.textContent.trim() === 'Apply subtitle').click();
        });
        await page.waitForFunction(selector => document.querySelector(`${selector} [x-ref="directLink"]`).textContent.includes('s=Svenska'), {}, dialogSelector);
        assert.ok(await page.$eval(`${dialogSelector} textarea`, node => node.value.includes('s=Svenska')), 'Embed code must update with the selected subtitle');
        await page.click(`${dialogSelector} button[aria-label="Close share dialog"]`);
        await page.waitForSelector(dialogSelector, { hidden: true });
        await triggers[1].click();
        await page.waitForSelector(dialogSelector, { visible: true });
        await page.keyboard.press('Escape');
        await page.waitForSelector(dialogSelector, { hidden: true });
        await page.waitForFunction(() => document.activeElement?.getAttribute('aria-haspopup') === 'dialog');
        // Removing a course must also remove its teleported modal.
        await page.evaluate(() => window.Alpine.morph(document.querySelector('#cards'), '<div id="cards"></div>'));
        await page.waitForFunction(() => !document.querySelector('[role="dialog"]'));
    }
    assert.deepEqual(errors, []);
    console.log('Passed: dynamically inserted share dialogs open, fit desktop/mobile, scroll, close, restore focus, have unique IDs, and clean up after Livewire morphs.');
} finally {
    await browser.close();
}
