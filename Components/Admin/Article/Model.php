<?php

namespace Lira\Components\Admin\Article;

use Lira\Framework\Database\DatabaseInterface;

class Model extends \Lira\Framework\Model
{
    protected \PDO $db;
    protected string $table = 'web_articles';
    protected string $table_category_ref = 'web_category_article_ref';


    public function __construct(DatabaseInterface $database)
    {
        parent::__construct($database);
        $this->db = $database->connect();
    }


    public function getById(int $id): array
    {
        try {
            $query = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
            $query->execute(['id'=>$id]);
            return $query->fetch(\PDO::FETCH_ASSOC);
        }catch (\Throwable $e){
            return [];
        }
    }

    public function add(string $title,string $text,string $url): ?array
    {
        try{
            $query = $this->db->prepare("INSERT INTO {$this->table} (title,text,url) VALUES(:title,:text,:url) RETURNING *");
            $query->execute(['title'=>$title,'text'=>$text,'url'=>$url]);
            return $query->fetch(\PDO::FETCH_ASSOC);
        }catch (\Throwable $e){
            return null;
        }
    }

    public function update(int $id,string $title,string $text,string $url): void
    {
        try{
            $query = $this->db->prepare("UPDATE {$this->table} SET title = :title, text = :text, url = :url WHERE id = :id");
            $query->execute(['id'=>$id,'title'=>$title,'text'=>$text,'url'=>$url]);
        }catch (\Throwable $e){
            //var_dump($e);
        }
    }

    public function delete(int $id): bool
    {
        try{
            $query = $this->db->prepare("DELETE FROM {$this->table} WHERE id=:id");
            return $query->execute(['id'=>$id]);
        }catch (\Throwable $e){
            //var_dump($e);
            return false;
        }
    }

    public function getList(): array
    {
        try{
            $query = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY id DESC");
            $query->execute();
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }catch (\Throwable $e){
            //var_dump($e);
            return [];
        }
    }

    public function getRefCategories(int $idArticle): array
    {
        try{
            $query = $this->db->prepare("SELECT id_category FROM {$this->table_category_ref} WHERE id_article = :id_article");
            $query->execute(['id_article'=>$idArticle]);
            return $query->fetchAll(\PDO::FETCH_COLUMN,0);
        }catch (\Throwable $e){
            //var_dump($e);
            return [];
        }
    }

    public function setCategory(int $idArticle,int $idCategory): void
    {
        try{
            $clear = $this->db->prepare("DELETE FROM {$this->table_category_ref} WHERE id_article = :id_article");
            $clear->execute(['id_article'=>$idArticle]);

            $query = $this->db->prepare("INSERT INTO {$this->table_category_ref} (id_article,id_category) VALUES(:id_article,:id_category)");
            $query->execute(['id_article'=>$idArticle,'id_category'=>$idCategory]);
        }catch (\Throwable $e){
            //var_dump($e);
        }
    }
}