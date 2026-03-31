<?php

declare(strict_types=1);

use App\Bootstrap;
use App\Infrastructure\Catalog\CatalogLoader;

require dirname(__DIR__) . '/app/Bootstrap.php';

Bootstrap::boot(dirname(__DIR__));

/** @var array<string, mixed> $config */
$config = require dirname(__DIR__) . '/config/app.php';
$config = Bootstrap::resolvePaths($config, dirname(__DIR__));

$catalogLoader = new CatalogLoader(
    $config['paths']['catalog_source_path'],
    $config['paths']['catalog_generated_path'],
    $config['paths']['storage_path']
);

$catalog = $catalogLoader->rebuildGeneratedCatalog();

echo "Generated catalog successfully.\n";
echo 'Products: ' . count($catalog['products']) . "\n";
echo 'Artifacts: ' . count($catalog['artifacts']) . "\n";
