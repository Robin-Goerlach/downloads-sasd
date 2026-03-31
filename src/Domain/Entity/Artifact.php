<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use DateTimeImmutable;

/**
 * Artifact entity.
 *
 * An artifact can be a software package, handbook, training document,
 * companion file, or any other downloadable unit.
 */
final class Artifact
{
    /**
     * @param array<string, string> $title
     * @param array<string, string> $description
     * @param list<string> $tags
     */
    public function __construct(
        private readonly string $id,
        private readonly string $slug,
        private readonly ?string $productSlug,
        private readonly string $group,
        private readonly string $type,
        private readonly array $title,
        private readonly array $description,
        private readonly string $version,
        private readonly string $language,
        private readonly string $platform,
        private readonly string $status,
        private readonly DateTimeImmutable $releaseDate,
        private readonly string $relativePath,
        private readonly string $absolutePath,
        private readonly string $fileName,
        private readonly int $fileSize,
        private readonly string $checksumSha256,
        private readonly bool $featured,
        private readonly bool $popular,
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

    public function productSlug(): ?string
    {
        return $this->productSlug;
    }

    public function group(): string
    {
        return $this->group;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function version(): string
    {
        return $this->version;
    }

    public function language(): string
    {
        return $this->language;
    }

    public function platform(): string
    {
        return $this->platform;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function releaseDate(): DateTimeImmutable
    {
        return $this->releaseDate;
    }

    public function relativePath(): string
    {
        return $this->relativePath;
    }

    public function absolutePath(): string
    {
        return $this->absolutePath;
    }

    public function fileName(): string
    {
        return $this->fileName;
    }

    public function fileSize(): int
    {
        return $this->fileSize;
    }

    public function checksumSha256(): string
    {
        return $this->checksumSha256;
    }

    public function featured(): bool
    {
        return $this->featured;
    }

    public function popular(): bool
    {
        return $this->popular;
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
