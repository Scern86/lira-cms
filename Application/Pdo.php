<?php

namespace Lira\Application;

use Lira\Framework\Database\DatabaseInterface;

class Pdo implements DatabaseInterface
{
    protected \PDO $pdo;

    public function __construct(string $database, string $user, string $password, string $host = '127.0.0.1', int $port = 5432)
    {
        $dsn = "pgsql:host={$host};port={$port};dbname={$database}";
        $this->pdo = new \PDO($dsn, $user, $password);
    }

    public function connect(): \PDO
    {
        return $this->pdo;
    }
}