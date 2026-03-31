<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Http\Request;
use App\Http\Response;
use App\Service\CatalogService;

/**
 * Controller for product overview pages.
 */
final class ProductController extends BaseController
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
        return $this->render('products/index', [
            'pageTitle' => $this->view->trans('pages.products.title'),
            'products' => $this->catalogService->getAllProducts(),
        ]);
    }

    public function show(Request $request, string $slug): Response
    {
        $product = $this->catalogService->getProductBySlug($slug);

        if ($product === null) {
            return $this->render('artifacts/not-found', [
                'pageTitle' => $this->view->trans('pages.not_found.title'),
                'message' => $this->view->trans('pages.not_found.product_message'),
            ], 404);
        }

        return $this->render('products/show', [
            'pageTitle' => $product->getTitle($this->view->locale(), $this->config['fallback_locale']),
            'product' => $product,
            'artifacts' => $this->catalogService->getArtifactsForProduct($slug),
            'latestArtifact' => $this->catalogService->getLatestArtifactForProduct($slug),
        ]);
    }
}
