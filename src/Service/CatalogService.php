<?php

declare(strict_types=1);

namespace App\Service;

use App\Domain\Entity\Artifact;
use App\Domain\Entity\Product;
use App\Repository\ArtifactRepositoryInterface;
use App\Repository\ProductRepositoryInterface;

/**
 * Application service for catalog-related use cases.
 *
 * This layer is the best place for business rules that should survive a later
 * migration from JSON to a relational database.
 */
final class CatalogService
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly ArtifactRepositoryInterface $artifactRepository,
        private readonly string $fallbackLocale
    ) {
    }

    /**
     * @return list<Product>
     */
    public function getAllProducts(): array
    {
        $products = $this->productRepository->findAll();

        usort(
            $products,
            static fn (Product $left, Product $right): int => strcmp($left->slug(), $right->slug())
        );

        return $products;
    }

    public function getProductBySlug(string $slug): ?Product
    {
        return $this->productRepository->findBySlug($slug);
    }

    public function getArtifactBySlug(string $slug): ?Artifact
    {
        return $this->artifactRepository->findBySlug($slug);
    }

    /**
     * @return list<Product>
     */
    public function getFeaturedProducts(int $limit = 3): array
    {
        $products = array_values(
            array_filter(
                $this->productRepository->findAll(),
                static fn (Product $product): bool => $product->featured()
            )
        );

        return array_slice($products, 0, $limit);
    }

    /**
     * @return list<Artifact>
     */
    public function getLatestArtifacts(int $limit = 4): array
    {
        $artifacts = array_values(
            array_filter(
                $this->artifactRepository->findAll(),
                static fn (Artifact $artifact): bool => in_array($artifact->status(), ['current', 'lts', 'deprecated'], true)
            )
        );

        usort(
            $artifacts,
            static fn (Artifact $left, Artifact $right): int => $right->releaseDate() <=> $left->releaseDate()
        );

        return array_slice($artifacts, 0, $limit);
    }

    /**
     * @return list<Artifact>
     */
    public function getPopularArtifacts(int $limit = 4): array
    {
        $artifacts = array_values(
            array_filter(
                $this->artifactRepository->findAll(),
                static fn (Artifact $artifact): bool => $artifact->popular()
            )
        );

        usort(
            $artifacts,
            static fn (Artifact $left, Artifact $right): int => $right->releaseDate() <=> $left->releaseDate()
        );

        return array_slice($artifacts, 0, $limit);
    }

    /**
     * @return list<Artifact>
     */
    public function getArtifactsForProduct(string $productSlug, ?string $excludeArtifactId = null): array
    {
        $artifacts = array_values(
            array_filter(
                $this->artifactRepository->findAll(),
                static fn (Artifact $artifact): bool => $artifact->productSlug() === $productSlug
                    && ($excludeArtifactId === null || $artifact->id() !== $excludeArtifactId)
            )
        );

        usort(
            $artifacts,
            static fn (Artifact $left, Artifact $right): int => $right->releaseDate() <=> $left->releaseDate()
        );

        return $artifacts;
    }

    public function getLatestArtifactForProduct(string $productSlug): ?Artifact
    {
        $artifacts = $this->getArtifactsForProduct($productSlug);

        return $artifacts[0] ?? null;
    }

    /**
     * @param array<string, string> $criteria
     *
     * @return list<Artifact>
     */
    public function searchArtifacts(array $criteria): array
    {
        $q = $this->normalizeForSearch(trim($criteria['q'] ?? ''));
        $group = trim($criteria['group'] ?? '');
        $platform = trim($criteria['platform'] ?? '');
        $type = trim($criteria['type'] ?? '');
        $language = trim($criteria['language'] ?? '');
        $status = trim($criteria['status'] ?? '');

        $artifacts = array_values(
            array_filter(
                $this->artifactRepository->findAll(),
                function (Artifact $artifact) use ($q, $group, $platform, $type, $language, $status): bool {
                    if ($artifact->status() === 'hidden') {
                        return false;
                    }

                    if ($group !== '' && $artifact->group() !== $group) {
                        return false;
                    }

                    if ($platform !== '' && $artifact->platform() !== $platform) {
                        return false;
                    }

                    if ($type !== '' && $artifact->type() !== $type) {
                        return false;
                    }

                    if ($language !== '' && $artifact->language() !== $language) {
                        return false;
                    }

                    if ($status !== '' && $artifact->status() !== $status) {
                        return false;
                    }

                    if ($q === '') {
                        return true;
                    }

                    $haystacks = [
                        $this->normalizeForSearch($artifact->slug()),
                        $this->normalizeForSearch($artifact->version()),
                        $this->normalizeForSearch($artifact->language()),
                        $this->normalizeForSearch($artifact->platform()),
                        $this->normalizeForSearch($artifact->group()),
                        $this->normalizeForSearch($artifact->type()),
                        $this->normalizeForSearch($artifact->getTitle('de', $this->fallbackLocale)),
                        $this->normalizeForSearch($artifact->getTitle('en', $this->fallbackLocale)),
                        $this->normalizeForSearch($artifact->getDescription('de', $this->fallbackLocale)),
                        $this->normalizeForSearch($artifact->getDescription('en', $this->fallbackLocale)),
                        $this->normalizeForSearch(implode(' ', $artifact->tags())),
                    ];

                    foreach ($haystacks as $haystack) {
                        if ($haystack !== '' && str_contains($haystack, $q)) {
                            return true;
                        }
                    }

                    return false;
                }
            )
        );

        usort(
            $artifacts,
            static fn (Artifact $left, Artifact $right): int => $right->releaseDate() <=> $left->releaseDate()
        );

        return $artifacts;
    }

    /**
     * @return array<string, int>
     */
    public function getGroupCounts(): array
    {
        $counts = [];

        foreach ($this->artifactRepository->findAll() as $artifact) {
            if ($artifact->status() === 'hidden') {
                continue;
            }

            $counts[$artifact->group()] = ($counts[$artifact->group()] ?? 0) + 1;
        }

        ksort($counts);

        return $counts;
    }

    /**
     * @return array<string, int>
     */
    public function getPlatformCounts(): array
    {
        $counts = [];

        foreach ($this->artifactRepository->findAll() as $artifact) {
            if ($artifact->status() === 'hidden') {
                continue;
            }

            $counts[$artifact->platform()] = ($counts[$artifact->platform()] ?? 0) + 1;
        }

        ksort($counts);

        return $counts;
    }

    /**
     * @return array<string, int>
     */
    public function getTypeCounts(): array
    {
        $counts = [];

        foreach ($this->artifactRepository->findAll() as $artifact) {
            if ($artifact->status() === 'hidden') {
                continue;
            }

            $counts[$artifact->type()] = ($counts[$artifact->type()] ?? 0) + 1;
        }

        ksort($counts);

        return $counts;
    }

    /**
     * @return list<string>
     */
    public function getAvailableGroups(): array
    {
        $groups = array_keys($this->getGroupCounts());
        sort($groups);

        return $groups;
    }

    /**
     * @return list<string>
     */
    public function getAvailablePlatforms(): array
    {
        $platforms = array_keys($this->getPlatformCounts());
        sort($platforms);

        return $platforms;
    }

    /**
     * @return list<string>
     */
    public function getAvailableTypes(): array
    {
        $types = array_keys($this->getTypeCounts());
        sort($types);

        return $types;
    }

    /**
     * @return list<string>
     */
    public function getAvailableLanguages(): array
    {
        $languages = [];

        foreach ($this->artifactRepository->findAll() as $artifact) {
            $language = trim($artifact->language());

            if ($language === '') {
                continue;
            }

            $languages[$language] = true;
        }

        $result = array_keys($languages);
        sort($result);

        return $result;
    }

    /**
     * Normalizes strings for the lightweight full-text search.
     *
     * mbstring is not guaranteed on minimal shared hosting, therefore the
     * method falls back to strtolower if mb_strtolower is unavailable.
     */
    private function normalizeForSearch(string $value): string
    {
        $value = trim($value);

        if (function_exists('mb_strtolower')) {
            return mb_strtolower($value);
        }

        return strtolower($value);
    }
}
