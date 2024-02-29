<?php

namespace Lira\Application;

use Lira\Framework\Database\DatabaseInterface;

class Pdo implements DatabaseInterface
{
    protected ?\PDO $pdo = null;

    public function __construct(private string $database, private string $user, private string $password, private string $host = '127.0.0.1', private int $port = 5432)
    {
    }

    public function init(): void
    {
        if(is_null($this->pdo)){
            try {
                $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->database}";
                $this->pdo = new \PDO($dsn, $this->user, $this->password);
            }catch (\Throwable $e){
                //$this->eventDispatcher->triggerEvent(new ErrorEvent(Level::WARNING,'database.connection.failed',[$e]));
            }
        }
    }

    public function connect(): ?\PDO
    {
        //$this->eventDispatcher->triggerEvent(new DefaultEvent(Level::DEBUG,'database.connection',[debug_backtrace()]));
        return $this->pdo;
    }
}