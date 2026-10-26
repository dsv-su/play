<?php

namespace Tests\Feature;

use App\Http\Controllers\EditController;
use App\Models\ManualPresentation;
use App\Models\Stream;
use App\Models\StreamResolution;
use App\Models\Video;
use App\Services\Notify\PlayStoreNotify;
use App\Services\Stream\StreamsStore;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class EditStreamsWorkflowTest extends TestCase
{
    private Video $video;

    private ManualPresentation $presentation;

    private Stream $main;

    private Stream $slides;

    private array $history = [];

    protected function setUp(): void
    {
        parent::setUp();
        config(['scout.driver' => null, 'database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');
        app()->instance('play_username', 'editor');
        app()->instance('play_email', 'editor@example.test');
        Video::disableSearchSyncing();
        $this->createTables();
        Storage::fake('play-store');
        $this->video = Video::create(['id' => 'video-id', 'title' => 'Original', 'category_id' => 1]);
        $this->presentation = ManualPresentation::create(['pkg_id' => $this->video->id, 'type' => 'edit']);
        $this->main = Stream::create(['video_id' => $this->video->id, 'name' => 'main', 'poster' => 'poster/main.jpg', 'audio' => true]);
        $this->slides = Stream::create(['video_id' => $this->video->id, 'name' => 'slides', 'poster' => 'poster/slides.jpg', 'audio' => false]);
        foreach ([$this->main, $this->slides] as $stream) {
            StreamResolution::create(['stream_id' => $stream->id, 'resolution' => 720, 'filename' => $stream->name.'-old.mp4']);
        }
        Artisan::shouldReceive('call')->with('download:clear')->andReturn(0)->byDefault();
        $this->mockNotifier(new Response(200, [], 'job-123'));
    }

    protected function tearDown(): void
    {
        Video::enableSearchSyncing();
        parent::tearDown();
    }

    private function mockNotifier(Response $response): void
    {
        $stack = HandlerStack::create(new MockHandler([$response]));
        $stack->push(Middleware::history($this->history));
        $http = new Client(['handler' => $stack]);
        app()->bind(PlayStoreNotify::class, fn ($app, $parameters) => new PlayStoreNotify(
            $parameters['presentation'], $http, $parameters['renderThumb']
        ));
    }

    private function save(array $changes = [])
    {
        $request = Request::create('/edit/video-id', 'POST', array_replace([
            'title' => 'Updated', 'recording_date' => '2026-10-26', 'playback' => 1,
            'edit_presentation_id' => $this->presentation->id,
            'audio' => ['main' => 'on'],
        ], $changes));
        $request->setLaravelSession(app('session.store'));

        return (new EditController)->edit($this->video, $request);
    }

    private function storeReplacement(string $name): string
    {
        $path = 'video/'.$name.'.mp4';
        $configFile = file_exists(base_path('systemconfig/play.ini')) ? 'play.ini' : 'play.ini.example';
        $config = parse_ini_file(base_path('systemconfig/'.$configFile), true);
        $folder = trim($config['nfs']['storage'], '/').'/'.$this->presentation->local;
        Storage::disk('play-store')->put($folder.'/'.$path, 'replacement');

        return $path;
    }

    public function test_replacing_one_stream_preserves_the_other_through_save_and_callback(): void
    {
        $path = $this->storeReplacement('slides');
        $this->save([
            'uploaded_stream' => [$this->slides->id => ['video' => $path]],
            'streamVisibility' => ['slides' => 'on'],
        ]);
        $payload = json_decode((string) $this->history[0]['request']->getBody(), true);
        self::assertSame(['playAudio' => true], $payload['sources']['main']);
        self::assertSame($path, $payload['sources']['slides']['video']);
        self::assertFalse($payload['sources']['slides']['playAudio']);
        self::assertSame('', $payload['sources']['slides']['poster']);
        self::assertNotEmpty($payload['upload_dir']);
        self::assertSame('sent', $this->presentation->fresh()->status);
        self::assertSame('poster/slides.jpg', $this->slides->fresh()->poster);

        (new StreamsStore(new Request(['package' => ['sources' => [
            'main' => ['playAudio' => true],
            'slides' => ['playAudio' => false, 'poster' => 'poster/new-slides.jpg', 'video' => [720 => 'slides-new.mp4']],
        ]]]), $this->video))->streams();

        self::assertSame('main-old.mp4', $this->main->resolutions()->sole()->filename);
        self::assertSame('poster/main.jpg', $this->main->fresh()->poster);
        self::assertSame('slides-new.mp4', $this->slides->resolutions()->sole()->filename);
        self::assertSame('poster/new-slides.jpg', $this->slides->fresh()->poster);
        self::assertTrue((bool) $this->slides->fresh()->hidden);
        self::assertCount(2, $this->video->streams()->get());
    }

    public function test_replacing_audio_stream_in_three_stream_presentation_preserves_all_other_media(): void
    {
        $camera = Stream::create([
            'video_id' => $this->video->id, 'name' => 'camera',
            'poster' => 'poster/camera.jpg', 'audio' => false,
        ]);
        $camera->hidden = true;
        $camera->save();
        foreach ([$this->main, $this->slides, $camera] as $stream) {
            StreamResolution::create([
                'stream_id' => $stream->id, 'resolution' => 1080,
                'filename' => $stream->name.'-1080-old.mp4',
            ]);
        }
        $before = [$this->slides->fresh()->toArray(), $camera->fresh()->toArray()];
        $resolutionsBefore = [$this->slides->resolutions()->get()->toArray(), $camera->resolutions()->get()->toArray()];

        $this->save([
            'uploaded_stream' => [$this->main->id => ['video' => $this->storeReplacement('main')]],
            'streamVisibility' => ['camera' => 'on'],
        ]);
        $payload = json_decode((string) $this->history[0]['request']->getBody(), true);
        self::assertCount(3, $payload['sources']);
        self::assertSame('video/main.mp4', $payload['sources']['main']['video']);
        self::assertTrue($payload['sources']['main']['playAudio']);
        self::assertSame(['playAudio' => false], $payload['sources']['slides']);
        self::assertSame(['playAudio' => false], $payload['sources']['camera']);

        (new StreamsStore(new Request(['jobid' => 'job-123', 'package' => ['sources' => [
            'main' => ['video' => [720 => 'main-new.mp4'], 'poster' => 'poster/new-main.jpg', 'playAudio' => true],
        ]]]), $this->video))->streams();

        self::assertCount(3, $this->video->streams()->get());
        self::assertSame('main-new.mp4', $this->main->resolutions()->sole()->filename);
        self::assertSame('poster/new-main.jpg', $this->main->fresh()->poster);
        self::assertTrue((bool) $this->main->fresh()->audio);
        self::assertSame($before, [$this->slides->fresh()->toArray(), $camera->fresh()->toArray()]);
        self::assertSame($resolutionsBefore, [$this->slides->resolutions()->get()->toArray(), $camera->resolutions()->get()->toArray()]);
    }

    public function test_interleaved_chunk_uploads_with_the_same_filename_keep_streams_separate(): void
    {
        config(['chunk-upload.storage.chunks' => 'test-chunks', 'chunk-upload.chunk.name.use.session' => false]);
        $completed = [];
        foreach ([0, 1] as $index) {
            foreach ([$this->main, $this->slides] as $stream) {
                $request = Request::create('/edit/video-id/stream/upload', 'POST', [
                    'edit_presentation_id' => $this->presentation->id,
                    'stream_id' => $stream->id,
                    'dzuuid' => 'upload-'.$stream->id,
                    'dzchunkindex' => $index,
                    'dztotalchunkcount' => 2,
                    'dztotalfilesize' => 20,
                    'dzchunksize' => 10,
                    'dzchunkbyteoffset' => $index * 10,
                ], [], ['file' => UploadedFile::fake()->createWithContent('video.mp4', $stream->name.'-'.$index)]);
                $request->setLaravelSession(app('session.store'));
                app()->instance('request', $request);
                $response = (new EditController)->streamUpload($this->video, $request);
                self::assertSame(200, $response->getStatusCode(), $response->getContent());
                $payload = $response->getData(true);
                if ($index === 0) {
                    self::assertArrayNotHasKey('video', $payload);
                } else {
                    self::assertSame($stream->id, $payload['stream_id']);
                    $completed[$stream->name] = $payload['video'];
                }
            }
        }
        self::assertNotSame($completed['main'], $completed['slides']);
        $files = Storage::disk('play-store')->allFiles();
        self::assertCount(2, $files);
        self::assertEqualsCanonicalizing(['main-0main-1', 'slides-0slides-1'], array_map(
            fn ($file) => Storage::disk('play-store')->get($file), $files
        ));
    }

    public function test_edit_callback_with_only_the_replaced_stream_preserves_omitted_streams(): void
    {
        $this->save(['uploaded_stream' => [$this->slides->id => ['video' => $this->storeReplacement('slides')]]]);
        (new StreamsStore(new Request(['jobid' => 'job-123', 'package' => ['sources' => [
            'slides' => ['video' => [720 => 'slides-new.mp4'], 'poster' => 'poster/new.jpg', 'playAudio' => false],
        ]]]), $this->video))->streams();
        self::assertCount(2, $this->video->streams()->get());
        self::assertSame('main-old.mp4', $this->main->resolutions()->sole()->filename);
        self::assertSame('poster/main.jpg', $this->main->fresh()->poster);
        self::assertTrue((bool) $this->main->fresh()->audio);
        self::assertSame('slides-new.mp4', $this->slides->resolutions()->sole()->filename);
    }

    public function test_replacing_both_streams_and_switching_audio_keeps_distinct_paths(): void
    {
        $this->save([
            'uploaded_stream' => [
                $this->main->id => ['video' => $this->storeReplacement('main')],
                $this->slides->id => ['video' => $this->storeReplacement('slides')],
            ],
            'audio' => ['slides' => 'on'],
        ]);
        $payload = json_decode((string) $this->history[0]['request']->getBody(), true);
        self::assertSame('video/main.mp4', $payload['sources']['main']['video']);
        self::assertSame('video/slides.mp4', $payload['sources']['slides']['video']);
        self::assertFalse($payload['sources']['main']['playAudio']);
        self::assertTrue($payload['sources']['slides']['playAudio']);
        self::assertFalse((bool) $this->main->fresh()->audio);
        self::assertTrue((bool) $this->slides->fresh()->audio);
    }

    public function test_flag_only_save_preserves_media_and_sends_no_video_paths(): void
    {
        $this->save(['audio' => ['slides' => 'on'], 'streamVisibility' => ['main' => 'on']]);
        $payload = json_decode((string) $this->history[0]['request']->getBody(), true);
        self::assertSame(['main' => ['playAudio' => false], 'slides' => ['playAudio' => true]], $payload['sources']);
        self::assertArrayNotHasKey('upload_dir', $payload);
        self::assertSame('main-old.mp4', $this->main->resolutions()->sole()->filename);
        self::assertSame('poster/main.jpg', $this->main->fresh()->poster);
        self::assertTrue((bool) $this->main->fresh()->hidden);
    }

    public function test_missing_replacement_is_rejected_before_video_changes(): void
    {
        try {
            $this->save(['uploaded_stream' => [$this->slides->id => ['video' => 'video/missing.mp4']]]);
            self::fail('Expected validation failure');
        } catch (ValidationException $e) {
            self::assertArrayHasKey('uploaded_stream.'.$this->slides->id.'.video', $e->errors());
        }
        self::assertSame('Original', $this->video->fresh()->title);
        self::assertSame([], $this->history);
    }

    public function test_notification_failure_is_returned_and_existing_media_is_kept(): void
    {
        $this->mockNotifier(new Response(500, [], 'failed'));
        $this->save(['uploaded_stream' => [$this->slides->id => ['video' => $this->storeReplacement('slides')]]]);
        self::assertSame('failed', $this->presentation->fresh()->status);
        self::assertSame('poster/slides.jpg', $this->slides->fresh()->poster);
        self::assertSame('slides-old.mp4', $this->slides->resolutions()->sole()->filename);
        self::assertNotSame('Processing the update', session('message'));
    }

    public function test_callback_without_sources_keeps_existing_streams(): void
    {
        (new StreamsStore(new Request(['package' => ['title' => 'Updated']]), $this->video))->streams();
        self::assertCount(2, $this->video->streams()->get());
        self::assertSame('main-old.mp4', $this->main->resolutions()->sole()->filename);
    }

    public function test_non_edit_callback_still_removes_streams_absent_from_its_snapshot(): void
    {
        (new StreamsStore(new Request(['package' => ['sources' => [
            'main' => ['playAudio' => true, 'poster' => 'poster/main.jpg', 'video' => [720 => 'main-new.mp4']],
        ]]]), $this->video))->streams();
        self::assertCount(1, $this->video->streams()->get());
        self::assertSame('main-new.mp4', $this->main->resolutions()->sole()->filename);
    }

    public function test_explicit_empty_non_edit_snapshot_still_clears_streams(): void
    {
        (new StreamsStore(new Request(['package' => ['sources' => []]]), $this->video))->streams();
        self::assertCount(0, $this->video->streams()->get());
    }

    public function test_upload_rejects_a_stream_from_another_video(): void
    {
        $foreign = Stream::create(['video_id' => 'other-video', 'name' => 'main', 'poster' => '', 'audio' => true]);
        $request = Request::create('/edit/video-id/stream/upload', 'POST', [
            'edit_presentation_id' => $this->presentation->id, 'stream_id' => $foreign->id,
        ]);
        $this->expectException(ModelNotFoundException::class);
        (new EditController)->streamUpload($this->video, $request);
    }

    public function test_upload_validation_is_not_reported_as_a_server_failure(): void
    {
        $this->expectException(ValidationException::class);
        (new EditController)->streamUpload($this->video, Request::create('/edit/video-id/stream/upload', 'POST'));
    }

    private function createTables(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->string('id')->primary();
            foreach (['title', 'title_en', 'description', 'creation'] as $field) {
                $table->string($field)->nullable();
            }
            foreach (['category_id', 'state', 'visibility', 'unlisted', 'download'] as $field) {
                $table->integer($field)->nullable();
            }
            $table->timestamps();
        });
        Schema::create('manual_presentations', function (Blueprint $table) {
            $table->id();
            foreach (['pkg_id', 'type', 'status', 'user', 'user_email', 'local', 'upload_dir', 'title', 'title_en', 'description', 'created', 'presenters', 'courses', 'tags', 'daisy_courses', 'thumb', 'sources', 'generate_subtitles', 'jobid'] as $field) {
                $table->text($field)->nullable();
            }
            foreach (['category_id', 'duration', 'visibility', 'unlisted'] as $field) {
                $table->integer($field)->nullable();
            }
            $table->timestamps();
        });
        Schema::create('streams', function (Blueprint $table) {
            $table->id();
            $table->string('video_id');
            $table->string('name');
            $table->string('poster')->nullable();
            $table->boolean('audio')->default(false);
            $table->boolean('hidden')->default(false);
            $table->timestamps();
        });
        Schema::create('stream_resolutions', function (Blueprint $table) {
            $table->id();
            $table->integer('stream_id');
            $table->integer('resolution');
            $table->string('filename');
            $table->timestamps();
        });
        foreach (['video_presenters', 'individual_permissions', 'video_courses', 'video_tags'] as $name) {
            Schema::create($name, function (Blueprint $table) {
                $table->id();
                $table->string('video_id');
            });
        }
        Schema::create('video_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('video_id');
            $table->integer('permission_id');
            $table->string('type');
            $table->string('jobid')->nullable();
            $table->timestamps();
        });
    }
}
