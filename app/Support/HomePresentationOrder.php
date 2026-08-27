<?php

namespace App\Support;

use App\Models\Channel;

class HomePresentationOrder
{
    public const BUILT_IN = [
        'home.newpresentations',
        'home.mypresentations',
        'home.studypresentations',
        'home.next-ilearn',
    ];

    public static function keys(): array
    {
        return array_merge(
            self::BUILT_IN,
            Channel::query()->where('show_on_homepage', true)->orderBy('id')->get()->map->component_key->all()
        );
    }

    public static function sanitize(mixed $order): array
    {
        $allowed = self::keys();
        $selected = collect(is_array($order) ? $order : [])
            ->filter(fn ($key) => is_string($key) && in_array($key, $allowed, true))
            ->values()->all();

        return array_values(array_unique(array_merge($selected, $allowed)));
    }
}
