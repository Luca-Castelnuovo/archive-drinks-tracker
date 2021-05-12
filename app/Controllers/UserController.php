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
        $dates = RecordModel::getDates(
            userId: $userId
        );

        $defaultStartDate = RecordModel::getFirstDate(
            userId: $userId
        );

        $startDate = $this->requestHelper->getQueryParam('startDate') ?: $defaultStartDate;
        $type = $this->requestHelper->getQueryParam('type') ?: 'week';

        return Respond::twig(
            view: 'dashboard.twig',
            parameters: [
                'type' => $type,
                'start_date' => $startDate,
                'dates' => $dates,
                'records' => RecordModel::get(
                    userId: $userId,
                    startDate: $startDate,
                    type: $type
                ),
                'last' => RecordModel::getLastAllTypes(
                    userId: $userId
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
                'authKey' => $authKey,
            ]
        );
    }
}
