<?php

namespace App\Services\Directory;

use App\Models\Presenter;
use App\Services\Ldap\SukatUser;
use Illuminate\Support\Str;
use stdClass;

class SearchPresenters
{
    public const ENT_STAFF   = 'urn:mace:swami.se:gmai:dsv-user:staff';
    public const ENT_STUDENT = 'urn:mace:swami.se:gmai:dsv-user:student';

    public function __construct(
        //LDAP/local lookups, etc.
    ) {}

    /** Escape for LDAP filter */
    public function esc(string $value): string
    {
        if (function_exists('ldap_escape')) {
            return ldap_escape($value, '', LDAP_ESCAPE_FILTER);
        }
        return strtr($value, ['\\'=>'\5c','*'=>'\2a','('=>'\28',')'=>'\29',"\0"=>'\00']);
    }

    public function execute(string $query, int $limit = 10, bool $external = true): array
    {
        $q = trim($query);

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
        if($external) {
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
        }


        return $users->take($limit)->values()->all();
    }
}
