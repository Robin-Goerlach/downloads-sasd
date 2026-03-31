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

$errors = $catalogLoader->validateSource();

if ($errors === []) {
    echo "Catalog validation passed.\n";
    exit(0);
}

echo "Catalog validation failed:\n\n";

foreach ($errors as $error) {
    echo '- ' . $error . "\n";
}

exit(1);
