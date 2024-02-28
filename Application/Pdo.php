<?php

namespace Lira\Application;

use Lira\Framework\Database\DatabaseInterface;

class Pdo implements DatabaseInterface
{
    protected ?\PDO $pdo = null;

    public function __construct(string $database, string $user, string $password, string $host = '127.0.0.1', int $port = 5432)
    {
        try {
            $dsn = "pgsql:host={$host};port={$port};dbname={$database}";
            $this->pdo = new \PDO($dsn, $user, $password);
        }catch (\Throwable $e){
            //$this->eventDispatcher->triggerEvent(new ErrorEvent(Level::WARNING,'database.connection.failed',[$e]));
        }
    }

    public function connect(): ?\PDO
    {
        //$this->eventDispatcher->triggerEvent(new DefaultEvent(Level::DEBUG,'database.connection',[debug_backtrace()]));
        return $this->pdo;
    }
}