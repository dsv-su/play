<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface VideoRepositoryInterface
{
    /**
     * Build the base query for "my presentations".
     *
     * @param array<int,int|string> $courseIds
     * @param array<int,int|string> $individualVideoIds
     * @param bool $isAdmin
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function baseMyPresentationsQuery(array $courseIds, array $individualVideoIds, bool $isAdmin);

    /** @return int */
    public function countFor(array $courseIds, array $individualVideoIds, bool $isAdmin): int;

    /** @return \Illuminate\Support\Collection<\App\Models\Video> */
    public function topFor(array $courseIds, array $individualVideoIds, bool $isAdmin, int $limit = 10): Collection;

    /** @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<\App\Models\Video> */
    //public function paginateFor(array $courseIds, array $individualVideoIds, bool $isAdmin, int $perPage = 10): LengthAwarePaginator;
}
