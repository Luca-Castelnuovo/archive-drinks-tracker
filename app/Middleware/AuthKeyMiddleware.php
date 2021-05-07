<?php

declare(strict_types=1);

namespace App\Middleware;

use Closure;
use CQ\Crypto\Exceptions\TokenException;
use CQ\Crypto\Token;
use CQ\Middleware\Middleware;
use CQ\Response\HtmlResponse;
use CQ\Response\JsonResponse;
use CQ\Response\NoContentResponse;
use CQ\Response\RedirectResponse;
use CQ\Response\Respond;

class AuthKeyMiddleware extends Middleware
{
    /**
     * Validate authKey
     */
    public function handleChild(Closure $next): Closure | HtmlResponse | JsonResponse | NoContentResponse | RedirectResponse
    {
        $authorization = $this->requestHelper->getAuthorization();

        try {
            $decode = Token::decode(
                key: ConfigHelper::get(key: 'app.key'),
                givenToken: $authorization
            );
        } catch (TokenException) {
            return Respond::prettyJson(
                message: 'Invalid authKey',
                code: 401
            );
        }

        $this->request->authKeyUserId = $decode->user_id;

        return $next($this->request);
    }
}
