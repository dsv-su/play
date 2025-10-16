<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\File;

class AuthHandler
{
    /**
     * Load all .ini configs from systemconfig/, preferring play.ini over play.ini.example.
     *
     * @return array<string, array<string, mixed>>  e.g. ['auth' => ['driver' => '...']]
     */
    public function authorize(?string $dir = null): array
    {
        $dir = $dir ?? base_path('systemconfig');

        if (!is_dir($dir)) {
            //
            return [];
        }

        // Collect base names present as .ini or .ini.example
        $iniPaths       = glob($dir . DIRECTORY_SEPARATOR . '*.ini') ?: [];
        $examplePaths   = glob($dir . DIRECTORY_SEPARATOR . '*.ini.example') ?: [];

        $byBase: array = [];

        //  play.ini.example
        foreach ($examplePaths as $path) {
            $base = basename($path, '.ini.example');
            $byBase[$base] = ['example' => $path];
        }

        // play.ini if present
        foreach ($iniPaths as $path) {
            $base = basename($path, '.ini');
            $byBase[$base]['real'] = $path;
        }

        $result = [];

        foreach ($byBase as $base => $paths) {
            $chosen = $paths['real'] ?? $paths['example'] ?? null;
            if (!$chosen || !is_readable($chosen)) {
                continue;
            }

            $parsed = @parse_ini_file($chosen, true, INI_SCANNER_TYPED);
            if ($parsed === false) {
                // Skip bad INI
                continue;
            }

            $result[$base] = $parsed; // array sections → nested arrays
        }

        return $result;
    }
}
