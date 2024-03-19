<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableExtObjectDtime extends AbstractMigration
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
        $table = $this->table('ext_object_dtime_ref', ['id' => false, 'primary_key' => ['id_object','definition']]);
        $table
            ->addColumn('id_object', 'string',['limit'=>50])
            ->addColumn('definition', 'string',['limit'=>25])
            ->addColumn('value', 'timestamp')
            ->addIndex(['id_object', 'definition'], ['unique' => true])
            ->create();
    }
}
