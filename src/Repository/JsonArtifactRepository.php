<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Entity\Artifact;
use App\Infrastructure\Catalog\CatalogLoader;
use DateTimeImmutable;

/**
 * JSON-backed artifact repository.
 */
final class JsonArtifactRepository implements ArtifactRepositoryInterface
{
    /**
     * @var list<Artifact>|null
     */
    private ?array $artifacts = null;

    public function __construct(private readonly CatalogLoader $catalogLoader)
    {
    }

    /**
     * @return list<Artifact>
     */
    public function findAll(): array
    {
        return $this->loadArtifacts();
    }

    public function findBySlug(string $slug): ?Artifact
    {
        foreach ($this->loadArtifacts() as $artifact) {
            if ($artifact->slug() === $slug) {
                return $artifact;
            }
        }

        return null;
    }

    /**
     * @return list<Artifact>
     */
    private function loadArtifacts(): array
    {
        if ($this->artifacts !== null) {
            return $this->artifacts;
        }

        $catalog = $this->catalogLoader->loadCatalog();
        $artifacts = [];

        foreach ($catalog['artifacts'] as $entry) {
            $absolutePath = $this->catalogLoader->storagePath() . DIRECTORY_SEPARATOR . ltrim((string) $entry['path'], DIRECTORY_SEPARATOR);
            $fileName = (string) ($entry['fileName'] ?? basename($absolutePath));
            $fileSize = (int) ($entry['fileSize'] ?? (is_file($absolutePath) ? filesize($absolutePath) : 0));
            $checksumSha256 = (string) ($entry['checksumSha256'] ?? (is_file($absolutePath) ? hash_file('sha256', $absolutePath) : ''));

            $artifacts[] = new Artifact(
                (string) $entry['id'],
                (string) $entry['slug'],
                isset($entry['productSlug']) ? (string) $entry['productSlug'] : null,
                (string) $entry['group'],
                (string) $entry['type'],
                (array) $entry['title'],
                (array) $entry['description'],
                (string) ($entry['version'] ?? ''),
                (string) ($entry['language'] ?? ''),
                (string) ($entry['platform'] ?? 'neutral'),
                (string) ($entry['status'] ?? 'current'),
                new DateTimeImmutable((string) $entry['releaseDate']),
                (string) $entry['path'],
                $absolutePath,
                $fileName,
                $fileSize,
                $checksumSha256,
                (bool) ($entry['featured'] ?? false),
                (bool) ($entry['popular'] ?? false),
                array_values((array) ($entry['tags'] ?? []))
            );
        }

        $this->artifacts = $artifacts;

        return $this->artifacts;
    }
}
