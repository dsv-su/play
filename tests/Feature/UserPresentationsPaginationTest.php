<?php

namespace Tests\Feature;

use App\Livewire\My\UserPresentations;
use App\Models\Video;
use App\Repositories\EloquentVideoRepository;
use App\Services\Filters\VisibilityFilter;
use App\Services\MyPresentation\MyPresentationsService;
use App\Services\MyPresentation\PresentationLibrary;
use App\Services\VideoSearch\VideoFilters;
use App\Services\VideoSearch\VideoSearchService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Mockery;
use Tests\TestCase;

class UserPresentationsPaginationTest extends TestCase
{
    private PresentationLibrary $library;

    private MyPresentationsService $membership;

    protected function setUp(): void
    {
        parent::setUp();
        // Isolated schema: these tests never touch the configured application database.
        config(['database.default' => 'library_test', 'database.connections.library_test' => [
            'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '',
        ]]);
        $this->app->instance('play_username', 'alice');
        $this->app->instance('play_auth', 'Student');
        $this->app->instance('play_role', 'Student');
        Schema::create('videos', function (Blueprint $t) {
            $t->string('id')->primary();
            $t->boolean('state')->default(true);
            $t->boolean('visibility')->default(true);
            $t->integer('creation');
            $t->string('thumb')->default('thumb.jpg');
            $t->string('title')->default('A presentation');
            $t->string('title_en')->nullable();
            $t->integer('category_id')->default(1);
        });
        Schema::create('courses', function (Blueprint $t) {
            $t->integer('id')->primary();
            foreach (['designation', 'semester', 'year', 'name', 'name_en'] as $column) {
                $t->string($column);
            }
            $t->boolean('state')->default(true);
            $t->boolean('visibility')->default(true);
        });
        foreach (['video_courses' => 'course_id', 'video_tags' => 'tag_id', 'video_presenters' => 'presenter_id', 'video_permissions' => 'permission_id'] as $table => $foreign) {
            Schema::create($table, function (Blueprint $t) use ($foreign) {
                $t->increments('id');
                $t->string('video_id');
                $t->integer($foreign);
                $t->timestamps();
            });
        }
        foreach (['individual_permissions', 'courseadmin_permissions', 'coursesettings_users'] as $table) {
            Schema::create($table, function (Blueprint $t) use ($table) {
                $t->increments('id');
                $table === 'coursesettings_users' ? $t->integer('course_id') : $t->string('video_id');
                $t->string('username');
                $t->string('permission')->default('view');
            });
        }
        Schema::create('tags', function (Blueprint $t) {
            $t->integer('id');
            $t->string('name');
        });
        Schema::create('presenters', function (Blueprint $t) {
            $t->integer('id');
            $t->string('username');
            $t->string('name');
        });
        Schema::create('categories', function (Blueprint $t) {
            $t->integer('id');
            $t->string('category_name');
        });
        DB::table('categories')->insert(['id' => 1, 'category_name' => 'Lecture']);
        Schema::create('pendings', function (Blueprint $t) {
            $t->string('video_id');
        });
        $this->membership = Mockery::mock(MyPresentationsService::class)->makePartial();
        $this->membership->shouldReceive('resolveCourseIds')->andReturn([42]);
        $this->membership->shouldReceive('resolveIndividualVideoIds')->andReturn(['orphan']);
        $this->library = new PresentationLibrary($this->membership, new EloquentVideoRepository, new VisibilityFilter);
        $this->app->instance(PresentationLibrary::class, $this->library);
        DB::table('courses')->insert([
            ['id' => 42, 'designation' => 'ABC', 'semester' => 'HT', 'year' => '2026', 'name' => 'Kurs', 'name_en' => 'Course'],
            ['id' => 43, 'designation' => 'DEF', 'semester' => 'VT', 'year' => '2025', 'name' => 'Annan', 'name_en' => 'Other'],
        ]);
        for ($i = 1; $i <= 45; $i++) {
            $this->video((string) $i, 42, $i);
        }
        $this->video('orphan', null, 100);
        DB::table('individual_permissions')->insert(['video_id' => 'orphan', 'username' => 'alice']);
    }

    private function video(string $id, ?int $course, int $creation, bool $visible = true, bool $state = true): void
    {
        DB::table('videos')->insert(['id' => $id, 'creation' => $creation, 'visibility' => $visible, 'state' => $state]);
        if ($course !== null) {
            DB::table('video_courses')->insert(['video_id' => $id, 'course_id' => $course]);
        }
    }

    private function makeLibraryComponent(?string $open = null, int $page = 1): UserPresentations
    {
        $component = new UserPresentations;
        $component->activeAccordion = $open;
        $component->paginators = ['presentationsPage' => $page];

        return $component;
    }

    public function test_closed_or_unknown_courses_load_no_video_models(): void
    {
        $retrieved = 0;
        Video::retrieved(function () use (&$retrieved) {
            $retrieved++;
        });
        foreach ([null, 'course-unknown', 'invalid', 'course-43'] as $open) {
            $data = $this->makeLibraryComponent($open)->render()->getData();
            $this->assertSame(46, $data['totalCount']);
            $this->assertSame([999999 => 1, 42 => 45], $data['courseCounts']->all());
            $this->assertCount(0, $data['courseVideos']->items());
        }
        $this->assertSame(0, $retrieved);
    }

    public function test_only_one_page_is_hydrated_and_no_models_are_public_state(): void
    {
        $retrieved = 0;
        Video::retrieved(function () use (&$retrieved) {
            $retrieved++;
        });
        $component = $this->makeLibraryComponent('course-42', 2);
        $paginator = $component->render()->getData()['courseVideos'];
        $this->assertSame(45, $paginator->total());
        $this->assertSame(array_map('strval', range(25, 6)), $paginator->getCollection()->pluck('id')->all());
        $this->assertSame(20, $retrieved);
        $this->assertArrayNotHasKey('videos', get_object_vars($component));
        $this->assertArrayNotHasKey('allVideos', get_object_vars($component));
    }

    public function test_pages_are_clamped_and_unassociated_presentations_work(): void
    {
        $page = $this->makeLibraryComponent('course-42', 99)->render()->getData()['courseVideos'];
        $this->assertSame(3, $page->currentPage());
        $this->assertCount(5, $page->items());
        $orphan = $this->makeLibraryComponent('course-999999', 2)->render()->getData()['courseVideos'];
        $this->assertSame(1, $orphan->total());
        $this->assertSame('orphan', $orphan->items()[0]->id);
    }

    public function test_permission_overrides_match_existing_visibility_filter(): void
    {
        foreach (['hidden', 'individual', 'admin', 'course-user', 'inactive'] as $index => $id) {
            $this->video($id, $id === 'course-user' ? 43 : 42, 200 + $index, false, $id !== 'inactive');
        }
        // A second course on a library video can grant visibility.
        DB::table('video_courses')->insert(['video_id' => 'course-user', 'course_id' => 42]);
        DB::table('individual_permissions')->insert(['video_id' => 'individual', 'username' => 'alice', 'permission' => 'edit']);
        DB::table('courseadmin_permissions')->insert(['video_id' => 'admin', 'username' => 'alice', 'permission' => 'delete']);
        DB::table('coursesettings_users')->insert(['course_id' => 43, 'username' => 'alice']);
        $repository = new EloquentVideoRepository;
        foreach (['Student', 'Administrator'] as $role) {
            $this->app->instance('play_role', $role);
            $legacy = (new VisibilityFilter)->filter($repository->topFor([42], ['orphan'], false, 1000));
            $query = $this->library->query(new VideoFilters);
            $this->assertEqualsCanonicalizing($legacy->pluck('id')->all(), (clone $query)->pluck('videos.id')->all());
            $this->assertSame($legacy->count(), $this->library->summary($query)['total']);
        }
        $page = $this->library->page($this->library->query(new VideoFilters), '42', 1);
        $this->assertTrue($page->getCollection()->firstWhere('id', 'individual')->edit);
        $this->assertTrue($page->getCollection()->firstWhere('id', 'admin')->delete);
    }

    public function test_filters_facets_and_multi_course_counts_match_existing_service(): void
    {
        DB::table('video_courses')->insert(['video_id' => '45', 'course_id' => 43]);
        DB::table('tags')->insert([['id' => 1, 'name' => 'One'], ['id' => 2, 'name' => 'Two']]);
        DB::table('presenters')->insert(['id' => 1, 'username' => 'teacher', 'name' => 'Teacher']);
        DB::table('video_tags')->insert([
            ['video_id' => '45', 'tag_id' => 1], ['video_id' => '45', 'tag_id' => 2], ['video_id' => '44', 'tag_id' => 1],
        ]);
        DB::table('video_presenters')->insert(['video_id' => '45', 'presenter_id' => 1]);
        $legacy = (new EloquentVideoRepository)->topFor([42], ['orphan'], false, 1000);
        foreach ([new VideoFilters, new VideoFilters(['DEF'], ['VT2025']), new VideoFilters(tags: ['One', 'Two']), new VideoFilters(presenters: ['teacher']), new VideoFilters(['nocourse'], ['HT2026']), new VideoFilters(['ABC'], ['VT2025']), new VideoFilters(tags: ['missing'])] as $filters) {
            [$courses, $terms, $presenters, $tags, $groups] = (new VideoSearchService)->performFiltering($legacy, $filters);
            $summary = $this->library->summary($this->library->query($filters));
            $this->assertEquals($groups->map->count()->all(), $summary['counts']->all());
            $this->assertEquals($courses, $summary['courses']);
            $this->assertEqualsCanonicalizing($terms, $summary['terms']);
            $this->assertEquals($presenters, $summary['presenters']);
            $this->assertEquals($tags, $summary['tags']);
        }
    }

    public function test_course_changes_and_filters_reset_pagination(): void
    {
        $component = $this->makeLibraryComponent('course-42', 2);
        $component->toggleCourse('course-999999');
        $this->assertSame('course-999999', $component->activeAccordion);
        $this->assertSame(1, $component->paginators['presentationsPage']);
        $component->toggleCourse('course-unknown');
        $this->assertSame('course-999999', $component->activeAccordion);
        $component->toggleCourse('course-999999');
        $this->assertNull($component->activeAccordion);
        $component->selectedTags = ['One'];
        $component->clearFilters();
        $this->assertSame([], $component->selectedTags);
        $this->assertSame(46, $component->render()->getData()['totalCount']);
    }

    public function test_livewire_renders_and_updates_filters_without_serializing_models(): void
    {
        Livewire::test(UserPresentations::class)
            ->assertSee('46 presentations')
            ->call('toggleCourse', 'course-42')
            ->assertSee('A presentation')
            ->call('setPage', 2, 'presentationsPage')
            ->assertSet('paginators.presentationsPage', 2)
            ->set('selectedCourses', ['nocourse'])
            ->assertSet('paginators.presentationsPage', 1)
            ->assertSee('1 presentation')
            ->call('clearFilters')
            ->assertSee('46 presentations');
    }

    public function test_counts_and_pagination_cover_presentations_beyond_the_old_limit(): void
    {
        $videos = [];
        $courses = [];
        for ($i = 46; $i <= 1005; $i++) {
            $videos[] = ['id' => (string) $i, 'creation' => $i];
            $courses[] = ['video_id' => (string) $i, 'course_id' => 42];
        }
        DB::table('videos')->insert($videos);
        DB::table('video_courses')->insert($courses);
        $data = $this->makeLibraryComponent('course-42', 51)->render()->getData();
        $this->assertSame(1006, $data['totalCount']);
        $this->assertSame(1005, $data['courseCounts']->get(42));
        $this->assertSame(1005, $data['courseVideos']->total());
        $this->assertCount(5, $data['courseVideos']->items());
    }

    public function test_empty_membership_never_exposes_other_presentations(): void
    {
        $membership = Mockery::mock(MyPresentationsService::class)->makePartial();
        $membership->shouldReceive('resolveCourseIds')->andReturn([]);
        $membership->shouldReceive('resolveIndividualVideoIds')->andReturn([]);
        $library = new PresentationLibrary($membership, new EloquentVideoRepository, new VisibilityFilter);
        $summary = $library->summary($library->query(new VideoFilters));
        $this->assertSame(0, $summary['total']);
        $this->assertTrue($summary['counts']->isEmpty());
    }
}
