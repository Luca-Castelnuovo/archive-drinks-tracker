<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Drink;
use App\Validators\DrinksValidator;
use CQ\Controllers\Controller;
use CQ\DB\DB;
use CQ\Helpers\UuidHelper;
use CQ\Response\JsonResponse;
use CQ\Response\Respond;

final class DrinksController extends Controller
{
    /**
     * Show drinks
     */
    public function index(): JsonResponse
    {
        return Respond::prettyJson(
            message: 'Drinks',
            data: [
                'count' => Drink::getCount(
                    userId: $this->request->authKeyUserId
                ),
                'last' => Drink::getLast(
                    userId: $this->request->authKeyUserId
                ),
            ]
        );
    }

    /**
     * Create drink.
     */
    public function create(): JsonResponse
    {
        try {
            DrinksValidator::create($this->request->data);
        } catch (\Throwable $th) {
            return Respond::prettyJson(
                message: 'Provided data was malformed',
                data: $th->getMessage(),
                code: 422
            );
        }

        $drink = [
            'id' => UuidHelper::v6(),
            'user_id' => $this->request->authKeyUserId,
            'type' => $this->request->data->type,
        ];

        DB::create(
            table: 'drinks',
            data: $drink
        );

        return Respond::prettyJson(
            message: 'Drink Created',
            data: $drink
        );
    }
}
