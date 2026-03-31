<?php

declare(strict_types=1);

namespace App\View;

use App\Http\Request;
use App\Service\Localization\Translator;
use DateTimeInterface;

/**
 * Tiny view renderer with template helpers.
 */
final class View
{
    /**
     * @param array<string, mixed> $config
     */
    public function __construct(
        private readonly array $config,
        private readonly Request $request,
        private readonly Translator $translator,
        private readonly string $locale
    ) {
    }

    /**
     * @param array<string, mixed> $params
     */
    public function render(string $template, array $params = []): string
    {
        $view = $this;
        $templatePath = $this->templatePath($template);

        if (!is_file($templatePath)) {
            throw new \RuntimeException('Template not found: ' . $templatePath);
        }

        extract($params, EXTR_SKIP);

        ob_start();
        require $templatePath;
        $content = (string) ob_get_clean();

        $layoutPath = $this->templatePath('layouts/base');

        ob_start();
        require $layoutPath;

        return (string) ob_get_clean();
    }

    public function escape(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * @param array<string, string> $replacements
     */
    public function trans(string $key, array $replacements = []): string
    {
        return $this->translator->trans($key, $replacements);
    }

    public function locale(): string
    {
        return $this->locale;
    }

    /**
     * @return list<string>
     */
    public function enabledLocales(): array
    {
        return $this->config['enabled_locales'];
    }

    public function currentPath(): string
    {
        return $this->request->path();
    }

    /**
     * @param array<string, mixed> $query
     */
    public function url(string $path, array $query = []): string
    {
        $query = array_filter(
            ['lang' => $this->locale] + $query,
            static fn (mixed $value): bool => $value !== ''
        );

        $separator = $query === [] ? '' : '?' . http_build_query($query);

        return $path . $separator;
    }

    public function asset(string $path): string
    {
        return '/assets/' . ltrim($path, '/');
    }

    public function formatDate(DateTimeInterface $date): string
    {
        if (class_exists(\IntlDateFormatter::class)) {
            $formatter = new \IntlDateFormatter(
                $this->locale === 'de' ? 'de_DE' : 'en_US',
                \IntlDateFormatter::MEDIUM,
                \IntlDateFormatter::NONE
            );

            if ($formatter !== false) {
                $formatted = $formatter->format($date);

                if (is_string($formatted)) {
                    return $formatted;
                }
            }
        }

        return $this->locale === 'de'
            ? $date->format('d.m.Y')
            : $date->format('M d, Y');
    }

    public function formatBytes(int $bytes): string
    {
        if ($bytes < 1024) {
            return $bytes . ' B';
        }

        $units = ['KB', 'MB', 'GB', 'TB'];
        $value = $bytes / 1024;
        $unitIndex = 0;

        while ($value >= 1024 && $unitIndex < count($units) - 1) {
            $value /= 1024;
            $unitIndex++;
        }

        return number_format($value, 1, $this->locale === 'de' ? ',' : '.', '') . ' ' . $units[$unitIndex];
    }

    public function label(string $category, string $value): string
    {
        $key = 'labels.' . $category . '.' . $value;
        $translated = $this->trans($key);

        return $translated === $key ? $value : $translated;
    }

    /**
     * @param array<string, mixed> $query
     */
    public function currentUrlWith(array $query): string
    {
        $merged = $this->request->allQuery();

        foreach ($query as $key => $value) {
            if ($value === null || $value === '') {
                unset($merged[$key]);
                continue;
            }

            $merged[$key] = $value;
        }

        $merged['lang'] = $this->locale;

        return $this->currentPath() . '?' . http_build_query($merged);
    }

    private function templatePath(string $template): string
    {
        return $this->config['paths']['view_path'] . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $template) . '.php';
    }
}
