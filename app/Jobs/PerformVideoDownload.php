<?php

namespace App\Jobs;

use App\Models\Video;
use App\Models\Presentation;
use App\Services\Download\DownloadService;
use App\Services\TicketHandler\Entitlement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class PerformVideoDownload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 900;               // 15 min
    public int $tries   = 3;                 // retry strategy

    public function __construct(
        public string $videoId,
        public array $providedEntitlements,
    ) {}

    //Prevent duplicate jobs per video while one is pending/running
    public function uniqueId(): string
    {
        return 'video-download:' . $this->videoId;
    }

    //Backoff between retries (seconds)
    public function backoff(): array
    {
        return [10, 30, 120];
    }

    public function handle(DownloadService $downloader, Entitlement $entitlement): void
    {

        $video = Video::findOrFail($this->videoId);
        $p = Presentation::findOrFail($this->videoId);

        //Mark as processing
        $p->update(['status' => 'processing', 'progress' => 10]);

        try {
            //Does the heavy lifting and reports progress
            $downloader->run($video, $entitlement, $this->providedEntitlements, function (int $percent) use ($p) {
                // Throttle writes as needed
                $p->update(['progress' => $percent]);
            });

        } catch (Throwable $e) {
            report($e);
            $p->update(['status' => 'failed']);
            //
            throw $e;
        }
        $p->update(['status' => 'stored', 'progress' => 100]);
    }

}
