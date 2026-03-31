<?php

declare(strict_types=1);

namespace App\Domain\Entity;

/**
 * Product entity.
 *
 * The localized values are stored as arrays so that the current JSON-based
 * storage can stay simple while still being future-ready for more languages.
 */
final class Product
{
    /**
     * @param array<string, string> $title
     * @param array<string, string> $summary
     * @param array<string, string> $description
     * @param list<string> $tags
     */
    public function __construct(
        private readonly string $id,
        private readonly string $slug,
        private readonly array $title,
        private readonly array $summary,
        private readonly array $description,
        private readonly string $productPageUrl,
        private readonly bool $featured,
        private readonly array $tags = []
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function productPageUrl(): string
    {
        return $this->productPageUrl;
    }

    public function featured(): bool
    {
        return $this->featured;
    }

    /**
     * @return list<string>
     */
    public function tags(): array
    {
        return $this->tags;
    }

    public function getTitle(string $locale, string $fallbackLocale): string
    {
        return $this->localizedValue($this->title, $locale, $fallbackLocale);
    }

    public function getSummary(string $locale, string $fallbackLocale): string
    {
        return $this->localizedValue($this->summary, $locale, $fallbackLocale);
    }

    public function getDescription(string $locale, string $fallbackLocale): string
    {
        return $this->localizedValue($this->description, $locale, $fallbackLocale);
    }

    /**
     * @param array<string, string> $values
     */
    private function localizedValue(array $values, string $locale, string $fallbackLocale): string
    {
        if (isset($values[$locale]) && $values[$locale] !== '') {
            return $values[$locale];
        }

        if (isset($values[$fallbackLocale]) && $values[$fallbackLocale] !== '') {
            return $values[$fallbackLocale];
        }

        if ($values !== []) {
            return (string) reset($values);
        }

        return '';
    }
}
