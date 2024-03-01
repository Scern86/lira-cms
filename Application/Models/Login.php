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
            $query->execute(
                [
                    'ssid'=>$ssid,
                    'ip_address'=>$ipAddress,
                    'component'=>$component,
                    'created'=>$yesterday
                ]
            );
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            if(!empty($result)){
                return new \Lira\Application\Objects\Login(...$result);
            }
        }catch (\Throwable $e){
            var_dump($e);
        }
        return new \Lira\Application\Objects\Login();
    }

    public function login(string $ssid,string $ipAddress,int $idUser,string $component): void
    {
        try{
            $query = $this->db->prepare("INSERT INTO {$this->table} (ssid,ip_address,id_user,is_active,component) 
VALUES(:ssid,:ip_address,:id_user,:is_active,:component)");
            $query->execute(
                [
                    'ssid'=>$ssid,
                    'ip_address'=>$ipAddress,
                    'id_user'=>$idUser,
                    'is_active'=>true,
                    'component'=>$component
                ]
            );
        }catch (\Throwable $e){
            var_dump($e);
        }
    }

    public function logout(int $idUser,string $ssid,string $component): void
    {
        try{
            $query = $this->db->prepare("UPDATE {$this->table} SET is_active = false 
             WHERE id_user = :id_user AND ssid = :ssid AND component = :component");
            $query->execute(
                [
                    'id_user'=>$idUser,
                    'ssid'=>$ssid,
                    'component'=>$component
                ]
            );
        }catch (\Throwable $e){
            var_dump($e);
        }
    }
}