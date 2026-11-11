<?php

namespace Tests\Feature;

use App\Http\Controllers\SearchResultController;
use App\Livewire\Search\CourseResults;
use App\Models\Video;
use Illuminate\Support\Facades\DB;
use Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException;
use Livewire\Livewire;
use Tests\Concerns\InteractsWithPresentationLibrary;
use Tests\TestCase;

class CourseResultsPaginationTest extends TestCase
{
    use InteractsWithPresentationLibrary;

    private function results(?string $open = null, int $page = 1): CourseResults
    {
        $component = new CourseResults;
        $component->designation = 'ABC';
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
        foreach ([null, 'invalid', 'course-unknown', 'course-43', 'course-999999'] as $open) {
            $data = $this->results($open)->render()->getData();
            $this->assertSame(45, $data['totalCount']);
            $this->assertSame([42 => 45], $data['courseCounts']->all());
            $this->assertCount(0, $data['courseVideos']->items());
        }
        $this->assertSame(0, $retrieved);
        $view = (new SearchResultController)->courses('ABC');
        $this->assertSame(['designation' => 'ABC'], $view->getData());
        $this->assertSame(0, $retrieved);
    }

    public function test_one_database_page_is_hydrated_and_out_of_range_pages_are_clamped(): void
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
        $this->assertArrayNotHasKey('videos', get_object_vars($component));
        $this->assertArrayNotHasKey('allVideos', get_object_vars($component));
        $last = $this->results('course-42', 99)->render()->getData()['courseVideos'];
        $this->assertSame(3, $last->currentPage());
        $this->assertCount(5, $last->items());
    }

    public function test_course_scope_covers_multiple_terms_and_preserves_visibility_overrides(): void
    {
        // A second term of the same designation lies outside My presentations.
        DB::table('courses')->where('id', 43)->update(['designation' => 'ABC']);
        $this->video('outside', 43, 200);
        $this->video('hidden', 43, 201, false);
        $this->video('allowed', 43, 202, false);
        DB::table('individual_permissions')->insert(['video_id' => 'allowed', 'username' => 'alice']);
        // Multi-course recordings remain available under each associated course.
        DB::table('video_courses')->insert(['video_id' => '45', 'course_id' => 43]);
        $data = $this->results('course-43')->render()->getData();
        $this->assertSame(47, $data['totalCount']);
        $this->assertSame([43 => 3, 42 => 45], $data['courseCounts']->all());
        $this->assertSame(['allowed', 'outside', '45'], $data['courseVideos']->getCollection()->pluck('id')->all());
        $component = $this->results('course-42');
        $component->selectedSemesters = ['VT2025'];
        $this->assertSame(3, $component->render()->getData()['totalCount']);
        $component->toggleCourse('course-unknown');
        $this->assertSame('course-42', $component->activeAccordion);
    }

    public function test_livewire_filters_clear_and_layout_switch_preserve_course_scope(): void
    {
        DB::table('tags')->insert(['id' => 1, 'name' => 'Topic']);
        DB::table('video_tags')->insert(['video_id' => '45', 'tag_id' => 1]);
        Livewire::test(CourseResults::class, ['designation' => 'ABC'])
            ->assertSee('Course: ABC')
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
            ->set('selectedCourses', ['DEF'])
            ->assertSee('0 presentations')
            ->call('clearFilters')
            ->assertSet('designation', 'ABC')
            ->assertSee('45 presentations');
    }

    public function test_designation_is_locked_and_unknown_courses_are_empty(): void
    {
        Livewire::test(CourseResults::class, ['designation' => 'Missing'])->assertSee('0 presentations');
        $this->expectException(CannotUpdateLockedPropertyException::class);
        Livewire::test(CourseResults::class, ['designation' => 'ABC'])->set('designation', 'DEF');
    }
}
