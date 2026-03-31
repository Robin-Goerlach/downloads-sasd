<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Http\Request;
use App\Http\Response;
use App\Service\CatalogService;

/**
 * Controller for catalog browsing and downloads.
 */
final class ArtifactController extends BaseController
{
    public function __construct(
        \App\View\View $view,
        private readonly CatalogService $catalogService,
        array $config
    ) {
        parent::__construct($view, $config);
    }

    public function index(Request $request): Response
    {
        $criteria = [
            'q' => trim((string) $request->query('q', '')),
            'group' => trim((string) $request->query('group', '')),
            'platform' => trim((string) $request->query('platform', '')),
            'type' => trim((string) $request->query('type', '')),
            'language' => trim((string) $request->query('language', '')),
            'status' => trim((string) $request->query('status', '')),
        ];

        return $this->render('artifacts/index', [
            'pageTitle' => $this->view->trans('pages.artifacts.title'),
            'criteria' => $criteria,
            'artifacts' => $this->catalogService->searchArtifacts($criteria),
            'groups' => $this->catalogService->getAvailableGroups(),
            'platforms' => $this->catalogService->getAvailablePlatforms(),
            'types' => $this->catalogService->getAvailableTypes(),
            'languages' => $this->catalogService->getAvailableLanguages(),
        ]);
    }

    public function show(Request $request, string $slug): Response
    {
        $artifact = $this->catalogService->getArtifactBySlug($slug);

        if ($artifact === null) {
            return $this->render('artifacts/not-found', [
                'pageTitle' => $this->view->trans('pages.not_found.title'),
                'message' => $this->view->trans('pages.not_found.artifact_message'),
            ], 404);
        }

        $product = null;

        if ($artifact->productSlug() !== null) {
            $product = $this->catalogService->getProductBySlug($artifact->productSlug());
        }

        return $this->render('artifacts/show', [
            'pageTitle' => $artifact->getTitle($this->view->locale(), $this->config['fallback_locale']),
            'artifact' => $artifact,
            'product' => $product,
            'relatedArtifacts' => $artifact->productSlug() !== null
                ? $this->catalogService->getArtifactsForProduct($artifact->productSlug(), $artifact->id())
                : [],
        ]);
    }

    public function download(Request $request, string $slug): Response
    {
        $artifact = $this->catalogService->getArtifactBySlug($slug);

        if ($artifact === null || !is_file($artifact->absolutePath())) {
            return $this->render('artifacts/not-found', [
                'pageTitle' => $this->view->trans('pages.not_found.title'),
                'message' => $this->view->trans('pages.not_found.download_message'),
            ], 404);
        }

        return Response::download(
            $artifact->absolutePath(),
            $artifact->fileName()
        );
    }
}
