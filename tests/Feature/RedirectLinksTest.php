<?php

namespace Tests\Feature;

use App\Http\Middleware\RedirectLinks;
use Illuminate\Http\Request;
use Tests\TestCase;

class RedirectLinksTest extends TestCase
{
    public function test_upload_and_save_requests_do_not_pollute_page_history(): void
    {
        $pages = ['http://localhost/edit/video-id', 'http://localhost/user/all'];
        session(['links' => $pages]);
        $middleware = new RedirectLinks();

        foreach (['/edit/video-id/stream/upload?stream_id=1', '/edit/video-id'] as $path) {
            $middleware->handle(Request::create($path, 'POST'), fn () => response('ok'));
            $this->assertSame($pages, session('links'));
        }
    }

    public function test_existing_upload_entries_are_removed_before_recording_a_page_visit(): void
    {
        session(['links' => [
            'http://localhost/edit/video-id/stream/upload?stream_id=1',
            'http://localhost/edit/video-id',
            'http://localhost/user/all',
        ]]);

        (new RedirectLinks())->handle(
            Request::create('http://localhost/edit/video-id'),
            fn () => response('ok')
        );

        $this->assertSame([
            'http://localhost/edit/video-id',
            'http://localhost/user/all',
        ], session('links'));
    }

    public function test_json_requests_do_not_count_as_page_visits(): void
    {
        session(['links' => ['http://localhost/user/all']]);
        $request = Request::create('/edit/video-id', 'GET', server: ['HTTP_ACCEPT' => 'application/json']);

        (new RedirectLinks())->handle($request, fn () => response('ok'));

        $this->assertSame(['http://localhost/user/all'], session('links'));
    }
}
