<?php

namespace App\Repositories;

use App\Models\Video;
use Illuminate\Support\Collection;

class EloquentVideoRepository implements VideoRepositoryInterface
{
    public function baseMyPresentationsQuery(array $courseIds, array $individualVideoIds, bool $isAdmin)
    {
        return Video::query()
            ->with([
                'video_course.course' => function ($q) {
                    $q->select('id');
                },
                'video_tag.tag' => function ($q) {
                    $q->select('id');
                },
            ])
            ->where(function ($q) use ($courseIds, $individualVideoIds, $isAdmin) {
                if (!empty($courseIds)) {
                    $q->whereHas('video_course.course', function ($sub) use ($courseIds, $isAdmin) {
                        $sub->whereIn('id', $courseIds)
                            ->where('state', true);

                        if (!$isAdmin) {
                            $sub->where('visibility', true);
                        }
                    });
                }

                if (!empty($individualVideoIds)) {
                    $q->orWhereIn('id', $individualVideoIds);
                }
            })
            ->where('state', true);
    }

    public function countFor(array $courseIds, array $individualVideoIds, bool $isAdmin): int
    {
        $query = $this->baseMyPresentationsQuery($courseIds, $individualVideoIds, $isAdmin);
        return (clone $query)->count();
    }

    public function topFor(array $courseIds, array $individualVideoIds, bool $isAdmin, int $limit = 10): Collection
    {
        return $this->baseMyPresentationsQuery($courseIds, $individualVideoIds, $isAdmin)
            ->latest('creation')
            ->limit($limit)
            ->get();
    }

    public function paginateFor(array $courseIds, array $individualVideoIds, bool $isAdmin, int $perPage = 10)
    {
        return $this->baseMyPresentationsQuery($courseIds, $individualVideoIds, $isAdmin)
            ->latest('creation')
            ->paginate($perPage);
    }
}
