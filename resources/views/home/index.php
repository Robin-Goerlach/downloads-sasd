<?php /** @var \App\View\View $view */ ?>
<section class="category-grid">
    <a class="category-card" href="<?= $view->escape($view->url('/artifacts', ['group' => 'products'])) ?>">
        <div class="category-icon">⬢</div>
        <div class="category-title"><?= $view->escape($view->label('group', 'products')) ?></div>
    </a>
    <a class="category-card" href="<?= $view->escape($view->url('/artifacts', ['group' => 'documentation'])) ?>">
        <div class="category-icon">📄</div>
        <div class="category-title"><?= $view->escape($view->label('group', 'documentation')) ?></div>
    </a>
    <a class="category-card category-card--accent" href="<?= $view->escape($view->url('/artifacts', ['group' => 'training'])) ?>">
        <div class="category-icon">🎓</div>
        <div class="category-title"><?= $view->escape($view->label('group', 'training')) ?></div>
    </a>
    <a class="category-card" href="<?= $view->escape($view->url('/artifacts', ['group' => 'books'])) ?>">
        <div class="category-icon">📘</div>
        <div class="category-title"><?= $view->escape($view->label('group', 'books')) ?></div>
    </a>
</section>

<div class="content-grid">
    <aside class="sidebar">
        <section class="panel">
            <h2><?= $view->escape($view->trans('sections.categories')) ?></h2>
            <ul class="sidebar-list">
                <?php foreach ($groupCounts as $group => $count): ?>
                    <li>
                        <a href="<?= $view->escape($view->url('/artifacts', ['group' => $group])) ?>">
                            <span><?= $view->escape($view->label('group', $group)) ?></span>
                            <small><?= $view->escape((string) $count) ?></small>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="panel">
            <h2><?= $view->escape($view->trans('sections.platform')) ?></h2>
            <ul class="sidebar-list">
                <?php foreach ($platformCounts as $platform => $count): ?>
                    <li>
                        <a href="<?= $view->escape($view->url('/artifacts', ['platform' => $platform])) ?>">
                            <span><?= $view->escape($view->label('platform', $platform)) ?></span>
                            <small><?= $view->escape((string) $count) ?></small>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="panel">
            <h2><?= $view->escape($view->trans('sections.type')) ?></h2>
            <ul class="sidebar-list">
                <?php foreach ($typeCounts as $type => $count): ?>
                    <li>
                        <a href="<?= $view->escape($view->url('/artifacts', ['type' => $type])) ?>">
                            <span><?= $view->escape($view->label('type', $type)) ?></span>
                            <small><?= $view->escape((string) $count) ?></small>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </aside>

    <section class="card-columns">
        <article class="panel panel--large">
            <div class="panel-header">
                <h2><?= $view->escape($view->trans('pages.home.latest')) ?></h2>
                <a href="<?= $view->escape($view->url('/artifacts')) ?>"><?= $view->escape($view->trans('pages.home.view_more')) ?></a>
            </div>

            <ul class="artifact-list">
                <?php foreach ($latestArtifacts as $artifact): ?>
                    <li>
                        <div class="artifact-list__content">
                            <a class="artifact-list__title" href="<?= $view->escape($view->url('/artifacts/' . $artifact->slug())) ?>">
                                <?= $view->escape($artifact->getTitle($view->locale(), 'en')) ?>
                            </a>
                            <div class="artifact-list__meta">
                                <span><?= $view->escape($artifact->version()) ?></span>
                                <span><?= $view->escape($view->formatDate($artifact->releaseDate())) ?></span>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </article>

        <article class="panel panel--large">
            <div class="panel-header">
                <h2><?= $view->escape($view->trans('pages.home.popular')) ?></h2>
                <a href="<?= $view->escape($view->url('/artifacts')) ?>"><?= $view->escape($view->trans('pages.home.view_more')) ?></a>
            </div>

            <ul class="artifact-list">
                <?php foreach ($popularArtifacts as $artifact): ?>
                    <li>
                        <div class="artifact-list__content">
                            <a class="artifact-list__title" href="<?= $view->escape($view->url('/artifacts/' . $artifact->slug())) ?>">
                                <?= $view->escape($artifact->getTitle($view->locale(), 'en')) ?>
                            </a>
                            <div class="artifact-list__meta">
                                <span><?= $view->escape($view->label('type', $artifact->type())) ?></span>
                                <span><?= $view->escape($view->label('platform', $artifact->platform())) ?></span>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </article>
    </section>
</div>

<section class="products-showcase">
    <div class="panel">
        <div class="panel-header">
            <h2><?= $view->escape($view->trans('pages.home.products')) ?></h2>
            <a href="<?= $view->escape($view->url('/products')) ?>"><?= $view->escape($view->trans('pages.home.view_more')) ?></a>
        </div>

        <div class="product-card-grid">
            <?php foreach ($featuredProducts as $product): ?>
                <article class="product-card">
                    <h3>
                        <a href="<?= $view->escape($view->url('/products/' . $product->slug())) ?>">
                            <?= $view->escape($product->getTitle($view->locale(), 'en')) ?>
                        </a>
                    </h3>
                    <p><?= $view->escape($product->getSummary($view->locale(), 'en')) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
