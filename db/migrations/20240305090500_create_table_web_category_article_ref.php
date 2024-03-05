<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableWebCategoryArticleRef extends AbstractMigration
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
        $table = $this->table('web_category_article_ref', ['id' => false, 'primary_key' => ['id_category','id_article']]);
        $table
            ->addColumn('id_category', 'integer')
            ->addColumn('id_article', 'integer')
            ->addColumn('pos', 'integer',['default'=>0])
            ->addIndex(['id_category', 'id_article'], ['unique' => true])
            ->create();
    }
}
