<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\ManualPresentation;
use App\Services\Notify\PlayStoreNotify;
use PHPUnit\Framework\TestCase;

final class PlayStoreNotifyTest extends TestCase
{
    public function test_edit_payload_contains_empty_thumb_when_regeneration_is_requested(): void
    {
        $presentation = new ManualPresentation([
            'title' => 'Presentation',
            'thumb' => 'existing-thumb.jpg',
        ]);

        $payload = json_decode(
            (new PlayStoreNotify($presentation, renderThumb: true))
                ->sendSuccess(PlayStoreNotify::TYPE_EDIT, dryRun: true),
            true,
            flags: JSON_THROW_ON_ERROR
        );

        self::assertArrayHasKey('thumb', $payload);
        self::assertSame('', $payload['thumb']);
    }

    public function test_edit_payload_omits_empty_thumb_when_regeneration_is_not_requested(): void
    {
        $presentation = new ManualPresentation([
            'title' => 'Presentation',
            'thumb' => '',
        ]);

        $payload = json_decode(
            (new PlayStoreNotify($presentation))
                ->sendSuccess(PlayStoreNotify::TYPE_EDIT, dryRun: true),
            true,
            flags: JSON_THROW_ON_ERROR
        );

        self::assertArrayNotHasKey('thumb', $payload);
    }
}
