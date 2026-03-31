<?php /** @var \App\View\View $view */ ?>
<section class="page-header">
    <h1><?= $view->escape($view->trans('pages.products.headline')) ?></h1>
</section>

<section class="product-card-grid">
    <?php foreach ($products as $product): ?>
        <article class="product-card">
            <h2>
                <a href="<?= $view->escape($view->url('/products/' . $product->slug())) ?>">
                    <?= $view->escape($product->getTitle($view->locale(), 'en')) ?>
                </a>
            </h2>
            <p><?= $view->escape($product->getSummary($view->locale(), 'en')) ?></p>

            <div class="product-actions">
                <a class="button button--secondary" href="<?= $view->escape($view->url('/products/' . $product->slug())) ?>">
                    <?= $view->escape($view->trans('pages.artifacts.details')) ?>
                </a>
                <?php if ($product->productPageUrl() !== ''): ?>
                    <a class="button button--accent" href="<?= $view->escape($product->productPageUrl()) ?>" target="_blank" rel="noopener">
                        <?= $view->escape($view->trans('pages.products.visit_product_page')) ?>
                    </a>
                <?php endif; ?>
            </div>
        </article>
    <?php endforeach; ?>
</section>
