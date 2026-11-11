import assert from 'node:assert/strict';
import { execFileSync } from 'node:child_process';
import { readFile } from 'node:fs/promises';
import puppeteer from 'puppeteer';

const fixtures = JSON.parse(execFileSync('php', [], {
    cwd: new URL('../../', import.meta.url),
    input: `<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\\Contracts\\Console\\Kernel::class)->bootstrap();
class BrowserVideoStats extends App\\Livewire\\Stats\\VideoStats {
    public function mount($video, $period = 'week'): void {
        $this->video = $video; $this->period = $period; $this->showModal = true; $this->getData();
    }
    public function getData(): void {
        $this->labels = ['11 Nov']; $this->data = [$this->period === 'month' ? 30 : 7];
        $this->datasets = ['labels' => ['11 Nov'], 'datasets' => [['label' => 'Views', 'data' => [$this->period === 'month' ? 30 : 7]]]];
    }
}
$video = new App\\Models\\Video;
$video->forceFill(['id' => 'example', 'title' => 'Example talk', 'state' => true]);
$video->setRelation('videoStats', null);
$fixtures = [];
foreach (['week', 'month'] as $period) {
    $c = Livewire\\Livewire::test(BrowserVideoStats::class, ['video' => $video, 'period' => $period]);
    $fixtures[$period] = ['html' => $c->html(), 'datasets' => $c->get('datasets')];
}
echo json_encode($fixtures);`, encoding: 'utf8',
}));
const manifest = JSON.parse(await readFile(new URL('../../public/build/manifest.json', import.meta.url), 'utf8'));
const css = await readFile(new URL(`../../public/build/${Object.values(manifest).find(entry => entry.file.endsWith('.css')).file}`, import.meta.url), 'utf8');
const chartScript = (await readFile(new URL('../../resources/js/presentation-stats-chart.js', import.meta.url), 'utf8')).replace("import Chart from 'chart.js/auto';", '');
const browser = await puppeteer.launch({ headless: true, ...(process.env.CHROME_PATH ? { executablePath: process.env.CHROME_PATH } : {}) });
try {
    const page = await browser.newPage();
    const errors = [];
    page.on('pageerror', error => errors.push(error.message));
    await page.setContent(`<style>${css}</style><button id="trigger">Stats</button><main class="presentation-library"><div id="stats"></div></main>`);
    await page.addScriptTag({ content: await readFile(new URL('../../node_modules/chart.js/dist/chart.umd.js', import.meta.url), 'utf8') });
    await page.evaluate(() => { window.livewireScriptConfig = {}; });
    await page.addScriptTag({ content: await readFile(new URL('../../vendor/livewire/livewire/dist/livewire.js', import.meta.url), 'utf8') });
    await page.evaluate(() => window.Livewire.start());
    await page.evaluate(() => {
        window.Alpine.magic('wire', () => ({
            closeModal() { window.statsClosed = true; },
        }));
    });
    await page.addScriptTag({ content: chartScript });
    for (const viewport of [{ width: 1280, height: 900 }, { width: 375, height: 480 }]) {
        await page.setViewport(viewport);
        for (const period of ['week', 'month']) {
            await page.focus('#trigger');
            await page.evaluate(html => {
                // Remove Livewire transport metadata: exercise the actual rendered view and chart locally.
                const doc = new DOMParser().parseFromString(html, 'text/html');
                for (const node of doc.querySelectorAll('*')) {
                    for (const attr of [...node.attributes]) {
                        if (attr.name.startsWith('wire:')) node.removeAttribute(attr.name);
                    }
                }
                window.Alpine.morph(document.querySelector('#stats'), `<div id="stats">${doc.body.innerHTML}</div>`);
            }, fixtures[period].html);
            await page.waitForSelector('[role="dialog"]', { visible: true });
            assert.equal(await page.$('#stats canvas'), null, 'Canvas is outside the component root after teleporting');
            await page.waitForFunction(() => Chart.getChart(document.querySelector('canvas')));
            const result = await page.$eval('[role="dialog"]', node => {
                const r = node.querySelector('canvas').getBoundingClientRect();
                const panel = node.querySelector('canvas').closest('.overflow-y-auto');
                const p = panel.getBoundingClientRect();
                return { width: r.width, height: r.height, left: p.left, right: p.right, top: p.top, bottom: p.bottom, data: Chart.getChart(node.querySelector('canvas')).data.datasets[0].data };
            });
            assert.ok(result.width > 0 && result.height > 0 && result.height <= 180, 'Chart must render at a compact height');
            assert.ok(result.left >= 0 && result.right <= viewport.width && result.top >= 0 && result.bottom <= viewport.height);
            assert.deepEqual(result.data, [period === 'month' ? 30 : 7]);
            await page.evaluate(() => { window.statsClosed = false; });
            await page.waitForFunction(() => document.activeElement?.closest('[role="dialog"]'));
            await page.keyboard.press('Escape');
            await page.waitForFunction(() => window.statsClosed === true, { timeout: 5000 });
            const canvas = await page.$('canvas');
            await page.evaluate(() => window.Alpine.morph(document.querySelector('#stats'), '<div id="stats"></div>'));
            assert.equal(await canvas.evaluate(node => Boolean(Chart.getChart(node))), false, 'Removed charts must be destroyed');
            await page.waitForFunction(() => !document.querySelector('[role="dialog"]'));
        }
    }
    assert.deepEqual(errors, []);
    console.log('Passed: real stats modal and Chart.js canvas render on desktop/mobile for both periods, handle Escape, and clean up after Livewire morphs.');
} finally { await browser.close(); }
