<?php

use CQ\DB\Migration;

final class CreateUsersTable extends Migration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $users = $this->table('users', ['id' => false, 'primary_key' => 'id']);
        $users->addColumn('id', 'uuid')

            ->addColumn('water_count', 'integer', [
                'default' => 0,
            ])
            ->addColumn('water_last_at', 'datetime', [
                'default' => null,
                'null' => true
            ])

            ->addColumn('bier_count', 'integer', [
                'default' => 0,
            ])
            ->addColumn('bier_last_at', 'datetime', [
                'default' => null,
                'null' => true
            ])

            ->addColumn('shot_count', 'integer', [
                'default' => 0,
            ])
            ->addColumn('shot_last_at', 'datetime', [
                'default' => null,
                'null' => true
            ])

            ->addColumn('barf_count', 'integer', [
                'default' => 0,
            ])
            ->addColumn('barf_last_at', 'datetime', [
                'default' => null,
                'null' => true
            ])

            ->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
