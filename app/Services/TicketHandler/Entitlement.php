<?php

namespace App\Services\TicketHandler;

use App\Models\Permission;
use App\Services\AuthHandler;

class Entitlement
{
    /**
     * Validate that the current request has at least one entitlement required by the permission $id.
     * - Allow on local env or when $id === 4.
     * - Read the header key from AuthHandler()->authorize()->global.authorization_parameter.
     * - Compare semicolon-separated lists (case-insensitive, trimmed).
     */
    public function __construct(private AuthHandler $auth) {}

    public function validate(int $id, array $provided): bool
    {
        // 1. Bypass in local env or for permission id 4
        if (app()->environment('local') || $id === 4) {
            return true;
        }

        // 2. Get the configured server authorization parameter from AuthHandler
        $system    = $this->auth->authorize();
        $paramName = data_get($system, 'global.authorization_parameter');
        if (!$paramName) {
            return false; // nothing configured → deny
        }

        // 3. If no entitlements were passed explicitly,
        //    try to read them from the server variable
        //if (empty($provided) && $id === 1) {
        if (empty($provided)) {
            $raw = $_SERVER[$paramName] ?? null;
            if (!$raw) {
                return false; // header/var not present → deny
            }

            $provided = $this->splitEntitlements($raw);
        }

        // 4. Load required entitlements for this permission id
        $requiredStr = (string) (Permission::whereKey($id)->value('entitlement') ?? '');
        if ($requiredStr === '') {
            // No entitlements configured for this permission → deny (or change to allow if you prefer)
            return false;
        }
        $required = $this->splitEntitlements($requiredStr);

        // 5. Case-insensitive intersection between required and provided entitlements
        $requiredLower = array_map('mb_strtolower', $required);
        $providedLower = array_map('mb_strtolower', $provided);

        return !empty(array_intersect($requiredLower, $providedLower));
    }


    private function splitEntitlements(string $value): array
    {
        // "a;b ; c " -> ["a", "b", "c"]
        return array_values(
            array_filter(
                array_map('trim', explode(';', $value)),
                static fn ($v) => $v !== ''
            )
        );
    }
}

