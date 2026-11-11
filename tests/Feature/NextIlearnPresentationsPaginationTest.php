<?php

namespace Tests\Feature;

use App\Livewire\Nextilearn\NextIlearnPresentations;
use App\Models\Video;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\Concerns\InteractsWithPresentationLibrary;
use Tests\TestCase;

class NextIlearnPresentationsPaginationTest extends TestCase
{
    use InteractsWithPresentationLibrary {
        setUp as protected setUpLibrary;
    }

    protected function setUp(): void
    {
        $this->setUpLibrary();
        DB::table('categories')->insert(['id' => 8, 'category_name' => 'NextIlearn Tutorials']);
        DB::table('videos')->where('id', '!=', 'orphan')->update(['category_id' => 8]);
    }

    private function results(?string $open = null, int $page = 1): NextIlearnPresentations
    {
        $component = new NextIlearnPresentations;
        $component->activeAccordion = $open;
        $component->paginators = ['presentationsPage' => $page];

        return $component;
    }

    public function test_closed_and_unknown_courses_load_no_models(): void
    {
        $retrieved = 0;
        Video::retrieved(function () use (&$retrieved) {
            $retrieved++;
        });
        foreach ([null, 'invalid', 'course-unknown', 'course-43'] as $open) {
            $data = $this->results($open)->render()->getData();
            $this->assertSame(45, $data['totalCount']);
            $this->assertCount(0, $data['courseVideos']->items());
        }
        $this->assertSame(0, $retrieved);
    }

    public function test_only_one_page_is_hydrated_and_pages_are_clamped(): void
    {
        $retrieved = 0;
        Video::retrieved(function () use (&$retrieved) {
            $retrieved++;
        });
        $component = $this->results('course-42', 2);
        $page = $component->render()->getData()['courseVideos'];
        $this->assertSame(45, $page->total());
        $this->assertSame(array_map('strval', range(25, 6)), $page->getCollection()->pluck('id')->all());
        $this->assertSame(20, $retrieved);
        foreach (['videos', 'allVideos', 'nextilearnvideos'] as $property) {
            $this->assertArrayNotHasKey($property, get_object_vars($component));
        }
        $last = $this->results('course-42', 99)->render()->getData()['courseVideos'];
        $this->assertSame(3, $last->currentPage());
        $this->assertCount(5, $last->items());
    }

    public function test_tutorial_scope_excludes_hidden_inactive_and_other_categories_for_all_roles(): void
    {
        DB::table('categories')->insert(['id' => 2, 'category_name' => 'Study information']);
        $this->video('study', 43, 199);
        DB::table('videos')->where('id', 'study')->update(['category_id' => 2]);
        $this->video('hidden', 43, 200, false);
        $this->video('inactive', 43, 201, true, false);
        $this->video('outside', 43, 202);
        $this->video('unassociated', null, 203);
        DB::table('videos')->whereIn('id', ['hidden', 'inactive', 'outside', 'unassociated'])->update(['category_id' => 8]);
        DB::table('individual_permissions')->insert(['video_id' => 'hidden', 'username' => 'alice', 'permission' => 'edit']);
        foreach (['Student', 'Administrator'] as $role) {
            $this->app->instance('play_role', $role);
            $data = $this->results('course-43')->render()->getData();
            $this->assertSame(47, $data['totalCount']);
            $this->assertSame([999999 => 1, 43 => 1, 42 => 45], $data['courseCounts']->all());
            $this->assertSame(['outside'], $data['courseVideos']->getCollection()->pluck('id')->all());
        }
        $orphan = $this->results('course-999999')->render()->getData()['courseVideos'];
        $this->assertSame(['unassociated'], $orphan->getCollection()->pluck('id')->all());
    }

    public function test_livewire_filters_and_layout_preserve_tutorial_scope(): void
    {
        DB::table('tags')->insert(['id' => 1, 'name' => 'Topic']);
        DB::table('video_tags')->insert(['video_id' => '45', 'tag_id' => 1]);
        Livewire::test(NextIlearnPresentations::class)
            ->assertSee('NextIlearn Tutorials')
            ->assertSee('45 presentations')
            ->assertDontSee('Edit selected')
            ->call('toggleCourse', 'course-42')
            ->assertSee('A presentation')
            ->set('switchOn', true)
            ->assertSee('library-recordings-grid')
            ->call('setPage', 3, 'presentationsPage')
            ->assertSet('paginators.presentationsPage', 3)
            ->set('selectedTags', ['Topic'])
            ->assertSet('paginators.presentationsPage', 1)
            ->assertSee('1 presentation')
            ->call('handleRecompute', 'tag')
            ->assertSee('45 presentations')
            ->set('selectedCourses', ['nocourse'])
            ->assertSee('0 presentations')
            ->call('clearFilters')
            ->assertSee('45 presentations');
    }
}
