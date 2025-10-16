<?php

declare(strict_types=1);

namespace App\Services;

class AuthHandler
{
    /**
     * Load and merge INI configs from systemconfig/.
     * Prefers play.ini over play.ini.example when both exist.
     *
     * Returns a stdClass where INI sections are top-level properties:
     *   $config->global->login_route
     */
    public function authorize(?string $dir = null): object
    {
        $dir = $dir ?? base_path('systemconfig');

        if (!is_dir($dir)) {
            // Return empty object if the directory is missing
            return new \stdClass();
        }

        // Find files
        $sep          = DIRECTORY_SEPARATOR;
        $iniPaths     = glob($dir . $sep . '*.ini') ?: [];
        $examplePaths = glob($dir . $sep . '*.ini.example') ?: [];

        // Group by base filename; prefer real .ini over .ini.example
        $byBase = [];
        //play.ini.example
        foreach ($examplePaths as $path) {
            $base = basename($path, '.ini.example');
            $byBase[$base]['example'] = $path;
        }
        //play.ini
        foreach ($iniPaths as $path) {
            $base = basename($path, '.ini');
            $byBase[$base]['real'] = $path;
        }

        // Merge all chosen INI files (section-wise)
        $merged = [];

        foreach ($byBase as $base => $paths) {
            $chosen = $paths['real'] ?? $paths['example'] ?? null;
            if (!$chosen || !is_readable($chosen)) {
                continue;
            }

            // INI_SCANNER_TYPED converts "true"/"false"/numbers" to native types
            $parsed = @parse_ini_file($chosen, true, INI_SCANNER_TYPED);
            if ($parsed === false || !is_array($parsed)) {
                // Skip invalid INI silently (or log if you prefer)
                continue;
            }

            // Later files override earlier ones (last write wins)
            $merged = array_replace_recursive($merged, $parsed);
        }

        // Convert nested associative arrays into a stdClass tree
        return $this->arrayToObject($merged);
    }

    /**
     * Recursively convert an associative array to stdClass.
     *
     * @param mixed $value
     */
    private function arrayToObject($value)
    {
        if (!is_array($value)) {
            return $value;
        }

        // Distinguish associative vs numeric arrays:
        $isAssoc = static function (array $arr): bool {
            if ($arr === []) {
                return true;
            }
            return array_keys($arr) !== range(0, count($arr) - 1);
        };

        if (!$isAssoc($value)) {
            // Numeric array: convert each element but keep it as an array
            return array_map([$this, __FUNCTION__], $value);
        }

        $obj = new \stdClass();
        foreach ($value as $k => $v) {
            $obj->{$k} = $this->arrayToObject($v);
        }
        return $obj;
    }
}
