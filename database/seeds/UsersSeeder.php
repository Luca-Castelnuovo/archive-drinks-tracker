<?php

use CQ\DB\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $faker = self::faker();
        $data = [];

        for ($i = 0; $i < 5; ++$i) {
            $data[] = [
                'id' => $faker->uuid,

                // 'water_count' => 0,
                // 'water_last_at' => null,

                // 'bier_count' => 0,
                // 'bier_last_at' => null,

                // 'shot_count' => 0,
                // 'shot_last_at' => null,

                // 'barf_count' => 0,
                // 'barf_last_at' => null,

                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->table('users')->insert($data)->saveData();
    }
}
