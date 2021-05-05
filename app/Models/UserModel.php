<?php

declare(strict_types=1);

namespace App\Models;

use CQ\DB\DB;

final class UserModel
{
    /**
     * Get drink type count
     */
    public static function getCount(string $userId): array
    {
        if (!DB::has(
            table: 'users',
            where: [
                'id' => $userId
            ]
        )) {
            DB::create(
                table: 'users',
                data: [
                    'id' => $userId
                ]
            );
        }

        $count = DB::get(
            table: 'users',
            columns: [
                'water_count [Int]',
                'bier_count [Int]',
                'shot_count [Int]',
                'barf_count [Int]'
            ],
            where: [
                'id' => $userId
            ]
        );

        return [
            'water' => $count['water_count'],
            'bier' => $count['bier_count'],
            'shot' => $count['shot_count'],
            'barf' => $count['barf_count'],
        ];
    }

    /**
     * Get last drink
     */
    public static function getLast(string $userId): array
    {
        if (!DB::has(
            table: 'users',
            where: [
                'id' => $userId
            ]
        )) {
            DB::create(
                table: 'users',
                data: [
                    'id' => $userId
                ]
            );
        }

        $count = DB::get(
            table: 'users',
            columns: [
                'water_last_at',
                'bier_last_at',
                'shot_last_at',
                'barf_last_at'
            ],
            where: [
                'id' => $userId
            ]
        );

        return [
            'water' => $count['water_last_at'],
            'bier' => $count['bier_last_at'],
            'shot' => $count['shot_last_at'],
            'barf' => $count['barf_last_at'],
        ];
    }
}
