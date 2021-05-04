<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Drink;
use CQ\Controllers\Controller;
use CQ\Crypto\Token;
use CQ\Helpers\AuthHelper;
use CQ\Helpers\ConfigHelper;
use CQ\Response\HtmlResponse;
use CQ\Response\JsonResponse;
use CQ\Response\Respond;

final class UserController extends Controller
{
    /**
     * Dashboard screen.
     */
    public function dashboard(): HtmlResponse|JsonResponse
    {
        $userId = AuthHelper::getUser()->getId();

        return Respond::twig(
            view: 'dashboard.twig',
            parameters: [
                'drinks' => Drink::get(
                    userId: $userId
                ),
                'count' => Drink::getCount(
                    userId: $userId
                ),
                'last' => Drink::getLast(
                    userId: $userId
                ),
            ]
        );
    }

    public function createAuthKey(): JsonResponse
    {
        $authKey = Token::create(
            key: ConfigHelper::get('app.key'),
            data: [
                'user_id' => AuthHelper::getUser()->getId(),
            ]
        );

        return Respond::prettyJson(
            message: 'authKey created successfully',
            data: $authKey
        );
    }
}
