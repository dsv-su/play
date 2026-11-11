<?php

namespace Tests\Feature;

use App\Livewire\My\UserPresentations;
use Tests\TestCase;

class UserPresentationsPaginationTest extends TestCase
{
    private function makeUserPresentations(?string $open, int $page = 1): UserPresentations
    {
        $component = new UserPresentations;
        $component->videos = collect([
            42 => collect(range(1, 45)),
            'nocourse' => collect(range(101, 125)),
        ]);
        $component->activeAccordion = $open;
        $component->paginators = ['presentationsPage' => $page];

        return $component;
    }

    public function test_closed_and_unknown_courses_render_no_presentations(): void
    {
        foreach ([null, 'course-unknown', 'invalid'] as $open) {
            $paginator = $this->makeUserPresentations($open)->render()->getData()['courseVideos'];
            $this->assertSame(0, $paginator->total());
            $this->assertCount(0, $paginator->items());
        }
    }

    public function test_only_one_page_from_the_open_course_is_rendered(): void
    {
        $component = $this->makeUserPresentations('course-42', 2);
        $paginator = $component->render()->getData()['courseVideos'];

        $this->assertSame(45, $paginator->total());
        $this->assertSame(range(21, 40), $paginator->items());
        $this->assertCount(45, $component->videos->get(42));
    }

    public function test_courses_without_an_id_can_be_paginated(): void
    {
        $paginator = $this->makeUserPresentations('course-nocourse', 2)->render()->getData()['courseVideos'];

        $this->assertSame(25, $paginator->total());
        $this->assertSame(range(121, 125), $paginator->items());
    }

    public function test_out_of_range_pages_are_clamped(): void
    {
        $paginator = $this->makeUserPresentations('course-42', 99)->render()->getData()['courseVideos'];

        $this->assertSame(3, $paginator->currentPage());
        $this->assertSame(range(41, 45), $paginator->items());
    }
    public function test_changing_courses_resets_pagination_and_invalid_courses_are_ignored(): void
    {
        $component = $this->makeUserPresentations('course-42', 2);
        $component->toggleCourse('course-nocourse');
        $this->assertSame('course-nocourse', $component->activeAccordion);
        $this->assertSame(1, $component->paginators['presentationsPage']);

        $component->toggleCourse('course-unknown');
        $this->assertSame('course-nocourse', $component->activeAccordion);
        $component->toggleCourse('course-nocourse');
        $this->assertNull($component->activeAccordion);
    }

    public function test_clearing_filters_restores_the_full_library_and_first_page(): void
    {
        $component = $this->makeUserPresentations('course-42', 2);
        $component->allVideos = collect();
        $component->selectedCourses = ['example'];
        $component->selectedPresenters = ['someone'];
        $component->selectedSemesters = ['HT2026'];
        $component->selectedTags = ['example'];
        $component->clearFilters();

        $this->assertSame([], $component->selectedCourses);
        $this->assertSame([], $component->selectedPresenters);
        $this->assertSame([], $component->selectedSemesters);
        $this->assertSame([], $component->selectedTags);
        $this->assertTrue($component->videos->isEmpty());
        $this->assertSame(1, $component->paginators['presentationsPage']);
    }
}
