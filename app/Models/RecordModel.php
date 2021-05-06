<?php

declare(strict_types=1);

namespace App\Models;

use CQ\DB\DB;

final class RecordModel
{
    /**
     * Get entries in range
     */
    public static function get(
        string $userId,
        string $startDate,
        string $endDate
    ): array {
        $records = DB::select(
            table: 'records',
            columns: [
                'type',
                'created_at',
            ],
            where: [
                'user_id' => $userId,
                'created_at[<>]' => [$startDate, $endDate],
            ]
        );

        if (!$records) {
            return [];
        }

        $summarisedRecords = array_reduce(
            array: $records,
            callback: function ($carry, $record) {
                if (!$carry) {
                    $newValue = [
                        'water' => 0,
                        'bier' => 0,
                        'shot' => 0,
                        'barf' => 0
                    ];
                } else {
                    $newValue = end($carry);
                }

                $newValue['created_at'] = $record['created_at'];
                $newValue[$record['type']] = $newValue[$record['type']] + 1;

                array_push($carry, $newValue);

                return $carry;
            },
            initial: []
        );

        return $summarisedRecords;
    }

    /**
     * Get last entry for type
     */
    public static function getLast(
        string $userId,
        string $type
    ): string|null {
        return DB::select(
            table: 'records',
            columns: [
                'created_at',
            ],
            where: [
                'user_id' => $userId,
                'type' => $type,
                'ORDER' => [
                    'id' => 'DESC'
                ],
                'LIMIT' => 1
            ]
        )[0]['created_at'] ?? null;
    }

    /**
     * Get last entry for all types
     */
    public static function getLastAllTypes(string $userId): array
    {
        return [
            'water' => self::getLast(
                userId: $userId,
                type: 'water'
            ),
            'bier' => self::getLast(
                userId: $userId,
                type: 'bier'
            ),
            'shot' => self::getLast(
                userId: $userId,
                type: 'shot'
            ),
            'barf' => self::getLast(
                userId: $userId,
                type: 'barf'
            ),
        ];
    }

    /**
     * Get count in range for type
     */
    public static function getCount(
        string $userId,
        string $type,
        string $startDate,
        string $endDate
    ): int {
        return DB::count(
            table: 'records',
            where: [
                'user_id' => $userId,
                'type' => $type,
                'created_at[<>]' => [$startDate, $endDate],
            ]
        );
    }

    /**
     * Get count in range for all types
     */
    public static function getCountAllTypes(
        string $userId,
        string $startDate,
        string $endDate
    ): array {
        return [
            'water' => self::getCount(
                userId: $userId,
                type: 'water',
                startDate: $startDate,
                endDate: $endDate
            ),
            'bier' => self::getCount(
                userId: $userId,
                type: 'bier',
                startDate: $startDate,
                endDate: $endDate
            ),
            'shot' => self::getCount(
                userId: $userId,
                type: 'shot',
                startDate: $startDate,
                endDate: $endDate
            ),
            'barf' => self::getCount(
                userId: $userId,
                type: 'barf',
                startDate: $startDate,
                endDate: $endDate
            ),
        ];
    }
}
