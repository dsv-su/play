<?php

namespace App\Services\Download;

use App\Models\Stream;
use App\Models\StreamResolution;
use App\Models\Video;
use App\Models\Presentation;
use App\Services\DownloadZip;
use App\Services\Store\DownloadResource;
use App\Services\Store\DownloadStreamResolution;
use App\Services\TicketHandler\Entitlement;
use App\Services\TicketHandler\TicketPermissionHandler;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DownloadService
{
    /** @var string */
    private const PUBLIC_DISK = 'public';

    /** @var string */
    private const MULTIPLAYER_TEMPLATE_PATH = 'multiplayer/dlplayer.html';

    /** @var string */
    private const STATUS_ASSETS  = 'assets';
    private const STATUS_PKG    = 'package';

    /** Cache for parsed ini */
    private ?string $storeListUri = null;

    /**
     * @param  callable(int $percent): void  $progress
     */
    public function run(Video $video, Entitlement $entitlement, callable $progress = null): void
    {
        $progress ??= fn (int $p) => null;

        $presentation = Presentation::findOrFail($video->id);

        // === Phase 1: fetch assets ===
        $this->downloadAssets($video, $entitlement, $presentation);
        $progress(40);

        // === Phase 2: build package ===
        $this->buildPackage($presentation);
        $progress(75);

        // === Phase 3: zip ===
        $this->zip($video, $presentation);
        $progress(100);
    }

    private function downloadAssets(Video $video, Entitlement $entitlement, Presentation $presentation): void
    {
        //file/folder creation + DownloadResource loops here
        $dirVideo  = trim($presentation->local, '/') . '/videos';
        $dirPoster = trim($presentation->local, '/') . '/posters';

        $downloader = new DownloadResource($video, new TicketPermissionHandler($video, $entitlement));
        $resolver   = new DownloadStreamResolution($video);

        $videoNames  = $resolver->videonames($presentation->resolution);
        $posterNames = $resolver->posternames();

        // Create directories
        Storage::disk(self::PUBLIC_DISK)->makeDirectory($dirVideo);
        Storage::disk(self::PUBLIC_DISK)->makeDirectory($dirPoster);

        // Download video files
        foreach ($videoNames as $name) {
            $downloader->getFile(
                $dirVideo . '/' . basename($name),
                $this->storeBaseUri() . '/' . $video->id . '/' . ltrim($name, '/')
            );
        }

        // Download poster files
        foreach ($posterNames as $name) {
            $downloader->getFile(
                $dirPoster . '/' . basename($name),
                $this->storeBaseUri() . '/' . $video->id . '/' . ltrim($name, '/')
            );
        }
        // Mark
        $presentation->status = self::STATUS_ASSETS;
        $presentation->save();
    }

    private function buildPackage(Presentation $presentation): void
    {
        //package/dlplayer logic here
        $this->makePackage($presentation);

        // Mark
        $presentation->status = self::STATUS_PKG;
        $presentation->save();
    }

    private function zip(Video $video, Presentation $presentation): void
    {
        // Zip
        $zip = new DownloadZip($video, $presentation->local);
        $zip->makezip();
    }

    /**
     * Package builder: creates package.json and embeds into dlplayer.
     */
    private function makePackage(Presentation $presentation): bool
    {
        $video = Video::find($presentation->id);
        if (!$video) {
            return false;
        }

        $package = [
            'id'       => $video->id,
            'title'    => $video->title,
            'thumb'    => $presentation->thumb,
            'duration' => $video->duration,
            'sources'  => [],
        ];

        $streams = Stream::where('video_id', $video->id)->where('hidden', 0)->get();

        foreach ($streams as $sIndex => $stream) {
            $entry = [
                'poster'    => 'posters/' . basename($stream->poster),
                'playAudio' => (bool) $stream->audio,
                'name'      => $stream->name,
                'video'     => [],
            ];

            $resolutions = StreamResolution::where('stream_id', $stream->id)
                ->where('resolution', $presentation->resolution)
                ->get();

            foreach ($resolutions as $res) {
                $entry['video'][(string) $res->resolution] = 'videos/' . basename($res->filename);
            }

            $package['sources'][$sIndex] = $entry;
        }

        // Prepare player shell
        $this->prepareMultiplayer($presentation);

        // Write package.json
        $json = json_encode($package, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        Storage::disk(self::PUBLIC_DISK)->put(trim($presentation->local, '/') . '/package.json', $json);

        // Inject into player and emit play.html
        $this->embedPackageIntoPlayer($presentation);

        // Cleanup temp files
        Storage::disk(self::PUBLIC_DISK)->delete(trim($presentation->local, '/') . '/dlplayer.html');
        Storage::disk(self::PUBLIC_DISK)->delete(trim($presentation->local, '/') . '/package.json');

        return true;
    }

    private function embedPackageIntoPlayer(Presentation $presentation): void
    {
        $dir = trim($presentation->local, '/');
        $playerPath  = $dir . '/dlplayer.html';
        $packagePath = $dir . '/package.json';

        $multiplayer = Storage::disk(self::PUBLIC_DISK)->get($playerPath);
        $package     = Storage::disk(self::PUBLIC_DISK)->get($packagePath);

        // Replace %PACKAGE% placeholder
        $replaced = Str::replace('%PACKAGE%', $package, $multiplayer);

        Storage::disk(self::PUBLIC_DISK)->put($dir . '/play.html', $replaced);
    }

    private function prepareMultiplayer(Presentation $presentation): void
    {
        // Copy template into the public presentation dir
        Storage::copy(
            self::MULTIPLAYER_TEMPLATE_PATH,
            self::PUBLIC_DISK . '/' . trim($presentation->local, '/') . '/dlplayer.html'
        );
    }

    private function storeBaseUri(): string
    {
        if ($this->storeListUri !== null) {
            return $this->storeListUri;
        }

        $iniPath = base_path('/systemconfig/play.ini');
        if (!file_exists($iniPath)) {
            $iniPath = base_path('/systemconfig/play.ini.example');
        }

        $cfg = @parse_ini_file($iniPath, true) ?: [];
        $this->storeListUri = $cfg['store']['list_uri'] ?? config('services.store.list_uri', '');

        return $this->storeListUri;
    }
}
