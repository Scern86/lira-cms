<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableMainUser extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('main_user', ['id' => false, 'primary_key' => ['id']]);
        $table
            ->addColumn('id', 'integer', ['identity' => true])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('name', 'string')
            ->addColumn('login', 'string')
            ->addColumn('password', 'string')
            ->addColumn('is_active', 'boolean', ['default' => false])
            ->addColumn('component', 'string',['limit'=>50])
            ->create();
    }
}
