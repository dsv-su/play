<?php

declare(strict_types=1);

namespace App\Services\Video;

use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

final class VideoStore
{
    public function __construct(private readonly Request $request) {}

    public function presentation(): Video
    {
        // Pull the "package"
        $pkg = (array) $this->request->input('package', []);

        // Title handling
        $titleObj = new TitleObject((array) data_get($pkg, 'title', ''));

        // Try to find existing video, otherwise create a new one
        $videoId = data_get($pkg, 'pkg_id');
        $video = Video::firstOrNew(['id' => $videoId]);

        // Build attributes cleanly
        $video->fill([
            'origin'          => $this->request->get('origin'),
            'notification_id' => $this->request->get('jobid'),
            'creation'        => data_get($pkg, 'created'),
            'title'           => $titleObj->swedish(),
            'title_en'        => $titleObj->english(),
            'description'     => data_get($pkg, 'description'),
            'thumb'           => data_get($pkg, 'thumb'),
            'duration'        => $this->normalizeDuration(data_get($pkg, 'duration')),
            'subtitles'       => json_encode(data_get($pkg, 'subtitles', []), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
            'sources'         => json_encode(data_get($pkg, 'sources', []), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
            'presentation'    => json_encode($this->request->all(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), // store full payload (cast to array in model)
            'category_id'     => (int) ($this->request->get('category_id', 1)),
            'state'           => $this->deriveState(json_decode($this->request->input('pending'), true)),
        ]);

        $video->save();

        return $video;
    }

    private function deriveState(mixed $pending): bool
    {
        // Treat anything as "has pending items" => state=false
        $pendingItems = Arr::wrap($pending);
        return count(array_filter($pendingItems, static fn($v) => !empty($v))) === 0;
    }

    private function normalizeDuration(mixed $value): ?Carbon
    {
        if ($value === null || $value === '') {
            return null;
        }

        return Carbon::parse($value);
    }
}
