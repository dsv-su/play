<?php

namespace App\Services\Ldap;

use LdapRecord\Models\Model;

class SukatUser extends Model
{
    /*protected array $casts = [
        'edupersonentitlement' => 'array',
    ];*/

    protected function convertAttributesForJson(array $attributes = []): array
    {
        // Let the parent handle its own conversions first.
        $attributes = parent::convertAttributesForJson($attributes);

        // LdapRecord normalizes attribute names to lowercase.
        $key = 'objectguid';

        if ($this->hasAttribute($key)) {
            // Only convert if the original value looks binary.
            $original = $this->getOriginalAttribute($key);

            // $original can be string|array|null; check first element if array.
            $raw = is_array($original) ? ($original[0] ?? null) : $original;

            if (is_string($raw) && !ctype_print($raw)) {
                $attributes[$key] = [$this->getConvertedGuid()];
            }
        }

        return $attributes;
    }
}

