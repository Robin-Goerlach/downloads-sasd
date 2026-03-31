<?php

declare(strict_types=1);

use App\Bootstrap;
use App\Http\Response;

/**
 * Root front controller for hosting environments where the document root
 * cannot or should not point directly to /public.
 *
 * This file serves as a compatibility entry point for shared hosting setups
 * such as IONOS subdomains that are configured against the project root.
 *
 * Behaviour:
 * - Public assets and downloadable files are served from /public transparently.
 * - All application requests are bootstrapped through the existing app stack.
 * - Internal project directories remain outside the web root contractually and
 *   are additionally protected via the repository root .htaccess file.
 */

$projectRoot = __DIR__;
$publicRoot = $projectRoot . '/public';
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$requestPath = rawurldecode((string) parse_url($requestUri, PHP_URL_PATH));

// Normalize empty values to the logical root path.
if ($requestPath === '') {
    $requestPath = '/';
}

/**
 * Attempts to serve an existing file from the public directory.
 *
 * This keeps asset URLs stable even when Apache points the subdomain to the
 * repository root instead of the /public directory.
 */
$servePublicFile = static function (string $absoluteFilePath): void {
    if (!is_file($absoluteFilePath) || !is_readable($absoluteFilePath)) {
        return;
    }

    $mimeType = 'application/octet-stream';

    if (function_exists('mime_content_type')) {
        $detected = mime_content_type($absoluteFilePath);
        if (is_string($detected) && $detected !== '') {
            $mimeType = $detected;
        }
    }

    header('Content-Type: ' . $mimeType);
    header('Content-Length: ' . (string) filesize($absoluteFilePath));

    // Encourage browsers and proxies to revalidate static files.
    header('Cache-Control: public, max-age=3600');

    readfile($absoluteFilePath);
    exit;
};

if ($requestPath !== '/') {
    $candidate = $publicRoot . $requestPath;
    $resolvedCandidate = realpath($candidate);
    $resolvedPublicRoot = realpath($publicRoot);

    if (
        $resolvedCandidate !== false
        && $resolvedPublicRoot !== false
        && str_starts_with($resolvedCandidate, $resolvedPublicRoot)
    ) {
        $servePublicFile($resolvedCandidate);
    }
}

require $projectRoot . '/app/Bootstrap.php';

$boot = Bootstrap::boot($projectRoot);

try {
    $response = $boot['router']->dispatch($boot['request']);
} catch (Throwable $throwable) {
    $response = Response::html(
        '<h1>500 - Internal Server Error</h1><p>' . htmlspecialchars($throwable->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>',
        500
    );
}

$response->send();
