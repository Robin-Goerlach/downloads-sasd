<?php

declare(strict_types=1);

namespace App\Http;

/**
 * Very small HTTP request object.
 *
 * It keeps the project readable and testable without introducing a large
 * framework dependency.
 */
final class Request
{
    /**
     * @param array<string, mixed> $query
     * @param array<string, mixed> $post
     * @param array<string, mixed> $cookies
     * @param array<string, mixed> $server
     */
    public function __construct(
        private readonly string $method,
        private readonly string $uri,
        private readonly string $path,
        private readonly array $query,
        private readonly array $post,
        private readonly array $cookies,
        private readonly array $server
    ) {
    }

    /**
     * Creates a request object from PHP superglobals.
     */
    public static function fromGlobals(): self
    {
        $uri = (string) ($_SERVER['REQUEST_URI'] ?? '/');
        $path = (string) parse_url($uri, PHP_URL_PATH);

        return new self(
            strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET')),
            $uri,
            $path ?: '/',
            $_GET,
            $_POST,
            $_COOKIE,
            $_SERVER
        );
    }

    public function method(): string
    {
        return $this->method;
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function path(): string
    {
        return $this->path;
    }

    /**
     * @param mixed $default
     *
     * @return mixed
     */
    public function query(string $key, mixed $default = null): mixed
    {
        return $this->query[$key] ?? $default;
    }

    /**
     * @return array<string, mixed>
     */
    public function allQuery(): array
    {
        return $this->query;
    }

    public function cookie(string $key, ?string $default = null): ?string
    {
        $value = $this->cookies[$key] ?? $default;

        return is_string($value) ? $value : $default;
    }

    public function server(string $key, ?string $default = null): ?string
    {
        $value = $this->server[$key] ?? $default;

        return is_string($value) ? $value : $default;
    }
}
