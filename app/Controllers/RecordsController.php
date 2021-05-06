<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\RecordModel;
use App\Validators\RecordsValidator;
use CQ\Controllers\Controller;
use CQ\DB\DB;
use CQ\Helpers\UuidHelper;
use CQ\Response\JsonResponse;
use CQ\Response\Respond;

final class RecordsController extends Controller
{
    /**
     * Show drinks
     */
    public function index(): JsonResponse
    {
        // TODO: startDate= (optional) & endDate= (optional)
        $startDate = $_GET['startDate'] ?: '2020-11-26 00:00:00';
        $endDate = $_GET['endDate'] ?: date('Y-m-d H:i:s');

        return Respond::prettyJson(
            message: "Entries between {$startDate} and {$endDate}",
            data: [
                'records' => RecordModel::get(
                    userId: $this->request->authKeyUserId,
                    startDate: $startDate,
                    endDate: $endDate
                ),
                'last' => RecordModel::getLastAllTypes(
                    userId: $this->request->authKeyUserId
                ),
                'count' => RecordModel::getCountAllTypes(
                    userId: $this->request->authKeyUserId,
                    startDate: $startDate,
                    endDate: $endDate
                )
            ]
        );
    }

    /**
     * Create drink.
     */
    public function create(): JsonResponse
    {
        try {
            RecordsValidator::create($this->request->data);
        } catch (\Throwable $th) {
            return Respond::prettyJson(
                message: 'Provided data was malformed',
                data: $th->getMessage(),
                code: 422
            );
        }

        $record = [
            'id' => UuidHelper::v6(),
            'user_id' => $this->request->authKeyUserId,
            'type' => $this->request->data->type
        ];

        // Add record
        DB::create(
            table: 'records',
            data: $record
        );

        return Respond::prettyJson(
            message: 'Record created',
            data: $record
        );
    }
}
