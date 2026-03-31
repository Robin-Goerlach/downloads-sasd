<?php

declare(strict_types=1);

namespace App\Http;

/**
 * Very small router with placeholder support.
 *
 * Supported route syntax example:
 *   /products/{slug}
 */
final class Router
{
    /**
     * @var array<int, array{method: string, path: string, handler: callable}>
     */
    private array $routes = [];

    public function get(string $path, callable $handler): void
    {
        $this->routes[] = [
            'method' => 'GET',
            'path' => $path,
            'handler' => $handler,
        ];
    }

    public function dispatch(Request $request): Response
    {
        foreach ($this->routes as $route) {
            if ($route['method'] !== $request->method()) {
                continue;
            }

            $parameters = $this->match($route['path'], $request->path());

            if ($parameters === null) {
                continue;
            }

            /** @var callable $handler */
            $handler = $route['handler'];

            return $handler($request, ...array_values($parameters));
        }

        return Response::html('<h1>404 - Not Found</h1>', 404);
    }

    /**
     * @return array<string, string>|null
     */
    private function match(string $routePath, string $requestPath): ?array
    {
        $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $routePath);
        $pattern = '#^' . $pattern . '$#';

        if ($pattern === null) {
            return null;
        }

        if (!preg_match($pattern, $requestPath, $matches)) {
            return null;
        }

        $parameters = [];

        foreach ($matches as $key => $value) {
            if (!is_string($key)) {
                continue;
            }

            $parameters[$key] = urldecode($value);
        }

        return $parameters;
    }
}
