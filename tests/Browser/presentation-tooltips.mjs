import assert from 'node:assert/strict';
import { readFile } from 'node:fs/promises';
import puppeteer from 'puppeteer';

// CHROME_PATH=/path/to/chrome node tests/Browser/presentation-tooltips.mjs
const script = await readFile(new URL('../../resources/js/presentation-tooltips.js', import.meta.url), 'utf8');
const css = await readFile(new URL('../../resources/css/presentation-library.css', import.meta.url), 'utf8');
const browser = await puppeteer.launch({ headless: true, ...(process.env.CHROME_PATH ? { executablePath: process.env.CHROME_PATH } : {}) });
try {
    const page = await browser.newPage();
    const errors = [];
    page.on('pageerror', error => errors.push(error.message));
    await page.setViewport({ width: 375, height: 800 });
    await page.setContent(`<style>${css}</style>
        <style>body{margin:0}#presentation-active-tooltip{position:fixed;background:#182332;color:white;padding:8px;max-width:240px}svg{width:20px;height:20px}button{display:flex;align-items:center}#source{display:none}</style>
        <div id="source" role="tooltip">Edit this presentation</div>
        <main class="presentation-library"><div id="courses"></div></main>`);
    await page.addScriptTag({ content: script });
    const insertCard = () => page.evaluate(() => {
        document.querySelector('#courses').innerHTML = `<article class="library-recording" style="display:block;margin-top:100px">
            <div class="library-actions"><div style="display:flex;width:100px">
                <button id="edit" data-tooltip-target="source" aria-describedby="original" aria-label="Edit presentation" style="width:44px">
                    <svg viewBox="0 0 24 24"><path d="M3 3h18v18H3Z"/></svg><span>123456</span>
                </button>
            </div></div></article>`;
    });
    await insertCard();
    await page.hover('#edit');
    await page.waitForSelector('#presentation-active-tooltip');
    assert.equal(await page.$eval('#presentation-active-tooltip', node => node.textContent), 'Edit this presentation');
    assert.equal(await page.$eval('#edit', node => node.getAttribute('aria-describedby')), 'original presentation-active-tooltip');
    assert.equal(await page.$eval('#edit svg', node => node.getBoundingClientRect().width), 20, 'SVGs must not collapse in a narrow action row');

    // A tooltip remains available while the pointer moves onto it (WCAG 1.4.13).
    await page.hover('#presentation-active-tooltip');
    await new Promise(resolve => setTimeout(resolve, 200));
    assert.ok(await page.$('#presentation-active-tooltip'));
    await page.keyboard.press('Escape');
    assert.equal(await page.$('#presentation-active-tooltip'), null);
    assert.equal(await page.$eval('#edit', node => node.getAttribute('aria-describedby')), 'original');

    await page.mouse.move(0, 0);
    await page.focus('#edit');
    await page.waitForSelector('#presentation-active-tooltip');
    const bounds = await page.$eval('#presentation-active-tooltip', node => { const r = node.getBoundingClientRect(); return { top: r.top, bottom: r.bottom, left: r.left, right: r.right }; });
    assert.ok(bounds.left >= 8 && bounds.right <= 367 && bounds.top >= 8 && bounds.bottom <= 792);

    // Simulate collapsing/replacing a course, then opening another course.
    await page.evaluate(() => document.querySelector('#courses').replaceChildren());
    await page.waitForFunction(() => !document.querySelector('#presentation-active-tooltip'));
    await insertCard();
    await page.hover('#edit');
    await page.waitForSelector('#presentation-active-tooltip');
    assert.equal(await page.$$eval('#presentation-active-tooltip', nodes => nodes.length), 1);
    await page.keyboard.press('Escape');
    await page.$eval('#edit svg', node => node.dispatchEvent(new MouseEvent('mouseover', { bubbles: true, relatedTarget: document.querySelector('#edit') })));
    assert.equal(await page.$('#presentation-active-tooltip'), null, 'Escape dismissal persists while still inside the trigger');

    await page.mouse.move(0, 0);
    await page.evaluate(() => {
        const card = document.querySelector('.library-recording');
        card.className = '';
        card.setAttribute('data-presentation-card', '');
    });
    await page.hover('#edit');
    await page.waitForSelector('#presentation-active-tooltip');
    assert.deepEqual(errors, []);
    console.log('Passed: dynamic course cards, SVG sizing, hover persistence, keyboard focus/Escape, viewport bounds, and replacement cleanup.');
} finally {
    await browser.close();
}
