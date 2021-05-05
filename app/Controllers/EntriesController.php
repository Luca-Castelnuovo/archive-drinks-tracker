<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\EntryModel;
use App\Models\UserModel;
use App\Validators\EntriesValidator;
use CQ\Controllers\Controller;
use CQ\DB\DB;
use CQ\Helpers\UuidHelper;
use CQ\Response\JsonResponse;
use CQ\Response\Respond;

final class EntriesController extends Controller
{
    /**
     * Show drinks
     */
    public function index(): JsonResponse
    {
        $date = date('Y-m-d');

        return Respond::prettyJson(
            message: "Entries on: {$date}",
            data: [
                'count' => UserModel::getCount(
                    userId: $this->request->authKeyUserId
                ),
                'last' => UserModel::getLast(
                    userId: $this->request->authKeyUserId
                ),
                'entries' => EntryModel::getOnDay(
                    userId: $this->request->authKeyUserId,
                    date: $date
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
            EntriesValidator::create($this->request->data);
        } catch (\Throwable $th) {
            return Respond::prettyJson(
                message: 'Provided data was malformed',
                data: $th->getMessage(),
                code: 422
            );
        }

        $lastEntry = EntryModel::getLastOnDay(
            userId: $this->request->authKeyUserId,
            date: '2021-05-05'
        );

        $lastEntry[$this->request->data->type] = $lastEntry[$this->request->data->type] + 1;

        $entry = [
            'id' => UuidHelper::v6(),
            'user_id' => $this->request->authKeyUserId,
            'water' => $lastEntry['water'],
            'bier' => $lastEntry['bier'],
            'shot' => $lastEntry['shot'],
            'barf' => $lastEntry['barf'],
        ];

        // Add entry to entries
        DB::create(
            table: 'entries',
            data: $entry
        );

        // Update users table
        DB::update(
            table: 'users',
            data: [
                "{$this->request->data->type}_last_at" => date('Y-m-d H:i:s'),
                "{$this->request->data->type}_count[+]" => 1
            ],
            where: [
                'id' => $this->request->authKeyUserId
            ]
        );

        return Respond::prettyJson(
            message: 'Entry recorded',
            data: $lastEntry
        );
    }
}
