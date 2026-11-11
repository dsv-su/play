import assert from 'node:assert/strict';
import { execFileSync } from 'node:child_process';
import { readFile } from 'node:fs/promises';
import puppeteer from 'puppeteer';

// Render the actual Blade partial, then exercise the morph engine bundled with Livewire.
const root = new URL('../../', import.meta.url);
const fixtures = JSON.parse(execFileSync('php', [], {
    cwd: root,
    input: `<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\\Contracts\\Console\\Kernel::class)->bootstrap();
$fixtures = [];
foreach ([false, true] as $cc) {
    foreach (['public', 'dsv_staff'] as $permission) {
        foreach ([false, true] as $private) {
            $video = new App\\Models\\Video;
            $video->forceFill(['id' => 'example', 'subtitles' => $cc ? '{"English":"subtitle/en.vtt"}' : null, 'permission_type' => $permission, 'hidden' => $private, 'unlisted' => false]);
            $fixtures[] = ['cc' => $cc, 'html' => '<div class="library-permissions">'.view('home.partials.permission-buttons', ['video' => $video, 'courseId' => 42])->render().'</div>'];
        }
    }
}
echo json_encode($fixtures);
`,
    encoding: 'utf8',
}));
const browser = await puppeteer.launch({ headless: true, ...(process.env.CHROME_PATH ? { executablePath: process.env.CHROME_PATH } : {}) });
try {
    const page = await browser.newPage();
    const errors = [];
    page.on('pageerror', error => errors.push(error.message));
    await page.setContent('<style>.library-permissions{display:flex;width:48px;background:#182332;color:white}.library-permissions>span{display:inline-flex;flex:0 0 24px}svg{width:20px;height:20px;flex-shrink:0}</style><article class="library-recording"><div class="library-permissions"></div></article>');
    await page.evaluate(() => { window.livewireScriptConfig = {}; });
    await page.addScriptTag({ content: await readFile(new URL('../../vendor/livewire/livewire/dist/livewire.js', import.meta.url), 'utf8') });
    await page.evaluate(() => window.Livewire.start());
    for (const fixture of [...fixtures, ...fixtures.toReversed()]) {
        await page.evaluate(html => {
            window.Alpine.morph(document.querySelector('.library-permissions'), html, {
                key: element => element.getAttribute('wire:key'),
                lookahead: true,
            });
        }, fixture.html);
        const badge = await page.$('[data-tooltip-target="subtitle-tooltip"]');
        assert.equal(Boolean(badge), fixture.cc, 'CC availability must survive conditional badge changes');
        if (fixture.cc) {
            const geometry = await badge.$eval('svg', node => ({ width: node.getBoundingClientRect().width, height: node.getBoundingClientRect().height, namespace: node.namespaceURI, shapes: node.querySelectorAll('rect,path').length }));
            assert.deepEqual(geometry, { width: 20, height: 20, namespace: 'http://www.w3.org/2000/svg', shapes: 2 });
        }
    }
    assert.deepEqual(errors, []);
    console.log('Passed: actual Blade CC badges survive 16 Livewire morphs with changing permission/privacy/subtitle states; SVG dimensions and namespace remain intact.');
} finally {
    await browser.close();
}
