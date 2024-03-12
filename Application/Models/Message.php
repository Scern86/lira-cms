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
            $query->bindValue('name',$name,\PDO::PARAM_STR);
            $query->bindValue('email',$email,\PDO::PARAM_STR);
            $query->bindValue('message',$message,\PDO::PARAM_STR);
            return $query->execute();
        }catch (\Throwable $e){
            App::getInstance()->logger->get('errors')->error('Error. Message model. Method add',[$e]);
        }
        return false;
    }
}