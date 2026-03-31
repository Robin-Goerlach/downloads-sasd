<?php

declare(strict_types=1);

namespace App\Service\Localization;

use App\Http\Request;

/**
 * Resolves the active locale from query parameters, cookies, and browser
 * headers.
 */
final class LocaleResolver
{
    /**
     * @param list<string> $enabledLocales
     */
    public function __construct(
        private readonly array $enabledLocales,
        private readonly string $defaultLocale
    ) {
    }

    public function resolve(Request $request): string
    {
        $queryLocale = $this->sanitizeLocale((string) $request->query('lang', ''));

        if ($queryLocale !== null) {
            $this->persistLocale($queryLocale);

            return $queryLocale;
        }

        $cookieLocale = $this->sanitizeLocale((string) $request->cookie('sasd_locale', ''));

        if ($cookieLocale !== null) {
            return $cookieLocale;
        }

        $acceptLanguage = (string) $request->server('HTTP_ACCEPT_LANGUAGE', '');
        $detectedLocale = $this->detectFromAcceptLanguage($acceptLanguage);

        return $detectedLocale ?? $this->defaultLocale;
    }

    private function persistLocale(string $locale): void
    {
        if (PHP_SAPI === 'cli') {
            return;
        }

        setcookie('sasd_locale', $locale, [
            'expires' => time() + 365 * 24 * 60 * 60,
            'path' => '/',
            'secure' => false,
            'httponly' => false,
            'samesite' => 'Lax',
        ]);
    }

    private function sanitizeLocale(string $locale): ?string
    {
        $locale = trim($locale);

        if ($locale === '') {
            return null;
        }

        if (in_array($locale, $this->enabledLocales, true)) {
            return $locale;
        }

        return null;
    }

    private function detectFromAcceptLanguage(string $acceptLanguage): ?string
    {
        if ($acceptLanguage === '') {
            return null;
        }

        $parts = explode(',', $acceptLanguage);

        foreach ($parts as $part) {
            $locale = strtolower(trim(explode(';', $part)[0]));
            $short = substr($locale, 0, 2);

            if (in_array($short, $this->enabledLocales, true)) {
                return $short;
            }

            if (in_array($locale, $this->enabledLocales, true)) {
                return $locale;
            }
        }

        return null;
    }
}
