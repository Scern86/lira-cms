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
            trigger_error($e->getMessage(),E_USER_WARNING);
        }
        return false;
    }

    public function getById(int $id): \Lira\Application\Objects\User
    {
        try {
            $query = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
            $query->bindValue('id',$id,\PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            if(!empty($result)){
                unset($result['password']);
                return new \Lira\Application\Objects\User(...$result);
            }
        }catch (\Throwable $e){
            trigger_error($e->getMessage(),E_USER_WARNING);
        }
        return new \Lira\Application\Objects\User();
    }
    public function getByLogin(string $login): \Lira\Application\Objects\User
    {
        try {
            $query = $this->db->prepare("SELECT * FROM {$this->table} WHERE login = :login");
            $query->bindValue('login',$login);
            $query->execute();
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            if(!empty($result)){
                unset($result['password']);
                return new \Lira\Application\Objects\User(...$result);
            }
        }catch (\Throwable $e){
            trigger_error($e->getMessage(),E_USER_WARNING);
        }
        return new \Lira\Application\Objects\User();
    }
}