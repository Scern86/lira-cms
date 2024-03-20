<?php

namespace Lira\Application\Models;

use Lira\Application\App;
use Lira\Framework\Database\DatabaseInterface;
use Lira\Framework\Model;

class Message extends Model
{
    protected \PDO $db;

    protected string $table = 'web_messages';

    public function __construct(DatabaseInterface $database)
    {
        parent::__construct($database);
        $this->db = $database->connect();
    }

    public function add(string $name,string $email,string $message): bool
    {
        try{
            $query = $this->db->prepare("INSERT INTO {$this->table} (name,email,message) VALUES(:name,:email,:message)");
            $query->bindValue('name',$name);
            $query->bindValue('email',$email);
            $query->bindValue('message',$message);
            return $query->execute();
        }catch (\Throwable $e){
            trigger_error($e->getMessage(),E_USER_WARNING);
        }
        return false;
    }
}