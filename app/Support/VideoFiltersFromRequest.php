<?php

namespace App\Support;

use App\Services\VideoSearch\VideoFilters;

class VideoFiltersFromRequest
{
    public static function make(array $overrides = []): VideoFilters
    {
        return new VideoFilters(
            $overrides['course']    ?? (request()->filled('course')    ? explode(',', request('course'))    : null),
            $overrides['semester']  ?? (request()->filled('semester')  ? explode(',', request('semester'))  : null),
            $overrides['tag']       ?? (request()->filled('tag')       ? explode(',', request('tag'))       : null),
            $overrides['presenter'] ?? (request()->filled('presenter') ? explode(',', request('presenter')) : null),
        );
    }

}
