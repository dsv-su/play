<?php

namespace Tests\Feature;

use App\Models\Video;
use Tests\TestCase;

class PresentationBadgesTest extends TestCase
{
    private function renderBadges(string $id, ?string $subtitles, bool $hidden = false, bool $unlisted = false): string
    {
        $video = new Video;
        $video->forceFill([
            'id' => $id,
            'subtitles' => $subtitles,
            'permission_type' => 'public',
            'hidden' => $hidden,
            'unlisted' => $unlisted,
        ]);

        return view('home.partials.permission-buttons', ['video' => $video, 'courseId' => 42])->render();
    }

    public function test_cc_has_a_stable_key_independent_of_other_optional_badges(): void
    {
        foreach ([[false, false], [true, false], [false, true]] as [$hidden, $unlisted]) {
            $html = $this->renderBadges('video-one', '{"English":"subtitle/en.vtt"}', $hidden, $unlisted);
            $this->assertStringContainsString('wire:key="badge-subtitle-42-video-one"', $html);
            $this->assertStringContainsString('aria-label="Presentation has subtitles"', $html);
            $this->assertStringContainsString('width="20" height="20"', $html);
        }
    }

    public function test_cc_is_omitted_when_subtitles_are_absent(): void
    {
        foreach ([null, '', 'null', '[]'] as $subtitles) {
            $this->assertStringNotContainsString('data-tooltip-target="subtitle-tooltip"', $this->renderBadges('video-one', $subtitles));
        }
    }

    public function test_badge_keys_are_distinct_between_presentations(): void
    {
        $this->assertStringContainsString('wire:key="badge-subtitle-42-video-two"', $this->renderBadges('video-two', '{"Svenska":"subtitle/sv.vtt"}'));
    }
}
