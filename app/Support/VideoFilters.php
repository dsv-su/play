<?php

declare(strict_types=1);

namespace App\Support;

use Livewire\Wireable;

final class VideoFilters implements Wireable
{
    /** @var array<string, array<int|string>> */
    public array $selected = [
        'courses'    => [],
        'presenters' => [],
        'semesters'  => [],
        'tags'       => [],
    ];

    public static function from(array $payload = []): self
    {
        $self = new self;

        // Accept BOTH shapes:
        // - ['selected' => ['courses'=>[], ...]]
        // - ['courses'=>[], 'presenters'=>[], ...]
        $data = $payload['selected'] ?? $payload;

        foreach (array_keys($self->selected) as $key) {
            $vals = $data[$key] ?? [];
            // normalize: drop null/'' and reindex
            $self->selected[$key] = array_values(
                array_filter($vals, static fn($v) => $v !== null && $v !== '')
            );
        }
        return $self;
    }

    // Livewire (de)hydration
    public function toLivewire(): array
    {
        // Keep the existing public shape: ['selected' => [...]]
        return ['selected' => $this->selected];
    }

    public static function fromLivewire($value): self
    {
        // $value is whatever toLivewire() returned on the previous request
        // (or a mutated version after a user interaction)
        return self::from(is_array($value) ? $value : []);
    }

    /** Convert to service's expected structure */
    public function toSearchArray(): array
    {
        return [
            'course'    => $this->selected['courses']     ?: null,
            'presenter' => $this->selected['presenters'] ?: null,
            'semester'  => $this->selected['semesters']  ?: null,
            'tag'       => $this->selected['tags']       ?: null,
        ];
    }
}

