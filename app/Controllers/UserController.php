<?php

declare(strict_types=1);

namespace App\Controllers;

use CQ\DB\DB;
use CQ\Controllers\Controller;
use CQ\Helpers\AuthHelper;
use CQ\Response\HtmlResponse;
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

        return Respond::twig(
            view: 'dashboard.twig',
            parameters: [
                "drinks" => $drinks
            ]
        );
    }
}
