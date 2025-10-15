<?php

namespace App\Livewire\Edit;

use App\Models\Video;
use App\Services\Ldap\SukatUser;
use App\Services\Directory\SearchPresenters;
use Livewire\Component;

class EditPresenters extends Component
{
    /** Core state */
    public ?Video $video = null;
    public array $presenters = [];
    public string $searchPresenter = '';
    /** @var array<int, array{uid:int|string, name:string, role:string, local:bool}> */
    public array $sukatUsers = [];
    public int $highlighted = 0;

    public function boot(SearchPresenters $search)
    {
        $this->searchService = $search;
    }

    public function mount($video = null): void
    {
        if ($video) {
            // Edit mode: ensure video is available
            $this->video = $video->loadMissing(['presenters']);

        }
        $this->getPresenters();
        if ($this->searchPresenter !== '') {
            $this->sukatUsers = $this->searchService->execute($this->searchPresenter);
        }
    }

    public function moveHighlight(int $direction): void
    {
        $count = count($this->sukatUsers);
        if ($count === 0) return;

        $this->highlighted = ($this->highlighted + $direction + $count) % $count;
    }

    public function addHighlighted(): void
    {
        if (isset($this->sukatUsers[$this->highlighted])) {
            $user = $this->sukatUsers[$this->highlighted];
            $this->addPresenter($user->uid, $user->name);
        }
    }

    public function updatedSearchPresenter(): void
    {
        $this->sukatUsers = $this->searchService->execute($this->searchPresenter);
    }

    public function getPresenters(): void
    {
        // If no video, there are no presenters to load from DB
        $presenters = $this->video?->exists
            ? $this->video->presenters
            : [];

        $uids = collect($presenters)->pluck('username')->filter()->unique()->values();

        $rolesByUid = [];

        if ($uids->isNotEmpty()) {
            // (|(uid=u1)(uid=u2)...)
            $clauses = $uids
                ->map(fn($u) => '(uid=' . $this->searchService->esc($u) . ')')
                ->implode('');
            $filter = '(|' . $clauses . ')';

            $ldapUsers = SukatUser::rawFilter($filter)->get();

            foreach ($ldapUsers as $u) {
                $uid  = is_array($u->uid ?? null) ? ($u->uid[0] ?? null) : ($u->uid ?? null);
                if (!$uid) continue;

                $ents = $u->edupersonentitlement ?? [];
                if (!is_array($ents)) $ents = [$ents];

                $role = null;
                if (in_array(SearchPresenters::ENT_STAFF, $ents, true)) {
                    $role = 'DSV';
                } elseif (in_array(SearchPresenters::ENT_STUDENT, $ents, true)) {
                    $role = 'Student';
                }
                $rolesByUid[$uid] = $role;
            }
        }

        $this->presenters = [];
        foreach ($presenters as $p) {
            $this->presenters[] = [
                'uid'  => $p->username,
                'name' => $p->name,
                'type' => $p->description,
                'role' => $rolesByUid[$p->username] ?? null,
            ];
        }
    }

    public function addPresenter($uid, $name)
    {
        $exists = false;
        foreach ($this->presenters as $item) {
            if (($item['uid'] ?? null) === $uid && ($item['name'] ?? '') === $name) {
                $exists = true;
                break;
            }
        }

        if (!$exists) {
            $role = null;
            if ($uid) {
                $su   = SukatUser::where('uid', $uid)->first(['edupersonentitlement']);
                $ents = $su?->edupersonentitlement ?? [];
                $role = in_array(SearchPresenters::ENT_STAFF, $ents, true) ? 'DSV'
                    : (in_array(SearchPresenters::ENT_STUDENT, $ents, true) ? 'Student' : null);
            }

            $this->presenters[] = ['uid' => $uid, 'name' => $name, 'type' => $uid ? 'sukat' : 'external', 'role' => $role];
            $this->searchPresenter = '';
        }

    }

    public function remove_presenter($index)
    {
        array_splice($this->presenters, $index, 1);
    }

    public function render()
    {
        return view('livewire.edit.edit-presenters', [
            'searchPresenter' => $this->searchPresenter,
        ]);
    }
}
