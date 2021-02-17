<?php

namespace App\Services\Ldap;

use LdapRecord\Models\Model;

class SukatUser extends Model
{
    protected function convertAttributesForJson(array $attributes = [])
    {
        if ($this->hasAttribute('objectguid')) {
            // If the model has a GUID set, we need to convert it due to it being in
            // binary. Otherwise we will receive a JSON serialization exception.
            return array_replace($attributes, [
                'objectguid' => [$this->getConvertedGuid()]
            ]);
        }

        return $attributes;
    }
}
