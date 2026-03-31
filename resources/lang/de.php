<?php

declare(strict_types=1);

return [
    'brand' => [
        'name' => 'SASD Downloads',
        'tagline' => 'Downloads, Handbücher, Trainingsmaterial und Begleitdateien zentral finden.',
    ],
    'nav' => [
        'home' => 'Home',
        'products' => 'Produkte',
        'artifacts' => 'Alle Downloads',
        'software_portal' => 'Software-Portal',
        'support' => 'Support',
    ],
    'search' => [
        'placeholder' => 'Suchen…',
        'button' => 'Suchen',
        'reset' => 'Filter zurücksetzen',
        'headline' => 'Downloads durchsuchen',
    ],
    'pages' => [
        'home' => [
            'title' => 'Downloads',
            'latest' => 'Neu & Aktualisiert',
            'popular' => 'Beliebte Downloads',
            'products' => 'Empfohlene Produkte',
            'view_more' => 'Mehr anzeigen',
        ],
        'products' => [
            'title' => 'Produkte',
            'headline' => 'SASD Produkte',
            'latest_release' => 'Neueste Version',
            'related_artifacts' => 'Zugehörige Artefakte',
            'visit_product_page' => 'Zur Produktseite',
        ],
        'artifacts' => [
            'title' => 'Downloads durchsuchen',
            'headline' => 'Alle Artefakte',
            'results' => 'Gefundene Artefakte',
            'filters' => 'Filter',
            'download' => 'Download starten',
            'details' => 'Details',
            'related_artifacts' => 'Verwandte Artefakte',
            'no_results' => 'Keine Artefakte für die aktuellen Filter gefunden.',
        ],
        'not_found' => [
            'title' => 'Nicht gefunden',
            'product_message' => 'Das gewünschte Produkt wurde nicht gefunden.',
            'artifact_message' => 'Das gewünschte Artefakt wurde nicht gefunden.',
            'download_message' => 'Die gewünschte Datei ist nicht vorhanden.',
        ],
    ],
    'sections' => [
        'categories' => 'Kategorien',
        'platform' => 'Plattform',
        'type' => 'Dateityp',
        'language' => 'Sprache',
        'status' => 'Status',
        'meta' => 'Metadaten',
        'checksum' => 'SHA-256 Prüfsumme',
    ],
    'labels' => [
        'group' => [
            'products' => 'Produkte',
            'documentation' => 'Handbücher & Doku',
            'training' => 'Trainingsunterlagen',
            'books' => 'Bücher & Guides',
        ],
        'platform' => [
            'windows' => 'Windows',
            'linux' => 'Linux',
            'macos' => 'macOS',
            'neutral' => 'Plattformneutral',
        ],
        'type' => [
            'installer' => 'Installer',
            'package' => 'Paket / ZIP',
            'manual' => 'Handbuch',
            'guide' => 'Guide',
            'slides' => 'Präsentation',
            'workbook' => 'Workbook',
            'companion' => 'Begleitmaterial',
        ],
        'language' => [
            'de' => 'Deutsch',
            'en' => 'Englisch',
            'multi' => 'Mehrsprachig',
        ],
        'status' => [
            'current' => 'Aktuell',
            'lts' => 'LTS',
            'deprecated' => 'Veraltet',
            'archived' => 'Archiviert',
            'hidden' => 'Ausgeblendet',
        ],
    ],
    'artifact' => [
        'version' => 'Version',
        'release_date' => 'Veröffentlicht',
        'platform' => 'Plattform',
        'language' => 'Sprache',
        'type' => 'Typ',
        'status' => 'Status',
        'file_size' => 'Dateigröße',
        'belongs_to_product' => 'Gehört zu Produkt',
        'back_to_catalog' => 'Zurück zum Katalog',
    ],
    'footer' => [
        'note' => 'Dateibasierte V1 für downloads.sasd.de – vorbereitet für spätere Repository-/Datenbank-Migration.',
    ],
];
