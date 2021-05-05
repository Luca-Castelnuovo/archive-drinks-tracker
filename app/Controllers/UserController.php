<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\EntryModel;
use App\Models\UserModel;
use CQ\Controllers\Controller;
use CQ\Crypto\Token;
use CQ\Helpers\AuthHelper;
use CQ\Helpers\ConfigHelper;
use CQ\Response\HtmlResponse;
use CQ\Response\Respond;

final class UserController extends Controller
{
    /**
     * Dashboard screen.
     */
    public function dashboard(): HtmlResponse
    {
        $userId = AuthHelper::getUser()->getId();

        return Respond::twig(
            view: 'dashboard.twig',
            parameters: [
                'count' => UserModel::getCount(
                    userId: $userId
                ),
                'last' => UserModel::getLast(
                    userId: $userId
                ),
                'entries' => EntryModel::getAll(
                    userId: $userId,
                    // date: date('Y-m-d', strtotime("-1 days"))
                )
            ]
        );
    }

    public function installation(): HtmlResponse
    {
        $authKey = Token::create(
            key: ConfigHelper::get('app.key'),
            data: [
                'user_id' => AuthHelper::getUser()->getId(),
            ]
        );

        return Respond::twig(
            view: 'installation.twig',
            parameters: [
                'authKey' => $authKey
            ]
        );
    }
}
