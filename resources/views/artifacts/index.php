<?php /** @var \App\View\View $view */ ?>
<section class="page-header">
    <h1><?= $view->escape($view->trans('pages.artifacts.headline')) ?></h1>
</section>

<div class="detail-grid">
    <aside class="panel">
        <h2><?= $view->escape($view->trans('pages.artifacts.filters')) ?></h2>

        <form class="filters-form" method="get" action="<?= $view->escape($view->url('/artifacts')) ?>">
            <input type="hidden" name="lang" value="<?= $view->escape($view->locale()) ?>">

            <label>
                <span><?= $view->escape($view->trans('search.placeholder')) ?></span>
                <input type="search" name="q" value="<?= $view->escape($criteria['q']) ?>">
            </label>

            <label>
                <span><?= $view->escape($view->trans('sections.categories')) ?></span>
                <select name="group">
                    <option value=""></option>
                    <?php foreach ($groups as $group): ?>
                        <option value="<?= $view->escape($group) ?>" <?= $criteria['group'] === $group ? 'selected' : '' ?>>
                            <?= $view->escape($view->label('group', $group)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label>
                <span><?= $view->escape($view->trans('sections.platform')) ?></span>
                <select name="platform">
                    <option value=""></option>
                    <?php foreach ($platforms as $platform): ?>
                        <option value="<?= $view->escape($platform) ?>" <?= $criteria['platform'] === $platform ? 'selected' : '' ?>>
                            <?= $view->escape($view->label('platform', $platform)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label>
                <span><?= $view->escape($view->trans('sections.type')) ?></span>
                <select name="type">
                    <option value=""></option>
                    <?php foreach ($types as $type): ?>
                        <option value="<?= $view->escape($type) ?>" <?= $criteria['type'] === $type ? 'selected' : '' ?>>
                            <?= $view->escape($view->label('type', $type)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label>
                <span><?= $view->escape($view->trans('sections.language')) ?></span>
                <select name="language">
                    <option value=""></option>
                    <?php foreach ($languages as $language): ?>
                        <option value="<?= $view->escape($language) ?>" <?= $criteria['language'] === $language ? 'selected' : '' ?>>
                            <?= $view->escape($view->label('language', $language)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label>
                <span><?= $view->escape($view->trans('sections.status')) ?></span>
                <select name="status">
                    <option value=""></option>
                    <?php foreach (['current', 'lts', 'deprecated', 'archived'] as $statusOption): ?>
                        <option value="<?= $view->escape($statusOption) ?>" <?= $criteria['status'] === $statusOption ? 'selected' : '' ?>>
                            <?= $view->escape($view->label('status', $statusOption)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <div class="filters-actions">
                <button type="submit" class="button button--accent"><?= $view->escape($view->trans('search.button')) ?></button>
                <a class="button button--secondary" href="<?= $view->escape($view->url('/artifacts')) ?>">
                    <?= $view->escape($view->trans('search.reset')) ?>
                </a>
            </div>
        </form>
    </aside>

    <section class="panel panel--large">
        <div class="panel-header">
            <h2><?= $view->escape($view->trans('pages.artifacts.results')) ?></h2>
            <span class="result-count"><?= $view->escape((string) count($artifacts)) ?></span>
        </div>

        <?php if ($artifacts === []): ?>
            <p><?= $view->escape($view->trans('pages.artifacts.no_results')) ?></p>
        <?php else: ?>
            <ul class="artifact-list artifact-list--dense">
                <?php foreach ($artifacts as $artifact): ?>
                    <li>
                        <div class="artifact-list__content">
                            <a class="artifact-list__title" href="<?= $view->escape($view->url('/artifacts/' . $artifact->slug())) ?>">
                                <?= $view->escape($artifact->getTitle($view->locale(), 'en')) ?>
                            </a>
                            <p class="artifact-list__description">
                                <?= $view->escape($artifact->getDescription($view->locale(), 'en')) ?>
                            </p>
                            <div class="artifact-list__meta">
                                <span><?= $view->escape($view->label('group', $artifact->group())) ?></span>
                                <span><?= $view->escape($view->label('type', $artifact->type())) ?></span>
                                <span><?= $view->escape($view->label('platform', $artifact->platform())) ?></span>
                                <span><?= $view->escape($view->formatDate($artifact->releaseDate())) ?></span>
                            </div>
                        </div>
                        <div class="artifact-actions">
                            <a class="button button--secondary" href="<?= $view->escape($view->url('/artifacts/' . $artifact->slug())) ?>">
                                <?= $view->escape($view->trans('pages.artifacts.details')) ?>
                            </a>
                            <a class="button button--accent" href="<?= $view->escape($view->url('/download/' . $artifact->slug())) ?>">
                                <?= $view->escape($view->trans('pages.artifacts.download')) ?>
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>
</div>
