<?php

namespace Tests\Feature;

use App\Livewire\Search\TagResults;
use App\Models\Video;
use Illuminate\Support\Facades\DB;
use Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException;
use Livewire\Livewire;
use Tests\Concerns\InteractsWithPresentationLibrary;
use Tests\TestCase;

class TagResultsPaginationTest extends TestCase
{
    use InteractsWithPresentationLibrary {
        setUp as protected setUpLibrary;
    }

    protected function setUp(): void
    {
        $this->setUpLibrary();
        DB::table('tags')->insert([['id' => 1, 'name' => 'Topic'], ['id' => 2, 'name' => 'Other']]);
        foreach (range(1, 45) as $id) {
            DB::table('video_tags')->insert(['video_id' => (string) $id, 'tag_id' => 1]);
        }
        DB::table('video_tags')->insert(['video_id' => 'orphan', 'tag_id' => 1]);
    }

    private function makeTagResults(?string $open, int $page = 1): TagResults
    {
        $component = new TagResults;
        $component->tagName = 'Topic';
        $component->activeAccordion = $open;
        $component->paginators = ['presentationsPage' => $page];

        return $component;
    }

    public function test_closed_and_unknown_courses_load_no_video_models(): void
    {
        $retrieved = 0;
        Video::retrieved(function () use (&$retrieved) {
            $retrieved++;
        });
        foreach ([null, 'course-unknown', 'invalid', 'course-43'] as $open) {
            $data = $this->makeTagResults($open)->render()->getData();
            $this->assertSame(46, $data['totalCount']);
            $this->assertCount(0, $data['courseVideos']->items());
        }
        $this->assertSame(0, $retrieved);
    }

    public function test_only_one_database_page_is_hydrated_without_public_models(): void
    {
        $retrieved = 0;
        Video::retrieved(function () use (&$retrieved) {
            $retrieved++;
        });
        $component = $this->makeTagResults('course-42', 2);
        $page = $component->render()->getData()['courseVideos'];
        $this->assertSame(45, $page->total());
        $this->assertSame(array_map('strval', range(25, 6)), $page->getCollection()->pluck('id')->all());
        $this->assertSame(20, $retrieved);
        $this->assertArrayNotHasKey('videos', get_object_vars($component));
        $this->assertArrayNotHasKey('allVideos', get_object_vars($component));
    }

    public function test_no_course_results_and_out_of_range_pages_work(): void
    {
        $page = $this->makeTagResults('course-42', 99)->render()->getData()['courseVideos'];
        $this->assertSame(3, $page->currentPage());
        $this->assertCount(5, $page->items());
        $orphan = $this->makeTagResults('course-999999', 2)->render()->getData()['courseVideos'];
        $this->assertSame(1, $orphan->currentPage());
        $this->assertSame(['orphan'], $orphan->getCollection()->pluck('id')->all());
    }

    public function test_tag_scope_includes_visible_results_outside_membership_and_permission_overrides(): void
    {
        $this->video('outside', 43, 200);
        $this->video('hidden', 43, 201, false);
        $this->video('allowed', 43, 202, false);
        $this->video('unrelated', 43, 203);
        foreach (['outside', 'hidden', 'allowed'] as $id) {
            DB::table('video_tags')->insert(['video_id' => $id, 'tag_id' => 1]);
        }
        DB::table('individual_permissions')->insert(['video_id' => 'allowed', 'username' => 'alice']);
        $component = $this->makeTagResults('course-43');
        $data = $component->render()->getData();
        $this->assertSame(48, $data['totalCount']);
        $this->assertSame(['allowed', 'outside'], $data['courseVideos']->getCollection()->pluck('id')->all());
        $component->toggleCourse('course-unknown');
        $this->assertSame('course-43', $component->activeAccordion);
    }

    public function test_livewire_filters_reset_pagination_and_clearing_keeps_the_tag_scope(): void
    {
        DB::table('presenters')->insert(['id' => 1, 'username' => 'teacher', 'name' => 'Teacher']);
        DB::table('video_presenters')->insert(['video_id' => '45', 'presenter_id' => 1]);
        Livewire::test(TagResults::class, ['tag' => 'Topic'])
            ->assertSee('Tag: Topic')
            ->assertSee('46 presentations')
            ->assertDontSee('Edit selected')
            ->call('toggleCourse', 'course-42')
            ->assertSee('A presentation')
            ->call('setPage', 3, 'presentationsPage')
            ->assertSet('paginators.presentationsPage', 3)
            ->set('selectedPresenters', ['teacher'])
            ->assertSee('1 presentation')
            ->assertSet('paginators.presentationsPage', 1)
            ->call('handleRecompute', 'presenter')
            ->assertSee('46 presentations')
            ->set('selectedCourses', ['nocourse'])
            ->assertSee('1 presentation')
            ->call('clearFilters')
            ->assertSet('tagName', 'Topic')
            ->assertSee('46 presentations');
    }

    public function test_tag_scope_is_locked_and_unknown_tags_are_empty(): void
    {
        Livewire::test(TagResults::class, ['tag' => 'Missing'])->assertSee('0 presentations');
        $this->expectException(CannotUpdateLockedPropertyException::class);
        Livewire::test(TagResults::class, ['tag' => 'Topic'])->set('tagName', 'Other');
    }
}
