<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Entity\Artifact;

/**
 * Artifact repository abstraction.
 */
interface ArtifactRepositoryInterface
{
    /**
     * @return list<Artifact>
     */
    public function findAll(): array;

    public function findBySlug(string $slug): ?Artifact;
}
