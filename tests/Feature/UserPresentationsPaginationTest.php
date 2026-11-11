<?php

namespace Tests\Feature;

use App\Livewire\My\UserPresentations;
use App\Livewire\Search\PresenterResults;
use App\Models\Video;
use App\Repositories\EloquentVideoRepository;
use App\Services\Filters\VisibilityFilter;
use App\Services\MyPresentation\MyPresentationsService;
use App\Services\MyPresentation\PresentationLibrary;
use App\Services\VideoSearch\VideoFilters;
use App\Services\VideoSearch\VideoSearchService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException;
use Livewire\Livewire;
use Mockery;
use Tests\Concerns\InteractsWithPresentationLibrary;
use Tests\TestCase;

class UserPresentationsPaginationTest extends TestCase
{
    use InteractsWithPresentationLibrary {
        setUp as protected setUpLibrary;
    }

    protected function setUp(): void
    {
        $this->setUpLibrary();
        Schema::table('videos', fn (Blueprint $table) => $table->boolean('unlisted')->default(false));
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->default('my-channel');
            $table->string('created_by');
        });
        Schema::create('channel_video_assignments', function (Blueprint $table) {
            $table->id();
            $table->integer('channel_id');
            $table->string('video_id');
            $table->string('assigned_by');
            $table->timestamps();
        });
    }

    public function test_can_add_a_manageable_presentation_to_own_channel_without_duplicates(): void
    {
        DB::table('channels')->insert(['id' => 1, 'name' => 'My channel', 'created_by' => 'alice']);
        DB::table('individual_permissions')->insert(['video_id' => '45', 'username' => 'alice', 'permission' => 'edit']);

        Livewire::test(UserPresentations::class)
            ->call('addToChannel', '45', 1)
            ->assertSee('Presentation added to channel.')
            ->call('addToChannel', '45', 1);

        $this->assertDatabaseCount('channel_video_assignments', 1);
        $this->assertDatabaseHas('channel_video_assignments', ['channel_id' => 1, 'video_id' => '45', 'assigned_by' => 'alice']);
    }

    public function test_cannot_add_to_another_users_channel(): void
    {
        DB::table('channels')->insert(['id' => 1, 'name' => 'Other channel', 'created_by' => 'bob']);
        $this->assertAdditionRejected('45', 1);
        $this->assertDatabaseCount('channel_video_assignments', 0);
    }

    public function test_connected_channels_are_shown_as_links_in_the_library(): void
    {
        DB::table('channels')->insert(['id' => 1, 'name' => 'Research talks', 'created_by' => 'alice']);
        DB::table('channel_video_assignments')->insert([
            'channel_id' => 1, 'video_id' => '45', 'assigned_by' => 'alice',
        ]);

        Livewire::test(UserPresentations::class)
            ->call('toggleCourse', 'course-42')
            ->assertSee('Research talks')
            ->assertSeeHtml('href="'.route('channels.show', 'my-channel').'"');
    }

    public function test_cannot_add_view_only_or_unlisted_presentations(): void
    {
        DB::table('channels')->insert(['id' => 1, 'name' => 'My channel', 'created_by' => 'alice']);
        $this->assertAdditionRejected('45', 1);
        DB::table('individual_permissions')->insert(['video_id' => '45', 'username' => 'alice', 'permission' => 'edit']);
        DB::table('videos')->where('id', '45')->update(['unlisted' => true]);
        $this->assertAdditionRejected('45', 1);
        $this->assertDatabaseCount('channel_video_assignments', 0);
    }

    private function assertAdditionRejected(string $videoId, int $channelId): void
    {
        try {
            (new UserPresentations)->addToChannel($videoId, $channelId);
            $this->fail('Unauthorized channel assignment was accepted.');
        } catch (ModelNotFoundException) {
            $this->assertDatabaseCount('channel_video_assignments', 0);
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

    public function test_presenter_results_use_the_presenter_scope_without_loading_closed_courses(): void
    {
        DB::table('presenters')->insert([
            ['id' => 1, 'username' => 'teacher', 'name' => 'Teacher'],
            ['id' => 2, 'username' => 'other', 'name' => 'Other'],
        ]);
        // Presenter results must include visible videos outside My presentations.
        $this->video('outside', 43, 200);
        $this->video('private', 43, 201, false);
        foreach (['outside', 'private', 'orphan', '45'] as $id) {
            DB::table('video_presenters')->insert(['video_id' => $id, 'presenter_id' => 1]);
        }
        DB::table('video_presenters')->insert(['video_id' => '44', 'presenter_id' => 2]);
        $retrieved = 0;
        Video::retrieved(function () use (&$retrieved) {
            $retrieved++;
        });
        $component = new PresenterResults;
        $component->presenter_search = 'teacher';
        $data = $component->render()->getData();
        $this->assertSame(3, $data['totalCount']);
        $this->assertSame([999999 => 1, 43 => 1, 42 => 1], $data['courseCounts']->all());
        $this->assertSame(0, $retrieved);
        $this->assertArrayNotHasKey('allVideos', get_object_vars($component));
        $component->toggleCourse('course-43');
        $page = $component->render()->getData()['courseVideos'];
        $this->assertSame(['outside'], $page->getCollection()->pluck('id')->all());
        $this->assertSame(1, $retrieved);
        $component->toggleCourse('course-unknown');
        $this->assertSame('course-43', $component->activeAccordion);
    }

    public function test_presenter_livewire_filters_paginates_and_keeps_its_scope_locked(): void
    {
        DB::table('presenters')->insert(['id' => 1, 'username' => 'teacher', 'name' => 'Teacher']);
        foreach (range(1, 45) as $id) {
            DB::table('video_presenters')->insert(['video_id' => (string) $id, 'presenter_id' => 1]);
        }
        Livewire::test(PresenterResults::class, ['presenter_search' => 'teacher'])
            ->assertSee('Presenter: Teacher')
            ->assertSee('45 presentations')
            ->assertDontSee('Edit selected')
            ->call('toggleCourse', 'course-42')
            ->assertSee('A presentation')
            ->call('setPage', 3, 'presentationsPage')
            ->assertSet('paginators.presentationsPage', 3)
            ->set('selectedCourses', ['nocourse'])
            ->assertSee('0 presentations')
            ->assertSet('paginators.presentationsPage', 1)
            ->call('clearFilters')
            ->assertSee('45 presentations');

        $this->expectException(CannotUpdateLockedPropertyException::class);
        Livewire::test(PresenterResults::class, ['presenter_search' => 'teacher'])
            ->set('presenter_search', 'other');
    }
}
