<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Entity\Product;

/**
 * Product repository abstraction.
 *
 * The future database migration should primarily replace the implementation,
 * not the rest of the application.
 */
interface ProductRepositoryInterface
{
    /**
     * @return list<Product>
     */
    public function findAll(): array;

    public function findBySlug(string $slug): ?Product;
}
