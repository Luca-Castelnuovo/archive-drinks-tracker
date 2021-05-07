<?php

declare(strict_types=1);

namespace App\Middleware;

use Closure;
use CQ\Helpers\AppHelper;
use CQ\Middleware\Middleware;
use CQ\Response\HtmlResponse;
use CQ\Response\JsonResponse;
use CQ\Response\NoContentResponse;
use CQ\Response\RedirectResponse;
use CQ\Response\Respond;

class DebugMiddleware extends Middleware
{
    /**
     * Validate authKey
     */
    public function handleChild(Closure $next): Closure | HtmlResponse | JsonResponse | NoContentResponse | RedirectResponse
    {
        if (!AppHelper::isDebug()) {
            return Respond::prettyJson(
                message: 'Only accessible in debug mode',
                code: 403
            );
        }

        return $next($this->request);
    }
}
