<?php

namespace App\Services\MyPresentation;

use App\Repositories\VideoRepositoryInterface;
use App\Services\Filters\VisibilityFilter;
use App\Services\VideoSearch\VideoFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/** Request-scoped queries: never persist presentation models in Livewire state. */
class PresentationLibrary
{
    public const NO_COURSE = 999999;

    public function __construct(
        private MyPresentationsService $membership,
        private VideoRepositoryInterface $videos,
        private VisibilityFilter $visibility,
    ) {}

    public function query(VideoFilters $filters): Builder
    {
        $username = (string) app('play_username');
        $authRole = (string) app('play_auth');
        $playRole = (string) app('play_role');
        $courses = $this->membership->resolveCourseIds($username, $authRole, $playRole);
        $individual = $this->membership->resolveIndividualVideoIds($username);
        $query = $this->videos->baseMyPresentationsQuery(
            $courses, $individual, $this->membership->isAdmin($authRole, $playRole),
        )->withoutEagerLoads();

        // The repository's empty OR group otherwise matches every active video.
        if (! $courses && ! $individual) {
            $query->whereRaw('1 = 0');
        }

        // Match VisibilityFilter's inclusion rules before counting or paginating.
        // Permission type changes display attributes, but does not affect inclusion.
        if ($playRole !== 'Administrator') {
            $query->where(function (Builder $q) use ($username) {
                $q->where('videos.visibility', true)
                    ->orWhereHas('individualPermissions', fn (Builder $p) => $p->where('username', $username))
                    ->orWhereHas('coursepermissions', fn (Builder $p) => $p->where('username', $username))
                    ->orWhereHas('courses', function (Builder $c) use ($username) {
                        $c->whereExists(function ($users) use ($username) {
                            $users->selectRaw('1')->from('coursesettings_users')
                                ->whereColumn('coursesettings_users.course_id', 'courses.id')
                                ->where('coursesettings_users.username', $username);
                        });
                    });
            });
        }

        if ($filters->courses || $filters->terms) {
            $query->where(function (Builder $q) use ($filters) {
                $q->whereHas('courses', function (Builder $c) use ($filters) {
                    if ($filters->courses) {
                        $c->whereIn('designation', $filters->courses);
                    }
                    if ($filters->terms) {
                        // Match the existing semester + year key, including nullable values.
                        $semester = "COALESCE(semester, '')";
                        $year = "COALESCE(year, '')";
                        $termKey = in_array($c->getConnection()->getDriverName(), ['sqlite', 'pgsql'], true)
                            ? "$semester || $year"
                            : "CONCAT($semester, $year)";
                        $c->whereIn(DB::raw($termKey), $filters->terms);
                    }
                });
                // Existing filters allow the no-course option regardless of semester selection.
                if (in_array('nocourse', $filters->courses ?? [], true)) {
                    $q->orWhereDoesntHave('courses');
                }
            });
        }
        foreach ($filters->tags ?? [] as $tag) {
            $query->whereHas('tags', fn (Builder $t) => $t->where('name', $tag));
        }
        if ($filters->presenters) {
            $query->whereHas('presenters', fn (Builder $p) => $p->whereIn('username', $filters->presenters));
        }

        return $query;
    }

    public function summary(Builder $query): array
    {
        $ids = (clone $query)->select('videos.id')->toBase();
        $groups = DB::query()->fromSub(clone $ids, 'matched')
            ->leftJoin('video_courses', 'video_courses.video_id', '=', 'matched.id')
            ->selectRaw('COALESCE(video_courses.course_id, ?) as course_id, COUNT(DISTINCT matched.id) as total', [self::NO_COURSE])
            ->groupBy('video_courses.course_id')->orderByDesc('course_id')->get();
        $counts = $groups->mapWithKeys(fn ($g) => [$g->course_id => (int) $g->total]);

        $courseColumns = ['courses.id', 'designation', 'semester', 'year', 'name', 'name_en'];
        $courses = DB::table('courses')->join('video_courses', 'video_courses.course_id', '=', 'courses.id')
            ->joinSub((clone $query)->select('videos.id', 'creation')->toBase(), 'matched', 'matched.id', '=', 'video_courses.video_id')
            ->select($courseColumns)->selectRaw('MAX(matched.creation) as latest_creation')
            ->groupBy($courseColumns)->orderByDesc('latest_creation')->orderBy('courses.id')->get();
        $courseOptions = ['nocourse' => __('No course association')];
        $titles = [self::NO_COURSE => __('Presentations')];
        foreach ($courses as $course) {
            $name = app()->getLocale() === 'sv' ? $course->name : $course->name_en;
            $courseOptions[$course->designation] ??= $name;
            $titles[$course->id] = "{$course->designation} {$course->semester}{$course->year} — {$name}";
        }
        $terms = $courses->map(fn ($c) => $c->semester.$c->year)->unique()->values()->all();
        $tags = DB::table('tags')->join('video_tags', 'video_tags.tag_id', '=', 'tags.id')
            ->whereIn('video_tags.video_id', clone $ids)->distinct()->orderBy('name')->pluck('name')->all();
        $presenters = DB::table('presenters')->join('video_presenters', 'video_presenters.presenter_id', '=', 'presenters.id')
            ->whereIn('video_presenters.video_id', clone $ids)->select('username', 'name')->distinct()->get()
            ->pluck('name', 'username')->all();
        asort($presenters);

        return [
            'counts' => $counts, 'titles' => $titles, 'courses' => $courseOptions,
            'terms' => $terms, 'tags' => $tags, 'presenters' => $presenters,
            'total' => (clone $query)->count(),
        ];
    }

    public function page(Builder $query, string $courseId, int $page, int $perPage = 20, ?int $total = null): LengthAwarePaginator
    {
        $query = clone $query;
        if ($courseId === (string) self::NO_COURSE) {
            $query->whereDoesntHave('videoCourse');
        } else {
            $query->whereHas('videoCourse', fn (Builder $c) => $c->where('course_id', $courseId));
        }
        $total ??= (clone $query)->count();
        $page = min(max(1, $page), max(1, (int) ceil($total / $perPage)));
        $videos = $query->with(['courses', 'tags', 'presenters', 'videoCourse', 'status', 'category', 'pending'])
            ->orderByDesc('creation')->orderBy('videos.id')->forPage($page, $perPage)->get();

        return new LengthAwarePaginator(
            $this->visibility->filter($videos)->values(), $total, $perPage, $page,
            ['path' => request()->url(), 'pageName' => 'presentationsPage'],
        );
    }
}
