<?php

namespace App\Livewire\Edit;

use App\Models\Presenter;
use App\Models\Video;
use App\Services\Ldap\SukatUser;
use Illuminate\Support\Str;
use Livewire\Component;
use stdClass;

class EditPresenters extends Component
{
    /** Entitlement URNs */
    private const ENT_STAFF   = 'urn:mace:swami.se:gmai:dsv-user:staff';
    private const ENT_STUDENT = 'urn:mace:swami.se:gmai:dsv-user:student';

    /** Core state */
    public Video $video;
    public array $presenters = [];
    public string $searchPresenter = '';
    public array $sukatUsers = [];
    public int $highlighted = 0;

    public function mount(Video $video): void
    {
        $this->video = $video->loadMissing(['presenters']);
        $this->getPresenters();

        if ($this->searchPresenter !== '') {
            $this->sukatUsers = $this->search();
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
        $this->sukatUsers = $this->search();
    }

    /** Escape for LDAP filter */
    private function esc(string $value): string
    {
        if (function_exists('ldap_escape')) {
            return ldap_escape($value, '', LDAP_ESCAPE_FILTER);
        }
        // Minimal fallback
        return strtr($value, [
            '\\' => '\5c',
            '*'  => '\2a',
            '('  => '\28',
            ')'  => '\29',
            "\0" => '\00',
        ]);
    }

    protected function search(): array
    {
        $q = trim($this->searchPresenter);

        // Clear on empty input
        if ($q === '') {
            return [];
        }

        // Split on whitespace, normalize
        $searchTerms = collect(preg_split('/\s+/', $q))
            ->filter() // remove empties
            ->map(fn ($t) => trim($t))
            ->unique()
            ->values();

        if ($searchTerms->isEmpty()) {
            return [];
        }

        // Build LDAP filter: (& (|(givenName=t*)(sn=t*)) (|(givenName=t2*)(sn=t2*)) ...)
        $filterParts = $searchTerms->map(function ($term) {
            $safe = $this->esc($term);
            return "(|(givenName={$safe}*)(sn={$safe}*))";
        });

        $ldapFilter = '(&' . $filterParts->implode('') . ')';

        // Single LDAP fetch
        $sukatUsers = SukatUser::rawFilter($ldapFilter)->get();

        // Map to role from entitlements
        $users = collect($sukatUsers)
            ->filter(fn ($su) => !empty($su->uid[0] ?? null)) // must have uid
            ->map(function ($su) {
                $entitlements = collect($su->edupersonentitlement ?? []);
                $role = 'Other';
                if ($entitlements->contains(fn ($e) => Str::contains($e, self::ENT_STAFF))) {
                    $role = 'DSV';
                } elseif ($entitlements->contains(fn ($e) => Str::contains($e, self::ENT_STUDENT))) {
                    $role = 'Student';
                }

                $user           = new stdClass();
                $user->uid      = $su->uid[0] ?? null;
                $user->name     = $su->displayName[0] ?? ($su->cn[0] ?? $user->uid);
                $user->role     = $role;
                $user->local    = false;

                return $user;
            })
            ->unique('uid') // avoid dupes if directory returns overlapping entries
            ->values();

        // Add local external presenters that match ALL terms
        $presentersQuery = Presenter::query()
            ->where('description', 'external')
            ->where(function ($qBuilder) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $qBuilder->where('name', 'LIKE', '%' . $term . '%');
                }
            });

        $presenters = $presentersQuery->get()->map(function ($local) {
            $user        = new stdClass();
            $user->uid   = 0;
            $user->local = true;
            $user->name  = $local->name;
            $user->role  = 'External';
            return $user;
        });

        // Prepend presenters
        $users = $presenters->concat($users);

        // Prepend “New external” if exact (case-insensitive) match not found
        $hasExactName = $users->contains(function ($item) use ($q) {
            return isset($item->name) && Str::lower($item->name) === Str::lower($q);
        });

        if (!$hasExactName) {
            $input        = new stdClass();
            $input->uid   = 0;
            $input->local = true;
            $input->name = ucwords(Str::lower($q));
            $input->role  = 'External';
            $users = collect([$input])->concat($users);
        }

        // Return top 20
        return $users->take(20)->values()->all();
    }

    public function getPresenters(): void
    {
        $presenters = $this->video->presenters;

        $uids = collect($presenters)->pluck('username')->filter()->unique()->values();

        $rolesByUid = [];

        if ($uids->isNotEmpty()) {
            // (|(uid=u1)(uid=u2)...)
            $clauses = $uids
                ->map(fn($u) => '(uid=' . $this->esc($u) . ')')
                ->implode('');
            $filter = '(|' . $clauses . ')';

            $ldapUsers = SukatUser::rawFilter($filter)->get();

            foreach ($ldapUsers as $u) {
                $uid  = is_array($u->uid ?? null) ? ($u->uid[0] ?? null) : ($u->uid ?? null);
                if (!$uid) continue;

                $ents = $u->edupersonentitlement ?? [];
                if (!is_array($ents)) $ents = [$ents];

                $role = null;
                if (in_array(self::ENT_STAFF, $ents, true)) {
                    $role = 'DSV';
                } elseif (in_array(self::ENT_STUDENT, $ents, true)) {
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
                $role = in_array(self::ENT_STAFF, $ents, true) ? 'DSV'
                    : (in_array(self::ENT_STUDENT, $ents, true) ? 'Student' : null);
            }

            $this->presenters[] = ['uid' => $uid, 'name' => $name, 'type' => $uid ? 'sukat' : 'external', 'role' => $role];
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
