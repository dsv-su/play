<?php

namespace App\Services\VideoSearch;

class VideoFilters
{
    public function __construct(
        public readonly ?array $courses = null,     // designations
        public readonly ?array $terms = null,       // semesters
        public readonly ?array $tags = null,
        public readonly ?array $presenters = null,
    ) {}
}
