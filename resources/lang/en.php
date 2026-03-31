<?php

declare(strict_types=1);

return [
    'brand' => [
        'name' => 'SASD Downloads',
        'tagline' => 'Find downloads, manuals, training material and companion files in one place.',
    ],
    'nav' => [
        'home' => 'Home',
        'products' => 'Products',
        'artifacts' => 'All Downloads',
        'software_portal' => 'Software Portal',
        'support' => 'Support',
    ],
    'search' => [
        'placeholder' => 'Search…',
        'button' => 'Search',
        'reset' => 'Reset filters',
        'headline' => 'Browse downloads',
    ],
    'pages' => [
        'home' => [
            'title' => 'Downloads',
            'latest' => 'New & Updated',
            'popular' => 'Popular Downloads',
            'products' => 'Featured Products',
            'view_more' => 'Show more',
        ],
        'products' => [
            'title' => 'Products',
            'headline' => 'SASD Products',
            'latest_release' => 'Latest release',
            'related_artifacts' => 'Related artifacts',
            'visit_product_page' => 'Open product page',
        ],
        'artifacts' => [
            'title' => 'Browse Downloads',
            'headline' => 'All Artifacts',
            'results' => 'Matching artifacts',
            'filters' => 'Filters',
            'download' => 'Start download',
            'details' => 'Details',
            'related_artifacts' => 'Related artifacts',
            'no_results' => 'No artifacts matched the current filters.',
        ],
        'not_found' => [
            'title' => 'Not found',
            'product_message' => 'The requested product could not be found.',
            'artifact_message' => 'The requested artifact could not be found.',
            'download_message' => 'The requested file does not exist.',
        ],
    ],
    'sections' => [
        'categories' => 'Categories',
        'platform' => 'Platform',
        'type' => 'File type',
        'language' => 'Language',
        'status' => 'Status',
        'meta' => 'Metadata',
        'checksum' => 'SHA-256 checksum',
    ],
    'labels' => [
        'group' => [
            'products' => 'Products',
            'documentation' => 'Manuals & Docs',
            'training' => 'Training Material',
            'books' => 'Books & Guides',
        ],
        'platform' => [
            'windows' => 'Windows',
            'linux' => 'Linux',
            'macos' => 'macOS',
            'neutral' => 'Platform neutral',
        ],
        'type' => [
            'installer' => 'Installer',
            'package' => 'Package / ZIP',
            'manual' => 'Manual',
            'guide' => 'Guide',
            'slides' => 'Slides',
            'workbook' => 'Workbook',
            'companion' => 'Companion files',
        ],
        'language' => [
            'de' => 'German',
            'en' => 'English',
            'multi' => 'Multilingual',
        ],
        'status' => [
            'current' => 'Current',
            'lts' => 'LTS',
            'deprecated' => 'Deprecated',
            'archived' => 'Archived',
            'hidden' => 'Hidden',
        ],
    ],
    'artifact' => [
        'version' => 'Version',
        'release_date' => 'Released',
        'platform' => 'Platform',
        'language' => 'Language',
        'type' => 'Type',
        'status' => 'Status',
        'file_size' => 'File size',
        'belongs_to_product' => 'Belongs to product',
        'back_to_catalog' => 'Back to catalog',
    ],
    'footer' => [
        'note' => 'File-based V1 for downloads.sasd.de – prepared for a later repository/database migration.',
    ],
];
