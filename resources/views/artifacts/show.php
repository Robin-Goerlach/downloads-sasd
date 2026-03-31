<?php /** @var \App\View\View $view */ ?>
<section class="page-header">
    <h1><?= $view->escape($artifact->getTitle($view->locale(), 'en')) ?></h1>
    <p class="page-intro"><?= $view->escape($artifact->getDescription($view->locale(), 'en')) ?></p>
</section>

<div class="detail-grid">
    <section class="panel panel--large">
        <div class="artifact-hero">
            <div class="artifact-hero__main">
                <dl class="meta-list">
                    <div>
                        <dt><?= $view->escape($view->trans('artifact.version')) ?></dt>
                        <dd><?= $view->escape($artifact->version()) ?></dd>
                    </div>
                    <div>
                        <dt><?= $view->escape($view->trans('artifact.release_date')) ?></dt>
                        <dd><?= $view->escape($view->formatDate($artifact->releaseDate())) ?></dd>
                    </div>
                    <div>
                        <dt><?= $view->escape($view->trans('artifact.platform')) ?></dt>
                        <dd><?= $view->escape($view->label('platform', $artifact->platform())) ?></dd>
                    </div>
                    <div>
                        <dt><?= $view->escape($view->trans('artifact.language')) ?></dt>
                        <dd><?= $view->escape($view->label('language', $artifact->language())) ?></dd>
                    </div>
                    <div>
                        <dt><?= $view->escape($view->trans('artifact.type')) ?></dt>
                        <dd><?= $view->escape($view->label('type', $artifact->type())) ?></dd>
                    </div>
                    <div>
                        <dt><?= $view->escape($view->trans('artifact.status')) ?></dt>
                        <dd><?= $view->escape($view->label('status', $artifact->status())) ?></dd>
                    </div>
                    <div>
                        <dt><?= $view->escape($view->trans('artifact.file_size')) ?></dt>
                        <dd><?= $view->escape($view->formatBytes($artifact->fileSize())) ?></dd>
                    </div>
                </dl>
            </div>

            <div class="artifact-hero__actions">
                <a class="button button--accent button--full" href="<?= $view->escape($view->url('/download/' . $artifact->slug())) ?>">
                    <?= $view->escape($view->trans('pages.artifacts.download')) ?>
                </a>
                <a class="button button--secondary button--full" href="<?= $view->escape($view->url('/artifacts')) ?>">
                    <?= $view->escape($view->trans('artifact.back_to_catalog')) ?>
                </a>
            </div>
        </div>

        <section class="checksum-box">
            <h2><?= $view->escape($view->trans('sections.checksum')) ?></h2>
            <code><?= $view->escape($artifact->checksumSha256()) ?></code>
        </section>
    </section>

    <aside class="panel">
        <h2><?= $view->escape($view->trans('sections.meta')) ?></h2>

        <?php if ($product !== null): ?>
            <p>
                <strong><?= $view->escape($view->trans('artifact.belongs_to_product')) ?>:</strong><br>
                <a href="<?= $view->escape($view->url('/products/' . $product->slug())) ?>">
                    <?= $view->escape($product->getTitle($view->locale(), 'en')) ?>
                </a>
            </p>
        <?php endif; ?>

        <?php if ($relatedArtifacts !== []): ?>
            <h3><?= $view->escape($view->trans('pages.artifacts.related_artifacts')) ?></h3>
            <ul class="link-list">
                <?php foreach ($relatedArtifacts as $relatedArtifact): ?>
                    <li>
                        <a href="<?= $view->escape($view->url('/artifacts/' . $relatedArtifact->slug())) ?>">
                            <?= $view->escape($relatedArtifact->getTitle($view->locale(), 'en')) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </aside>
</div>
