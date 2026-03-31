<?php

declare(strict_types=1);

namespace App;

use App\Http\Controller\ArtifactController;
use App\Http\Controller\HomeController;
use App\Http\Controller\ProductController;
use App\Http\Request;
use App\Http\Router;
use App\Infrastructure\Catalog\CatalogLoader;
use App\Repository\JsonArtifactRepository;
use App\Repository\JsonProductRepository;
use App\Service\CatalogService;
use App\Service\Localization\LocaleResolver;
use App\Service\Localization\Translator;
use App\View\View;

/**
 * Application bootstrapper.
 *
 * This class wires the tiny application together without introducing a heavy
 * dependency injection container. The goal is to stay simple today while still
 * keeping the architecture clean enough for later growth.
 */
final class Bootstrap
{
    /**
     * Bootstraps the application and returns a configured router together with
     * the request instance.
     *
     * @param string $basePath Absolute project base path.
     *
     * @return array{router: Router, request: Request}
     */
    public static function boot(string $basePath): array
    {
        self::registerAutoloader($basePath);

        /** @var array<string, mixed> $config */
        $config = require $basePath . '/config/app.php';
        $config = self::resolvePaths($config, $basePath);

        // Development defaults can later be moved into environment-specific
        // configuration, but for now this is practical and explicit.
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        $request = Request::fromGlobals();
        $localeResolver = new LocaleResolver(
            $config['enabled_locales'],
            $config['default_locale']
        );
        $locale = $localeResolver->resolve($request);

        $translator = new Translator(
            $config['paths']['lang_path'],
            $locale,
            $config['fallback_locale']
        );

        $catalogLoader = new CatalogLoader(
            $config['paths']['catalog_source_path'],
            $config['paths']['catalog_generated_path'],
            $config['paths']['storage_path']
        );

        $productRepository = new JsonProductRepository($catalogLoader);
        $artifactRepository = new JsonArtifactRepository($catalogLoader);

        $catalogService = new CatalogService(
            $productRepository,
            $artifactRepository,
            $config['fallback_locale']
        );

        $view = new View(
            $config,
            $request,
            $translator,
            $locale
        );

        $homeController = new HomeController($view, $catalogService, $config);
        $productController = new ProductController($view, $catalogService, $config);
        $artifactController = new ArtifactController($view, $catalogService, $config);

        $router = new Router();
        $router->get('/', [$homeController, 'index']);
        $router->get('/products', [$productController, 'index']);
        $router->get('/products/{slug}', [$productController, 'show']);
        $router->get('/artifacts', [$artifactController, 'index']);
        $router->get('/artifacts/{slug}', [$artifactController, 'show']);
        $router->get('/download/{slug}', [$artifactController, 'download']);

        return [
            'router' => $router,
            'request' => $request,
        ];
    }

    /**
     * Registers a tiny PSR-4-like autoloader for the App namespace.
     *
     * Composer is intentionally optional in this starter project, so the
     * application can run immediately on a plain PHP host.
     */
    private static function registerAutoloader(string $basePath): void
    {
        spl_autoload_register(
            static function (string $className) use ($basePath): void {
                $prefix = 'App\\';

                if (!str_starts_with($className, $prefix)) {
                    return;
                }

                $relativeClass = substr($className, strlen($prefix));
                $relativePath = str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';
                $filePath = $basePath . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $relativePath;

                if (is_file($filePath)) {
                    require $filePath;
                }
            }
        );
    }

    /**
     * Resolves configured relative paths to absolute filesystem paths.
     *
     * @param array<string, mixed> $config
     *
     * @return array<string, mixed>
     */
    public static function resolvePaths(array $config, string $basePath): array
    {
        foreach ($config['paths'] as $key => $relativePath) {
            $config['paths'][$key] = $basePath . DIRECTORY_SEPARATOR . $relativePath;
        }

        $config['base_path'] = $basePath;

        return $config;
    }
}
