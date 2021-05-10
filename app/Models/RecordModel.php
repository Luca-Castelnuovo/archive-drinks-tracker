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

        return array_reduce(
            array: $records,
            callback: static function ($carry, $record) {
                if (!$carry) {
                    $newValue = [
                        'water' => 0,
                        'bier' => 0,
                        'shot' => 0,
                        'barf' => 0,
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
                    'created_at' => 'ASC',
                ],
            ]
        ) ?? [];

        $created_at_array = [];

        foreach ($records as $record) {
            $date = date(
                format: 'Y-m-d',
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
    ): string | null {
        return DB::select(
            table: 'records',
            columns: [
                'created_at',
            ],
            where: [
                'user_id' => $userId,
                'type' => $type,
                'ORDER' => [
                    'id' => 'DESC',
                ],
                'LIMIT' => 1,
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

    private static function getEndDate(string $startDate, string $type): string
    {
        return match ($type) {
            'day' => date('Y-m-d', strtotime($startDate . ' + 0 days')),
            'week' => date('Y-m-d', strtotime($startDate . ' + 7 days')),
            'month' => date('Y-m-d', strtotime($startDate . ' + 30 days')),
            default => date('Y-m-d')
        };
    }
}
