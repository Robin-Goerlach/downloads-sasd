<?php /** @var \App\View\View $view */ ?>
<!DOCTYPE html>
<html lang="<?= $view->escape($view->locale()) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($pageTitle) ? $view->escape($pageTitle) : $view->escape($view->trans('brand.name')) ?></title>
    <link rel="stylesheet" href="<?= $view->escape($view->asset('css/app.css')) ?>">
</head>
<body>
<header class="topbar">
    <div class="container topbar-inner">
        <a class="brand" href="<?= $view->escape($view->url('/')) ?>">
            <span class="brand-mark" aria-hidden="true">⬢</span>
            <span class="brand-text">
                <strong>SASD</strong> <span>DOWNLOADS</span>
            </span>
        </a>

        <nav class="main-nav" aria-label="Main navigation">
            <a href="<?= $view->escape($view->url('/')) ?>" class="<?= $view->currentPath() === '/' ? 'active' : '' ?>">
                <?= $view->escape($view->trans('nav.home')) ?>
            </a>
            <a href="<?= $view->escape($view->url('/products')) ?>" class="<?= str_starts_with($view->currentPath(), '/products') ? 'active' : '' ?>">
                <?= $view->escape($view->trans('nav.products')) ?>
            </a>
            <a href="<?= $view->escape($view->url('/artifacts')) ?>" class="<?= str_starts_with($view->currentPath(), '/artifacts') || str_starts_with($view->currentPath(), '/download') ? 'active' : '' ?>">
                <?= $view->escape($view->trans('nav.artifacts')) ?>
            </a>
            <a href="https://software.sasd.de" target="_blank" rel="noopener">
                <?= $view->escape($view->trans('nav.software_portal')) ?>
            </a>
            <a href="https://www.sasd.de" target="_blank" rel="noopener">
                <?= $view->escape($view->trans('nav.support')) ?>
            </a>
        </nav>

        <div class="locale-switcher" aria-label="Language switcher">
            <?php foreach ($view->enabledLocales() as $localeCode): ?>
                <?php $query = $_GET; $query['lang'] = $localeCode; ?>
                <a href="<?= $view->escape($view->currentPath() . '?' . http_build_query($query)) ?>" class="<?= $localeCode === $view->locale() ? 'active' : '' ?>">
                    <?= $view->escape(strtoupper($localeCode)) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</header>

<section class="hero-search">
    <div class="container">
        <form class="hero-search-form" action="<?= $view->escape($view->url('/artifacts')) ?>" method="get">
            <input type="hidden" name="lang" value="<?= $view->escape($view->locale()) ?>">
            <input
                type="search"
                name="q"
                value="<?= $view->escape((string) ($_GET['q'] ?? '')) ?>"
                placeholder="<?= $view->escape($view->trans('search.placeholder')) ?>"
                aria-label="<?= $view->escape($view->trans('search.placeholder')) ?>"
            >
            <button type="submit"><?= $view->escape($view->trans('search.button')) ?></button>
        </form>
    </div>
</section>

<main class="page">
    <div class="container">
        <?= $content ?>
    </div>
</main>

<footer class="footer">
    <div class="container">
        <p><?= $view->escape($view->trans('footer.note')) ?></p>
    </div>
</footer>
</body>
</html>
