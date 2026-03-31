<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Http\Response;
use App\View\View;

/**
 * Base controller with small convenience helpers.
 */
abstract class BaseController
{
    /**
     * @param array<string, mixed> $config
     */
    public function __construct(
        protected readonly View $view,
        protected readonly array $config
    ) {
    }

    /**
     * @param array<string, mixed> $params
     */
    protected function render(string $template, array $params = [], int $statusCode = 200): Response
    {
        return Response::html(
            $this->view->render($template, $params),
            $statusCode
        );
    }
}
