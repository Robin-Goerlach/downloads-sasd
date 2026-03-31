<?php /** @var \App\View\View $view */ ?>
<section class="page-header">
    <h1><?= $view->escape($product->getTitle($view->locale(), 'en')) ?></h1>
    <p class="page-intro"><?= $view->escape($product->getDescription($view->locale(), 'en')) ?></p>
</section>

<div class="detail-grid">
    <section class="panel panel--large">
        <div class="panel-header">
            <h2><?= $view->escape($view->trans('pages.products.related_artifacts')) ?></h2>
            <?php if ($product->productPageUrl() !== ''): ?>
                <a href="<?= $view->escape($product->productPageUrl()) ?>" target="_blank" rel="noopener">
                    <?= $view->escape($view->trans('pages.products.visit_product_page')) ?>
                </a>
            <?php endif; ?>
        </div>

        <?php if ($artifacts === []): ?>
            <p><?= $view->escape($view->trans('pages.artifacts.no_results')) ?></p>
        <?php else: ?>
            <ul class="artifact-list">
                <?php foreach ($artifacts as $artifact): ?>
                    <li>
                        <div class="artifact-list__content">
                            <a class="artifact-list__title" href="<?= $view->escape($view->url('/artifacts/' . $artifact->slug())) ?>">
                                <?= $view->escape($artifact->getTitle($view->locale(), 'en')) ?>
                            </a>
                            <div class="artifact-list__meta">
                                <span><?= $view->escape($view->label('type', $artifact->type())) ?></span>
                                <span><?= $view->escape($artifact->version()) ?></span>
                                <span><?= $view->escape($view->formatDate($artifact->releaseDate())) ?></span>
                            </div>
                        </div>
                        <div>
                            <a class="button button--accent" href="<?= $view->escape($view->url('/download/' . $artifact->slug())) ?>">
                                <?= $view->escape($view->trans('pages.artifacts.download')) ?>
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>

    <aside class="panel">
        <h2><?= $view->escape($view->trans('pages.products.latest_release')) ?></h2>

        <?php if ($latestArtifact !== null): ?>
            <dl class="meta-list">
                <div>
                    <dt><?= $view->escape($view->trans('artifact.version')) ?></dt>
                    <dd><?= $view->escape($latestArtifact->version()) ?></dd>
                </div>
                <div>
                    <dt><?= $view->escape($view->trans('artifact.release_date')) ?></dt>
                    <dd><?= $view->escape($view->formatDate($latestArtifact->releaseDate())) ?></dd>
                </div>
                <div>
                    <dt><?= $view->escape($view->trans('artifact.type')) ?></dt>
                    <dd><?= $view->escape($view->label('type', $latestArtifact->type())) ?></dd>
                </div>
            </dl>

            <a class="button button--accent button--full" href="<?= $view->escape($view->url('/download/' . $latestArtifact->slug())) ?>">
                <?= $view->escape($view->trans('pages.artifacts.download')) ?>
            </a>
        <?php else: ?>
            <p><?= $view->escape($view->trans('pages.artifacts.no_results')) ?></p>
        <?php endif; ?>
    </aside>
</div>
