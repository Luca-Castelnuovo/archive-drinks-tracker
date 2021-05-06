<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\RecordModel;
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
        $startDate = $this->requestHelper->getQueryParam('startDate') ?: '2020-11-26';
        $endDate = $this->requestHelper->getQueryParam('endDate') ?: date('Y-m-d');

        return Respond::twig(
            view: 'dashboard.twig',
            parameters: [
                'records' => RecordModel::get(
                    userId: $userId,
                    startDate: $startDate,
                    endDate: $endDate
                ),
                'last' => RecordModel::getLastAllTypes(
                    userId: $userId
                ),
                'count' => RecordModel::getCountAllTypes(
                    userId: $userId,
                    startDate: $startDate,
                    endDate: $endDate
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

        // TODO: finish installation instructions

        return Respond::twig(
            view: 'installation.twig',
            parameters: [
                'authKey' => $authKey
            ]
        );
    }
}
