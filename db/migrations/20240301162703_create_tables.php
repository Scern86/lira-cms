<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTables extends AbstractMigration
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
        $this->_createLoginTable();
        $this->_createUserTable();
        $this->_createWebArticlesTable();
        $this->_createWebCategoriesTable();
        $this->_createWebCategoriesArticlesReferenceTable();
    }

    private function _createLoginTable()
    {
        $table = $this->table('main_login', ['id' => false, 'primary_key' => ['id']]);
        $table
            ->addColumn('id', 'integer', ['identity' => true])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('ssid', 'string')
            ->addColumn('ip_address', 'string',['limit'=>100])
            ->addColumn('id_user', 'integer')
            ->addColumn('is_active', 'boolean', ['default' => false])
            ->addColumn('component', 'string',['limit'=>50])
            ->create();
    }
    private function _createUserTable()
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
    private function _createWebArticlesTable()
    {
        $table = $this->table('web_articles', ['id' => false, 'primary_key' => ['id']]);
        $table
            ->addColumn('id', 'integer', ['identity' => true])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('title', 'string')
            ->addColumn('text', 'text')
            ->addIndex(['created'])
            ->create();
    }
    private function _createWebCategoriesTable()
    {
        $table = $this->table('web_categories', ['id' => false, 'primary_key' => ['id']]);
        $table
            ->addColumn('id', 'integer', ['identity' => true])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('title', 'string')
            ->addColumn('id_parent', 'integer')
            ->create();
    }
    private function _createWebCategoriesArticlesReferenceTable()
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