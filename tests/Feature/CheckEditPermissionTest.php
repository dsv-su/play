<?php

namespace Tests\Feature;

use App\Http\Middleware\CheckEditPermission;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;
use ReflectionMethod;

class CheckEditPermissionTest extends TestCase
{
    public function test_nested_stream_upload_route_resolves_its_bound_video(): void
    {
        $video = new Video();
        $video->id = '546641c8-927f-42b7-bc5f-a38087f92e01';
        $request = Request::create('/edit/' . $video->id . '/stream/upload', 'POST');
        $route = new Route('POST', 'edit/{video}/stream/upload', fn () => null);
        $route->bind($request);
        $route->setParameter('video', $video);
        $request->setRouteResolver(fn () => $route);

        $resolved = (new ReflectionMethod(CheckEditPermission::class, 'resolveVideo'))
            ->invoke(new CheckEditPermission(), $request);

        self::assertSame($video, $resolved);
    }
}
