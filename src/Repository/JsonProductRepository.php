<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Entity\Product;
use App\Infrastructure\Catalog\CatalogLoader;

/**
 * JSON-backed product repository.
 */
final class JsonProductRepository implements ProductRepositoryInterface
{
    /**
     * @var list<Product>|null
     */
    private ?array $products = null;

    public function __construct(private readonly CatalogLoader $catalogLoader)
    {
    }

    /**
     * @return list<Product>
     */
    public function findAll(): array
    {
        return $this->loadProducts();
    }

    public function findBySlug(string $slug): ?Product
    {
        foreach ($this->loadProducts() as $product) {
            if ($product->slug() === $slug) {
                return $product;
            }
        }

        return null;
    }

    /**
     * @return list<Product>
     */
    private function loadProducts(): array
    {
        if ($this->products !== null) {
            return $this->products;
        }

        $catalog = $this->catalogLoader->loadCatalog();
        $products = [];

        foreach ($catalog['products'] as $entry) {
            $products[] = new Product(
                (string) $entry['id'],
                (string) $entry['slug'],
                (array) $entry['title'],
                (array) $entry['summary'],
                (array) $entry['description'],
                (string) ($entry['productPageUrl'] ?? ''),
                (bool) ($entry['featured'] ?? false),
                array_values((array) ($entry['tags'] ?? []))
            );
        }

        $this->products = $products;

        return $this->products;
    }
}
