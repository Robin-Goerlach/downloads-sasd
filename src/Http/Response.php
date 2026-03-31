<?php

declare(strict_types=1);

namespace App\Http;

/**
 * Minimal HTTP response object.
 *
 * It supports both regular HTML responses and downloadable files.
 */
final class Response
{
    /**
     * @param array<string, string> $headers
     */
    public function __construct(
        private readonly string $content = '',
        private readonly int $statusCode = 200,
        private readonly array $headers = [],
        private readonly ?string $filePath = null
    ) {
    }

    /**
     * Creates an HTML response.
     *
     * @param array<string, string> $headers
     */
    public static function html(string $content, int $statusCode = 200, array $headers = []): self
    {
        $headers = ['Content-Type' => 'text/html; charset=UTF-8'] + $headers;

        return new self($content, $statusCode, $headers);
    }

    /**
     * Creates a binary file download response.
     *
     * @param array<string, string> $headers
     */
    public static function download(string $filePath, string $downloadName, array $headers = []): self
    {
        $defaultHeaders = [
            'Content-Type' => (string) (mime_content_type($filePath) ?: 'application/octet-stream'),
            'Content-Disposition' => 'attachment; filename="' . $downloadName . '"',
            'Content-Length' => (string) filesize($filePath),
            'Cache-Control' => 'private, must-revalidate',
            'Pragma' => 'public',
        ];

        return new self('', 200, $defaultHeaders + $headers, $filePath);
    }

    /**
     * Sends the response to the client.
     */
    public function send(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $headerName => $headerValue) {
            header($headerName . ': ' . $headerValue);
        }

        if ($this->filePath !== null) {
            readfile($this->filePath);

            return;
        }

        echo $this->content;
    }
}
