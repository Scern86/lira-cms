<?php

namespace Lira\Application\Models;

use Lira\Framework\Database\DatabaseInterface;
use Lira\Framework\Model;

class Article extends Model
{
    protected \PDO $db;
    protected string $table = 'web_articles';
    protected string $table_category_ref = 'web_category_article_ref';

    public function __construct(DatabaseInterface $database)
    {
        parent::__construct($database);
        $this->db = $database->connect();
    }

    public function getArticleById(int $articleId): array
    {
        try{
            $query = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
            $query->execute(['id'=>$articleId]);
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            if(array($result)) return $result;
        }catch (\Throwable $e){
            //var_dump($e);
        }
        return [];
    }

    public function getArticlesByCategoryId(int $categoryId): array
    {
        try{
            $query = $this->db->prepare("SELECT * FROM {$this->table} AS a, {$this->table_category_ref} AS ref
         WHERE a.id = ref.id_article AND ref.id_category = :id_category ORDER BY pos ASC");
            $query->execute(['id_category'=>$categoryId]);
            $result = $query->fetchAll(\PDO::FETCH_ASSOC);
            if(array($result)) return $result;
        }catch (\Throwable $e){
            //var_dump($e);
        }
        return [];
    }
}