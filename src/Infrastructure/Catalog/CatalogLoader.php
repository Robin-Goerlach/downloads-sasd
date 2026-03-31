<?php

declare(strict_types=1);

namespace App\Infrastructure\Catalog;

use RuntimeException;

/**
 * Loads catalog data from JSON files.
 *
 * Source files are intended for human editing.
 * A generated catalog file can be created via the CLI rebuild script and is
 * preferred if available.
 */
final class CatalogLoader
{
    public function __construct(
        private readonly string $sourceDirectory,
        private readonly string $generatedCatalogPath,
        private readonly string $storagePath
    ) {
    }

    public function storagePath(): string
    {
        return $this->storagePath;
    }

    /**
     * @return array{products: list<array<string, mixed>>, artifacts: list<array<string, mixed>>}
     */
    public function loadCatalog(): array
    {
        if (is_file($this->generatedCatalogPath)) {
            /** @var array{products: list<array<string, mixed>>, artifacts: list<array<string, mixed>>} $catalog */
            $catalog = $this->readJsonFile($this->generatedCatalogPath);

            return $catalog;
        }

        return [
            'products' => $this->loadSourceProducts(),
            'artifacts' => $this->loadSourceArtifacts(),
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function loadSourceProducts(): array
    {
        return $this->readJsonFile($this->sourceDirectory . DIRECTORY_SEPARATOR . 'products.json');
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function loadSourceArtifacts(): array
    {
        return $this->readJsonFile($this->sourceDirectory . DIRECTORY_SEPARATOR . 'artifacts.json');
    }

    /**
     * @return list<string>
     */
    public function validateSource(): array
    {
        $errors = [];
        $products = $this->loadSourceProducts();
        $artifacts = $this->loadSourceArtifacts();

        foreach ($products as $index => $product) {
            foreach (['id', 'slug', 'title', 'summary', 'description'] as $requiredField) {
                if (!array_key_exists($requiredField, $product)) {
                    $errors[] = sprintf('Product #%d is missing required field "%s".', $index, $requiredField);
                }
            }
        }

        foreach ($artifacts as $index => $artifact) {
            foreach (['id', 'slug', 'group', 'type', 'title', 'description', 'releaseDate', 'path'] as $requiredField) {
                if (!array_key_exists($requiredField, $artifact)) {
                    $errors[] = sprintf('Artifact #%d is missing required field "%s".', $index, $requiredField);
                }
            }

            $absolutePath = $this->storagePath . DIRECTORY_SEPARATOR . ltrim((string) ($artifact['path'] ?? ''), DIRECTORY_SEPARATOR);

            if (!is_file($absolutePath)) {
                $errors[] = sprintf('Artifact "%s" points to a missing file: %s', (string) ($artifact['slug'] ?? '#unknown'), $absolutePath);
            }
        }

        return $errors;
    }

    /**
     * @return array{products: list<array<string, mixed>>, artifacts: list<array<string, mixed>>}
     */
    public function rebuildGeneratedCatalog(): array
    {
        $products = $this->loadSourceProducts();
        $artifacts = $this->loadSourceArtifacts();

        foreach ($artifacts as &$artifact) {
            $absolutePath = $this->storagePath . DIRECTORY_SEPARATOR . ltrim((string) $artifact['path'], DIRECTORY_SEPARATOR);

            if (!is_file($absolutePath)) {
                throw new RuntimeException('Missing artifact file during rebuild: ' . $absolutePath);
            }

            $artifact['fileName'] = basename($absolutePath);
            $artifact['fileSize'] = filesize($absolutePath);
            $artifact['checksumSha256'] = hash_file('sha256', $absolutePath);
        }
        unset($artifact);

        $catalog = [
            'generatedAt' => gmdate(DATE_ATOM),
            'products' => $products,
            'artifacts' => $artifacts,
        ];

        $targetDirectory = dirname($this->generatedCatalogPath);

        if (!is_dir($targetDirectory) && !mkdir($targetDirectory, 0775, true) && !is_dir($targetDirectory)) {
            throw new RuntimeException('Unable to create generated catalog directory: ' . $targetDirectory);
        }

        $encoded = json_encode($catalog, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        if ($encoded === false) {
            throw new RuntimeException('Failed to encode generated catalog JSON.');
        }

        file_put_contents($this->generatedCatalogPath, $encoded);

        return $catalog;
    }

    /**
     * @return array<int|string, mixed>
     */
    private function readJsonFile(string $filePath): array
    {
        if (!is_file($filePath)) {
            throw new RuntimeException('Missing JSON file: ' . $filePath);
        }

        $content = file_get_contents($filePath);

        if ($content === false) {
            throw new RuntimeException('Failed to read JSON file: ' . $filePath);
        }

        /** @var array<int|string, mixed>|null $decoded */
        $decoded = json_decode($content, true);

        if (!is_array($decoded)) {
            throw new RuntimeException('Invalid JSON file: ' . $filePath);
        }

        return $decoded;
    }
}
