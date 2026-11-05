<?php

namespace Tests\Feature;

use App\Livewire\Search\TagResults;
use Tests\TestCase;

class TagResultsPaginationTest extends TestCase
{
    private function makeTagResults(?string $open, int $page = 1): TagResults
    {
        $component = new TagResults;
        $component->videos = collect([
            42 => collect(range(1, 45)),
            'nocourse' => collect(range(101, 125)),
        ]);
        $component->activeAccordion = $open;
        $component->paginators = ['tagPage' => $page];

        return $component;
    }

    public function test_closed_and_unknown_courses_render_no_presentations(): void
    {
        foreach ([null, 'course-unknown', 'invalid'] as $open) {
            $paginator = $this->makeTagResults($open)->render()->getData()['courseVideos'];
            $this->assertSame(0, $paginator->total());
            $this->assertCount(0, $paginator->items());
        }
    }

    public function test_only_one_page_from_the_open_course_is_rendered(): void
    {
        $component = $this->makeTagResults('course-42', 2);
        $paginator = $component->render()->getData()['courseVideos'];

        $this->assertSame(45, $paginator->total());
        $this->assertSame(range(21, 40), $paginator->items());
        $this->assertCount(45, $component->videos->get(42));
    }

    public function test_courses_without_an_id_can_be_paginated(): void
    {
        $paginator = $this->makeTagResults('course-nocourse', 2)->render()->getData()['courseVideos'];

        $this->assertSame(25, $paginator->total());
        $this->assertSame(range(121, 125), $paginator->items());
    }

    public function test_out_of_range_pages_are_clamped(): void
    {
        $paginator = $this->makeTagResults('course-42', 99)->render()->getData()['courseVideos'];

        $this->assertSame(3, $paginator->currentPage());
        $this->assertSame(range(41, 45), $paginator->items());
    }
}
