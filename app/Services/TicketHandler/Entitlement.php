<?php

namespace App\Services\TicketHandler;

use App\Permission;                // adjust to App\Models\Permission if needed
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

        // Get the configured server var / header name (e.g. "HTTP_ENTITLEMENTS")
        $system = app(AuthHandler::class)->authorize();
        $param  = data_get($system, 'global.authorization_parameter');
        if (!$param) {
            return false;
        }

        // Required entitlements for this permission id
        $requiredStr = (string) (Permission::whereKey($id)->value('entitlement') ?? '');
        if ($requiredStr === '') {
            // No entitlements configured for this permission → deny (adjust if you prefer allow)
            return false;
        }
        $required = $this->splitEntitlements($requiredStr);

        // Entitlements from request
        $rawHeader = (string) ($_SERVER[$param] ?? '');
        if ($rawHeader === '') {
            return false;
        }
        $provided = $this->splitEntitlements($rawHeader);

        // Case-insensitive intersection
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

