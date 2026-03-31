<?php /** @var \App\View\View $view */ ?>
<section class="page-header">
    <h1><?= $view->escape($view->trans('pages.not_found.title')) ?></h1>
    <p class="page-intro"><?= $view->escape($message ?? '') ?></p>
    <p>
        <a class="button button--accent" href="<?= $view->escape($view->url('/artifacts')) ?>">
            <?= $view->escape($view->trans('artifact.back_to_catalog')) ?>
        </a>
    </p>
</section>
