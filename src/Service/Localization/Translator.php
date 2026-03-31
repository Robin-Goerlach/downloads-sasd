<?php

declare(strict_types=1);

namespace App\Service\Localization;

/**
 * Tiny translation service using PHP array files.
 */
final class Translator
{
    /**
     * @var array<string, mixed>
     */
    private array $messages = [];

    /**
     * @var array<string, mixed>
     */
    private array $fallbackMessages = [];

    public function __construct(
        string $langPath,
        private readonly string $locale,
        private readonly string $fallbackLocale
    ) {
        $this->messages = $this->loadMessages($langPath, $this->locale);
        $this->fallbackMessages = $this->loadMessages($langPath, $this->fallbackLocale);
    }

    public function locale(): string
    {
        return $this->locale;
    }

    /**
     * @param array<string, string> $replacements
     */
    public function trans(string $key, array $replacements = []): string
    {
        $value = $this->find($this->messages, $key);

        if ($value === null) {
            $value = $this->find($this->fallbackMessages, $key);
        }

        if (!is_string($value)) {
            return $key;
        }

        foreach ($replacements as $name => $replacement) {
            $value = str_replace(':' . $name, $replacement, $value);
        }

        return $value;
    }

    /**
     * @return array<string, mixed>
     */
    private function loadMessages(string $langPath, string $locale): array
    {
        $filePath = $langPath . DIRECTORY_SEPARATOR . $locale . '.php';

        if (!is_file($filePath)) {
            return [];
        }

        /** @var array<string, mixed> $messages */
        $messages = require $filePath;

        return $messages;
    }

    /**
     * @param array<string, mixed> $messages
     */
    private function find(array $messages, string $key): mixed
    {
        $segments = explode('.', $key);
        $current = $messages;

        foreach ($segments as $segment) {
            if (!is_array($current) || !array_key_exists($segment, $current)) {
                return null;
            }

            $current = $current[$segment];
        }

        return $current;
    }
}
