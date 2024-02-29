<?php

namespace Lira\Application\Models;

use Lira\Framework\Database\DatabaseInterface;
use Lira\Framework\Model;

class User extends Model
{
    protected \PDO $db;
    protected string $table = 'main_users';

    public function __construct(DatabaseInterface $database)
    {
        parent::__construct($database);
        $this->db = $database->connect();
    }

    public function verifyCredentials(string $login,string $password,string $component): bool
    {
        try {
            $query = $this->db->prepare("SELECT * FROM {$this->table} WHERE login = :login 
                      AND component = :component AND is_active=true");
            $query->execute(['login'=>$login,'component'=>$component]);
            $user = $query->fetch(\PDO::FETCH_ASSOC);
            if(!empty($user)){
                if(password_verify($password,$user['password'])){
                    return true;
                }
            }
        }catch (\Throwable $e){
            var_dump($e);
        }
        return false;
    }

    public function getById(int $id): ?array
    {
        try {
            $query = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
            $query->execute(['id'=>$id]);
            return $query->fetch(\PDO::FETCH_ASSOC);
        }catch (\Throwable $e){
            //var_dump($e);
            return null;
        }
    }
    public function getByLogin(string $login): ?array
    {
        try {
            $query = $this->db->prepare("SELECT * FROM {$this->table} WHERE login = :login");
            $query->execute(['login'=>$login]);
            return $query->fetch(\PDO::FETCH_ASSOC);
        }catch (\Throwable $e){
            //var_dump($e);
            return null;
        }
    }
}