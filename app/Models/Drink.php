<?php

declare(strict_types=1);

namespace App\Models;

use CQ\DB\DB;

final class Drink
{
    /**
     * Validate json submission.
     */
    public static function get(string $userId): array
    {
        $drinksDB = DB::select('drinks', [
            'type',
            'created_at',
        ], [
            'user_id' => $userId,
            'ORDER' => [
                'created_at' => 'DESC',
            ],
        ]);

        $currDay = null;
        $drinks = [];
        $drinksCounter = -1;

        foreach ($drinksDB as $drink) {
            $day = date(
                format: 'Y-m-d',
                timestamp: strtotime(datetime: $drink['created_at'])
            );

            if ($currDay !== $day) {
                $currDay = $day;
                $drinksCounter++;
            }

            if (array_key_exists(key: $drinksCounter, array: $drinks)) {
                array_push($drinks[$drinksCounter], $drink);
                continue;
            }

            array_push($drinks, [$drink]);
        }

        return $drinks;
    }

    /**
     * Get drink type count
     */
    public static function getCount(string $userId): array
    {
        $countWater = DB::count(
            table: 'drinks',
            where: [
                'user_id' => $userId,
                'type' => 'Water',
            ]
        );

        $countBier = DB::count(
            table: 'drinks',
            where: [
                'user_id' => $userId,
                'type' => 'Bier',
            ]
        );

        $countShot = DB::count(
            table: 'drinks',
            where: [
                'user_id' => $userId,
                'type' => 'Shot',
            ]
        );

        $countBarf = DB::count(
            table: 'drinks',
            where: [
                'user_id' => $userId,
                'type' => 'Barf',
            ]
        );

        return [
            'water' => $countWater,
            'bier' => $countBier,
            'shot' => $countShot,
            'barf' => $countBarf,
            // 'totalAlcoholicDrink' => $countBier + $countShot,
        ];
    }

    /**
     * Get last drink
     */
    public static function getLast(string $userId): array
    {
        $lastWater = DB::select(
            table: 'drinks',
            columns: [
                'created_at',
            ],
            where: [
                'user_id' => $userId,
                'type' => 'Water',
                'ORDER' => [
                    'id' => 'DESC'
                ]
            ]
        );

        $lastBier = DB::select(
            table: 'drinks',
            columns: [
                'created_at',
            ],
            where: [
                'user_id' => $userId,
                'type' => 'Bier',
                'ORDER' => [
                    'id' => 'DESC'
                ]
            ]
        );

        $lastShot = DB::select(
            table: 'drinks',
            columns: [
                'created_at',
            ],
            where: [
                'user_id' => $userId,
                'type' => 'Shot',
                'ORDER' => [
                    'id' => 'DESC'
                ]
            ]
        );

        $lastBarf = DB::select(
            table: 'drinks',
            columns: [
                'created_at',
            ],
            where: [
                'user_id' => $userId,
                'type' => 'Barf',
                'ORDER' => [
                    'id' => 'DESC'
                ]
            ]
        );

        return [
            'water' => $lastWater[0]['created_at'] ?? null,
            'bier' => $lastBier[0]['created_at'] ?? null,
            'shot' => $lastShot[0]['created_at'] ?? null,
            'barf' => $lastBarf[0]['created_at'] ?? null,
        ];
    }
}
