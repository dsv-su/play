<?php

namespace App\Data\Directory;

use Livewire\Wireable;

final class UserSuggestion implements Wireable
{
    public function __construct(
        public int|string $uid,
        public string $name,
        public string $role,
        public bool $local,
    ) {}

    public function toLivewire(): array
    {
        return [
            'uid'   => $this->uid,
            'name'  => $this->name,
            'role'  => $this->role,
            'local' => $this->local,
        ];
    }

    public static function fromLivewire($value): self
    {
        return new self(
            $value['uid'],
            $value['name'],
            $value['role'],
            $value['local'],
        );
    }
}

