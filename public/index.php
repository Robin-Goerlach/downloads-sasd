<?php

declare(strict_types=1);

use App\Bootstrap;
use App\Http\Response;

require dirname(__DIR__) . '/app/Bootstrap.php';

$boot = Bootstrap::boot(dirname(__DIR__));

try {
    $response = $boot['router']->dispatch($boot['request']);
} catch (Throwable $throwable) {
    $response = Response::html(
        '<h1>500 - Internal Server Error</h1><p>' . htmlspecialchars($throwable->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>',
        500
    );
}

$response->send();
