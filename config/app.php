<?php

declare(strict_types=1);

/**
 * Global application configuration.
 *
 * The current version enables German and English, but the architecture is
 * intentionally prepared for additional locales later.
 */
return [
    'app_name' => 'SASD Downloads',
    'default_locale' => 'de',
    'fallback_locale' => 'en',

    /**
     * Locales which are already available in the UI language switcher.
     */
    'enabled_locales' => [
        'de',
        'en',
    ],

    /**
     * Locales which are planned for the future.
     *
     * Note:
     * - "hi" is used for Hindi
     * - "zh" is a generic Chinese code; later you may want to split it into
     *   "zh-CN" and "zh-TW"
     */
    'planned_locales' => [
        'fr',
        'es',
        'pt',
        'it',
        'pl',
        'tr',
        'ar',
        'hi',
        'ko',
        'zh',
        'ja',
    ],

    /**
     * Brand colors are defined here so the application can later expose them
     * to templates, a theme switch, or an admin backend if needed.
     */
    'brand' => [
        'primary' => '#173f7a',
        'primary_dark' => '#123463',
        'accent' => '#f58220',
        'surface' => '#f3f5f8',
        'surface_dark' => '#dde3ec',
        'text' => '#17304f',
    ],

    /**
     * Relative paths are resolved in Bootstrap to absolute paths.
     */
    'paths' => [
        'view_path' => 'resources/views',
        'lang_path' => 'resources/lang',
        'catalog_source_path' => 'data/catalog/source',
        'catalog_generated_path' => 'data/catalog/generated/catalog.json',
        'storage_path' => 'storage/files',
    ],
];
