<?php

namespace Lira\Components\Admin\Messages;

use Lira\Framework\Database\DatabaseInterface;

class Model extends \Lira\Framework\Model
{
    protected \PDO $db;
    protected string $table = 'web_messages';

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
}