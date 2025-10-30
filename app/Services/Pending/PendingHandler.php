<?php

namespace App\Services\Pending;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

final class PendingHandler
{
    public function __construct(private readonly Request $request) {}

    public function handle()
    {
        // Pull the "package"
        $pkg = (array) $this->request->input('package', []);

        // Try to find existing video, otherwise create a new one
        $pkgId = data_get($pkg, 'pkg_id');
        $pkg = \App\Models\Pending::firstOrNew(['id' => $pkgId]);

        // Build attributes
        $pkg->fill([
            'id'          => $pkgId,
            'video_id'    => $pkgId,
            'handlers'    => json_encode($this->request->input('pending'), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
            'progress'        => $this->calculateProgress($this->request->input('pending')),
        ]);

        $pkg->save();
    }

    private function calculateProgress(mixed $pending): float
    {
        $items = Arr::wrap($pending);
        $total = 4;

        $done = count(array_filter($items, fn($v) => !empty($v)));

        return round((1 - ($done / $total)) * 100, 2); // return as percentage
    }
}
