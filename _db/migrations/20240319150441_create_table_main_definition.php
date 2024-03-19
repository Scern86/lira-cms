<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableMainDefinition extends AbstractMigration
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
        $table = $this->table('main_definition', ['id' => false, 'primary_key' => ['name']]);
        $table
            ->addColumn('name', 'string',['limit'=>25])
            ->addColumn('type', 'string',['limit'=>25])
            ->addColumn('description', 'string')
            ->addIndex(['name'], ['unique' => true])
            ->create();
    }
}
