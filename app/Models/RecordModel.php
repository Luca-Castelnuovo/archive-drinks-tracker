<?php

declare(strict_types=1);

namespace App\Models;

use CQ\DB\DB;

final class RecordModel
{
    private static function getEndDate(string $startDate, string $type): string
    {
        return match ($type) {
            'day' => date('Y-m-d', strtotime($startDate . ' + 1 days')),
            'week' => date('Y-m-d', strtotime($startDate . ' + 1 days')),
            'month' => date('Y-m-d', strtotime($startDate . ' + 1 days')),
            default => date('Y-m-d')
        };
    }

    /**
     * Get entries in range
     */
    public static function get(
        string $userId,
        string $startDate,
        string $type
    ): array {
        $endDate = self::getEndDate(
            startDate: $startDate,
            type: $type
        );

        $records = DB::select(
            table: 'records',
            columns: [
                'type',
                'created_at',
            ],
            where: [
                'user_id' => $userId,
                'created_at[<>]' => ["{$startDate} 00:00:00", "{$endDate} 23:59:59"],
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

    public static function getFirstDate(
        string $userId
    ): string {
        $dates = self::getDates(
            userId: $userId
        );

        return $dates[0] ?? '2020-11-26';
    }

    /**
     * Get all unique record dates
     */
    public static function getDates(
        string $userId
    ): array {
        $records = DB::select(
            table: 'records',
            columns: [
                'created_at',
            ],
            where: [
                'user_id' => $userId,
                'ORDER' => [
                    'created_at' => 'ASC'
                ],
            ]
        ) ?? [];

        $created_at_array = [];

        foreach ($records as $record) {
            $date = date(
                format: "Y-m-d",
                timestamp: strtotime(
                    datetime: $record['created_at']
                )
            );

            if (in_array(
                needle: $date,
                haystack: $created_at_array
            )) {
                continue;
            }

            $created_at_array[] = $date;
        }

        return $created_at_array;
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
        string $startDate,
        string $type
    ): int {
        $endDate = self::getEndDate(
            startDate: $startDate,
            type: $type
        );

        return DB::count(
            table: 'records',
            where: [
                'user_id' => $userId,
                'type' => $type,
                'created_at[<>]' => ["{$startDate} 00:00:00", "{$endDate} 23:59:59"],
            ]
        );
    }

    /**
     * Get count in range for all types
     */
    public static function getCountAllTypes(
        string $userId,
        string $startDate,
        string $type
    ): array {
        return [
            'water' => self::getCount(
                userId: $userId,
                startDate: $startDate,
                type: 'water'
            ),
            'bier' => self::getCount(
                userId: $userId,
                startDate: $startDate,
                type: 'bier'
            ),
            'shot' => self::getCount(
                userId: $userId,
                startDate: $startDate,
                type: 'shot'
            ),
            'barf' => self::getCount(
                userId: $userId,
                startDate: $startDate,
                type: 'barf'
            ),
        ];
    }
}
