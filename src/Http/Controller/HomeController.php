<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Http\Request;
use App\Http\Response;
use App\Service\CatalogService;

/**
 * Controller for the landing page.
 */
final class HomeController extends BaseController
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
        return $this->render('home/index', [
            'pageTitle' => $this->view->trans('pages.home.title'),
            'latestArtifacts' => $this->catalogService->getLatestArtifacts(4),
            'popularArtifacts' => $this->catalogService->getPopularArtifacts(4),
            'featuredProducts' => $this->catalogService->getFeaturedProducts(3),
            'groupCounts' => $this->catalogService->getGroupCounts(),
            'platformCounts' => $this->catalogService->getPlatformCounts(),
            'typeCounts' => $this->catalogService->getTypeCounts(),
        ]);
    }
}
