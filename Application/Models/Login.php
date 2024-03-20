<?php

namespace Lira\Application\Models;

use Lira\Framework\Database\DatabaseInterface;
use Lira\Framework\Model;

class Login extends Model
{
    protected \PDO $db;
    protected string $table = 'main_login';

    public function __construct(DatabaseInterface $database)
    {
        parent::__construct($database);
        $this->db = $database->connect();
    }

    public function checkLogin(string $ssid,string $ipAddress,string $component): \Lira\Application\Objects\Login
    {
        try {
            $today = new \DateTime();
            $yesterday = $today->modify('-1 day')->format('Y-m-d H:i:s');
            $query = $this->db->prepare("SELECT * FROM {$this->table} WHERE ssid = :ssid AND ip_address = :ip_address 
                      AND component = :component AND created > :created AND is_active=true");
            $query->bindValue('ssid',$ssid);
            $query->bindValue('ip_address',$ipAddress);
            $query->bindValue('component',$component);
            $query->bindValue('created',$yesterday);
            $query->execute();

            $result = $query->fetch(\PDO::FETCH_ASSOC);
            if(!empty($result)){
                return new \Lira\Application\Objects\Login(...$result);
            }
        }catch (\Throwable $e){
            trigger_error($e->getMessage(),E_USER_WARNING);
        }
        return new \Lira\Application\Objects\Login();
    }

    public function login(string $ssid,string $ipAddress,int $idUser,string $component): void
    {
        try{
            $query = $this->db->prepare("INSERT INTO {$this->table} (ssid,ip_address,id_user,is_active,component) 
VALUES(:ssid,:ip_address,:id_user,:is_active,:component)");
            $query->bindValue('ssid',$ssid);
            $query->bindValue('ip_address',$ipAddress);
            $query->bindValue('id_user',$idUser,\PDO::PARAM_INT);
            $query->bindValue('is_active',true,\PDO::PARAM_BOOL);
            $query->bindValue('component',$component);
            $query->execute();
        }catch (\Throwable $e){
            trigger_error($e->getMessage(),E_USER_WARNING);
        }
    }

    public function logout(int $idUser,string $ssid,string $component): void
    {
        try{
            $query = $this->db->prepare("UPDATE {$this->table} SET is_active = false 
             WHERE id_user = :id_user AND ssid = :ssid AND component = :component");
            $query->bindValue('id_user',$idUser,\PDO::PARAM_INT);
            $query->bindValue('ssid',$ssid);
            $query->bindValue('component',$component);
            $query->execute();
        }catch (\Throwable $e){
            trigger_error($e->getMessage(),E_USER_WARNING);
        }
    }
}