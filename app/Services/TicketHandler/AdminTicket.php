<?php

namespace App\Services\TicketHandler;

use App\Services\AuthHandler;
use App\Models\Video;

class AdminTicket implements \App\Interfaces\TicketInterface
{
    protected Video $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function cast(): Video
    {
        $system = app(AuthHandler::class)->authorize();

        // Read the server var name configured by AuthHandler
        $paramName = data_get($system, 'global.authorization_parameter');
        if (!$paramName) {
            return $this->video; // nothing to check
        }

        $raw = $_SERVER[$paramName] ?? null;
        if (!$raw) {
            return $this->video; // header/var not present → no ticket
        }

        // Split the semicolon-delimited entitlements and trim them
        $entitlements = array_values(
            array_filter(
                array_map('trim', explode(';', (string) $raw)),
                static fn ($v) => $v !== ''
            )
        );

        $adminEntitlement = $this->adminEntitlement();
        if ($adminEntitlement && in_array($adminEntitlement, $entitlements, true)) {
            $this->video->setAttribute('ticket', true);
        }

        return $this->video;
    }

    private function adminEntitlement(): ?string
    {
        // Cache within this request to avoid re-parsing
        static $cached = null;
        static $loaded = false;

        if ($loaded) {
            return $cached;
        }

        $file = base_path('systemconfig/play.ini');
        if (!is_file($file)) {
            abort(503);
        }

        $config = parse_ini_file($file, true) ?: [];
        $cached = $config['global']['admin'] ?? null;
        $loaded = true;

        return $cached;
    }
}

