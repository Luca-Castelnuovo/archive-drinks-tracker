<?php

declare(strict_types=1);

namespace App\Models;

use CQ\DB\DB;

final class EntryModel
{
    /**
     * Get entries on specific day
     */
    public static function getOnDay(string $userId, string $date)
    {
        $entriesDB = DB::select(
            table: 'entries',
            columns: [
                'water [Int]',
                'bier [Int]',
                'shot [Int]',
                'barf [Int]',
                'created_at'
            ],
            where: [
                'user_id' => $userId,
                'created_at[<>]' => ["{$date} 00:00:00", "{$date} 23:59:59"],
                'ORDER' => [
                    'id' => 'DESC'
                ]
            ]
        ) ?? [];

        $entries = [];

        foreach ($entriesDB as $entry) {
            $time = date(
                format: 'H:i',
                timestamp: strtotime(datetime: $entry['created_at'])
            );

            $entry['created_at'] = $time;

            array_push($entries, $entry);
        }

        // Order entries by time
        usort($entries, fn ($a, $b) => strcmp($a['created_at'], $b['created_at']));

        return $entries;
    }

    /**
     * Get last entry
     */
    public static function getLast(string $userId): array
    {
        return DB::select(
            table: 'entries',
            columns: [
                'water [Int]',
                'bier [Int]',
                'shot [Int]',
                'barf [Int]'
            ],
            where: [
                'user_id' => $userId,
                'ORDER' => [
                    'id' => 'DESC'
                ]
            ]
        )[0] ?? [
            'water' => 0,
            'bier' => 0,
            'shot' => 0,
            'barf' => 0,
            'created_at' => null,
        ];
    }

    /**
     * Get last entry on specific day
     */
    public static function getLastOnDay(string $userId, string $date)
    {
        return DB::select(
            table: 'entries',
            columns: [
                'water [Int]',
                'bier [Int]',
                'shot [Int]',
                'barf [Int]',
                'created_at'
            ],
            where: [
                'user_id' => $userId,
                'created_at[<>]' => ["{$date} 00:00:00", "{$date} 23:59:59"],
                'ORDER' => [
                    'id' => 'DESC'
                ]
            ]
        )[0] ?? [
            'water' => 0,
            'bier' => 0,
            'shot' => 0,
            'barf' => 0
        ];
    }
}
