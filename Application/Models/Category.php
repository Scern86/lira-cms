<?php

namespace Lira\Application\Models;

use Lira\Application\App;
use Lira\Framework\Database\DatabaseInterface;
use Lira\Framework\Model;

class Category extends Model
{
    protected \PDO $db;
    protected string $table = 'web_categories';
    protected string $tableArticles = 'web_articles';
    protected string $tableCategoryRef = 'web_category_article_ref';

    public function __construct(DatabaseInterface $database)
    {
        parent::__construct($database);
        $this->db = $database->connect();
    }

    public function getArticlesByCategoryUrl(string $categoryUrl): array
    {
        try{
            $query = $this->db->prepare("SELECT a.* FROM {$this->tableArticles} AS a, {$this->tableCategoryRef} AS ref, {$this->table} AS c
         WHERE a.id = ref.id_article AND c.id = ref.id_category AND  c.url = :category_url ORDER BY ref.pos ASC");
            $query->execute(['category_url'=>$categoryUrl]);
            $result = $query->fetchAll(\PDO::FETCH_ASSOC);
            if(array($result)) return $result;
        }catch (\Throwable $e){
            App::getInstance()->logger->get('errors')->error('Error. Category model. Method getArticlesByCategoryUrl',[$e]);
        }
        return [];
    }
}