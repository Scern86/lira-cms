<?php

namespace Lira\Components\Admin\Category;

use Lira\Framework\Database\DatabaseInterface;

class Model extends \Lira\Framework\Model
{
    protected \PDO $db;
    protected string $table = 'web_categories';

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

    public function add(string $title,int $idParent, string $url): ?array
    {
        try{
            $query = $this->db->prepare("INSERT INTO {$this->table} (title,id_parent,url) VALUES(:title,:id_parent,:url) RETURNING *");
            $query->execute(['title'=>$title,'id_parent'=>$idParent,'url'=>$url]);
            return $query->fetch(\PDO::FETCH_ASSOC);
        }catch (\Throwable $e){
            return null;
        }
    }

    public function update(int $id,string $title,int $idParent, string $url): void
    {
        try{
            $query = $this->db->prepare("UPDATE {$this->table} SET title = :title, id_parent = :id_parent, url = :url WHERE id = :id");
            $query->execute(['id'=>$id,'title'=>$title,'id_parent'=>$idParent,'url'=>$url]);
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
            $query = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY id ASC");
            $query->execute();
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }catch (\Throwable $e){
            //var_dump($e);
            return [];
        }
    }
}