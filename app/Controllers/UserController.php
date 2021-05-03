<?php

declare(strict_types=1);

namespace App\Controllers;

use CQ\DB\DB;
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
    public function dashboard(): HtmlResponse
    {
        $drinks = DB::select('drinks', [
            'type',
            'created_at',
        ], [
            'user_id' => AuthHelper::getUser()->getId(),
            'ORDER' => [
                'created_at' => 'DESC'
            ]
        ]);

        // group output by 24hour intervals

        return Respond::twig(
            view: 'dashboard.twig',
            parameters: [
                "drinks" => $drinks
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
