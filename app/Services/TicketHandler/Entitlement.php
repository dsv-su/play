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
    public function validate(int $id): bool
    {
        if (app()->environment('local') || $id === 4) {
            return true;
        }
        \Log::notice('Entitlement remote (1) ');
        // Get the configured server authorization parameter
        $system = app(AuthHandler::class)->authorize();
        $param  = data_get($system, 'global.authorization_parameter');
        if (!$param) {
            return false;
        }
        \Log::notice('Entitlement remote (2) ');
        // Required entitlements for this permission id
        $requiredStr = (string) (Permission::whereKey($id)->value('entitlement') ?? '');
        if ($requiredStr === '') {
            // No entitlements configured for this permission → deny (adjust if you prefer allow)
            return false;
        }
        $required = $this->splitEntitlements($requiredStr);
        \Log::notice('Entitlement remote (3) ');
        // Entitlements from request
        $rawHeader = (string) ($_SERVER[$param] ?? '');
        if ($rawHeader === '') {
            return false;
        }
        $provided = $this->splitEntitlements($rawHeader);
        \Log::notice('Entitlement remote (4) ');
        // Case-insensitive intersection
        $requiredLower = array_map('mb_strtolower', $required);
        $providedLower = array_map('mb_strtolower', $provided);
        \Log::notice('Entitlement remote (5) ');
        \Log::notice('Entitlement: ', ['value' => !empty(array_intersect($requiredLower, $providedLower))]);
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

