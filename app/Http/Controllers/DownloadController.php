<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\PerformVideoDownload;
use App\Models\Video;
use App\Models\Presentation;
use App\Services\AuthHandler;
use App\Services\Store\DownloadResource;
use App\Services\TicketHandler\Entitlement;
use App\Services\TicketHandler\TicketPermissionHandler;
use App\Models\VideoStat;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class DownloadController extends Controller
{
    /** @var string */
    private const PUBLIC_DISK = 'public';

    /** @var string */
    private const MULTIPLAYER_TEMPLATE_PATH = 'multiplayer/dlplayer.html';

    /** @var string */
    private const STATUS_REQUESTED = 'request download';
    /** @var string */
    //private const STATUS_STORED    = 'stored';

    /** Cache for parsed ini */
    private ?string $storeListUri = null;

    public function download(Request $request, Entitlement $entitlement, Video $video)
    {
        $param = data_get(app(AuthHandler::class)->authorize(), 'global.authorization_parameter');
        $headerName = $this->normalizeHeaderName($param);
        $provided = $this->splitEntitlements((string) ($_SERVER[$headerName] ?? ''));

        $resolution = (string) ($request->input('r', '720'));

        try {
            // If it's already been built, ship it immediately.
            if ($this->downloadExists($video)) {
                return $this->browserDownloadZip($video);
            }

            // Initialize a Presentation row if downloads are allowed & not present.
            $created = $this->initDownload($video, $resolution);

            // If initDownload() returned false and nothing exists, downloading is disabled.
            if (!$created && !$this->downloadExists($video)) {
                return $this->redirectWithError(__('Error: Download not allowed for this video.'));
            }

            $sync = $request->boolean('sync', false); // default to no sync

            if ($sync) {
                PerformVideoDownload::dispatchSync($video->id, $provided);
            } else {
                PerformVideoDownload::dispatch($video->id, $provided);
            }

            // After the job finishes, the ZIP should be on disk; stream it.
            if ($this->downloadExists($video)) {
                return $this->browserDownloadZip($video);
            }

            // If the job finished without producing the expected files.
            //return $this->redirectWithError(__('Error: Download package not found after processing.'));
            return redirect()->back();
        } catch (\Throwable $e) {
            \Log::error('Download failed', ['video_id' => $video->id, 'e' => $e]);
            return $this->redirectWithError(__('Error: Unable to process download.'));
        }
    }

    public function status(Video $video)
    {
        $p = Presentation::find($video->id);

        if (!$p) {
            return response()->json(['exists' => false, 'status' => null, 'progress' => 0]);
        }

        //disk check
        $ready = $this->downloadExists($video);

        return response()->json([
            'exists'   => $ready,
            'status'   => $p->status,
            'progress' => (int) $p->progress,
        ]);
    }

    /**
     * Initializes a Presentation row if downloads are allowed and one doesn't exist.
     */
    private function initDownload(Video $video, string $resolution): bool
    {
        // Update derived "download_setting" flag based on course settings
        $video = $this->applyDownloadStatusFromCourses($video);

        // If disabled at both levels, bail early
        if (!($video->download || $video->download_setting)) {
            return false;
        }

        // Idempotent by (id,resolution). Add a DB unique index on (id,resolution) for safety.
        /** @var Presentation $presentation */
        $presentation = Presentation::firstOrNew(['id' => $video->id, 'resolution' => $resolution]);

        if ($presentation->exists) {
            // Already requested/created for this resolution
            return false;
        }

        $downloadDir = $this->makeDownloadDir($video->id);
        $sourcesArr  = is_array($video->sources) ? $video->sources : json_decode((string) $video->sources, true) ?? [];

        $presentation->fill([
            'status'      => self::STATUS_REQUESTED,
            'user'        => app()->make('play_user'),
            'local'       => $downloadDir,
            'base'        => '/data0/incoming/' . $downloadDir,
            'title'       => $video->title,
            'presenters'  => '[]',
            'tags'        => '[]',
            'courses'     => '[]',
            'thumb'       => 'image/thumb.jpg',
            'created'     => $video->creation,
            'duration'    => $video->duration,
            'sources'     => $sourcesArr,
        ]);

        $presentation->save();

        return true;
    }

    /**
     * Browser download of the zipped package.
     */
    public function browserDownloadZip(Video $video): RedirectResponse|StreamedResponse
    {
        $presentation = Presentation::find($video->id);
        if (!$presentation) {
            return $this->redirectWithError(__('Error: Presentation not found!'));
        }

        // Safer filename: slug + id
        $safeName = $video->title . '.zip';
        $filePath = trim($presentation->local, '/') . '/' . $safeName;

        if (Storage::disk(self::PUBLIC_DISK)->exists($filePath)) {
            // Increment stats atomically
            $stat = VideoStat::firstOrCreate(
                ['video_id' => $video->id],
                ['download' => 0]
            );

            // If download is NULL (from old data), normalize it
            if (is_null($stat->download)) {
                $stat->download = 0;
                $stat->save();
            }

            // Atomic increment
            $stat->increment('download');





            //Record metrics for presentation
            metric('presentation_download')
                ->measurable($video)
                ->with(['vid' => $video->id])
                ->category('download')
                ->record();
            //Record metrics overall
            metric('download')
                ->category('download')
                ->record();

            return Storage::disk(self::PUBLIC_DISK)->download($filePath);
        }

        return $this->redirectWithError(__('Error: File not found!'));
    }


    /**
     * Download a subtitle file for the given language.
     */
    public function subtitle(Video $video, Request $request): Response|RedirectResponse
    {
        $request->validate([
            'lang' => ['required', 'string', 'max:8'],
        ]);

        $lang = $request->string('lang')->toString();

        Storage::disk(self::PUBLIC_DISK)->makeDirectory('subtitles/' . $video->id);
        $downloader = new DownloadResource($video, new TicketPermissionHandler($video));

        $subs = is_array($video->subtitles) ? $video->subtitles : json_decode((string) $video->subtitles, true) ?? [];
        $path = null;

        foreach ($subs as $code => $file) {
            if ($code === $lang) {
                $path = 'subtitles/' . $video->id . '/' . basename($file);
                $downloader->getFile($path, $this->storeBaseUri() . '/' . $video->id . '/' . ltrim($file, '/'));
                break;
            }
        }

        if (!$path) {
            return $this->redirectWithError(__('Error: Subtitle not found for requested language.'));
        }

        try {
            return Storage::disk(self::PUBLIC_DISK)->download($path);
        } catch (FileNotFoundException) {
            return $this->redirectWithError(__('Error: Subtitle file missing.'));
        }
    }

    /**
     * Fast check whether the presentation directory exists on disk.
     */
    private function downloadExists(Video $video): bool
    {
        $presentation = Presentation::find($video->id);
        if (!$presentation) {
            return false;
        }
        $dir = trim($presentation->local, '/');
        //directoryExists
        if (method_exists(Storage::disk(self::PUBLIC_DISK), 'directoryExists')) {
            return Storage::disk(self::PUBLIC_DISK)->directoryExists($dir);
        }
        return Storage::disk(self::PUBLIC_DISK)->exists($dir . '/');
    }

    private function redirectWithError(string $message): RedirectResponse
    {
        return redirect('/')->with(['message' => $message, 'alert' => 'alert-danger']);
    }

    /**
     * Create a safe, sortable download dir name.
     */
    private function makeDownloadDir(string $id): string
    {
        // YYYYMMDD_uuid-id
        return now()->format('Ymd') . '_' . Str::lower(Str::ulid()) . '-' . $id;
    }

    /**
     * Set/derive download_setting from related courses.
     */
    private function applyDownloadStatusFromCourses(Video $video): Video
    {
        // Prefer querying instead of materializing all courses
        try {
            $hasDownloadableCourse = $video->courses()
                ->whereHas('coursesettings', fn ($q) => $q->where('downloadable', true))
                ->exists();

            if ($hasDownloadableCourse) {
                $video->setAttribute('download_setting', true);
            }
        } catch (Throwable $e) {
            Log::warning('Course download setting check failed', ['video_id' => $video->id, 'e' => $e]);
        }

        return $video;
    }

    private function splitEntitlements(string $value): array
    {
        return array_values(array_filter(
            array_map('trim', explode(';', $value)),
            static fn ($v) => $v !== ''
        ));
    }

    private function normalizeHeaderName(string $param): string
    {
        // If it's given as 'HTTP_X_USER_ENTITLEMENTS', convert to 'X-User-Entitlements'
        if (str_starts_with($param, 'HTTP_')) {
            $param = substr($param, 5);
            $param = str_replace('_', '-', $param);
        }
        // HeaderBag is case-insensitive, so case doesn’t matter, but this is fine.
        return $param;
    }
}
