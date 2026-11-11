<?php

namespace App\Repositories;

use App\Models\Video;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface VideoRepositoryInterface
{
    /**
     * Build the base query for "my presentations".
     *
     * @param  array<int,int|string>  $courseIds
     * @param  array<int,int|string>  $individualVideoIds
     * @return Builder
     */
    public function baseMyPresentationsQuery(array $courseIds, array $individualVideoIds, bool $isAdmin);

    public function countFor(array $courseIds, array $individualVideoIds, bool $isAdmin): int;

    /** @return Collection<Video> */
    public function topFor(array $courseIds, array $individualVideoIds, bool $isAdmin, int $limit = 10): Collection;

    /** @return LengthAwarePaginator<Video> */
    // public function paginateFor(array $courseIds, array $individualVideoIds, bool $isAdmin, int $perPage = 10): LengthAwarePaginator;
}
