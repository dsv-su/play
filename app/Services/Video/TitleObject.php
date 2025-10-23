<?php

namespace App\Services\Video;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

/**
 * TitleObject
 *
 * Accepts either:
 *  - a plain string title, or
 *  - a locale map like ['sv' => '...', 'en' => '...'] (array or JSON string).
 *
 * Provides convenient accessors with sensible fallbacks.
 */
final class TitleObject
{
    /** @var array<string, string|null> */
    private array $titles;

    private const DEFAULT_SV = 'Bearbetar';
    private const DEFAULT_EN = 'Processing';

    /**
     * @param string|array<string, mixed>|null $title
     */
    public function __construct($title)
    {
        // Normalize input to an associative array of locales.
        $this->titles = $this->normalizeToLocaleArray($title);
    }

    /**
     * Swedish title if available, otherwise default.
     */
    public function swedish(): string
    {
        $sv = $this->get('sv');

        // If the original input was a plain string, that becomes the sv title.
        return $sv !== '' ? $sv : self::DEFAULT_SV;
    }

    /**
     * English title if available; empty string if not provided in source.
     * (Keeps your original behavior of returning '' when not JSON.)
     */
    public function english(): string
    {
        $en = $this->get('en');

        return $en !== '' ? $en : '';
    }

    /**
     * Title for the current app locale, with fallback chain:
     *  current locale -> English -> Swedish -> defaults
     */
    public function getLangTitle(): string
    {
        $locale = $this->normalizeLocale(App::getLocale());

        // Try exact locale
        $primary = $this->get($locale);
        if ($primary !== '') {
            return $primary;
        }

        // Reasonable fallbacks
        if ($locale !== 'en') {
            $en = $this->get('en');
            if ($en !== '') {
                return $en;
            }
        }

        $sv = $this->get('sv');
        if ($sv !== '') {
            return $sv;
        }

        // Final defaults
        return $locale === 'sv' ? self::DEFAULT_SV : self::DEFAULT_EN;
    }

    /**
     * Allow echoing directly in Blade: {{ $titleObject }}
     */
    public function __toString(): string
    {
        return $this->getLangTitle();
    }

    /**
     * Get a locale value trimmed, or empty string if missing/null.
     */
    private function get(string $locale): string
    {
        $value = $this->titles[$locale] ?? null;
        return is_string($value) ? trim($value) : '';
    }

    /**
     * Normalize various inputs to ['sv' => ?, 'en' => ?].
     *
     * @param mixed $input
     * @return array<string, string|null>
     */
    private function normalizeToLocaleArray($input): array
    {
        // If it's a JSON string, decode to array
        if (is_string($input)) {
            $decoded = json_decode($input, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $input = $decoded;
            } else {
                // Plain string -> treat as Swedish by convention
                return [
                    'sv' => $input,
                    'en' => null,
                ];
            }
        }

        // If it's already an array, try to extract relevant keys.
        if (is_array($input)) {
            // Normalize keys: accept sv_SE, swe, etc.
            $map = $this->extractLocales($input);

            // If neither en nor sv exists, and array looks like a single value, treat as sv.
            if ($map['sv'] === null && $map['en'] === null) {
                $asString = $this->firstStringValue($input);
                return [
                    'sv' => $asString,
                    'en' => null,
                ];
            }

            return $map;
        }

        // Anything else (null, numbers, objects) -> safe defaults
        return [
            'sv' => null,
            'en' => null,
        ];
    }

    /**
     * Extract 'sv' and 'en' considering variants (sv_SE, swe, en_GB, etc.)
     *
     * @param array<string, mixed> $arr
     * @return array{sv: string|null, en: string|null}
     */
    private function extractLocales(array $arr): array
    {
        $normalized = [];
        foreach ($arr as $key => $value) {
            if (!is_string($key)) {
                continue;
            }
            $norm = $this->normalizeLocale($key);
            if (in_array($norm, ['sv', 'en'], true)) {
                $normalized[$norm] = is_string($value) || is_null($value)
                    ? $value
                    : (is_scalar($value) ? (string) $value : null);
            }
        }

        return [
            'sv' => $normalized['sv'] ?? null,
            'en' => $normalized['en'] ?? null,
        ];
    }

    /**
     * Normalize locale keys to 'sv' or 'en' (sv, swe, sv_SE -> sv).
     */
    private function normalizeLocale(string $locale): string
    {
        $l = Str::of($locale)->lower()->toString();

        if (Str::startsWith($l, 'sv') || $l === 'swe' || $l === 'sv_se') {
            return 'sv';
        }

        return 'en'; // default bucket
    }

    /**
     * Find the first string-ish value in an array for graceful fallback.
     *
     * @param array<string, mixed> $arr
     */
    private function firstStringValue(array $arr): ?string
    {
        foreach ($arr as $value) {
            if (is_string($value)) {
                return $value;
            }
            if (is_scalar($value)) {
                return (string) $value;
            }
        }
        return null;
    }
}
