<?php

namespace App\Services\Manage;

use App\Video;

class UncatPresentations
{
    public static function IsNullOrEmptyString($str): bool
    {
        return ($str === '%%' || trim($str) === '% %');
    }

    public static function uncat_presenter_id($filterTerm): \Illuminate\Support\Collection
    {
        return Video::with('video_presenter.presenter')
            ->whereHas('video_presenter.presenter', function ($query) use ($filterTerm) {
                $query->where('name', 'LIKE', $filterTerm)
                    ->orwhere('name', 'LIKE', $filterTerm);
            })
            ->pluck('id');
    }

    public static function uncat_video_courses($presenter_id)
    {
        return Video::doesntHave('video_course')
            ->whereIn('id', $presenter_id)
            ->get();
    }

    public static function unfiltered_uncat_video_course()
    {
        return Video::doesntHave('video_course')->get();
    }
}
