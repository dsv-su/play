<?php

namespace Tests\Feature;

use App\Http\Controllers\EditController;
use App\Models\ManualPresentation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use ReflectionMethod;
use RuntimeException;
use Tests\TestCase;

class ReplacementStreamTest extends TestCase
{
    public function test_streams_with_the_same_original_filename_keep_separate_contents(): void
    {
        Storage::fake('play-store');
        $presentation = new ManualPresentation();
        $presentation->local = 'replacement-test';
        $controller = new EditController();
        $store = new ReflectionMethod($controller, 'storeReplacementStream');
        $exists = new ReflectionMethod($controller, 'storedReplacementStreamExists');

        $first = $store->invoke($controller, UploadedFile::fake()->createWithContent('video.mp4', 'first'), $presentation, 'main');
        $second = $store->invoke($controller, UploadedFile::fake()->createWithContent('video.mp4', 'second'), $presentation, 'slides');

        $this->assertNotSame($first, $second);
        $this->assertTrue($exists->invoke($controller, $presentation, $first));
        $this->assertTrue($exists->invoke($controller, $presentation, $second));
        $files = Storage::disk('play-store')->allFiles();
        $this->assertCount(2, $files);
        $contents = array_map(fn ($path) => Storage::disk('play-store')->get($path), $files);
        $this->assertEqualsCanonicalizing(['first', 'second'], $contents);
    }

    public function test_failed_storage_write_does_not_return_a_successful_video_path(): void
    {
        Storage::shouldReceive('disk')->with('play-store')->once()->andReturnSelf();
        Storage::shouldReceive('putFileAs')->once()->andReturn(false);
        $presentation = new ManualPresentation();
        $presentation->local = 'replacement-test';
        $controller = new EditController();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('could not be stored');
        (new ReflectionMethod($controller, 'storeReplacementStream'))->invoke(
            $controller,
            UploadedFile::fake()->createWithContent('video.mp4', 'video'),
            $presentation,
            'main'
        );
    }
}
